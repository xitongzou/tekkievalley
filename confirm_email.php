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
require('language/' .$_SESSION['language']. '/confirm.lang.php');

$vcode = ( isset($_REQUEST['vcode']) ) ? mysql_real_escape_string($_REQUEST['vcode']) : NULL;
if ( $vcode ) {
	$sql="select * from verify as v,signup as s WHERE v.vcode='$vcode' and v.UID=s.UID limit 1";
	$rs  = $conn->execute($sql);
	if ( $rs->recordcount() == 0 ) {
		$err = 'Invalid Verification code!';
	} else {
		$sql="update signup set emailverified='yes' where UID='" .$rs->fields['UID']. "'";
		$conn->execute($sql);
		
		session_register('UID');
		session_register('EMAIL');
		session_register('USERNAME');
		session_register('EMAILVERIFIED');
		
		$_SESSION['UID']=$rs->fields['UID'];
		$_SESSION['EMAIL']=$rs->fields['email'];
		$_SESSION['USERNAME']=$rs->fields['username'];
		$_SESSION['EMAILVERIFIED']="yes";
		
		settype($_SESSION['UID'], 'integer');
		
		if(mysql_affected_rows()>=1) {
			$msg = 'Your email has been successfully verified.';
		} else {
			$msg = 'Your email is already verified.';
		}
        }
}

if ( isset($_REQUEST['action_send']) && $_REQUEST['action_send'] != '' ) {
        $uid = mysql_real_escape_string($_SESSION['UID']);
        $ran=time().rand(1,99999999);
        $sql="update verify as v, signup as s set v.vcode='$ran', s.emailverified='no' WHERE v.UID=s.UID and v.UID=$uid";
        $conn->execute($sql);
        STemplate::assign('vcode',$ran);
        $to=$_SESSION['EMAIL'];
        $name=$config['site_name'];
        $from=$config['admin_email'];

        $rs = $conn->execute("select * from emailinfo where email_id='verify_email'");
        $subj = $rs->fields['email_subject'];
        $email_path = $rs->fields['email_path'];
        $mailbody=STemplate::fetch($email_path);
        mailing($to,$name,$from,$subj,$mailbody);
        session_to_db();
        $msg = "A verification email is sent to your address. Please check your email.";
}

STemplate::assign('err',$err);
STemplate::assign('msg',$msg);
STemplate::display('head1.tpl');
STemplate::display('err_msg.tpl');
STemplate::display('confirm_email.tpl');
STemplate::display('footer.tpl');
STemplate::gzip_encode();
?>
