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
require('classes/captcha.class.php');
require('language/' .$_SESSION['language']. '/signup.lang.php');

if ( $config['user_registrations'] == 0 ) {
	$msg = $lang['signup.registration_disabled'];
	session_write_close();
	header('Location: index.php?msg=' .$msg);
	die();
}

$email      = NULL;
$username   = NULL;
if ( isset($_REQUEST['action_signup']) && $_REQUEST['action_signup'] != '' ) {
    $email      = $filterObj->process(trim($_POST['email']));
	$password	= $filterObj->process(trim($_POST['password1']));
	$username	= $filterObj->process(trim($_POST['username']));

	if( $email == '' )
		$err = $lang['signup.email_empty'];
	elseif ( !check_email($email) )
		$err = $lang['signup.email_invalid'];
	elseif ( check_field_exists($email, 'email', 'signup') == 1 )
		$err = $lang['signup.email_exists'];
	elseif ( $username == '' )
		$err = $lang['signup.username_empty'];
	elseif ( !preg_match('/^[a-zA-Z0-9_]*$/', $username) )
		$err = $lang['signup.username_invalid'];
    elseif ( preg_match('/^[_]*$/', $username) )
        $err = $lang['signup.username_invalid'];
	elseif ( check_field_exists($username, 'username', 'signup') == 1 )
		$err = $lang['signup.username_exists'];
	elseif ( $password == '' )
		$err = $lang['signup.password_empty'];
	elseif ( $password != $_REQUEST['password2'] )
		$err = $lang['signup.password_mismatch'];
	elseif ( !PhpCaptcha::Validate($_REQUEST['capcha']) ) {
		if ( $config['captcha'] ==1 )
			$err = $lang['signup.captcha_invalid'];
	} elseif ( $config['enable_package'] == 'yes' and $_REQUEST['pack_id'] == '' )
		$err = $lang['signup.select_package'];
		
        if ( $err == '' ) {
		$email 		= mysql_real_escape_string($email);
		$username 	= mysql_real_escape_string($username);
		$passwd		= mysql_real_escape_string(md5($password));
		$sql		= "insert into signup set email='" .$email. "', username='" .$username. "', pwd='" .$passwd. "', addtime='".time()."', logintime='".time()."'";
		$conn->execute($sql);
		$userid		= mysql_insert_id();	
		$sql		= "insert into verify set UID='" .$userid. "'";
		$conn->execute($sql);		
		$sql        = "insert subscriber set UID='" .$userid. "'";
		$conn->execute($sql);
				
		if( $config['enable_package'] == 'yes' ) {
			$pack_id = mysql_real_escape_string($_REQUEST['pack_id']);
			$sql = "select * from package where pack_id='" .$pack_id. "'";
			$rs  = $conn->execute($sql);
			if( $rs->fields['is_trial'] == 'yes' ) {
				$expired_time = date("Y-m-d H:i:s", strtotime("+".$rs->fields['trial_period']." day"));	
				$sql = "update subscriber set pack_id='" .$pack_id. "', subscribe_time='".date("Y-m-d H:i:s")."',
						expired_time='" .$expired_time. "' where UID = '" .$userid. "' limit 1";
				$conn->execute($sql);
			} else {
				$sql = "update signup set acount_status='Inactive' where UID='" .$userid. "' limit 1";
				$conn->execute($sql);
				session_write_close();
				header("Location: pack_ops.php?pack=$_REQUEST[pack_id]&uid=".base64_encode($userid));
				die();
			}
		}

        $sql = "INSERT INTO users_online (UID, online) VALUES (" .$userid. ", " .time(). ")";
        $conn->execute($sql);
		
		$_SESSION['UID']		= $userid;
		$_SESSION['EMAIL']		= $_REQUEST['email'];
		$_SESSION['USERNAME']		= $_REQUEST['username'];
		$_SESSION['EMAILVERIFIED']	= 'no';
		
		$ran=time().rand(1,99999999);
		$sql="update verify as v, signup as s set v.vcode='" .$ran. "', s.emailverified='no' WHERE v.UID=s.UID and v.UID='" .$userid. "'";
		$conn->execute($sql);
		STemplate::assign('vcode',$ran);

		$to 		= $_SESSION['EMAIL'];
		$name		= $config['site_name'];
		$from		= $config['admin_email'];
		$rs 		= $conn->execute("select * from emailinfo where email_id='verify_email'");
		$subj 		= $rs->fields['email_subject'];
		$email_path 	= $rs->fields['email_path'];
		$mailbody	= STemplate::fetch($email_path);
		mailing($to,$name,$from,$subj,$mailbody);
		
		$_SESSION['verification_sent'] = $lang['signup.verification_sent'];
		
		$redirect = ( isset($_SESSION['redirect']) && $_SESSION['redirect'] != '' ) ? $_SESSION['redirect'] : $config['BASE_URL'];
		$_SESSION['redirect'] = NULL;
		
		session_write_close();
		header('Location: ' .$redirect);
		die();
	}
}

if ( $config['enable_package'] == 'yes' ) {
        $sql = "select * from package where status = 'Active' order by price desc";
        $rs = $conn->execute($sql);
        STemplate::assign('package', $rs->getrows());
}

STemplate::assign('err',$err);
STemplate::assign('msg',$msg);
STemplate::assign('head_bottom',"homelinks.tpl");
STemplate::assign('username', $username);
STemplate::assign('email', $email);
STemplate::display('head1.tpl');
STemplate::display('err_msg.tpl');
STemplate::display('signup.tpl');
STemplate::display('footer.tpl');
STemplate::gzip_encode();
?>
