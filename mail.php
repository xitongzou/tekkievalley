<?php
defined('_VALID') or die('Restricted Access!');

chk_admin_login();

require_once ('editor_files/editor_functions.php');
require_once ('editor_files/config.php');
require_once ('editor_files/editor_class.php');

$editor = new wysiwygPro();

$subject    = NULL;
$email      = ( isset($_GET['email']) ) ? trim($_GET['email']) : NULL;
$username   = ( isset($_GET['username']) ) ? trim($_GET['username']) : NULL;
$specific   = ( $email && $username ) ? true : false;
if ( isset($_POST['send_email']) ) {
    $email      = ( isset($_POST['email']) ) ? trim($_POST['email']) : NULL;
    $subject    = trim($_POST['subject']);
    $message    = trim($_POST['htmlCode']);
    $username   = trim($_POST['username']);
    
    if ( $specific ) {
        if ( $email == '' )
            $err = 'Email field cannot be blank!';
        elseif ( !check_email($email) )
            $err = 'Email is not a valid email address!';
    } else {
        if ( $username == '' )
            $err = 'Username field cannot be empty!';
        else {
            $sql = "SELECT email FROM signup WHERE username = '" .mysql_real_escape_string($username). "' LIMIT 1";
            $rs  = $conn->execute($sql);
            if ( $conn->Affected_Rows() )
                $email = $rs->fields['email'];
            else
                $err = 'Username does not exist!';
        }        
    }
    
    if ( $subject == '' )
        $err = 'Subject field cannot be empty!';
    elseif ( $message == '' )
        $err = 'Email message cannot be empty!';
    
    if ( $err == '' ) {
        if ( mailing($email, $config['site_name'], $config['admin_email'], $subject, $message) )
            $msg = 'Email was successfuly sent to <b>' .$username. '</b>!';
        else
            $err = 'Failed to send email! Please check your <a href="index.php?m=mail">Mail Settings</a> and make sure the provided email is valid!';
    }
}

$htmlCode   = ( isset($_POST['htmlCode']) ) ? trim($_POST['htmlCode']) : NULL;
$editor->set_code($htmlCode);

STemplate::assign('email', $email);
STemplate::assign('username', $username);
STemplate::assign('specific', $specific);
STemplate::assign('subject', $subject);
STemplate::assign('editor', $editor->return_editor('100%', 350));
?>
