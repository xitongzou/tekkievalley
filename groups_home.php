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
require('language/' .$_SESSION['language']. '/groups_home.lang.php');

$urlkey = NULL;
$active = ( $config['approve'] == 1 ) ? "AND active = '1'" : NULL;
$page   = ( isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) ) ? $_REQUEST['page'] : 1;
$urlkey = ( isset($_REQUEST['urlkey']) && preg_match('/^[A-Za-z0-9_\-]+$/', $_REQUEST['urlkey']) ) ? mysql_real_escape_string($_REQUEST['urlkey']) : NULL;
$uid 	= ( isset($_SESSION['UID']) ) ? @mysql_real_escape_string($_SESSION['UID']) : NULL;

$sql        = "SELECT * FROM group_own WHERE gurl = '" .$urlkey. "' LIMIT 1";
$rs         = $conn->execute($sql);
if ( $conn->Affected_Rows() == 1 ) {
    $GID        = $rs->fields['GID'];
    $gposting   = $rs->fields['gposting'];
    $gupload    = $rs->fields['gupload'];
    $type       = $rs->fields['type'];       
    $oid        = $rs->fields['OID'];
    STemplate::assign('gposting', $gposting);
    STemplate::assign('gupload', $gupload);   
    STemplate::assign('type', $type);
} else {
    session_write_close();
    header('Location: ' .$config['BASE_URL']. '/error.php?type=group_missing');
    die();
}

if ( $type == 'private' ) {
    $access = ( $uid == $oid ) ? true : false;
    if ( $uid ) {
        $sql = "SELECT GID FROM group_mem WHERE MID = '" .$uid. "' AND GID = '" .$GID. "' AND approved = 'yes' LIMIT 1;";
        $conn->execute($sql);
        if ( $conn->Affected_Rows() ) {
            $access = true;
        }
    }
    
    if ( !$access ) {
        session_write_close();
        header('Location: ' .$config['BASE_URL']. '/error.php?type=group_private');
        die();
    }
}

$flag   = ( $oid == $uid ) ? 'self' : 'guest';
$grpid 	= ( isset($_POST['GRPID']) && is_numeric($_POST['GRPID']) ) ? @mysql_real_escape_string($_POST['GRPID']) : NULL;
$rtype	= ( isset($_REQUEST['type']) ) ? $_REQUEST['type'] : NULL;

// group joining
if( isset($_POST['joingroup']) ) {
    chk_member_login();	
	
    $sql = "SELECT MID FROM group_mem WHERE MID = '" .$uid. "' AND GID = '" .$grpid. "' LIMIT 1";
    $conn->execute($sql);
    if ( !$conn->Affected_Rows() ) {    
        $approved = ( $type = 'protected' ) ? 'no' : 'yes';
        $sql = "insert into group_mem set GID='" .$grpid. "', MID='" .$uid. "', member_since='".date('Y-m-d H:i:s')."', approved='" .$approved. "'";
        $conn->execute($sql);
        if ( $conn->Affected_Rows() == 1 ) {
	        $msg = ( $type == 'protected' ) ? $lang['groups_home.approve_yes'] : $lang['groups_home.approve_no'];
        }
    } else {
        $err = $lang['groups_home.already_member'];
    }
}

// group leaving
if( isset($_REQUEST['leavegroup']) && $_REQUEST['leavegroup'] != '' ){
    $sql="DELETE from group_mem WHERE GID='" .$grpid. "' and MID='" .$uid. "'";
    $conn->execute($sql);
    if ( $conn->Affected_Rows() == 1 ) {
	    $msg = $lang['groups_home.leave'];
    }
}

// approve topics
if ( isset($_SESSION['UID']) && $_SESSION['UID'] == $oid && isset($_REQUEST['apost_TID']) ) {
	$apost_tid = @mysql_real_escape_string($_REQUEST['apost_TID']);
    $sql = "update group_tps set approved='yes' where TID='" .$apost_tid. "'";
    $conn->execute($sql);
	$msg = $lang['groups_home.approve_apost'];
}

// delete topics
if ( isset($_SESSION['UID']) && $_SESSION['UID'] == $oid && isset($_REQUEST['unapost_TID']) ) {
	$unapost_tid = @mysql_real_escape_string($_REQUEST['unapost_TID']);
	$sql = "delete from group_tps where TID='" .$unapost_tid. "'";
    $conn->execute($sql);
	$msg = $lang['groups_home.remove_apost'];
}

// add new topic
$gid 		    = ( isset($_REQUEST['GID']) ) ? @mysql_real_escape_string($_REQUEST['GID']) : NULL;
$topic_title 	= ( isset($_REQUEST['topic_title']) ) ? @mysql_real_escape_string($_REQUEST['topic_title']) : NULL;
if( isset($_POST['add_topic']) ) {
    chk_member_login();
    $topic_title    = ( isset($_POST['topic_title']) ) ? @mysql_real_escape_string($_POST['topic_title']) : NULL;
    $topic_title    = ( $topic_title ) ? $filterObj->process($topic_title) : NULL;
    $topic_video    = ( isset($_POST['topic_video']) ) ? @mysql_real_escape_string($_POST['topic_video']) : NULL;
    
    if ( $topic_title == '' )
        $err = 'Topic Title cannot be blank!';
    
    if ( $err == '' ) {
        if ( $gposting == 'owner_approve' && $flag != 'self' ) {
            $approved = 'no';
        } else {
            $approved = 'yes';
        }
        
        // add group topic
        $sql = "INSERT group_tps SET GID = '" .$gid. "', addtime = '" .date('Y-d-d H:i:s'). "', title = '" .$topic_title. "',
                                     UID = '" .$uid. "', VID = '" .$topic_video. "', approved = '" .$approved. "'";
        $conn->execute($sql);
        // end add group topic
    
        // add group video from list
        if ( $topic_video ) {
            $sql = "INSERT group_vdoSET GID = '" .$gid. "', VID = '" .$topic_video. "', MID = '" .$uid. "', approved = '" .$approved. "'";
            $conn->execute($sql);
        }
        // end add group video
        
        // redirect after add
        if ( $gposting == 'owner_approve' && $flag != 'self' ) {
            $msg = 'Your topic will be added after owner approval!';
        } else {
            $msg = 'Your group topic was added successfuly!';
        }
        
        $URL = seo_url('group/' .$urlkey. '/?' .$msg, 'groups_home.php?urlkey=' .$urlkey. '&msg=' .$msg);
        session_write_close();
        header('Location: ' .$URL);
        die();
    }
}



$GID    = NULL;
$sql 	= "SELECT * FROM group_own WHERE gurl = '" .$urlkey. "' LIMIT 1";
$rs 	= $conn->execute($sql);
if ( $conn->Affected_Rows() ) {
    $GID              = mysql_real_escape_string($rs->fields['GID']);
    $group            = $rs->getrows();
    $sql_count        = "SELECT count(TID) AS total_topics FROM group_tps WHERE GID = '" .$GID. "'";
    $ars              = $conn->execute($sql_count);
    $total            = $ars->fields['total_topics'];
    $pagination       = new Pagination(10);
    $limit            = $pagination->getLimit($total);
    $sql              = "SELECT * FROM group_tps WHERE GID = '" .$GID. "' LIMIT " .$limit;
    $rst              = $conn->execute($sql);
    $topics           = $rst->getrows();
    $pagination_url   = $config['BASE_URL']. '/group/' .$urlkey. '/{#PAGE#}';
    $page_link        = $pagination->getPagination($pagination_url);
    $start_num        = $pagination->getStartItem();
    $end_num          = $pagination->getEndItem();

    STemplate::assign('start_num', $start_num);
    STemplate::assign('end_num', $end_num);
    STemplate::assign('page_link', $page_link);
    STemplate::assign('grptps', $topics);
} else
    $err = 'This group does not exist!';

// fetch recent videos from current group
$gvideo = array();
if ( $GID ) {
	$sql 	= "SELECT * FROM group_vdo WHERE GID = '" .$GID. "' AND approved ='yes' ORDER BY AID DESC LIMIT 0, 4";
	$rs 	= $conn->execute($sql);
    if ( $conn->Affected_Rows() ) {
        while ( !$rs->EOF ) {
            $gvideo[] = $rs->fields['VID'];
    	    $rs->movenext();
        }
    }
}

if ( $gvideo ) {
    $group_video 	= implode(',', $gvideo);
    $sql 		    = "SELECT * FROM video WHERE VID in (" .$group_video. ")";
    $rs 		    = $conn->execute($sql);
    $gvideo 	    = $rs->getrows();

    STemplate::assign('gvideo', $gvideo);
}

$sql 	= "SELECT * FROM group_mem WHERE GID = '" .$GID. "' AND MID = '" .$uid. "'";
$rs 	= $conn->execute($sql);
$is_mem = $rs->fields['approved'];
STemplate::assign('is_mem', $is_mem);

$sql 	= "SELECT count(*) AS total FROM group_vdo WHERE approved='no' AND GID = '" .$GID. "'";
$rs 	= $conn->execute($sql);
STemplate::assign('total_new_video',$rs->fields['total']+0);

$sql 	= "SELECT count(*) AS total FROM group_mem WHERE approved='no' AND GID = '" .$GID. "'";
$rs 	= $conn->execute($sql);
STemplate::assign('total_new_member',$rs->fields['total']+0);

// fetch recent members from current group
$gmember    = array();
$sql 	    = "SELECT * FROM group_mem WHERE GID = '" .$GID. "' AND approved ='yes' ORDER BY AID DESC LIMIT 0, 4";
$rs 	    = $conn->execute($sql);
if ( $conn->Affected_Rows() ) {
    while ( !$rs->EOF ) {
        $gmember[] = $rs->fields['MID'];
        $rs->movenext();
    }
}

if ( $gmember ) {
    $group_members 	= implode(',', $gmember);
    $sql 		    = "SELECT * FROM signup WHERE UID IN (" .$group_members. ")";
    $rs 		    = $conn->execute($sql);

    STemplate::assign('gmember', $rs->getrows());
}

// fetch login user video for combobox
if( $uid ) {
        $sql 		= "select VID, title from video where UID = '" .$uid. "' $active order by VID desc";
        $rs 		= $conn->execute($sql);
        $video_ops 	= "<OPTION value='' selected>- Your Videos -</OPTION>";
        while ( !$rs->EOF ) {
    		$video_ops .= "<option value=".$rs->fields['VID'].">".$rs->fields['title']."</option>";
                $rs->movenext();
        }
        
        $fav            = array();
        $video_ops     .="<OPTION value=''>- Your Favorite Videos -</OPTION>";
        $sql 		    = "select VID from favourite where UID = '" .$uid. "'";
        $rs             = $conn->execute($sql);
        while(!$rs->EOF) {
                $fav[] = $rs->fields['VID'];
                $rs->movenext();
        }

        if ( isset($fav['0']) && $fav['0'] != '' ) {
                $fav_video = implode(',', $fav);
                $sql = "select VID, title from video where VID in ($fav_video) $active order by VID desc";
                $rs  = $conn->execute($sql);
                while ( !$rs->EOF ) {
                        $video_ops .= "<option value=".$rs->fields['VID'].">".htmlspecialchars($rs->fields['title'], ENT_QUOTES, 'UTF-8')."</option>";
                        $rs->movenext();
                }
        }

        STemplate::assign('video_ops', $video_ops);
}

$add = base64_encode("&urlkey=$_REQUEST[urlkey]");
STemplate::assign('add',$add);

STemplate::assign('err',$err);
STemplate::assign('msg',$msg);
STemplate::assign('answers', $group);
STemplate::assign('head_bottom', 'grouplinks.tpl');
if ( isset($_SESSION['UID']) )
	STemplate::assign('head_bottom_add', 'crglinks.tpl');
STemplate::display('head1.tpl');
STemplate::display('err_msg.tpl');
STemplate::display('groups_home.tpl');
STemplate::display('footer.tpl');
STemplate::gzip_encode();
?>
