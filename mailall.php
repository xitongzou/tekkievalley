<?php
defined('_VALID') or die('Restricted Access!');

chk_admin_login();

require_once ('editor_files/editor_functions.php');
require_once ('editor_files/config.php');
require_once ('editor_files/editor_class.php');

$editor = new wysiwygPro();

if ( isset($_SESSION['email_errors']) ) {
    $err = $_SESSION['email_errors'];
    unset($_SESSION['email_errors']);
}

if ( isset($_POST['email_users']) ) {
    $subject    = trim($_POST['subject']);
    $message    = trim($_POST['htmlCode']);
    
    if ( $subject == '' )
        $err = 'Subject field cannot be empty!';
    elseif ( $message == '' )
        $err = 'Email message cannot be empty!';
    
    if ( $err == '' ) {
        $errors = array();
        $sql    = "SELECT email FROM signup WHERE account_status = 'Active'";
        $rs     = $conn->execute($sql);
        if ( $conn->Affected_Rows() ) {
            while ( !$rs->EOF ) {
                if ( !mailing($rs->fields['email'], $config['site_name'], $config['admin_email'], $subject, $message) )
                    $errors[] = $rs->fields['email'];
                $rs->movenext();
            }
        } else 
            $err = 'No users! Is this your new site? :-)';
        
        if ( $err == '' ) {
            if ( $errors )
                $_SESSION['email_errors'] = 'Could not send email to the following addresses: ' .implode(', ', $errors). '!';
            else
                $msg = 'Email was sent successfuly!';
        }
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
