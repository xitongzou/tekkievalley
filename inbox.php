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

$username = mysql_real_escape_string($_SESSION['USERNAME']);
$page     = ( isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) ) ? $_REQUEST['page'] : NULL;

if ( isset($_POST['id']) ) {
    $id  = ( isset($_POST['id']) && is_numeric($_POST['id']) ) ? mysql_real_escape_string($_POST['id']) : NULL;
	$conn->execute("UPDATE pm SET inbox_track = 1 WHERE pm_id = '" .$id. "' AND receiver='" .$username. "' LIMIT 1");
	$msg = $lang['mail.delete'];
    $msg = 'Message successfuly deleted!';
}

$sql_count      = "SELECT count(pm_id) AS total_messages FROM pm WHERE receiver = '" .$username. "' AND inbox_track = '2'";
$ars            = $conn->execute($sql_count);
$total          = $ars->fields['total_messages'];
$pagination     = new Pagination($config['items_per_page']);
$limit          = $pagination->getLimit($total);
$sql            = "SELECT * FROM pm WHERE receiver = '" .$username. "' AND inbox_track = '2' ORDER BY pm_id DESC LIMIT " .$limit;
$rs             = $conn->execute($sql);
$pagination_url = $config['BASE_URL']. '/mail/inbox/{#PAGE#}';
$page_link      = $pagination->getPagination($pagination_url);
$start_num      = $pagination->getStartItem();
$end_num        = $pagination->getEndItem();

$pm_id          = array();
$body           = array();
$sender         = array();
$date           = array();
$seen           = array();
if ( $conn->Affected_Rows() ) {
    while ( !$rs->EOF ) {
        $pm_id[]    = $rs->fields['pm_id'];
        $body[]     = $rs->fields['body'];
        $sender[]   = $rs->fields['sender'];
        $subject[]  = $rs->fields['subject'];
        $date[]     = $rs->fields['date'];
        $seen[]     = $rs->fields['seen'];
        $rs->movenext();
    }
}

STemplate::assign('pm_id', $pm_id);
STemplate::assign('subject', $subject);
STemplate::assign('body', $body);
STemplate::assign('sender', $sender);
STemplate::assign('date', $date);
STemplate::assign('seen', $seen);
STemplate::assign('start_num', $start_num);
STemplate::assign('end_num', $end_num);
STemplate::assign('page_link', $page_link);
STemplate::assign('total', $total);
STemplate::assign('err', $err);
STemplate::assign('msg', $msg);
STemplate::assign('head_bottom', 'msglinks.tpl');
STemplate::display('head1.tpl');
STemplate::display('err_msg.tpl');
STemplate::display('inbox.tpl');
STemplate::display('footer.tpl');
STemplate::gzip_encode();
?>
