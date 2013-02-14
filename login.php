<?php
include('../include/config.php');

if ( isset($_POST['submit_login']) ) {
    $username   = trim($_POST['username']);
    $password   = trim($_POST['password']);
        
    if ( $username == '' or $password == '' ) {
        $err = 'Please provide a username and password!';
    } else {
        $access = false;
        $sql    = "SELECT soption FROM sconfig WHERE soption = 'admin_name' AND svalue = '" .mysql_real_escape_string($username). "'";
        $conn->execute($sql);
        if ( $conn->Affected_Rows() == 1 ) {
            $sql = "SELECT soption FROM sconfig WHERE soption = 'admin_pass' AND svalue = '" .mysql_real_escape_string($password). "'";
            $conn->execute($sql);
            if ( $conn->Affected_Rows() == 1 ) {
                $access = true;
            }
        }
    }
    
    if ( !$access ) {
        $err = 'Invalid username and/or password!';
    } else {
        session_register('AUID');
        session_register('APASSWORD');
        $_SESSION['AUID']   = $config['admin_name'];
        $_SESSION['APASSWORD']  = $config['admin_pass'];
            
        session_write_close();
        header('Location: index.php');
        die();
    }
}

if ( isset($_POST['submit_forgot']) ) {
    if ( !isset($_SESSION['email_forgot']) )
        $_SESSION['email_forgot'] = 1;
    
    if ( $_SESSION['email_forgot'] == 3 ) {
        $err = 'Please try again later!';
    }
    
    if ( $err == '' ) {
        require '../include/function.php';
        $from       = $config['admin_email'];
        $from_name  = $config['site_name'];
        $to         = $config['admin_email'];
        $subject    = 'Your ' .$config['site_name']. ' administrator username and password!';
        $message    = 'Username: ' .$config['admin_name']. "\n";
        $message   .= 'Password: ' .$config['admin_pass']. "\n";
        if ( mailing($to, $from, $from_name, $subject, $message) )
            $msg = 'Email was successfuly sent!';
        else
            $err = 'Failed to send email!';
    }
    
    $_SESSION['email_forgot'] = $_SESSION['email_forgot']+1;
}

STemplate::assign('msg',$msg);
STemplate::assign('err',$err);
STemplate::display('siteadmin/header.tpl');
STemplate::display('siteadmin/login.tpl');
?>
