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
require('language/' .$_SESSION['language']. '/my_video.lang.php');

chk_member_login();

$active = ( $config['approve'] == 1 ) ? " AND active = '1'" : NULL;
$uid 	= mysql_real_escape_string($_SESSION['UID']);
$vid 	= ( isset($_REQUEST['VID']) && is_numeric($_REQUEST['VID']) ) ? mysql_real_escape_string($_REQUEST['VID']) : NULL;
$page   = ( isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) ) ? $_REQUEST['page'] : 1;

if ( isset($_POST['remove_video']) ) {
	if ( $config['enable_package'] == 'yes' ) {
    	$space      = vid_to_space($vid);
		$sql        = "UPDATE subscriber SET used_space = 'floor(used_space-" .$space. ") WHERE UID='" .$uid. "' LIMIT 1";
		$conn->execute($sql);
		$sql        = "UPDATE subscriber SET total_video=floor(total_video-1) WHERE UID='" .$uid. "' LIMIT 1";
		$conn->execute($sql);
    }
        
	if ( delete_vdo($vid, $uid) )
		$msg = $lang['my_video.delete_success'];
	else
		$err = $lang['my_video.delete_failed'];
}

$sql_count      = "SELECT count(VID) AS total_videos FROM video WHERE UID = '" .$uid. "'" .$active;
$ars            = $conn->execute($sql_count);
$total          = $ars->fields['total_videos'];
$pagination     = new Pagination(ceil($config['items_per_page']/2));
$limit          = $pagination->getLimit($total);
$sql            = "SELECT * FROM video WHERE UID = '" .$uid. "'" .$active. " LIMIT " .$limit;
$rs             = $conn->execute($sql);
$videos         = $rs->getrows();
$pagination_url = $config['BASE_URL']. '/my_videos/{#PAGE#}';
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
STemplate::display('my_video.tpl');
STemplate::display('footer.tpl');
STemplate::gzip_encode();
?>
