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
require('language/' .$_SESSION['language']. '/my_playlist.lang.php');

chk_member_login();

$active	= ( $config['approve'] == 1 ) ? " AND v.active = '1'" : NULL;
$page   = ( isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) ) ? $_REQUEST['page'] : NULL;
$g_uid 	= ( isset($_GET['UID']) && is_numeric($_GET['UID']) ) ? mysql_real_escape_string($_GET['UID']) : NULL;
$s_uid 	= mysql_real_escape_string($_SESSION['UID']);
$uid    = ( $g_uid ) ? $g_uid : $s_uid;

if ( isset($_POST['delete']) ) {
    $sql = "DELETE FROM playlist WHERE UID = '" .$s_uid. "'";
    $conn->execute($sql);
    $msg = $lang['my_playlist.deleted'];
}

if ( isset($_POST['removevideo']) ) {
	$rvid = ( isset($_POST['rvid']) && is_numeric($_POST['rvid']) ) ? $_POST['rvid'] : NULL;
	if ( $rvid ) {
        $sql = "DELETE FROM playlist WHERE UID = '" .$s_uid. "' AND VID = '" .mysql_real_escape_string($rvid). "' LIMIT 1";
		$conn->execute($sql);
        $msg = $lang['my_playlist.removed'];
	}
}

$sql_count      = "SELECT count(v.VID) AS total_videos FROM video AS v, playlist AS f WHERE f.UID = '" .$uid. "' AND f.VID = v.VID" .$active;
$ars            = $conn->execute($sql_count);
$total          = $ars->fields['total_videos'];
$pagination     = new Pagination(ceil($config['items_per_page']/2));
$limit          = $pagination->getLimit($total);
$sql            = "SELECT * FROM video AS v, playlist AS f WHERE f.UID = '" .$uid. "' AND f.VID = v.VID" .$active. " LIMIT " .$limit;
$rs             = $conn->execute($sql);
$videos         = $rs->getrows();
$pagination_url = $config['BASE_URL']. '/my_playlists/{#PAGE#}';
$page_link      = $pagination->getPagination($pagination_url);
$start_num      = $pagination->getStartItem();
$end_num        = $pagination->getEndItem();

STemplate::assign('err', $err);
STemplate::assign('msg', $msg);
STemplate::assign('page', $page);
STemplate::assign('start_num', $start_num);
STemplate::assign('end_num', $end_num);
STemplate::assign('page_link', $page_link);
STemplate::assign('total', $total);
STemplate::assign('answers', $videos);
STemplate::assign('mytags', group_tags($sql));
STemplate::assign('head_bottom', 'homelinks.tpl');
STemplate::display('head1.tpl');
STemplate::display('err_msg.tpl');
STemplate::display('my_playlist.tpl');
STemplate::display('footer.tpl');
STemplate::gzip_encode();
?>
