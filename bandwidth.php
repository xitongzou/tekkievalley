<?php
defined('_VALID') or die('Restricted Access!');

chk_admin_login();

if ( isset($_POST['submit_bandwidth']) ) {
    $sql    = "UPDATE subscriber SET used_bw = '0'";
    $conn->execute($sql);
    $count  = $conn->Affected_Rows();
    
    if ( $count )
        $msg = 'Bandwidth reseted to 0 for all (' .$count. ') subscribers!';
    else
        $msg = 'You dont have any subscribers yet!';
}
?>
