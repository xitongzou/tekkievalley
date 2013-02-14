<?php
defined('_VALID') or die('Restricted Access!');

chk_admin_login();

require $config['BASE_DIR']. '/classes/pagination.class.php';

$remove         = NULL;
$users          = array();
$GID            = ( isset($_GET['GID']) && is_numeric($_GET['GID']) && groupExists($_GET['GID']) ) ? trim($_GET['GID']) : NULL;
if ( $GID ) {
    if ( isset($_GET['a']) && $_GET['a'] == 'remove' ) {
        $UID = ( isset($_GET['UID']) && is_numeric($_GET['UID']) ) ? trim($_GET['UID']) : NULL;
        if ( $UID ) {
            $sql = "SELECT OID FROM group_own WHERE GID = '" .mysql_real_escape_string($GID). "' LIMIT 1";
            $rs  = $conn->execute($sql);
            if ( $rs->fields['OID'] == $UID ) {
                $err = 'You cannot remove the owner of the group!';
            } else {
                $sql = "DELETE FROM group_mem WHERE GID = '" .mysql_real_escape_string($GID). "' AND MID = '" .mysql_real_escape_string($UID). "'";
                $conn->execute($sql);
                $msg = 'User successfuly removed from group!';
            }
        } else
            $err = 'User id not set or not numeric!';
        $remove = '&a=remove&UID=' .$UID;
    }
    
    $query          = constructQuery($GID);
    $sql            = $query['count'];
    $rs             = $conn->execute($sql);
    $total_users    = $rs->fields['total_users'];
    $pagination     = new Pagination($query['page_items']);
    $limit          = $pagination->getLimit($total_users);
    $paging         = $pagination->getAdminPagination($remove);
    $sql            = $query['select']. " LIMIT " .$limit;
    $rs             = $conn->execute($sql);
    $users          = $rs->getrows();
} else
    $err = 'Group does not exist! Invalid group id!?';

function constructQuery($gid)
{
    global $conn;
    
    $sql                = "SELECT gname FROM group_own WHERE GID = '" .mysql_real_escape_string($gid). "' LIMIT 1";
    $rs                 = $conn->execute($sql);
    $group_name         = $rs->fields['gname'];

    $group_members      = array();
    $sql                = "SELECT MID FROM group_mem WHERE GID = '" .mysql_real_escape_string($gid). "' AND approved = 'yes'";
    $rs                 = $conn->execute($sql);
    if ( $conn->Affected_Rows() ) {
        while ( !$rs->EOF ) {
            $group_members[] = $rs->fields['MID'];
            $rs->movenext();
        }
    }
    $group_members      = implode(',', $group_members);
    
    $query              = array();
    $query_select       = "SELECT * FROM signup WHERE UID in (" .$group_members. ")";
    $query_count        = "SELECT count(*) AS total_users FROM signup WHERE UID in (" .$group_members. ")";
    $query_add          = " AND";
    $query_option       = array();
    $option_orig        = array('username' => '', 'email' => '', 'country' => '', 'name' => '', 'gender' => '', 'relation' => '',
                                'sort' => 'UID', 'order' => 'DESC', 'display' => 10);
    $option             = ( isset($_SESSION['search_members_option']) ) ? $_SESSION['search_members_option'] : $option_orig;
    
    if ( isset($_POST['search_videos']) ) {
        $option['username']     = trim($_POST['username']);
        $option['email']        = trim($_POST['email']);
        $option['country']      = trim($_POST['country']);
        $option['name']         = trim($_POST['name']);
        $option['gender']       = trim($_POST['gender']);
        $option['relation']     = trim($_POST['relation']);
        $option['sort']         = trim($_POST['sort']);
        $option['order']        = trim($_POST['order']);
        $option['display']      = trim($_POST['display']);
        
        if ( $option['username'] != '' ) {
            $query_option[] = $query_add. " username LIKE '%" .mysql_real_escape_string($option['username']). "%'";
            $query_add      = " AND";
        }

        if ( $option['email'] != '' ) {
            $query_option[] = $query_add. " email LIKE '%" .mysql_real_escape_string($option['email']). "%'";
            $query_add      = " AND";
        }

        if ( $option['country'] != '' ) {
            $query_option[] = $query_add. " country LIKE '%" .mysql_real_escape_string($option['country']). "%'";
            $query_add      = " AND";
        }
        
        if ( $option['name'] != '' ) {
            $query_option[] = $query_add. " ( fname LIKE '%" .mysql_real_escape_string($option['name']). "%' OR lname LIKE '%" .mysql_real_escape_string($option['name']). "%'";
            $query_add      = " AND";
        }
        
        if ( $option['gender'] != '' ) {
            $query_option[] = $query_add. " gender = '" .mysql_real_escape_string($option['gender']). "'";
            $query_add      = " AND";
        }
        
        if ( $option['relation'] != '' ) {
            $query_option[] = $query_add. " relation = '" .mysql_real_escape_string($option['relation']). "'";
            $query_add      = " AND";            
        }

        $_SESSION['search_members_option'] = $option;
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

STemplate::assign('users', $users);
STemplate::assign('total_users', $users);
STemplate::assign('paging', $paging);
?>
