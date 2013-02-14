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
require('language/' .$_SESSION['language']. '/invite.lang.php');

chk_member_login();

$uid = mysql_real_escape_string($_SESSION['UID']);

if ( isset($_REQUEST['action_invite']) && $_REQUEST['action_invite'] != '' ) {
	$first_name = ( isset($_REQUEST['first_name']) && $_REQUEST['first_name'] != '' ) ? mysql_real_escape_string($_REQUEST['first_name']) : NULL;
	$recipients = ( isset($_REQUEST['recipients']) && $_REQUEST['recipients'] != '' ) ? $_REQUEST['recipients'] : NULL;
	$ruid	    = ( isset($_REQUEST['UID']) && is_numeric($_REQUEST['UID']) ) ? $_REQUEST['UID'] : NULL;
	if ( $first_name ) {
		$sql = "UPDATE signup SET fname = '" .$first_name. "' WHERE UID = '" .$uid. "' LIMIT 1";
		$conn->execute($sql);
	}
	
	if ( $first_name == '' )
		$err = $lang['invite.fname_empty'];
	elseif ( $recipients == '' && $ruid == '' )
		$err = $lang['invite.recipient_empty'];
    elseif ( $ruid == $uid ) 
        $err = $lang['invite.recipient_self'];
	else {
		$sql = "SELECT username, fname, lname FROM signup WHERE UID = '" .$uid. "' LIMIT 1";
		$rs  = $conn->execute($sql);
		
		STemplate::assign('sender_name', $rs->fields['username']);
		STemplate::assign('sender_fname', $rs->fields['fname']);
		STemplate::assign('sender_lname', $rs->fields['lname']);
		
		$sender_name = $_SESSION['USERNAME'];
		$rs = $conn->execute("SELECT * FROM emailinfo WHERE email_id = 'invite_email' LIMIT 1");
		$subj = $rs->fields['email_subject'];
		$subj = str_replace('$sender_name', $sender_name, $subj);
		$email_path = $rs->fields['email_path'];
		
		if ( !$ruid ) {
			$emails = explode(',', $recipients);
			for ( $i=0; $i<count($emails); $i++ ) {
				$to = $emails[$i];
				$name = $_SESSION['USERNAME'];
				$from = $_SESSION['EMAIL'];
				$message = ( isset($_REQUEST['message']) ) ? $_REQUEST['message'] : NULL;
				
				STemplate::assign('message', $message);
				STemplate::assign('freqkey', $uid);
				
				$sql = "INSERT INTO friends SET UID = '" .$uid. "', friends_name = '" .$emails[$i]. "', friends_type = 'All|Friends', invite_date='".date('Y-m-d')."'";
				$conn->execute($sql);
				$id=mysql_insert_id();
				
				STemplate::assign('id', $id);
				
				$mailbody = STemplate::fetch($email_path);
				$mailbody = nl2br($mailbody);
				mailing($to, $name, $from, $subj, $mailbody);
				$msg = $lang['invite.sent'];
			}
		} else {
			$sql = "SELECT * FROM signup WHERE UID = '" .$ruid. "' LIMIT 1";
			$rs  = $conn->execute($sql);
			
			STemplate::assign('receiver_name', $rs->fields['username']);
			STemplate::assign('receiver_fname', $rs->fields['fname']);
			STemplate::assign('receiver_lname', $rs->fields['lname']);
			
			$to         = $rs->fields['email'];
			$name       = $_SESSION['USERNAME'];
			$from       = $config['admin_email'];
			$message    = ( isset($_REQUEST['message']) ) ? $_REQUEST['message'] : NULL;
			
			STemplate::assign('message', $message);
			STemplate::assign('freqkey', $uid);

			$sql = "SELECT UID, FID FROM friends WHERE UID = '" .$uid. "' AND FID = '" .$ruid. "' LIMIT 1";
			$rs2 = $conn->execute($sql);
            if ( $conn->Affected_Rows() ) {
				$sql = "UPDATE friends SET invite_date = '" .date('Y-m-d'). "' WHERE UID = '" .$uid. "' AND FID = '" .$ruid. "'";
				$conn->execute($sql);
				$msg = $lang['invite.already_invited'];
                $URL = seo_url('invite/' .$ruid. '/?msg=' .$msg, 'invite_friends.php?UID=' .$ruid. '&msg=' .$msg);
				session_write_close();
				header('Location: ' .$URL);
				die();
			} else {
				$sql = "INSERT INTO friends SET UID = '" .$uid. "', FID = '" .$ruid. "', friends_name = '" .$rs->fields['username']. "', friends_type='All|Friends', invite_date='".date('Y-m-d')."'";
				$conn->execute($sql);
			}
			
			$id = mysql_insert_id();
			
			STemplate::assign('id', $id);
			STemplate::assign('firstname', $rs->fields['username']);

			$mailbody = STemplate::fetch($email_path);
			$mailbody = nl2br($mailbody);
			$username = mysql_real_escape_string($_SESSION['USERNAME']);
			$conn->execute("INSERT pm SET subject = '" .$subj. "', body = '" .$mailbody. "', sender = '" .$username. "', receiver = '" .$rs->fields['username']. "', date = '" .date('Y-m-d H:i:s'). "'");
			mailing($to,$name,$from,$subj,$mailbody);
			$msg = $lang['invite.success'];
		}
	}
}

$sql = "select fname from signup where UID='" .$uid. "' limit 1";
$rs = $conn->execute($sql);
$first_name = $rs->fields['fname'];
STemplate::assign('first_name', $first_name);

STemplate::assign('err',$err);
STemplate::assign('msg',$msg);
STemplate::assign('head_bottom',"friendlinks.tpl");
STemplate::display('head1.tpl');
STemplate::display('err_msg.tpl');
STemplate::display('invite_friends.tpl');
STemplate::display('footer.tpl');
STemplate::gzip_encode();
?>
