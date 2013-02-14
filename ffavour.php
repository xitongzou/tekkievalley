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
require('language/' .$_SESSION['language']. '/ffavorites.lang.php');

chk_member_login();

$active 	= ( $config['approve'] == 1 ) ? " AND active = '1'" : NULL;
$uid 		= mysql_real_escape_string($_SESSION['UID']);
$reqtype	= ( isset($_REQUEST['type']) ) ? mysql_real_escape_string($_REQUEST['type']) : NULL;
$page       = ( isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) ) ? $_REQUEST['page'] : 1;

$friends    = array();
$sql        = "SELECT FID FROM friends WHERE UID = '" .$uid. "' AND friends_status = 'Confirmed'";
$rs         = $conn->execute($sql);
if ( $conn->Affected_Rows() ) {
    while ( !$rs->EOF ) {
        $friends[] = $rs->fields['FID'];
        $rs->movenext();
    }
}

$favorites  = array();
$page_link  = NULL;
$start_num  = NULL;
$end_num    = NULL;
if ( $friends ) {
    $friends        = implode(',', $friends);
    $sql_count      = "SELECT count(*) AS total_videos FROM video AS v, favourite AS f WHERE f.UID IN (" .$friends. ") AND f.VID = v.VID" .$active;
    $ars            = $conn->execute($sql_count);
    $total          = $ars->fields['total_videos'];
    $pagination     = new Pagination(ceil($config['items_per_page']/2));
    $limit          = $pagination->getLimit($total);
    $sql            = "SELECT * FROM video AS v, favourite AS f WHERE f.UID IN (" .$friends. ") AND f.VID = v.VID" .$active. " LIMIT " .$limit;
    $rs             = $conn->execute($sql);
    $favorites      = $rs->getrows();
    $pagination_url = $config['BASE_URL']. '/userfriends/favorites/{#PAGE#}';
    $page_link      = $pagination->getPagination($pagination_url);
    $start_num      = $pagination->getStartItem();
    $end_num        = $pagination->getEndItem();
}

STemplate::assign('err', $err);
STemplate::assign('msg', $msg);
STemplate::assign('page', $page);
STemplate::assign('start_num', $start_num);
STemplate::assign('end_num', $end_num);
STemplate::assign('page_link', $page_link);
STemplate::assign('total', $total);
STemplate::assign('answers', $favorites);
if ( $friends ) {
    STemplate::assign('tags', group_tags($sql));
}
STemplate::assign('head_bottom', 'friendlinks.tpl');
STemplate::display('head1.tpl');
STemplate::display('err_msg.tpl');
STemplate::display('search.tpl');
STemplate::display('ffavour.tpl');
STemplate::display('footer.tpl');
STemplate::gzip_encode();
?>
