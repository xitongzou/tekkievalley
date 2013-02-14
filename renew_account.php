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
require('language/' .$_SESSION['language']. '/renew_account.lang.php');

if ( $config['enable_package'] == 'yes' ) {
    if ( isset($_POST['submit']) ) {
        if( $_POST['pack_id'] == '' ) {
            $err = $lang['renew_account.select_package'];
        } else {    
			$uid 	 = ( isset($_GET['uid']) ) ? base64_decode($_GET['uid']) : NULL;
            if ( $uid && is_numeric($uid) ) {
			    $pack_id = ( is_numeric($_POST['pack_id']) ) ? $_POST['pack_id'] : NULL;
			    session_write_close();
                header('Location: pack_ops.php?pack=' .$pack_id. '&uid=' .base64_encode($uid));
			    die();
            } else {
                session_write_close();
                header('Location: ' .$config['BASE_URL']. '/error.php');
                die();
            }
        }
	}

    $sql = "select * from package where status = 'Active' and is_trial<>'yes' order by price desc";
    $rs = $conn->execute($sql);
    STemplate::assign('package', $rs->getrows());
}

STemplate::assign('err',$err);
STemplate::assign('msg',$msg);
STemplate::assign('head_bottom',"homelinks.tpl");
STemplate::display('head1.tpl');
STemplate::display('err_msg.tpl');
STemplate::display('renew_account.tpl');
STemplate::display('footer.tpl');
STemplate::gzip_encode();
?>
