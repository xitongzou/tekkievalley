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
require('language/' .$_SESSION['language']. '/mail.lang.php');

chk_member_login();

$uid		= mysql_real_escape_string($_SESSION['UID']);
$username 	= mysql_real_escape_string($_SESSION['USERNAME']);
$type		= ( isset($_REQUEST['type']) ) ? $_REQUEST['type'] : NULL;
$page       = ( isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) ) ? $_REQUEST['page'] : 1;

if ( isset($_POST['id']) ) {
	$id = ( isset($_POST['id']) && is_numeric($_POST['id']) ) ? $_REQUEST['id'] : NULL;
	$sql = "UPDATE pm SET outbox_track = 1 WHERE pm_id = '" .mysql_real_escape_string($id). "' AND sender = '" .$username. "'";
	$conn->execute($sql);
    $msg = 'Message removed successfuly!';
}

$sql_count      = "SELECT count(pm_id) AS total_messages FROM pm WHERE sender = '" .$username. "' AND outbox_track = '2'";
$ars            = $conn->execute($sql_count);
$total          = $ars->fields['total_messages'];
$pagination     = new Pagination();
$limit          = $pagination->getLimit($total);
$sql            = "SELECT * FROM pm WHERE sender = '" .$username. "' AND outbox_track = '2' ORDER BY pm_id DESC LIMIT " .$limit;
$rs             = $conn->execute($sql);
$pagination_url = $config['BASE_URL']. '/mail/outbox/{#PAGE#}';
$page_link      = $pagination->getPagination($pagination_url);
$start_num      = $pagination->getStartItem();
$end_num        = $pagination->getEndItem();

$pm_id          = array();
$subject        = array();
$body           = array();
$receiver       = array();
$date           = array();
if ( $conn->Affected_Rows() ) {
    while ( !$rs->EOF ) {
        $pm_id[]    = $rs->fields['pm_id'];
        $subject[]  = $rs->fields['subject'];
        $body[]     = $rs->fields['body'];
        $receiver[] = $rs->fields['receiver'];
        $date[]     = $rs->fields['date'];
        $rs->movenext();
    }
}

STemplate::assign('pm_id', $pm_id);
STemplate::assign('subject', $subject);
STemplate::assign('body', $body);
STemplate::assign('receiver', $receiver);
STemplate::assign('date', $date);
STemplate::assign('start_num',$start_num);
STemplate::assign('end_num',$end_num);
STemplate::assign('page_link',$page_link);
STemplate::assign('total', $total);
STemplate::assign('err', $err);
STemplate::assign('msg', $msg);
STemplate::assign('head_bottom', 'msglinks.tpl');
STemplate::display('head1.tpl');
STemplate::display('err_msg.tpl');
STemplate::display('outbox.tpl');
STemplate::display('footer.tpl');
STemplate::gzip_encode();
?>
