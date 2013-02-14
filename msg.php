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

chk_member_login();

$id 		= ( isset($_REQUEST['id']) && is_numeric($_REQUEST['id']) ) ? mysql_real_escape_string($_REQUEST['id']) : NULL;
$username	= mysql_real_escape_string($_SESSION['USERNAME']);
if ( !$id )
	die('Nice try!');

if ( isset($_GET['s']) && $_GET['s'] == '0' ) {
	$sql = "UPDATE pm SET seen = '1' WHERE pm_id = '" .$id. "' LIMIT 1";
	$conn->execute($sql);
}
    
$sql = "SELECT * FROM pm WHERE pm_id='" .$id. "' AND ( sender = '" .$username. "' OR receiver = '" .$username. "' ) LIMIT 1";
$rs = $conn->execute($sql);
if ( !$conn->Affected_Rows() ) {
    session_write_close();
    header('Location: ' .$config['BASE_URL']. '/error.php?type=msg_missing');
    die();
}

STemplate::assign('subject', stripslashes(fx_replace('$sender_name',$rs->fields['subject'],$rs->fields['sender'])));
STemplate::assign('body', stripslashes($rs->fields['body']));
STemplate::assign('sender', $rs->fields['sender']);
STemplate::assign('date', $rs->fields['date']);

$sql    = "SELECT UID FROM signup WHERE username='".$rs->fields['sender']."'";
$rs_u   = $conn->execute($sql);

STemplate::assign('userid', $rs_u->fields['UID']);
STemplate::assign('err', $err);
STemplate::assign('head_bottom', 'msglinks.tpl');
STemplate::display('head1.tpl');
STemplate::display('msg.tpl');
STemplate::display('footer.tpl');
STemplate::gzip_encode();
?>
