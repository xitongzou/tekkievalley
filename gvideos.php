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
require('language/' .$_SESSION['language']. '/gvideos.lang.php');

$active = ( $config['approve'] == 1 ) ? " AND active = '1'" : NULL;
$gid	= ( isset($_REQUEST['gid']) && is_numeric($_REQUEST['gid']) ) ? mysql_real_escape_string($_REQUEST['gid']) : NULL;
$uid	= ( isset($_SESSION['UID']) ) ? mysql_real_escape_string($_SESSION['UID']) : NULL;
$page   = ( isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) ) ? $_REQUEST['page'] : 1;

$sql    = "SELECT * FROM group_own WHERE GID = '" .$gid. "' LIMIT 1";
$rs     = $conn->execute($sql);
if ( $conn->Affected_Rows() == 1 ) {
    $urlkey     = $rs->fields['gurl'];
    $gname      = $rs->fields['gname'];
    $type       = $rs->fields['type'];
    $gupload    = $rs->fields['gupload'];
    $gimage     = $rs->fields['gimage'];
    STemplate::assign('gname', $gname);
    STemplate::assign('gurl', $urlkey);
    STemplate::assign('gid', $gid);
    STemplate::assign('type', $type);
    STemplate::assign('gimage', $gimage);
    STemplate::assign('gupload', $gupload);
} else {
    session_write_close();
    header('Location: ' .$config['BASE_URL']. '/error.php?type=group_missing');
    die();
}


$sql = "select * from group_mem where GID='" .$gid. "' and MID='" .$uid. "'";
$rs = $conn->execute($sql);
$is_mem = $rs->fields['approved'];
STemplate::assign("is_mem", $is_mem);

if ( !$gid )
	$err = $lang['groups_videos.invalid_id'];
if ( $err == '' ) {
	$vid = ( isset($_REQUEST['VID']) && is_numeric($_REQUEST['VID']) ) ? mysql_real_escape_string($_REQUEST['VID']) : NULL;
	if ( isset($_REQUEST['group_image']) && $_REQUEST['group_image'] ) {
    	$sql = "update group_own set gimage_vdo='" .$vid. "' where GID='" .$gid. "' limit 1";
    	$conn->execute($sql);
    	$msg = $lang['gvideos.image_updated'];
	}

	if ( isset($_REQUEST['remove_image']) && $_REQUEST['remove_image'] ) {
    	$sql = "delete from group_vdo where VID='" .$vid. "' and GID='" .$gid. "' limit 1";
    	$conn->execute($sql);
		$msg = $lang['gvideos.image_removed'];
	}
	
	if ( isset($_REQUEST['approve_it']) && $_REQUEST['approve_it'] ) {
    	$sql = "update group_vdo set approved='yes' where GID='" .$gid. "' and VID='" .$vid. "'";
		$conn->execute($sql);
		$msg = $lang['gvideos.video_approved'];
	}
}

$approved       = ( isset($_SESSION['UID']) && $_SESSION['UID'] == $gid ) ? " AND approved = 'yes'" : NULL;
$sql_count      = "SELECT count(VID) AS total_videos FROM group_vdo WHERE GID = '" .$gid. "'" .$approved;
$ars            = $conn->execute($sql_count);
$total          = $ars->fields['total_videos'];
$pagination     = new Pagination(10);
$limit          = $pagination->getLimit($total);
$sql            = "SELECT * FROM group_vdo WHERE GID = '" .$gid. "'" .$approved. " ORDER BY AID DESC LIMIT " .$limit;
$rs             = $conn->execute($sql);
$pagination_url = $config['BASE_URL']. '/group/' .$urlkey. '/videos/' .$gid. '/{#PAGE#}';
$page_link      = $pagination->getPagination($pagination_url);
$start_num      = $pagination->getStartItem();
$end_num        = $pagination->getEndItem();
$videos         = array();
if ( $conn->Affected_Rows() ) {
    $i  = 0;
    while ( !$rs->EOF ) {
        $sql    = "SELECT * FROM video WHERE VID = '" .$rs->fields['VID']. "'" .$active. " LIMIT 1";
        $rsv    = $conn->execute($sql);
        if ( $conn->Affected_Rows() ) {
            $video                  = $rsv->getrows();
            $video['0']['approved'] = $rs->fields['approved'];
            $videos[$i]             = $video['0'];
            $rs->movenext();
            ++$i;
        }
    }
}

STemplate::assign('err', $err);
STemplate::assign('msg', $msg);
STemplate::assign('page', $page);
STemplate::assign('start_num', $start_num);
STemplate::assign('end_num', $end_num);
STemplate::assign('page_link', $page_link);
STemplate::assign('total', $total);
STemplate::assign('answers', $videos);
STemplate::assign('vtags', group_tags($sql));
STemplate::assign('head_bottom', 'grouplinks.tpl');
if( isset($_SESSION['UID']) )
	STemplate::assign('head_bottom_add', 'crglinks.tpl');
STemplate::display('head1.tpl');
STemplate::display('err_msg.tpl');
STemplate::display('gvideos.tpl');
STemplate::display('footer.tpl');
STemplate::gzip_encode();
?>
