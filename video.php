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
require('language/' .$_SESSION['language']. '/video.lang.php');

$active     = ( $config['approve'] == '1' ) ? " AND active = '1'" : NULL;
$page 		= ( isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) ) ? $_REQUEST['page'] : 1;
$category 	= ( isset($_REQUEST['category']) && strlen($_REQUEST['category']) == 2 ) ? $_REQUEST['category'] : 'mr';
$viewtype   = ( isset($_REQUEST['viewtype']) && $_REQUEST['viewtype'] == 'detailed' ) ? 'detailed' : 'basic';

switch ( $category ) {
    case 'mv':
        $sql_add        = " ORDER BY v.viewnumber DESC";
        break;
    case 'md':
        $sql_add        = " ORDER BY v.com_num DESC";
        break;
    case 'tf':
        $sql_add        = " ORDER BY v.fav_num DESC";
        break;
    case 'tr':
        $sql_add        = " ORDER BY (v.ratedby*v.rate) DESC";
        break;
    case 'rf':
        $sql_add        = " AND v.featured = 'yes' ORDER BY v.addtime DESC";
        $sql_add_count  = " AND featured = 'yes'";
        break;
    case 'rd':
        $sql_add        = " ORDER BY rand()";
        break;
    default:
        $sql_add        = " ORDER BY v.addtime DESC";
        break;
}


$sql_add_count  = ( isset($sql_add_count) ) ? $sql_add_count : NULL;
$sql_add_count .= $active;
$sql            = "SELECT count(VID) AS total_videos FROM video WHERE type = 'public'" .$sql_add_count;
$ars            = $conn->execute($sql);
$total          = $ars->fields['total_videos'];
$pagination     = new Pagination($config['items_per_page']);
$limit          = $pagination->getLimit($total);
$sql            = "SELECT v.*, s.username FROM video AS v, signup AS s
                   WHERE v.type = 'public' AND v.UID = s.UID" .$active. $sql_add. " LIMIT " .$limit;
$rs             = $conn->execute($sql);
$videos         = $rs->getrows();
$pagination_url = $config['BASE_URL']. '/videos/' .$viewtype. '/' .$category. '/{#PAGE#}';
$page_link      = $pagination->getPagination($pagination_url);
$start_num      = $pagination->getStartItem();
$end_num        = $pagination->getEndItem();
$rs=$conn->execute("select * from channel order by name ASC");

STemplate::assign('err',$err);
STemplate::assign('msg',$msg);
STemplate::assign('page',$page);
STemplate::assign('viewtype', $viewtype);
STemplate::assign('start_num',$start_num);
STemplate::assign('end_num',$end_num);
STemplate::assign('page_link',$page_link);
STemplate::assign('total',$total);
STemplate::assign('answers',$videos);
STemplate::assign('channels', $rs->getrows());
STemplate::assign('recadd', array('a','b','c','d','e','f','g','h','i','k','l','m','n','o','p','q','r'));
STemplate::assign('head_bottom',"videolinks.tpl");
STemplate::display('head1.tpl');
STemplate::display('err_msg.tpl');
STemplate::display('search.tpl');
STemplate::display('video.tpl');
STemplate::display('footer.tpl');
STemplate::gzip_encode();
?>
