<?php
defined('_VALID') or die('Restricted Access!');

chk_admin_login();

if ( isset($_GET['a']) && $_GET['a'] == 'delete' ) {
    $CID = ( isset($_GET['CID']) && is_numeric($_GET['CID']) ) ? trim($_GET['CID']) : NULL;
    if ( $CID ) {
        $sql = "DELETE FROM channel WHERE CHID = '" .mysql_real_escape_string($CID). "' LIMIT 1";
        $conn->execute($sql);
        if ( $conn->Affected_Rows() )
            $msg = 'Channel deleted successfuly!';
        else
            $err = 'Failed to delete channel. Invalid channel id!?';
    } else
        $err = 'Channel id not set or not numeric!';
}

$query      = constructQuery();
$sql        = $query['select'];
$rs         = $conn->execute($sql);
$channels   = $rs->getrows();

function constructQuery()
{
    $query              = array();
    $query_select       = "SELECT * FROM channel";
    $query_count        = "SELECT count(CHID) AS total_channels FROM channel";
    $query_add          = NULL;
    $option_orig        = array('sort' => 'CHID', 'order' => 'DESC');
    $option             = ( isset($_SESSION['search_channels_option']) ) ? $_SESSION['search_channels_option'] : $option_orig;
    
    if ( isset($_POST['search_packages']) ) {
        $option['sort']     = trim($_POST['sort']);
        $option['order']    = trim($_POST['order']);
        
        $query_add = " ORDER BY " .$option['sort']. " " .$option['order'];
        
        $_SESSION['search_channels_option'] = $option;
    }
    
    $query['select']    = $query_select . $query_add;
    $query['count']     = $query_count . $query_add;
    
    STemplate::assign('option', $option);
    
    return $query;
}

STemplate::assign('channels', $channels);
?>
