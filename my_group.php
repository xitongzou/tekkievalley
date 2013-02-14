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
require('language/' .$_SESSION['language']. '/my_group.lang.php');

chk_member_login();

$uid 	= mysql_real_escape_string($_SESSION['UID']);
$type	= ( isset($_REQUEST['type']) ) ? $_REQUEST['type'] : NULL;
$page	= ( isset($_GET['page']) && is_numeric($_GET['page']) ) ? $_GET['page'] : 1;

$mid    = array();
$sql    = "SELECT GID FROM group_mem WHERE MID = '" .$uid. "'";
$rs     = $conn->execute($sql);
if ( $conn->Affected_Rows() ) {
    while ( !$rs->EOF ) {
        $mid[]  = $rs->fields['GID'];
        $rs->movenext();
    }
}

$sql_add = NULL;
if ( $mid ) {
    $sql_add = " OR GID IN (" .implode(',', $mid). ")";
}

$sql_count      = "SELECT count(*) AS total_groups FROM group_own WHERE OID = '" .$uid. "'" .$sql_add;
$ars            = $conn->execute($sql_count);
$total          = $ars->fields['total_groups'];
$pagination     = new Pagination(ceil($config['items_per_page']/2));
$limit          = $pagination->getLimit($total);
$sql            = "SELECT DISTINCT * FROM group_own WHERE OID = '" .$uid. "'" .$sql_add. " LIMIT " .$limit;
$rs             = $conn->execute($sql);
$groups         = $rs->getrows();
$pagination_url = $config['BASE_URL']. '/my_group/{#PAGE#}';
$page_link      = $pagination->getPagination($pagination_url);
$start_num      = $pagination->getStartItem();
$end_num        = $pagination->getEndItem();

STemplate::assign('err', $err);
STemplate::assign('msg', $msg);
STemplate::assign('page', $page);
STemplate::assign('start_num', $start_num);
STemplate::assign('end_num', $end_num);
STemplate::assign('page_link', $page_link);
STemplate::assign('total', $total);
STemplate::assign('answers', $groups);
STemplate::assign('mytags', group_tags($sql));
STemplate::assign('head_bottom', 'grouplinks.tpl');
STemplate::display('head1.tpl');
STemplate::display('err_msg.tpl');
STemplate::display('my_group.tpl');
STemplate::display('footer.tpl');
STemplate::gzip_encode();
?>

