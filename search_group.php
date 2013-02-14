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
require('language/' .$_SESSION['language']. '/search_group.lang.php');

$search_type    = ( isset($_REQUEST['search_type']) ) ? $_REQUEST['search_type'] : NULL;
$search_id      = ( isset($_REQUEST['search_id']) ) ? $filterObj->process($_REQUEST['search_id']) : NULL;
$page           = ( isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) ) ? $_REQUEST['page'] : 1;

$total          = 0;
if ( !$search_id )
	$err = $lang['search_group.invalid_id'];
else {
    $searches   = explode(' ', $search_id);
    $query      = "(";
    $query_add  = NULL;
    foreach ( $searches as $item ) {
        $query     .= $query_add. "gname LIKE '%" .mysql_real_escape_string($item). "%' OR keyword LIKE '%" .mysql_real_escape_string($item). "%' OR gdescn LIKE '%" .mysql_real_escape_string($item). "%'";
        $query_add  = " OR ";
    }
    $query     .= ")";
    
    $sql_count          = "SELECT count(*) AS total_groups FROM group_own WHERE " .$query;
    $ars                = $conn->execute($sql_count);
    $total              = $ars->fields['total_groups'];
    $pagination         = new Pagination(ceil($config['items_per_page']/2));
    $limit              = $pagination->getLimit($total);    
    $sql                = "SELECT * FROM group_own WHERE " .$query. " LIMIT " .$limit;
    $rs                 = $conn->execute($sql);
    $groups             = $rs->getrows();
    $pagination_url     = $config['BASE_URL']. '/search/?search_type=search_groups&search_id=' .$search_id. '&page=' .$page;
    $page_link          = $pagination->getPagination($pagination_url);
    $start_num          = $pagination->getStartItem();
    $end_num            = $pagination->getEndItem();
	$tags               = group_tags($sql);
	STemplate::assign('tags',$tags);
}

if ( $total == 0 ) {
    $err = $lang['search_group.nothing'];
}

STemplate::assign('err', $err);
STemplate::assign('msg', $msg);
STemplate::assign('page', $page);
STemplate::assign('start_num', $start_num);
STemplate::assign('end_num', $end_num);
STemplate::assign('page_link', $page_link);
STemplate::assign('total', $total);
STemplate::assign('answers', $groups);
STemplate::assign('head_bottom', 'grouplinks.tpl');
STemplate::display('head1.tpl');
STemplate::display('err_msg.tpl');
STemplate::display('search.tpl');
STemplate::assign('ttime',($t2-$t1));
STemplate::display('search_group.tpl');
STemplate::display('footer.tpl');
STemplate::gzip_encode();
?>
