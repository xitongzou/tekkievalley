<?php
defined('_VALID') or die('Restricted Access!');

chk_admin_login();

$package    = array();
$PID        = ( isset($_GET['PID']) && is_numeric($_GET['PID']) ) ? $_GET['PID'] : NULL;
if ( $PID ) {
    $sql    = "SELECT * FROM package WHERE pack_id = '" .mysql_real_escape_string($PID). "' LIMIT 1";
    $rs     = $conn->execute($sql);
    if ( mysql_affected_rows() == 1 )
        $package = $rs->getrows();
    else
        $err = 'Package does not exist! Invalid id!?';
} else
    $err = 'Package id not set or not numeric!';

STemplate::assign('package', $package);
?>
