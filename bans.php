<?php
defined('_VALID') or die('Restricted Access!');

chk_admin_login();

$action = ( isset($_GET['a']) && $_GET['a'] != '' ) ? $_GET['a'] : NULL;
if ( isset($_POST['add_ban']) or $action == 'add' ) {
    if ( isset($_GET['ip']) ) {
        $ban_ip = ( $_GET['ip'] != '' ) ? trim($_GET['ip']) : NULL;
    } else {
        $ban_ip = trim($_POST['add_ip']);
    }

    if ( $ban_ip == '' )
        $err = 'Ban IP field cannot be empty!';
    else {
        $ip = ip2long($ban_ip);
        if ( $ip == -1 || $ip === FALSE )
            $err = 'Ban IP is not valid IP address!';
    }
    
    if ( $err == '' ) {
        $sql = "SELECT ban_id FROM bans WHERE ban_ip = '" .mysql_real_escape_string($ban_ip). "' LIMIT 1";
        $conn->execute($sql);
        if ( !$conn->Affected_Rows() ) {
            $sql = "INSERT INTO bans (ban_ip, ban_date) VALUES ('" .mysql_real_escape_string($ban_ip). "', '" .date('Y-m-d h:i:s'). "')";
            $conn->execute($sql);
            if ( $conn->Affected_Rows() )
                $msg = 'IP was successfuly banned!';
            else
                $err = 'Failed to ban IP!';
        } else {
            $err = 'IP is already in the ban list!';
        }
    }
}

if ( $action == 'delete' ) {
    $BID = ( isset($_GET['BID']) && is_numeric($_GET['BID']) ) ? trim($_GET['BID']) : NULL;
    if ( $BID ) {
        $sql = "DELETE FROM bans WHERE ban_id = '" .mysql_real_escape_string($BID). "'";
        $conn->execute($sql);
        if ( $conn->Affected_Rows() )
            $msg = 'Ban was removed successfuly!';
        else
            $err = 'Failed to remove ban! Ban does not exist!?';
    } else
        $err = 'Ban id not set or not numeric!?';
}

$query      = constructQuery();
$sql        = $query['select'];
$rs         = $conn->execute($sql);
$bans       = $rs->getrows();

function constructQuery()
{
    $query              = array();
    $query_select       = "SELECT * FROM bans";
    $query_count        = "SELECT count(ban_id) AS total_bans FROM bans";
    $query_add          = NULL;
    $option_orig        = array('ip' => '', 'sort' => 'ban_id', 'order' => 'DESC', 'display' => '10');
    $option             = ( isset($_SESSION['search_bans_option']) ) ? $_SESSION['search_bans_option'] : $option_orig;
    
    if ( isset($_POST['search_bans']) ) {
        $option['ip']       = trim($_POST['ip']);
        $option['sort']     = trim($_POST['sort']);
        $option['order']    = trim($_POST['order']);
        $option['display']  = trim($_POST['display']);
        
        if ( $option['ip'] != '' )
            $query_add = " WHERE ban_ip LIKE '%" .mysql_real_escape_string($option['ip']). "%'";
        
        $query_add .= " ORDER BY " .$option['sort']. " " .$option['order'];
        
        $_SESSION['search_bans_option'] = $option;
    }
    
    $query['select']    = $query_select . $query_add;
    $query['count']     = $query_count . $query_add;
    $query['items']     = $option['display'];
    
    STemplate::assign('option', $option);
    
    return $query;
}

STemplate::assign('bans', $bans);
?>
