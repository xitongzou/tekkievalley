<?php
defined('_VALID') or die('Restricted Access!');
chk_admin_login();

if ( isset($_GET['a']) && ( $_GET['a'] == 'activate' or $_GET['a'] == 'suspend' ) ) {
    $AGID   = ( isset($_GET['AGID']) && is_numeric($_GET['AGID']) ) ? intval(trim($_GET['AGID'])) : NULL;
    $status = ( $_GET['a'] == 'activate' ) ? '1' : '0';
    $sql    = "UPDATE adv_group SET advgrp_status = '" .$status. "' WHERE advgrp_id = " .$AGID. " LIMIT 1";
    $conn->execute($sql);
    if ( $conn->Affected_Rows() ) {
        $msg = 'Advertise group successfuly ' .$_GET['a']. 'ed!';
    } else {
        $err = 'Failed to ' .$_GET['a']. ' advertise group! Invalid advertise id!?';
    }
}

$query      = constructQuery();
$sql        = $query['select'];
$rs         = $conn->execute($sql);
$advgroups  = $rs->getrows();

function constructQuery()
{
    $query              = array();
    $query_select       = "SELECT * FROM adv_group";
    $query_count        = "SELECT COUNT(advgrp_id) AS total_adv_groups FROM adv_group";
    $query_add          = NULL;
    $option_orig        = array('sort' => 'advgrp_id', 'order' => 'DESC');
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

STemplate::assign('advgroups', $advgroups);
?>
