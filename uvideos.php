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
require('language/' .$_SESSION['language']. '/uvideos.lang.php');

$UID        = NULL;
$username   = NULL;
$active     = ( $config['approve'] == 1 ) ? " AND active = '1'" : NULL;
$type       = ( isset($_REQUEST['type']) && $_REQUEST['type'] == 'private' ) ? 'private' : 'public';
$page       = ( isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) ) ? trim($_REQUEST['page']) : 1;
if ( isset($_REQUEST['username']) ) {
	$username   = trim($_REQUEST['username']);
    $sql        = "SELECT UID FROM signup WHERE username = '" .mysql_real_escape_string($username). "' LIMIT 1";
	$us         = $conn->execute($sql);
	if ( $conn->Affected_Rows() == 1 )
		$UID = $us->fields['UID'];
}

if ( isset($_REQUEST['UID']) && is_numeric($_REQUEST['UID']) ) {
	$UID    = trim($_REQUEST['UID']);
	$sql    = "SELECT UID FROM signup WHERE UID = '" .mysql_real_escape_string($UID). "' LIMIT 1;";
	$us     = $conn->execute($sql);
	if ( $conn->Affected_Rows() != 1 )
		$UID = NULL;
}

if ( !$UID ) {
    session_write_close();
    header('Location: ' .$config['BASE_URL']. '/error.php?type=user_missing');
    die();
}    

if ( $type == 'private' ) {
    $access = ( isset($_SESSION['UID']) && $_SESSION['UID'] == $UID ) ? true : false;
    if ( isset($_SESSION['UID']) ) {
    	$sql    = "SELECT * FROM friends WHERE FID = '" .mysql_real_escape_string($_SESSION['UID']). "' AND friends_status = 'Confirmed'";
	    $frs    = $conn->execute($sql);
	    if ( $conn->Affected_Rows() ) {
		    $access = true;
	    }
    }

    if ( !$access ) {
	    session_write_close();
	    header('Location: ' .$config['BASE_URL']. '/error.php?type=video_private');
	    die();
    }
}

$total      = 0;
$videos     = array();
$page_link  = NULL;
$start_num  = NULL;
$end_num    = NULL;
if ( $err == '' ) {
    $sql_count      = "SELECT count(VID) AS total_videos FROM video WHERE UID = '" .mysql_real_escape_string($UID). "' AND type = '" .mysql_real_escape_string($type). "'" .$active;
    $ars            = $conn->execute($sql_count);
    $total          = $ars->fields['total_videos'];
    $pagination     = new Pagination(ceil($config['items_per_page']/4));
    $limit          = $pagination->getLimit($total);
    $sql            = "SELECT * FROM video WHERE UID = '" .mysql_real_escape_string($UID). "' AND type = '" .mysql_real_escape_string($type). "'" .$active. " LIMIT " .$limit;
    $rs             = $conn->execute($sql);
    $videos         = $rs->getrows();
    $pagination_url = $config['BASE_URL']. '/users/' .$username. '/videos/' .$type. '/{#PAGE#}';
    $page_link      = $pagination->getPagination($pagination_url);
    $start_num      = $pagination->getStartItem();
    $end_num        = $pagination->getEndItem();
}

STemplate::assign('UID', $UID);
STemplate::assign('err', $err);
STemplate::assign('msg', $msg);
STemplate::assign('page', $page);
STemplate::assign('type', $type);
STemplate::assign('start_num', $start_num);
STemplate::assign('end_num', $end_num);
STemplate::assign('page_link', $page_link);
STemplate::assign('total', $total);
STemplate::assign('answers', $videos);
STemplate::assign('vtags', group_tags($sql));
STemplate::assign('head_bottom_add',"viewuserlinks.tpl");
STemplate::display('head1.tpl');
STemplate::display('err_msg.tpl');
STemplate::display('uvideos.tpl');
STemplate::display('footer.tpl');
STemplate::gzip_encode();
?>
