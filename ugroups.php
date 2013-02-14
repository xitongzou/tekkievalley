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
require('language/' .$_SESSION['language']. '/groups.lang.php');

$UID        = NULL;
$username   = NULL;
$page       = ( isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) ) ? $_REQUEST['page'] : NULL;
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

$sql_count      = "SELECT count(m.GID) AS total_groups FROM group_own AS o, group_mem AS m WHERE m.GID = o.GID AND m.MID = '" .$UID. "'";
$ars            = $conn->execute($sql_count);
$total          = $ars->fields['total_groups'];
$pagination     = new Pagination(floor($config['items_per_page']/4));
$limit          = $pagination->getLimit($total);
$sql            = "SELECT o.*, m.GID FROM group_own AS o, group_mem AS m WHERE m.GID = o.GID AND m.MID = '" .$UID. "' LIMIT " .$limit;
$rs             = $conn->execute($sql);
$groups         = $rs->getrows();
$pagination_url = $config['BASE_URL']. '/users/' .$username. '/groups/{#PAGE#}';
$page_link      = $pagination->getPagination($pagination_url);
$start_num      = $pagination->getStartItem();
$end_num        = $pagination->getEndItem();

STemplate::assign('UID', $UID);
STemplate::assign('err', $err);
STemplate::assign('msg', $msg);
STemplate::assign('page', $page);
STemplate::assign('start_num', $start_num);
STemplate::assign('end_num', $end_num);
STemplate::assign('page_link', $page_link);
STemplate::assign('total', $total);
STemplate::assign('answers', $groups);
STemplate::assign('tags', group_tags($sql));
STemplate::assign('head_bottom', 'blank.tpl');
STemplate::assign('head_bottom_add', 'viewuserlinks.tpl');
STemplate::display('head1.tpl');
STemplate::display('err_msg.tpl');
STemplate::display('ugroups.tpl');
STemplate::display('footer.tpl');
STemplate::gzip_encode();
?>
