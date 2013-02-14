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
require('language/' .$_SESSION['language']. '/gmembers.lang.php');

$gname  = NULL;
$gurl   = NULL;
$oid    = NULL;
$gid    = ( isset($_REQUEST['gid']) && is_numeric($_REQUEST['gid']) ) ? mysql_real_escape_string($_REQUEST['gid']) : NULL;
$sql    = "SELECT * FROM group_own WHERE GID='" .$gid. "' limit 1";
$rs     = $conn->execute($sql);
if ( $conn->Affected_Rows() == 1 ) {
    $urlkey     = $rs->fields['gurl'];
    $gname      = $rs->fields['gname'];
    $gupload    = $rs->fields['gupload'];
    $oid        = $rs->fields['OID'];
    STemplate::assign('gname', $gname);
    STemplate::assign('gurl', $urlkey);
    STemplate::assign('gupload', $gupload);
} else {
    session_write_close();
    header('Location: ' .$config['BASE_URL']. '/error.php?type=group_missing');
    die();
}

if ( isset($_POST['approve_mem']) ) {
    if ( isset($_SESSION['UID']) && $_SESSION['UID'] != '' && $_SESSION['UID'] == $oid ) {
	    $mid = ( isset($_POST['MID']) && is_numeric($_POST['MID']) ) ? mysql_real_escape_string($_POST['MID']) : NULL;
	    $sql = "UPDATE group_mem SET approved = 'yes' WHERE MID = '" .$mid. "' AND GID = '" .$gid. "' LIMIT 1";
	    $conn->execute($sql);
	    $msg = $lang['gmembers.approve_mem'];
    }
}

if ( isset($_POST['remove_mem']) ) {
    if ( isset($_SESSION['UID']) && $_SESSION['UID'] != '' && $_SESSION['UID'] == $oid ) {
	    $mid = ( isset($_POST['MID']) && is_numeric($_POST['MID']) ) ? mysql_real_escape_string($_POST['MID']) : NULL;
	    $sql = "DELETE FROM group_mem WHERE MID = '" .$mid. "' AND GID = '" .$gid. "'";
	    $conn->execute($sql);
	    $msg = $lang['gmembers.remove_mem'];
    }
}

$page           = ( isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) ) ? $_REQUEST['page'] : 1;
$approved       = ( isset($_SESSION['UID']) && $_SESSION['UID'] != $oid ) ? " AND approved = 'yes'" : NULL;
$sql_count      = "SELECT count(MID) AS total_members FROM group_mem WHERE GID = '" .$gid. "'" .$approved;
$ars            = $conn->execute($sql_count);
$total          = $ars->fields['total_members'];
$pagination     = new Pagination(10);
$limit          = $pagination->getLimit($total);
$sql            = "SELECT * FROM group_mem WHERE GID = '" .$gid. "'" .$approved. " LIMIT " .$limit;
$rs             = $conn->execute($sql);
$members        = $rs->getrows();
$pagination_url = $config['BASE_URL'] . '/group/' .$urlkey. '/members/' .$gid. '/{#PAGE#}';
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
STemplate::assign('friends', $members);
STemplate::assign('head_bottom', 'grouplinks.tpl');
if ( isset($_SESSION['UID']) )
	STemplate::assign('head_bottom_add', 'crglinks.tpl');
STemplate::display('head1.tpl');
STemplate::display('err_msg.tpl');
STemplate::display('gmembers.tpl');
STemplate::display('footer.tpl');
STemplate::gzip_encode();
?>
