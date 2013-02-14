<?php
defined('_VALID') or die('Restricted Access!');
chk_admin_login();

$adv_group  = array('advgrp_id' => '', 'advgrp_name' => '', 'adv_width' => 0, 'adv_height' => 0,
                    'advgrp_rotate' => '0', 'advgrp_status' => '0');
$AGID       = ( isset($_GET['AGID']) && is_numeric($_GET['AGID']) && advGroupExists($_GET['AGID']) ) ? intval(trim($_GET['AGID'])) : NULL;
if ( !$AGID ) {
    $err = 'Invalid advertise group ID! Are you sure this advertise exists!?';
}

if ( isset($_POST['edit_adv_group']) && !$err ) {
    $adv_width      = intval(trim($_POST['adv_width']));
    $adv_height     = intval(trim($_POST['adv_height']));
    $adv_rotate     = trim($_POST['adv_rotate']);
    $adv_status     = trim($_POST['adv_status']);

    $sql            = "UPDATE adv_group SET advgrp_width = " .$adv_width. ", advgrp_height = " .$adv_height. ", 
                                            advgrp_rotate = '" .mysql_real_escape_string($adv_rotate). "', 
                                            advgrp_status = '" .mysql_real_escape_string($adv_status). "' 
                       WHERE advgrp_id = " .$AGID. " LIMIT 1";
    $conn->execute($sql);
    $msg     = 'Advertising group successfully updated!';
}

if ( !$err ) {
    $sql        = "SELECT * FROM adv_group WHERE advgrp_id = " .$AGID. " LIMIT 1";
    $rs         = $conn->execute($sql);
    $adv_group  = $rs->getrows();
}

function advGroupExists( $advgrp_id )
{
    global $conn;

    $sql = "SELECT advgrp_id FROM adv_group WHERE advgrp_id = " .intval($advgrp_id). " LIMIT 1";
    $conn->execute($sql);

    return $conn->Affected_Rows();
}

STemplate::assign('adv_group', $adv_group);
?>
