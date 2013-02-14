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
require('language/' .$_SESSION['language']. '/recoverpass.lang.php');

if ( isset($_REQUEST['recover']) ) {
	$email = trim($_REQUEST['email']);
	if ( $email == '' )
		$err = $lang['recoverpass.email_empty'];
	else {
                $sql = "select UID, username, pwd, fname, lname from signup where email='" .mysql_real_escape_string($email). "' limit 1";
                $rs = $conn->execute($sql);
                if( $rs->fields['UID'] == '' )
                        $err = $lang['recoverpass.email_invalid'];
                else {
                        $my_new_pw = pw_gen(); 
			$userid = $rs->fields['UID'];
                        STemplate::assign('receiver_name', $rs->fields['username']);
                        STemplate::assign('receiver_fname', $rs->fields['fname']);
                        STemplate::assign('receiver_lname', $rs->fields['lname']);
                        STemplate::assign('password', $my_new_pw);
                        $rs = $conn->execute('UPDATE signup SET pwd = \''.md5($my_new_pw).'\' WHERE UID = \''.$userid.'\' LIMIT 1');
                        $rs = $conn->execute("select * from emailinfo where email_id='recover_password' limit 1");
                        $subj = $rs->fields['email_subject'];
                        $email_path = $rs->fields['email_path'];
			$body = STemplate::fetch($email_path);
			mailing($_REQUEST['email'], $config['site_name'], $config['admin_email'], $subj, $body);
                        $msg = $lang['recoverpass.email_sent'];
                }
        }
}


STemplate::assign('err',$err);
STemplate::assign('msg',$msg);
STemplate::assign('head_bottom',"homelinks.tpl");
STemplate::display('head1.tpl');
STemplate::display('err_msg.tpl');
STemplate::display('recoverpass.tpl');
STemplate::display('footer.tpl');
STemplate::gzip_encode();
?>
