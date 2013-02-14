<?php
defined('_VALID') or die('Restricted Access!');
chk_admin_login();

function profile_exists( $PID )
{
    global $conn;
    $sql    = "SELECT id FROM player_settings WHERE id = " .intval($PID). " LIMIT 1";
    $conn->execute($sql);
    
    return $conn->Affected_Rows();
}

$action     = ( isset($_GET['a']) && ( $_GET['a'] == 'activate' || $_GET['a'] == 'delete' ) ) ? $_GET['a'] : NULL;
if ( $action ) {
    $PID    = ( isset($_GET['PID']) && is_numeric($_GET['PID']) && profile_exists($_GET['PID']) ) ? intval($_GET['PID']) : NULL;
    if ( $PID ) {
        if ( $action == 'activate' ) {
            $sql    = "UPDATE player_settings SET status = '0'";
            $conn->execute($sql);
            $sql    = "UPDATE player_settings SET status = '1' WHERE id = " .$PID. " LIMIT 1";
            $conn->execute($sql);
            $msg    = 'Player profile successfully activated!';
        } else {
            $sql    = "DELETE FROM player_settings WHERE id = " .$PID. " LIMIT 1";
            $conn->execute($sql);
            $msg    = 'Player profile was successfully delete!';
        }
    } else {
        $err = 'Invalid profile id or not set!';
    }
}

$sql        = "SELECT * FROM player_settings ORDER BY status DESC";
$rs         = $conn->execute($sql);
$profiles   = $rs->getrows();

STemplate::assign('profiles', $profiles);
?>
