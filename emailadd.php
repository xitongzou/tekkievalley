<?php
defined('_VALID') or die('Restricted Access!');

chk_admin_login();

$emails_path = $config['BASE_DIR']. '/templates/emails';
if ( !file_exists($emails_path) or !is_dir($emails_path) or !is_writable($emails_path) )
    $err = 'Emails directory ' .$emails_path. ' is not writable!';    

$email = array('email_id' => '', 'email_file' => '', 'subject' => '', 'content' => '', 'comment' => '');
if ( isset($_POST['add_email']) ) {
    $email_id   = trim($_POST['email_id']);
    $email_file = trim($_POST['email_file']);
    $subject    = trim($_POST['subject']);
    $content    = trim($_POST['content']);
    $comment    = trim($_POST['comment']);
    
    if ( $email_id == '' )
        $err = 'Email Id field cannot be blank!';
    elseif ( emailExists($email_id) )
        $err = 'A email with this email id already exists!';
    else
        $email['email_id'] = $email_id;
        
    if ( $email_file == '' )
        $err = 'Email file field cannot be blank!';
    elseif ( strtolower(substr($email_file, strrpos($email_file, '.') + 1)) != 'tpl' )
        $err = 'Email file must have .tpl as extension!';
    elseif ( file_exists($emails_path. '/' .$email_file) )
        $err = 'A email with the same file already exists!';
    else
        $email['email_file'] = $email_file;
    
    if ( $subject == '' )
        $err = 'Email subject cannot be blank!';
    else
        $email['subject'] = $subject;
    
    if ( $content == '' )
        $err = 'Email content cannot be blank!';
    else
        $email['content'] = $content;    
        
    if ( $comment == '' )
        $err = 'Email comment field cannot be blank!';
    else
        $email['comment'] = $comment;
    
    if ( $err == '' ) {
        $sql = "INSERT INTO emailinfo (email_id, email_subject, email_path, comment)
                VALUES ('" .mysql_real_escape_string($email_id). "', '" .mysql_real_escape_string($subject). "',
                        'emails/" .mysql_real_escape_string($email_file). "', '" .mysql_real_escape_string($comment). "'";
        $conn->execute($sql);
                                
        $handle = fopen($emails_path. '/' .$email_file, 'w');
        if ( $handle ) {
            fwrite($handle, $content);
            fclose($handle);
            $msg = 'Email added successfuly!';
        } else
            $err = 'Could not write email file!';
    }    
}

function emailExists( $email_id )
{
    global $conn;
    
    $sql = "SELECT email_id FROM emailinfo WHERE email_id = '" .mysql_real_escape_string($email_id). "' LIMIT 1";
    $conn->execute($sql);
    if ( mysql_affected_rows() > 0 )
        return false;
    
    return true;
}

STemplate::assign('email', $email);
STemplate::assign('emails_path', $emails_path);
?>
