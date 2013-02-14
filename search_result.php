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

$t1=time();
require('include/config.php');
require('include/function.php');
require('classes/pagination.class.php');
require('language/' .$_SESSION['language']. '/search_result.lang.php');

$active		    = ( $config['approve'] == 1 ) ? " AND active = '1'" : NULL;
$search_id 	    = ( isset($_REQUEST['search_id']) ) ? mysql_real_escape_string($filterObj->process($_REQUEST['search_id'])) : NULL;
$search_type	= ( isset($_REQUEST['search_type']) ) ? $_REQUEST['search_type'] : 'videos';
$search_key	    = ( isset($_REQUEST['search_key']) ) ? mysql_real_escape_string($filterObj->process($_REQUEST['search_key'])) : NULL;
$sort		    = ( isset($_REQUEST['sort']) && strlen($_REQUEST['sort']) <= 7 ) ? $_REQUEST['sort'] : NULL;
$page           = ( isset($_GET['page']) && is_numeric($_GET['page']) ) ? trim($_GET['page']) : 1;
$viewtype       = ( isset($_REQUEST['viewtype']) && $_REQUEST['viewtype'] == 'detailed' ) ? 'detailed' : 'basic';

switch ( $sort ) {
    case 'addate':
        $sortby = " ORDER BY adddate DESC";
        break;
    case 'viewnum':
        $sortby = " ORDER BY viewnumber DESC";
        break;
    case 'rate':
        $sortby = " ORDER BY (ratedby*rate) DESC";
        break;
    default:
        $sortby = " ORDER BY title";
}

if ( $search_id == '' && $search_key == '' ) {
        $err = $lang['search_result.query_empty'];
}

$searching  = false;
$total      = 0;
$start_num  = NULL;
$end_num    = NULL;
$videos     = array();
$ch         = NULL;
if ( $err == '' ) {
    if ( $search_type == 'search_users' ) {
        $sql    = "SELECT UID, username FROM signup WHERE username LIKE '%" .$search_id. "%' LIMIT 1";
        $rs     = $conn->execute($sql);
        if ( $conn->Affected_Rows() ) {
            $uid        = $rs->fields['UID'];
            $username   = $rs->fields['username'];
            $URL        = seo_url('users/' .$username, 'uprofile.php?UID=' .$uid);
            session_write_close();
            header('Location: ' .$URL);
            die();
        } else {
            $err = $lang['search_result.nothing'];
        }
    } elseif ( $search_type == 'search_groups' ) {
        session_write_close();
        $URL = $config['BASE_URL']. '/search_group.php?search_type=' .$search_type. '&search_id=' .$search_id;
        header('Location: ' .$URL);
        die();
    } elseif ( $search_type == 'related' ) {
        $searching  = true;
        $list       = key_to_info($search_key);
        $ch         = explode(' ', $list['2']);
        if ( count($ch) > 1 ) {
            $channel = NULL;
            for ($i=1; $i<count($ch); $i++) {
                $channel    .= "OR keyword LIKE '%" .mysql_real_escape_string($ch[$i]). "%'";
            }
        }
        $sql_count  = "SELECT count(VID) AS total_videos FROM video WHERE type = 'public' AND (title LIKE '%" .mysql_real_escape_string($ch['0']). "%' " .$channel. ")";
        $sql        = "SELECT * FROM video WHERE type = 'public' AND (title LIKE '%" .mysql_real_escape_string($ch['0']). "%' " .$channel. ") ORDER BY VID ASC";
    } else {
        $searching  = true;
        $searches   = explode(' ', $search_id);
        $query      = "(";
        $query_add  = NULL;
        foreach ( $searches as $item ) {
            $query     .= $query_add. "title LIKE '%" .mysql_real_escape_string($item). "%' OR keyword LIKE '%" .mysql_real_escape_string($item). "%' OR description LIKE '%" .mysql_real_escape_string($item). "%'";
            $query_add  = " OR ";
        }
        $query     .= ")";
        $sql_count  = "SELECT count(VID) AS total_videos FROM video WHERE type = 'public'" .$active. " AND " .$query. $sortby;
        $sql        = "SELECT * FROM video WHERE type = 'public'" .$active. " AND " .$query. $sortby;
    }
    
    if ( $searching ) {
        $ars            = $conn->execute($sql_count);
        $total          = $ars->fields['total_videos'];
        $pagination     = new Pagination($config['items_per_page']);
        $limit          = $pagination->getLimit($total);
        $sql            = $sql. " LIMIT " .$limit;
        $rs             = $conn->execute($sql);
        $videos         = $rs->getrows();
        $pagination_url = $config['BASE_URL']. '/search/{#PAGE#}/?sort=' .$sort. '&search_type=' .$search_type. '&search_id=' .$search_id. '&search_key=' .$search_key;
        $page_link      = $pagination->getPagination($pagination_url);
        $start_num      = $pagination->getStartItem();
        $end_num        = $pagination->getEndItem();    
	    $tags           = group_tags($sql);
	    STemplate::assign('tags',$tags);
        
        if ( $total == 0 ) {
            $err = $lang['search_result.nothing'];
        }
    }
}

STemplate::assign('err',$err);
STemplate::assign('msg',$msg);
STemplate::assign('ch', $ch);
STemplate::assign('page',$page);
STemplate::assign('viewtype', $viewtype);
STemplate::assign('start_num',$start_num);
STemplate::assign('end_num',$end_num);
STemplate::assign('page_link',$page_link);
STemplate::assign('total',$total);
STemplate::assign('answers',$videos);
STemplate::assign('head_bottom',"homelinks.tpl");
STemplate::display('head1.tpl');
STemplate::display('err_msg.tpl');
STemplate::display('search.tpl');
$t2=time();
STemplate::assign('ttime',($t2-$t1));
STemplate::display('search_result.tpl');
STemplate::display('footer.tpl');
STemplate::gzip_encode();
?>
