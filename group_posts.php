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
require('language/' .$_SESSION['language']. '/group_posts.lang.php');

$active		    = ( $config['approve'] == 1 ) ? "and active = '1'" : NULL;
$tid 		    = ( isset($_GET['tid']) && is_numeric($_GET['tid']) ) ? mysql_real_escape_string($_GET['tid']) : NULL;
$uid 		    = ( isset($_SESSION['UID']) && is_numeric($_SESSION['UID']) ) ? mysql_real_escape_string($_SESSION['UID']) : NULL;
$gid		    = ( isset($_GET['gid']) && is_numeric($_GET['gid']) ) ? mysql_real_escape_string($_GET['gid']) : NULL;

$sql            = "SELECT * FROM group_own WHERE GID = '" .$gid. "' LIMIT 1";
$rs             = $conn->execute($sql);
if ( $conn->Affected_Rows() == 1 ) {
    $gname      = $rs->fields['gname'];
    $gupload    = $rs->fields['gupload'];
    STemplate::assign('gname', $gname);
    STemplate::assign('gupload', $gupload);
} else {
    session_write_close();
    header('Location: ' .$config['BASE_URL']. '/error.php?type=group_missing');
    die();
}

if ( isset($_POST['add_message']) && $uid ) {
    $message    = $filterObj->process(trim($_POST['topic_message']));
    $video      = trim($_POST['message_video']);
    settype($video, 'integer');
    
    if ( $message == '' )
        $err = 'Please enter topic message!';
    
    if ( $err == '' ) {
        $sql = "INSERT INTO group_tps_post (TID, UID, date, post, VID)
                VALUES ('" .$tid. "', '" .$uid. "', '" .date('Y-m-d H:i:s'). "',
                        '" .mysql_real_escape_string($message). "', '" .mysql_real_escape_string($video). "')";
        $conn->execute($sql);
        if ( $conn->Affected_Rows() == 1 )
            $msg = $lang['group_posts.message_add'];
    }    
}

$sql = "select * from group_tps where TID='" .$tid. "'";
$rs = $conn->execute($sql);
$topic = $rs->getrows();
STemplate::assign('topic', $topic[0]);

$sql = "select * from group_tps_post where  TID='" .$tid. "' order by PID asc";
$rs1 = $conn->execute($sql);
$post = $rs1->getrows();
STemplate::assign('post', $post);
STemplate::assign('total_post', count($post));

/* Fetch login user video for combobox */
if ( isset($_SESSION['UID']) && $_SESSION['UID'] != '' ) {
        $sql = "select VID, title from video where UID='" .$uid. "' $active order by VID desc";
        $rs = $conn->execute($sql);
        $video_ops = "<OPTION value='' selected>- Your Videos -</OPTION>";
        while(!$rs->EOF) {
                $video_ops .= "<option value=".$rs->fields['VID'].">".$rs->fields['title']."</option>";
                $rs->movenext();
        }
        $video_ops .="<OPTION value=''>- Your Favorite Videos -</OPTION>";
        $sql = "select VID from favourite where UID='$uid'";
        $rs = $conn->execute($sql);
        while(!$rs->EOF) {
                $fav[] = $rs->fields['VID'];
                $rs->movenext();
        }

        if ( isset($fav['0']) && $fav['0'] != '' ) {
                $fav_video = implode(',', $fav);
                $sql = "select VID, title from video where VID in ($fav_video) $active order by VID desc";
                $rs = $conn->execute($sql);
                while(!$rs->EOF) {
                        $video_ops .= "<option value=".$rs->fields['VID'].">".htmlspecialchars($rs->fields['title'], ENT_QUOTES, 'UTF-8')."</option>";
                        $rs->movenext();
                }
        }

        STemplate::assign('video_ops', $video_ops);
}


$add = base64_encode("&urlkey=$_GET[urlkey]&gid=$_GET[gid]&tid=$_GET[tid]");
STemplate::assign('add', $add);
STemplate::assign('err', $err);
STemplate::assign('msg', $msg);
STemplate::assign('head_bottom', 'grouplinks.tpl');
if ( isset($_SESSION['UID']) )
	STemplate::assign('head_bottom_add', 'crglinks.tpl');
STemplate::display('head1.tpl');
STemplate::display('err_msg.tpl');
STemplate::display('group_posts.tpl');
STemplate::display('footer.tpl');
STemplate::gzip_encode();
?>
