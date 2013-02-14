<?php
require('../include/config.php');

if ( isset($_SESSION['AUID']) ) {
    $_SESSION['AUID']       = '';
    $_SESSION['APASSWORD']  = '';    
    session_unregister('AUID');
    session_unregister('APASSWORD');
}

session_destroy();
header('Location: index.php');
die();
?>
