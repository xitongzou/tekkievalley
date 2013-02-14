<?php
defined('_VALID') or die('Restricted Acccess!');
chk_admin_login();

if ( isset($_GET['a']) ) {
    $action     = trim($_GET['a']);
    $AID        = ( isset($_GET['AID']) && is_numeric($_GET['AID']) ) ? intval(trim($_GET['AID'])) : NULL;
    if ( $action == 'activate' or $action == 'suspend' ) {
        $status = ( $_GET['a'] == 'activate' ) ? '1' : '0';
        $sql    = "UPDATE adv SET adv_status = '" .$status. "' WHERE adv_id = " .$AID. " LIMIT 1";
        $conn->execute($sql);
        if ( $conn->Affected_Rows() ) {
            $msg = 'Advertise successfuly ' .$_GET['a']. 'ed!';
        } else {
            $err = 'Failed to ' .$_GET['a']. ' advertise! Invalid advertise id!?';
        }
    } elseif ( $action == 'delete' ) {
        $sql    = "DELETE FROM adv WHERE adv_id = " .$AID. " LIMIT 1";
        $conn->execute($sql);
        $msg    = 'Advertise deleted successfully!';
    } else {
        $err = 'Invalid action specified! Allowed actions: activate, suspend and delete!';
    }
}

$query      = constructQuery();
$sql        = $query['select'];
$rs         = $conn->execute($sql);
$advs       = $rs->getrows();

function constructQuery()
{
    $query              = array();
    $query_select       = "SELECT a.*, g.advgrp_name FROM adv AS a, adv_group AS g WHERE a.adv_group = g.advgrp_id";
    $query_count        = "SELECT COUNT(adv_id) AS total_advs FROM adv";
    $query_add          = NULL;
    $option_orig        = array('sort' => 'a.adv_id', 'order' => 'DESC');
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

STemplate::assign('advs', $advs);
?>
