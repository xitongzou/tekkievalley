<?php
defined('_VALID') or die('Restricted Access!');

chk_admin_login();

$adv = array('adv_id' => '', 'adv_name' => '', 'adv_text' => '', 'adv_status' => '');
$AID = ( isset($_GET['AID']) && is_numeric($_GET['AID']) && advExists($_GET['AID']) ) ? trim($_GET['AID']) : NULL;
if ( !$AID )
    $err = 'Invalid advertise ID! Are you sure this advertise exists!?';

if ( isset($_POST['edit_advertise']) && $err == '' ) {
    $code = trim($_POST['code']);
    if ( $code == '' )
        $err = 'Adertise code box cannot be empty!';
    
    if ( $err == '' ) {
        $sql = "UPDATE adv SET adv_text = '" .mysql_real_escape_string($code). "' WHERE adv_id = '" .mysql_real_escape_string($AID). "' LIMIT 1";
        $conn->execute($sql);
        $msg = 'Advertise code updated successfuly!';
    }
}

if ( $err == '' ) {
    $sql = "SELECT * FROM adv WHERE adv_id = '" .mysql_real_escape_string($AID). "' LIMIT 1";
    $rs  = $conn->execute($sql);
    $adv = $rs->getrows();
}

function advExists( $adv_id )
{
    global $conn;
    
    $sql = "SELECT adv_id FROM adv WHERE adv_id = '" .mysql_real_escape_string($adv_id). "' LIMIT 1";
    $conn->execute($sql);
    
    return $conn->Affected_Rows();
}

STemplate::assign('adv', $adv);
?>
