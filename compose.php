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
require('language/' .$_SESSION['language']. '/mail.lang.php');

if ( $config['private_msgs'] == 0 )
	$err = $lang['mail.pms_disabled'];

chk_member_login();

$username = mysql_real_escape_string($_SESSION['USERNAME']);
if( isset($_REQUEST['receiver']) && $_REQUEST['receiver'] == $_SESSION['USERNAME'] )
	$err = $lang['mail.self'];
elseif( isset($_REQUEST['send']) && $_REQUEST['send'] != '' ) {
        if( isset($_REQUEST['buddy_name']) && $_REQUEST['buddy_name'] != 'Select Buddy' )
                $receiver_name = mysql_real_escape_string($_REQUEST['buddy_name']);
        else
                $receiver_name = mysql_real_escape_string($_REQUEST['receiver']);
        STemplate::assign("receiver_name", $receiver_name);
	
	$receiver = ( isset($_REQUEST['receiver']) ) ? mysql_real_escape_string($filterObj->process(trim($_REQUEST['receiver']))) : NULL;
	$buddy	  = ( isset($_REQUEST['buddy_name']) ) ? mysql_real_escape_string($filterObj->process(trim($_REQUEST['buddy_name']))) : NULL;
	$subject  = ( isset($_REQUEST['subject']) ) ? mysql_real_escape_string($filterObj->process(trim($_REQUEST['subject']))) : NULL;
	$details  = ( isset($_REQUEST['details']) ) ? mysql_real_escape_string($filterObj->process(trim($_REQUEST['details']))) : NULL;
	
        if ( $receiver_name == '' and $buddy_name == 'Select Buddy' )
    		$err = $lang['mail.receiver_empty'];
        elseif ( $subject == '' )
                $err = $lang['mail.subject_empty'];
        elseif ( $details == '' )
                $err = $lang['mail.details_empty'];
        else {
    		$rs_e = $conn->execute("select * from signup where username='" .$receiver_name. "'");
                $count = $rs_e->rowcount();
                if($count>0) {
                        $conn->execute("insert pm set subject='" .$subject. "', body='" .$details. "', sender='" .$username. "', receiver='" .$receiver_name. "', date='".date('Y-m-d H:i:s')."'");
                        $conn->execute("insert buddy_list set username='" .$username. "', buddy_name='" .$receiver_name. "'");
                        $rs_u = $conn->execute("select email, pm_notify from signup where username='" .$receiver_name. "' limit 1");
                        if ( $rs_u->fields['pm_notify'] == '1' && $config['pm_notify'] == '1' ) {
                                STemplate::assign("user_id", $_SESSION['id']);
                                STemplate::assign("user_name", $_SESSION['username']);
                                STemplate::assign("user_type", $_SESSION['type']);
                                STemplate::assign('sitename', $config['BASE_URL']);

                                $to = $rs_u->fields['email'];
                                $name = $config['admin_name'];
                                $from = $config['admin_email'];
                                $subj = $config['site_name']." - New Private Message";
                                $body = STemplate::fetch("mail/new_pm_notify.tpl");

                                mailing($to,$name,$from,$subj,$body);
                        }
			
			session_write_close();
                        header('Location: inbox.php?msg=' .$lang['mail.sent']);
			die();
                } else {
                    $err = $lang['mail.no_username'];
                }
        }

        $sql = "SELECT * FROM buddy_list WHERE username = '" .$username. "'";
        $rs = $conn->execute($sql);
        $buddy_name = array();
        $buddy_name[] = "Select Buddy";
        while(!$rs->EOF) {
                $buddy_name[] = $rs->fields['buddy_name'];
                $rs->movenext();
        }
}

STemplate::assign('buddy_name', $buddy_name);
STemplate::assign('err', $err);
STemplate::assign('msg', $msg);
STemplate::assign('head_bottom', 'msglinks.tpl');
STemplate::display('head1.tpl');
STemplate::display('err_msg.tpl');
if ( $config['private_msgs'] == 1 )
	STemplate::display('compose.tpl');
STemplate::display('footer.tpl');
STemplate::gzip_encode();
?>
