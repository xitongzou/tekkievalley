<?php
/**************************************************************************************************
| Software Name        : ClipShare - Video Sharing Community Script
| Software Author      : Clip-Share.Com / ScriptXperts.Com
| Website              : http://www.clip-share.com
| E-mail               : office@clip-share.com
|**************************************************************************************************
| This source file is subject to the ClipShare End-User License Agreement, available online at:
| http://www.clip-share.com/video-sharing-script-eula.html
| By using this software, you acknowledge having read this Agreement and agree to be bound thereby.
|**************************************************************************************************
| Copyright (c) 2006-2007 Clip-Share.com. All rights reserved.
|**************************************************************************************************/

require('include/config.php');
require('include/function.php');
require('classes/pagination.class.php');

chk_member_login();

$UID    = NULL;
$active = ( $config['approve'] == 1 ) ? " AND v.active = '1'" : NULL;
if ( isset($_REQUEST['username']) && $_REQUEST['username'] != '' ) {
	$username       = mysql_real_escape_string(trim($_REQUEST['username']));
	$sql            = "SELECT UID FROM signup WHERE username = '" .$username. "' LIMIT 1;";
	$us             = $conn->execute($sql);
	if ( $conn->Affected_Rows() == 1 )
		$UID = $us->fields['UID'];
}

if ( isset($_REQUEST['UID']) && is_numeric($_REQUEST['UID']) && $_REQUEST['UID'] != '' ) {
	$UID    = mysql_real_escape_string(trim($_REQUEST['UID']));
	$sql    = "SELECT UID FROM signup WHERE UID = '" .$UID. "' LIMIT 1;";
	$us     = $conn->execute($sql);
	if ( $conn->Affected_Rows() != 1 )
		$UID = NULL;
}

$s_uid 	= ( isset($_SESSION['UID']) ) ? @mysql_real_escape_string($_SESSION['UID']) : NULL;
$g_uid	= $UID;
$type   = ( isset($_REQUEST['type']) ) ? trim($_REQUEST['type']) : NULL;
$page   = ( isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) ) ? $_REQUEST['page'] : 1;

$sql        = "SELECT playlist FROM signup WHERE UID = '" .mysql_real_escape_string($g_uid). "' LIMIT 1;";
$rs         = $conn->execute($sql);
$playlist   = $rs->fields['playlist'];
if ( $playlist == 'Private' ) {
    $access = ( $s_uid == $g_uid ) ? true : false;
    if ( !$access && $s_uid ) {
        $sql = "SELECT FID FROM friends WHERE FID = '" .$s_uid. "' AND UID = '" .$g_uid. "' AND friends_status = 'Confirmed'";
        $conn->execute($sql);
        if ( $conn->Affected_Rows() ) {
            $access = true;
        }
    }
    
    if ( !$access ) {
        session_write_close();
        header('Location: ' .$config['BASE_URL']. '/error.php?type=playlist_private');
        die();
    }
}

if ( isset($_POST['removefavour']) ) {
    $sql = "DELETE FROM favourite WHERE UID = '" .$s_uid. "' AND VID = '" .$rvid. "' LIMIT 1";    
}

$uid            = ( $g_uid ) ? $g_uid : $s_uid;
$sql_count      = "SELECT count(v.VID) AS total_videos FROM video AS v, playlist AS f WHERE f.UID = '" .$uid. "' AND f.VID = v.VID" .$active;
$ars            = $conn->execute($sql_count);
$total          = $ars->fields['total_videos'];
$pagination     = new Pagination(floor($config['items_per_page']/4));
$limit          = $pagination->getLimit($total);
$sql            = "SELECT * FROM video AS v, playlist AS f WHERE f.UID = '" .$uid. "' AND f.VID = v.VID" .$active. " LIMIT " .$limit;
$rs             = $conn->execute($sql);
$videos         = $rs->getrows();
$pagination_url = $config['BASE_URL']. '/users/' .$username. '/playlists/{#PAGE#}';
$page_link      = $pagination->getPagination($pagination_url);
$start_num      = $pagination->getStartItem();
$end_num        = $pagination->getEndItem();

STemplate::assign('UID', $UID);
STemplate::assign('err',$err);
STemplate::assign('msg',$msg);
STemplate::assign('page',$page);
STemplate::assign('start_num',$start_num);
STemplate::assign('end_num',$end_num);
STemplate::assign('page_link',$page_link);
STemplate::assign('total',$total);
STemplate::assign('answers',$videos);
STemplate::assign('mytags', group_tags($sql));
STemplate::assign('head_bottom',"blank.tpl");
STemplate::assign('head_bottom_add',"viewuserlinks.tpl");
STemplate::display('head1.tpl');
STemplate::display('err_msg.tpl');
STemplate::display('uplaylist.tpl');
STemplate::display('footer.tpl');
STemplate::gzip_encode();
?>
