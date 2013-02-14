<?php
defined('_VALID') or die('Restricted Access!');

chk_admin_login();

require $config['BASE_DIR']. '/classes/pagination.class.php';

$remove         = NULL;
$posts          = array();
$TID            = ( isset($_GET['TID']) && is_numeric($_GET['TID']) && topicExists($_GET['TID']) ) ? trim($_GET['TID']) : NULL;
$GID            = ( isset($_GET['GID']) && is_numeric($_GET['GID']) && groupExists($_GET['GID']) ) ? trim($_GET['GID']) : NULL;
if ( $TID ) {
    if ( isset($_GET['a']) && $_GET['a'] == 'delete' ) {
        $PID    = ( isset($_GET['PID']) && is_numeric($_GET['PID']) && postExists($_GET['PID']) ) ? $_GET['PID'] : NULL;
        if ( $PID ) {
            $sql = "DELETE FROM group_tps_post WHERE PID = '" .mysql_real_escape_string($PID). "' LIMIT 1";
            $conn->execute($sql);
            $msg = 'Topic message deleted successfuly!';
        } else {
            $err = 'Invalid topic message id!';
        }
        $remove = '&a=delete&PID=' .$PID;
    }

    $query          = constructQuery($TID, $GID);
    $sql            = $query['count'];
    $rs             = $conn->execute($sql);
    $total_posts    = $rs->fields['total_posts'];
    $pagination     = new Pagination($query['page_items']);
    $limit          = $pagination->getLimit($total_topics);
    $paging         = $pagination->getAdminPagination($remove);
    $sql            = $query['select']. " LIMIT " .$limit;
    $rs             = $conn->execute($sql);
    $posts          = $rs->getrows();
} else
    $err = 'Topic does not exist! Invalid topic id!?';

function constructQuery($tid, $gid)
{
    global $conn;

    $sql                = "SELECT gname FROM group_own WHERE GID = '" .mysql_real_escape_string($gid). "' LIMIT 1";
    $rs                 = $conn->execute($sql);
    $group_name         = $rs->fields['gname'];
    
    $sql                = "SELECT title FROM group_tps WHERE TID = '" .mysql_real_escape_string($tid). "' LIMIT 1";
    $rs                 = $conn->execute($sql);
    $topic_title        = $rs->fields['title'];
        
    $query              = array();
    $query_select       = "SELECT * FROM group_tps_post";
    $query_count        = "SELECT count(*) AS total_posts FROM group_tps_post";
    $query_add          = " WHERE";
    $query_option       = array();
    $option             = array('username' => '', 'post' => '',  'sort' => 'PID', 'order' => 'DESC', 'display' => 10);                                    
    if ( isset($_POST['search_videos']) ) {
        $option['username']     = trim($_POST['username']);
        $option['title']        = trim($_POST['title']);
        $option['sort']         = trim($_POST['sort']);
        $option['order']        = trim($_POST['order']);
        $option['display']      = trim($_POST['display']);
    }    
    
    if ( $option['username'] != '' ) {
        $UID            = getUserID($option['username']);
        if ( $UID ) {
            $query_option[] = $query_add. " UID = '" .mysql_real_escape_string($UID). "'";
            $query_add      = " AND";
        }
    }

    if ( $option['title'] != '' ) {
        $query_option[] = $query_add. " post LIKE '%" .mysql_real_escape_string($option['title']). "%'";
        $query_add      = " AND";
    }

    $query_option[]         = " ORDER BY " .$option['sort']. " " .$option['order'];    
    $query['select']        = $query_select .implode(' ', $query_option);
    $query['count']         = $query_count .implode(' ', $query_option);
    $query['page_items']    = $option['display'];
    
    STemplate::assign('gid', $gid);
    STemplate::assign('tid', $tid);
    STemplate::assign('group_name', $group_name);
    STemplate::assign('topic_title', $topic_title);
    STemplate::assign('option', $option);
    
    return $query;
}

function getUserID( $username )
{
    global $conn;
    
    $sql = "SELECT UID FROM signup WHERE username = '" .mysql_real_escape_string($username). "' LIMIT 1";
    $rs  = $conn->execute($sql);
    if ( mysql_affected_rows() == 1 )
        return $rs->fields['username'];
    
    return false;
}

STemplate::assign('posts', $posts);
STemplate::assign('total_posts', $total_posts);
STemplate::assign('paging', $paging);
?>
