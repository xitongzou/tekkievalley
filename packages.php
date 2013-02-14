<?php
defined('_VALID') or die('Restricted Access!');

chk_admin_login();

if ( isset($_GET['a']) && $_GET['a'] == 'delete' ) {
    $PID = ( isset($_GET['PID']) && is_numeric($_GET['PID']) ) ? trim($_GET['PID']) : NULL;
    if ( $PID ) {
        $sql = "DELETE FROM package WHERE pack_id = '" .mysql_real_escape_string($PID). "' LIMIT 1";
        $conn->execute($sql);
        if ( mysql_affected_rows() == 1 )
            $msg = 'Package was removed successfuly!';
        else
            $err = 'Failed to remove package! Package does not exist!?';
    } else
        $err = 'Package id is not set or not numeric!';
}

$query      = constructQuery();
$sql        = $query['select'];
$rs         = $conn->execute($sql);
$packages   = $rs->getrows();

function constructQuery()
{
    $query              = array();
    $query_select       = "SELECT * FROM package";
    $query_count        = "SELECT count(pack_id) AS total_packages FROM package";
    $query_add          = NULL;
    $option_orig        = array('sort' => 'pack_id', 'order' => 'DESC');
    $option             = ( isset($_SESSION['search_packages_option']) ) ? $_SESSION['search_packages_option'] : $option_orig;
    
    if ( isset($_POST['search_packages']) ) {
        $option['sort']     = trim($_POST['sort']);
        $option['order']    = trim($_POST['order']);
        
        $query_add = " ORDER BY " .$option['sort']. " " .$option['order'];
        
        $_SESSION['search_packages_option'] = $option;
    }
    
    $query['select']    = $query_select . $query_add;
    $query['count']     = $query_count . $query_add;
    
    STemplate::assign('option', $option);
    
    return $query;
}

STemplate::assign('packages', $packages);
?>
