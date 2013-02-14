<?php
defined('_VALID') or die('Restricted Access!');

chk_admin_login();

require $config['BASE_DIR']. '/classes/pagination.class.php';

$remove         = NULL;
$topics         = array();
$GID            = ( isset($_GET['GID']) && is_numeric($_GET['GID']) && groupExists($_GET['GID']) ) ? trim($_GET['GID']) : NULL;
if ( $GID ) {
    if ( isset($_GET['a']) && $_GET['a'] == 'delete' ) {
        $TID    = ( isset($_GET['TID']) && is_numeric($_GET['TID']) ) ? trim($_GET['TID']) : NULL;
        if ( $TID ) {
            $sql = "DELETE FROM group_tps WHERE TID = '" .mysql_real_escape_string($TID). "' AND GID = '" .mysql_real_escape_string($GID). "'";
            $conn->execute($sql);
            $sql = "DELETE FROM group_tps_post WHERE TID = '" .mysql_real_escape_string($TID). "'";
            $conn->execute($sql);
            $msg = 'Topic deleted successfuly!';
        } else {
            $err = 'Topic id not set or not numeric!';
        }
        $remove = '&a=delete&TID=' .$TID;
    }

    $query          = constructQuery($GID);
    $sql            = $query['count'];
    $rs             = $conn->execute($sql);
    $total_topics   = $rs->fields['total_topics'];
    $pagination     = new Pagination($query['page_items']);
    $limit          = $pagination->getLimit($total_topics);
    $paging         = $pagination->getAdminPagination($remove);
    $sql            = $query['select']. " LIMIT " .$limit;
    $rs             = $conn->execute($sql);
    $topics         = $rs->getrows();
} else
    $err = 'Group does not exist! Invalid group id!?';

function constructQuery($gid)
{
    global $conn;

    $sql                = "SELECT gname FROM group_own WHERE GID = '" .mysql_real_escape_string($gid). "' LIMIT 1";
    $rs                 = $conn->execute($sql);
    $group_name         = $rs->fields['gname'];
    
    $query              = array();
    $query_select       = "SELECT * FROM group_tps WHERE GID = '" .mysql_real_escape_string($gid). "'";
    $query_count        = "SELECT count(*) AS total_topics FROM group_tps WHERE GID = '" .mysql_real_escape_string($gid). "'";
    $query_add          = " AND";
    $query_option       = array();
    $option             = array('username' => '', 'title' => '',  'sort' => 'TID', 'order' => 'DESC', 'display' => 10);
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
        $query_option[] = $query_add. " title LIKE '%" .mysql_real_escape_string($option['title']). "%'";
        $query_add      = " AND";
    }

    $query_option[]         = " ORDER BY " .$option['sort']. " " .$option['order'];    
    $query['select']        = $query_select .implode(' ', $query_option);
    $query['count']         = $query_count .implode(' ', $query_option);
    $query['page_items']    = $option['display'];
    
    STemplate::assign('gid', $gid);
    STemplate::assign('group_name', $group_name);
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

STemplate::assign('topics', $topics);
STemplate::assign('total_topics', $total_topics);
STemplate::assign('paging', $paging);
?>
