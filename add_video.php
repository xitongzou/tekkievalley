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
require('language/' .$_SESSION['language']. '/add_video.lang.php');

chk_member_login();

$active = ( $config['appprove'] == 1 ) ? " AND active = '1'" : NULL;
$gid 	= ( isset($_REQUEST['gid']) && is_numeric($_REQUEST['gid']) ) ? mysql_real_escape_string($_REQUEST['gid']) : NULL;
$vid 	= ( isset($_REQUEST['VID']) && is_numeric($_REQUEST['VID']) ) ? mysql_real_escape_string($_REQUEST['VID']) : NULL;
$urlkey	= ( isset($_REQUEST['urlkey']) && preg_match('/^[a-zA-Z0-9_]*$/', $_REQUEST['urlkey']) ) ? $_REQUEST['urlkey'] : NULL;
$uid 	= mysql_real_escape_string($_SESSION['UID']);
$type   = ( isset($_REQUEST['type']) ) ? $_REQUEST['type'] : NULL;
$page   = ( isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) ) ? $_REQUEST['page'] : 1;

$sql    = "SELECT * FROM group_mem WHERE GID = '" .$gid. "'";
$rs     = $conn->execute($sql);
if ( !$conn->Affected_Rows() > 0 ) {
    session_write_close();
    header('Location: ' .$config['BASE_URL']. '/error.php?type=group_missing');
}

$gname      = $rs->fields['gname'];
$gupload    = $rs->fields['gupload'];
STemplate::assign('gname', $gname);
STemplate::assign('gupload', $gupload);

if ( isset($_REQUEST['add_video']) ) {
	$sql = "SELECT * FROM group_mem WHERE GID='" .$gid. "'";
        $rs = $conn->execute($sql);
        if($rs->recordcount()>0) {
		$approved = ( $gupload == 'owner_approve' ) ? 'no' : 'yes';
                $sql = "insert group_vdo set GID='" .$gid. "', VID='" .$vid. "', MID='" .$uid. "', approved='" .$approved. "'";
                $conn->execute($sql);
		$msg = ( $gupload == 'owner_approve' ) ? $lang['add_video.add_approve'] : $lang['add_video.add_success'];
        }
}

$sql_count          = "SELECT count(*) AS total_videos FROM video WHERE UID = '" .$uid. "'" .$active;
$ars                = $conn->execute($sql_count);
$total              = $ars->fields['total_videos'];
$pagination         = new Pagination(ceil($config['items_per_page']/2));
$limit              = $pagination->getLimit($total);
$sql                = "SELECT * FROM video WHERE UID = '" .$uid. "'" .$active. " LIMIT " .$limit;
$rs                 = $conn->execute($sql);
$videos             = $rs->getrows();
$pagination_url     = $config['BASE_URL']. '/group/add/video/' .$urlkey. '/' .$gid. '/{#PAGE#}';
$page_link          = $pagination->getPagination($pagination_url);
$start_num          = $pagination->getStartItem();
$end_num            = $pagination->getEndItem();

STemplate::assign('err', $err);
STemplate::assign('msg', $msg);
STemplate::assign('urlkey', $urlkey);
STemplate::assign('gid', $gid);
STemplate::assign('page',$page);
STemplate::assign('start_num', $start_num);
STemplate::assign('end_num', $end_num);
STemplate::assign('page_link', $page_link);
STemplate::assign('total', $total);
STemplate::assign('answers', $videos);
STemplate::assign('tags', group_tags($sql));
STemplate::assign('head_bottom', 'homelinks.tpl');
if ( isset($_SESSION['UID']) ) {
	STemplate::assign('head_bottom_add', 'addvideolink.tpl');
}
STemplate::display('head1.tpl');
STemplate::display('err_msg.tpl');
STemplate::display('add_video.tpl');
STemplate::display('footer.tpl');
STemplate::gzip_encode();
?>
