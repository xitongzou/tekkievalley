<?php
defined('_VALID') or die('Restricted Access!');

chk_admin_login();

require $config['BASE_DIR']. '/classes/pagination.class.php';

$page 			= ( isset($_GET['page']) && is_numeric($_GET['page']) ) ? intval($_GET['page']) : 1;

$thumb_dir      = $config['TMB_DIR'];
$video_dir      = $config['VDO_DIR'];
$flvideo_dir    = $config['FLVDO_DIR'];
$tmp_dir        = $config['TMP_DIR']. '/thumbs';
$err            = ( isset($err) ) ? $err : NULL;
if ( !file_exists($thumb_dir) or !is_dir($thumb_dir) or !is_writable($thumb_dir) )
    $err .= 'Thumb directory ' .$thumb_dir. ' does not exist or not writable!<br>';
if ( !file_exists($video_dir) or !is_dir($video_dir) or !is_writable($video_dir) )
    $err .= 'Video directory ' .$video_dir. ' does not exist or not writable!<br>';
if ( !file_exists($flvideo_dir) or !is_dir($flvideo_dir) or !is_writable($flvideo_dir) )
    $err .= 'FLVideo directory ' .$flvideo_dir. ' does not exist or not writable!<br>';
if ( !file_exists($tmp_dir) or !is_dir($tmp_dir) or !is_writable($tmp_dir) )
    $err .= 'Temporary directory ' .$tmp_dir. ' does not exist or not writable!<br>';

if (isset($_POST['delete_selected_videos'])) {
    $index = 0;
    foreach ( $_POST as $key => $value ) {
        if ( $key != 'check_all_videos' && substr($key, 0, 18) == 'video_id_checkbox_') {
            if ( $value == 'on' ) {
                deleteVideo(str_replace('video_id_checkbox_', '', $key));
                ++$index;
            }
        }
    }
                
    if ( $index === 0 ) {
        $err = 'Please select videos to be deleted!';
    } else {
        $msg = 'Successfully deleted ' .$index. ' (selected) videos!';
    }
}


if (isset($_POST['suspend_selected_videos']) || isset($_POST['approve_selected_videos']) ) {
    $act        = 1;
    $act_name   = 'activated';
    $index      = 0;
    if ( isset($_POST['suspend_selected_videos']) ) {
        $act        = 0;
        $act_name   = 'suspended';
    }
    
    foreach ( $_POST as $key => $value ) {
        if ( $key != 'check_all_videos' && substr($key, 0, 18) == 'video_id_checkbox_') {
            if ( $value == 'on' ) {
                $vid = intval(str_replace('video_id_checkbox_', '', $key));
                $sql = "UPDATE video SET active = '" .$act. "' WHERE VID = " .$vid. " LIMIT 1";
                $conn->execute($sql);
                if ( $act_name == 'activated' ) {
                    send_video_approve_email($vid);
                }
                ++$index;
            }
        }
    }

    if ( $index === 0 ) {
        $err = 'Please select videos to be ' .$act_name. '!';
    } else {
        $msg = 'Successfully ' .$act_name. ' ' .$index. ' (selected) videos!';
    }
}

$remove = NULL;
if ( isset($_GET['a']) && $_GET['a'] != '' ) {
    $action = trim($_GET['a']);
    $VID    = ( isset($_GET['VID']) && is_numeric($_GET['VID']) && videoExists($_GET['VID']) ) ? trim($_GET['VID']) : NULL;
    if ( $VID ) {
        switch ( $action ) {
            case 'delete':
                deleteVideo($VID);
                $msg = 'Video deleted successfuly!';
                $remove = '&a=delete&VID=' .$VID;
                break;
            case 'activate':
            case 'suspend':
                $active     = ( $action == 'activate' ) ? 1 : 0;
                $message    = ( $action == 'activate' ) ? 'activated' : 'suspended';
                $sql        = "UPDATE video SET active = '" .$active. "' WHERE VID = '" .mysql_real_escape_string($VID). "' LIMIT 1";
                $conn->execute($sql);
                $msg        = 'Video ' .$message. ' successfuly!';
                $remove     = '&a=' .$action. '&VID=' .$VID;
                break;
            case 'feature':
            case 'unfeature':
                $feature    = ( $action == 'feature' ) ? 'yes' : 'no';
                $message    = ( $action == 'feature' ) ? 'featured' : 'unfeatured';
                $sql        = "UPDATE video SET featured = '" .$feature. "' WHERE VID = '" .mysql_real_escape_string($VID). "' LIMIT 1";
                $conn->execute($sql);
                $msg        = 'Video ' .$message. ' successfuly!';
                $remove     = '&a=' .$action. '&VID=' .$VID;
                break;
            case 'regenthumbs':
                $regen = regenVideoThumbs($VID);
                if ( $regen == '' )
                    $msg = 'msg=Thumbs regenerated successfuly!';
                else
                    $msg = 'err=' .$regen;
                session_write_close();
                header('Location: videos.php?m=' .$module_keep. '&' .$msg);
                die();
                break;
        }
    } else {
        $err = 'Invalid video id. Video does not exist!?';
    }
}

$query          = constructQuery($module_keep);
$sql            = $query['count'];
$rs             = $conn->execute($sql);
$total_videos   = $rs->fields['total_videos'];
$pagination     = new Pagination($query['page_items']);
$limit          = $pagination->getLimit($total_videos);
$paging         = $pagination->getAdminPagination($remove);
$sql            = $query['select']. " LIMIT " .$limit;
$rs             = $conn->execute($sql);
$videos         = $rs->getrows();

function constructQuery($module)
{
    $query_module = '';
    if ( $module == 'private' or $module == 'public' )
            $query_module = " WHERE type = '" .$module. "'";

    $query              = array();
    $query_select       = "SELECT * FROM video" .$query_module;
    $query_count        = "SELECT count(*) AS total_videos FROM video" .$query_module;
    $query_add          = ( $query_module != '' ) ? " AND" : " WHERE";
    $query_option       = array();
    $channel            = ( isset($_GET['CID']) && is_numeric($_GET['CID']) && channelExists($_GET['CID']) ) ? trim($_GET['CID']) : NULL;
    $option             = array('username' => '', 'title' => '', 'description' => '', 'keyword' => '', 'channel' => $channel, 'featured' => '',
                                'sort' => 'VID', 'order' => 'DESC', 'display' => 10);
    $option             = ( isset($_SESSION['search_videos']) ) ? $_SESSION['search_videos'] : $option;
    
	if (isset($_POST['reset_submit'])) {
		$option = $option_orig;
	}        
	
    if ( isset($_POST['search_videos']) ) {
        $option['username']     = trim($_POST['username']);
        $option['title']        = trim($_POST['title']);
        $option['description']  = trim($_POST['description']);
        $option['keyword']      = trim($_POST['keyword']);
        $option['channel']      = trim($_POST['channel']);
        $option['featured']     = trim($_POST['featured']);
        $option['sort']         = trim($_POST['sort']);
        $option['order']        = trim($_POST['order']);
        $option['display']      = trim($_POST['display']);
        $_SESSION['search_videos'] = $option;
    }    
    
    if ( $option['username'] != '' || isset($_GET['UID']) ) {
        if ( $option['username'] != '' ) {
            $UID            = getUserID($option['username']);
        } else {
            $UID            = ( isset($_GET['UID']) && is_numeric($_GET['UID']) ) ? $_GET['UID'] : 0;
        }
        $UID            = ( $UID ) ? $UID : 0;
        $query_option[] = $query_add. " UID = '" .mysql_real_escape_string($UID). "'";
        $query_add      = " AND";
    }

    if ( $option['title'] != '' ) {
        $query_option[] = $query_add. " title LIKE '%" .mysql_real_escape_string($option['title']). "%'";
        $query_add      = " AND";
    }

    if ( $option['description'] != '' ) {
        $query_option[] = $query_add. " description LIKE '%" .mysql_real_escape_string($option['description']). "%'";
        $query_add      = " AND";
    }
        
    if ( $option['keyword'] != '' ) {
        $query_option[] = $query_add. " keyword LIKE '%" .mysql_real_escape_string($option['keyword']). "%'";
        $query_add      = " AND";
    }

    if ( $option['channel'] != '' ) {
        $query_option[] = $query_add. " channel LIKE '0|%" .mysql_real_escape_string($option['channel']). "%|0'";
        $query_add      = " AND";
    }

    if ( $option['featured'] != '' ) {
        $query_option[] = $query_add. " featured = '" .mysql_real_escape_string($option['featured']). "'";
        $query_add      = " AND";
    }

    $query_option[]         = " ORDER BY " .$option['sort']. " " .$option['order'];    
    $query['select']        = $query_select .implode(' ', $query_option);
    $query['count']         = $query_count .implode(' ', $query_option);
    $query['page_items']    = $option['display'];
    
    STemplate::assign('option', $option);
    
    return $query;
}

function getUserID( $username )
{
    global $conn;
    
    $sql = "SELECT UID FROM signup WHERE username = '" .mysql_real_escape_string($username). "' LIMIT 1";
    $rs  = $conn->execute($sql);
    if ( $conn->Affected_Rows() == 1 )
        return $rs->fields['UID'];
    
    return false;
}

STemplate::assign('page', $page);
STemplate::assign('videos', $videos);
STemplate::assign('total_videos', $total_videos);
STemplate::assign('paging', $paging);
?>
