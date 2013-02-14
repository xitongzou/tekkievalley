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
require('language/' .$_SESSION['language']. '/video.lang.php');
require('language/' .$_SESSION['language']. '/view_video.lang.php');

if ( $config['video_view'] == 'registered' )
	chk_member_login();

$viewkey    = ( isset($_REQUEST['viewkey']) && strlen($_REQUEST['viewkey']) == 20 ) ? $_REQUEST['viewkey'] : NULL;
if ( isset($_REQUEST['vid']) && is_numeric($_REQUEST['vid']) ) {
	$video_id       = trim($_REQUEST['vid']);
    $video_id       = mysql_real_escape_string($video_id);
	settype( $video_id, 'integer' );
	$sql            = sprintf("SELECT vkey FROM video WHERE VID = '%d' LIMIT 1;", $video_id);
	$fs             = $conn->execute($sql);
	if ( $conn->Affected_Rows() == 1 )
		$viewkey        = $fs->fields['vkey'];
}

if ( !$viewkey ) {
    session_write_close();
    header('Location: ' .$config['BASE_URL']. '/error.php?type=video_missing');
    die();
}

$sql    = "SELECT * FROM video WHERE vkey = '" .mysql_real_escape_string($viewkey). "' LIMIT 1";
$rs     = $conn->execute($sql);
if ( $conn->Affected_Rows() != 1 ) {
    session_write_close();
    header('Location: ' .$config['BASE_URL']. '/error.php?type=video_missing');
    die();
}

$video      = $rs->getrows();
$VID        = $video['0']['VID'];
$UID        = $video['0']['UID'];
$flag       = ( isset($_REQUEST['flag']) && strlen($_REQUEST['flag']) == 1 ) ? $_REQUEST['flag'] : NULL;
$action     = ( isset($_REQUEST['action']) ) ? $_REQUEST['action'] : NULL;
$active 	= ( $config['approve'] == 1 ) ? " AND active = '1'" : NULL;
$uid	    = ( isset($_SESSION['UID']) ) ? mysql_real_escape_string($_SESSION['UID']) : NULL;
$viewkey    = ( $viewkey ) ? mysql_real_escape_string($viewkey) : NULL;
$viewtype   = ( isset($_REQUEST['viewtype']) && $_REQUEST['viewtype'] == 'detailed' ) ? 'detailed' : 'basic';

// GUEST!!!
if ( !isset($_SESSION['UID']) ) {
    $guest_ip   = $_SERVER['REMOTE_ADDR'];
    $guest_date = date('d-m-y');
    $sql        = "SELECT * FROM guest_info WHERE guest_ip = '" .mysql_real_escape_string($guest_ip). "' AND log_date = '" .mysql_real_escape_string($guest_date). "'";
    $rs         = $conn->execute($sql);    
    $sql        = "SELECT duration FROM video WHERE vkey = '" .$viewkey. "' LIMIT 1";
    $rsx        = $conn->execute($sql);
    $duration   = $rsx->fields['duration'];
    
    if ( $conn->Affected_Rows() ) {
        $guest_bw   = $rs->fields['use_bw'];
//        if ( $guest_bw >= $config['guest_limite'] ) {
//          $URL    = $config['BASE_URL']. '?msg=Your video limit has esceeded for today!';
//            redirect($URL);
//        }    
        $use_bw     = $duration+$guest_bw;
        $sql        = "UPDATE guest_info SET use_bw = '" .mysql_real_escape_string($use_bw). "'
                       WHERE guest_ip = '" .mysql_real_escape_string($guest_ip). "'
                       AND log_date = '" .mysql_real_escape_string($guest_date). "'";
        $conn->execute($sql);
    } else {
        $sql        = "INSERT INTO guest_info SET guest_ip = '" .mysql_real_escape_string($guest_ip). "',
                       log_date = '" .mysql_real_escape_string($guest_date). "', use_bw = '" .mysql_real_escape_string($duration). "'";
        $conn->execute($sql);
    }
}

if ( $config['enable_package'] == 'yes' ) {
    if ( !isset($_SESSION['UID']) ) {
        $msg = $lang['view_video.guest'];
    } else {
        $sql    = "SELECT space FROM video WHERE vkey = '" .$viewkey. "'";
        $rs     = $conn->execute($sql);
        $space  = $rs->fields['space'];
        $sql    = "UPDATE subscriber SET used_bw = used_bw+" .$space. " WHERE UID = '" .$uid. "'";
        $conn->execute($sql);
    }
}

if ( $flag == 'F' ) {
    $sql    = "SELECT count(*) AS total FROM feature_req WHERE VID = '" .$VID. "'" .$active;
    $rs1    = $conn->execute($sql);
    if ( $rs1->fields['total'] > 0 ) {
        $sql    = "UPDATE feature_req SET req = req+1, date = '" .date('Y-m-d'). "' WHERE VID = '" .$VID. "'";
    } else {
        $sql    = "INSERT feature_req SET VID = '" .$VID. "', req = 1, date = '" .date('Y-m-d'). "'";
    }
    
    $conn->execute($sql);
    $msg = $lang['view_video.feature_request'];
} elseif ( $flag == 'I' ) {
    $sql    = "SELECT count(*) AS total FROM inappro_req WHERE VID = '" .$VID. "'";
    $rs1    = $conn->execute($sql);
    if ( $rs1->fields['total'] > 0 ) {
        $sql = "UPDATE inappro_req SET req = req+1, date = '" .date('Y-m-d'). "' WHERE VID = '" .$VID. "'";
    } else {
        $sql = "INSERT inappro_req SET VID = '" .$VID. "', req = 1, date = '" .date('Y-m-d'). "'";
    }
        
    $conn->execute($sql);
    $msg = $lang['view_video.innappropriate_request'];
}

if ( $video['0']['type'] == 'private' && $uid != $UID ) {
    $sql = "SELECT * FROM friends WHERE FID = '" .$uid. "' AND UID = '" .$UID. "' AND friends_status = 'Confirmed' LIMIT 1";
    $conn->execute($sql);
    if ( $conn->Affected_Rows() != 1 ) {
        session_write_close();
        header('Location: ' .$config['BASE_URL']. '/error.php?type=video_private');
        die();
    }
}

$sql = "UPDATE video SET viewnumber=viewnumber+1, viewtime='" .date('Y-m-d H:i:s'). "' WHERE VID = '" .$VID. "' LIMIT 1";
$conn->execute($sql);
$sql = "UPDATE signup SET video_viewed=video_viewed+1 WHERE UID = '" .$UID. "' LIMIT 1";
$conn->execute($sql);
if ( isset($_SESSION['UID']) ) {
    $sql = "UPDATE signup SET watched_video=watched_video+1 WHERE UID='" .$uid. "' LIMIT 1";
    $conn->execute($sql);    
    $sql = "INSERT INTO playlist SET UID = '" .$uid. "' , VID = '" .$VID. "'";
    $conn->execute($sql);
}

$keywords       = explode(' ', $video['0']['keyword']);
$keywords_add   = NULL;
$keywords_count = count($keywords);
if ( $keywords_count > 1 ) {
    for ( $i=1; $i<$keywords_count; $i++ ) {
        $keywords_add .= " OR keyword LIKE '%" .mysql_real_escape_string($keywords[$i]). "%'";
    }
}

$sql_add        = " AND ( keyword LIKE '%" .mysql_real_escape_string($keywords['0']). "%' " .$keywords_add. ")";
$sql_count      = "SELECT count(VID) AS total_videos FROM video WHERE type='public'" .$sql_add . $active;
$ars            = $conn->execute($sql_count);
$total          = $ars->fields['total_videos'];
$pagination     = new Pagination($config['rel_video_per_page']);
$limit          = $pagination->getLimit($total);
$sql            = "SELECT * FROM video WHERE type = 'public'" .$active . $sql_add. " ORDER BY VID DESC LIMIT " .$limit;
$rs             = $conn->execute($sql);
$videos         = $rs->getrows();
$start_num      = $pagination->getStartItem();
$end_num        = $pagination->getEndItem();

// Handle video player SEO URLS!
$player_path = '';
if ( $config['seo_urls'] == 1 ) {
	$player_path = '../../';
	if ( isset($_REQUEST['page']) )
		$player_path .= '../';
	if ( isset($_REQUEST['category']) )
		$player_path .= '../';
	if ( isset($_REQUEST['viewtype']) )
		$player_path .= '../';
	if ( isset($_REQUEST['action']) )
		$player_path .= '../';
}
//END

$delete = ( isset($_SESSION['UID']) && $video['0']['UID'] == $uid ) ? '1' : NULL;

$type           = ( $video['0']['type'] == 'public' ) ? " AND type = 'public'" : NULL;
$sql            = "SELECT * FROM video WHERE VID != '" .$VID. "' AND UID = '" .$UID. "'" .$type . $active. " LIMIT " .$config['rel_video_per_page'];
$rs             = $conn->execute($sql);
$uservideos     = $rs->getrows();
$sql            = "SELECT keyword FROM video WHERE VID != '" .$VID. "'" .$type . $active . $sql_add. " LIMIT " .$limit;
$relatedtags    = cloudTags($sql);

STemplate::assign('err', $err);
STemplate::assign('msg', $msg);
STemplate::assign('VID', $VID);
STemplate::assign('UID', $UID);
STemplate::assign('player_path', $player_path);
STemplate::assign('video_id', $video_id);
STemplate::assign('viewkey', $viewkey);
STemplate::assign('viewtype', $viewtype);
STemplate::assign('head_bottom', 'videolinks.tpl');
STemplate::assign('iscommented', is_commented($VID));
STemplate::assign('isvideocommented', is_video_commented($VID));
STemplate::assign('isvideorated', is_video_rated($VID));
STemplate::assign('isvideoembabed', is_video_embabed($VID));
STemplate::assign('total',$total);
STemplate::assign('items_per_page', $config['rel_video_per_page']);
STemplate::assign('start_num',$start_num);
STemplate::assign('end_num',$end_num);
STemplate::assign('answers', $videos);
STemplate::assign('answersuser', $uservideos);
STemplate::assign('relatedtags', $relatedtags);
STemplate::assign('tags', explode(' ', $video['0']['keyword']));
STemplate::display('header_view_video.tpl');
STemplate::display('err_msg.tpl');
STemplate::display('search.tpl');
STemplate::display('view_video.tpl');
STemplate::display('footer.tpl');
STemplate::gzip_encode();
?>
