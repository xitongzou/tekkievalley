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
require('language/' .$_SESSION['language']. '/invite_members.lang.php');

chk_member_login();

$uid 	    = mysql_real_escape_string($_SESSION['UID']);
$username   = mysql_real_escape_string($_SESSION['USERNAME']);
$urlkey     = ( isset($_REQUEST['urlkey']) ) ? mysql_real_escape_string($_REQUEST['urlkey']) : NULL;
$sql 	    = "select * from group_own where gurl='" .$urlkey. "' limit 1";
$rs 	    = $conn->execute($sql);
$gname      = $rs->fields['gname'];
$gupload    = $rs->fields['gupload'];
STemplate::assign('gupload', $gupload);
STemplate::assign('gname',$gname);
$flist      = $_REQUEST['flist'];

if ( isset($_REQUEST['send']) && $_REQUEST['send'] != '' ) {
	$sql            = "select username, fname, lname from signup where UID='" .$uid. "' LIMIT 1";
	$rs             = $conn->execute($sql);
	$sender_name    = $rs->fields['username'];
	$sender_fname   = $rs->fields['fname'];
	$sender_lname   = $rs->fields['lname'];
	STemplate::assign('sender_name',$sender_name);
	STemplate::assign('sender_fname',$sender_fname);
	STemplate::assign('sender_lname',$sender_lname);

	$message 	= ( isset($_REQUEST['message']) ) ? $filterObj->process($_REQUEST['message']) : NULL;
	$recipients	= ( isset($_REQUEST['recipients']) ) ? $_REQUEST['recipients'] : NULL;
	if ( $message == '' )
		$err = $lang['invite_members.message_empty'];
	elseif ( $flist['0'] == '' and $recipients == '' )
		$err = $lang['invite_members.recipients_empty'];
	else {
        $rs 	= $conn->execute("select * from emailinfo where email_id='invite_group_email' limit 1");
        $subj 	= $rs->fields['email_subject'];
        $subj   = str_replace('{$gname}',$gname,$subj);
		$subj   = str_replace('$sender_name',$sender_name,$subj);
        $email_path = $rs->fields['email_path'];
		if ( count($flist) > 0 ) {
            for ( $i=0; $i<count($flist); $i++ ) {
                $rs_e   = $conn->execute("select * from signup where username='".$flist[$i]."'");
                $count  = $rs_e->rowcount();
                STemplate::assign('receiver_name', $rs_e->fields['username']);
                STemplate::assign('receiver_fname', $rs_e->fields['fname']);
                STemplate::assign('receiver_lname', $rs_e->fields['lname']);
                $key = md5($rs_e->fields['UID'].$urlkey);
                if ( $count > 0 ) {
                    $conn->execute("insert pm set subject='" .$subj. "',
                                    body='".$message."<br><br>" .$lang['invite_members.click_here']. "<A href=$config[BASE_URL]/groups_home.php?urlkey=$urlkey&key=$key>$config[BASE_URL]/groups_home.php?urlkey=$urlkey&key=$key</A> " .$lang['invite_members.visit']. "',
                                    sender='" .$username. "',
                                    receiver='" .$flist[$i]. "',
                                    date='" .date('Y-m-d H:i:s'). "'");
                    $conn->execute("insert buddy_list set username='" .$username. "', buddy_name='" .$flist[$i]. "'");
                }
                
                $sql    = "select email from signup where username='".$flist[$i]."'";
                $rs     = $conn->execute($sql);
                $to     = $rs->fields['email'];
                $name   = $_SESSION['USERNAME'];
                $from   = $_SESSION['EMAIL'];

                STemplate::assign('message', $message);
                STemplate::assign('key',$key);
                STemplate::assign('firstname',$flist[$i]);
                
                $mailbody   = STemplate::fetch($email_path);
                $mailbody   = nl2br($mailbody);
                $subj       = str_replace('{$gname}',$gname,$subj);
			    $subj       = str_replace('$sender_name',$sender_name,$subj);
                mailing($to,$name,$from,$subj,$mailbody);
			    $msg = $lang['invite_members.sent'];
            }
        }

        if ( $recipients ) {
		    $emails = explode(',', $recipients);
		    for ( $i=0; $i < count($emails); $i++ ) {
                $to	        = $emails[$i];
                $name	    = $_SESSION['USERNAME'];
                $from       = $_SESSION['EMAIL'];
                STemplate::assign('message', $message);
                $mailbody   = STemplate::fetch($email_path);
                $mailbody   = nl2br($mailbody);
			    $subj       = str_replace('$sender_name',$sender_name,$subj);
			    $subj       = str_replace('$gname',$gname,$subj);
                mailing($to,$name,$from,$subj,$mailbody);
			    $msg = $lang['invite_members.sent'];
            }
        }
    }
}


$sql = "select fname from signup where UID='$uid'";
$rs = $conn->execute($sql);
$first_name = $rs->fields['fname'];
STemplate::assign('first_name', $first_name);
$sql = "select friends_name, FID from friends where UID=$uid and friends_status='Confirmed'";
$rs = $conn->execute($sql);
while(!$rs->EOF) {
	$my_friends[] = $rs->fields['friends_name'];
        $fname .= "<option value=".$rs->fields['friends_name'].">".$rs->fields['friends_name']."</option>\n";
        $rs->movenext();
}

STemplate::assign('fname',$fname);
STemplate::assign('myfriends',$my_friends);
STemplate::assign('err', $err);
STemplate::assign('msg', $msg);
STemplate::assign('head_bottom_add',"crglinks.tpl");
STemplate::display('head1.tpl');
STemplate::display('err_msg.tpl');
STemplate::display('invite_members.tpl');
STemplate::display('footer.tpl');
STemplate::gzip_encode();
?>
