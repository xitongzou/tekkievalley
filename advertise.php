<?php
defined('_VALID') or die('Restricted Access!');

chk_admin_login();

if ( isset($_GET['a']) && ( $_GET['a'] == 'activate' or $_GET['a'] == 'suspend' ) ) {
    $AID    = ( isset($_GET['AID']) && is_numeric($_GET['AID']) ) ? trim($_GET['AID']) : NULL;
    $status = ( $_GET['a'] == 'activate' ) ? 'Active' : 'Inactive';
    $sql    = "UPDATE adv SET adv_status = '" .$status. "' WHERE adv_id = '" .mysql_real_escape_string($AID). "' LIMIT 1";
    $conn->execute($sql);
    if ( $conn->Affected_Rows() )
        $msg = 'Advertise was successfuly ' .$_GET['a']. 'ed!';
    else
        $err = 'Failed to ' .$_GET['a']. ' advertise! Invalid advertise id!?';
}

$query      = constructQuery();
$sql        = $query['select'];
$rs         = $conn->execute($sql);
$ads        = $rs->getrows();

function constructQuery()
{
    $query              = array();
    $query_select       = "SELECT * FROM adv";
    $query_count        = "SELECT count(adv_id) AS total_advertise FROM adv";
    $query_add          = NULL;
    $option_orig        = array('sort' => 'adv_id', 'order' => 'DESC');
    $option             = ( isset($_SESSION['search_advertise_option']) ) ? $_SESSION['search_advertise_option'] : $option_orig;
    
    if ( isset($_POST['search_advertise']) ) {
        $option['sort']     = trim($_POST['sort']);
        $option['order']    = trim($_POST['order']);
        
        $query_add = " ORDER BY " .$option['sort']. " " .$option['order'];
        
        $_SESSION['search_advertise_option'] = $option;
    }
    
    $query['select']    = $query_select . $query_add;
    $query['count']     = $query_count . $query_add;
    
    STemplate::assign('option', $option);
    
    return $query;
}

STemplate::assign('ads', $ads);
?>
