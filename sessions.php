<?php
defined('_VALID') or die('Restricted Access!');

chk_admin_login();

if ( isset($_POST['submit_sessions']) ) {
	$session_driver 	= trim($_POST['session_driver']);
	$session_lifetime   = trim($_POST['session_lifetime']);
    
    if ( $session_lifetime == '' )
        $err = 'Session Lifetime field cannot be blank!';
    elseif ( !is_numeric($session_lifetime) )
        $err = 'Session Lifetime field must have a numeric value!';

	if ( $err == '' ) {
	    $sql = "UPDATE sconfig SET svalue = '" .mysql_real_escape_string($session_driver). "' WHERE soption = 'session_driver' LIMIT 1";
	    $conn->execute($sql);
	    $sql = "UPDATE sconfig SET svalue = '" .mysql_real_escape_string($session_lifetime). "' WHERE soption = 'session_lifetime' LIMIT 1";
	    $conn->execute($sql);
	    update_config_and_smarty();
	    $msg = 'Sessions Settings Updated Successfuly!';
    }
}
?>
