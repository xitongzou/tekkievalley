<?php
defined('_VALID') or die('Restricted Access!');

chk_admin_login();

if ( isset($_GET['a']) && $_GET['a'] == 'delete' ) {
    $EID  = ( isset($_GET['EID']) ) ? trim($_GET['EID']) : NULL;
    if ( $EID ) {
        $sql = "DELETE FROM emailinfo WHERE email_id = '" .mysql_real_escape_string($EID). "' LIMIT 1";
        $conn->execute($sql);
        $msg = 'Email deleted successfuly!';
    } else
        $err = 'Invalid email id or not set!';
}

$sql    = "SELECT * FROM emailinfo";
$rs     = $conn->execute($sql);
$emails = $rs->getrows();

STemplate::assign('emails', $emails);
?>
