<?php
defined('_VALID') or die('Restricted Access!');

chk_admin_login();

$chimg = $config['BASE_DIR']. '/chimg';
if ( !file_exists($chimg) or !is_dir($chimg) or !is_writable($chimg) ) {
    $err = 'Channel image directory \'' .$chimg. '\' is not writable!';
}

$channel = array('name' => '', 'desc' => '');
if ( isset($_POST['add_channel']) ) {
    $name   = trim($_POST['name']);
    $desc   = trim($_POST['desc']);
    
    if ( $name == '' )
        $err = 'Channel name field cannot be blank!';
    else
        $channel['name'] = $name;
    
    if ( $desc == '' )
        $err = 'Channel description field cannot be blank!';
    else
        $channel['desc'] = $desc;
    
    if ( $_FILES['picture']['tmp_name'] == '' )
        $err = 'Please provide a channel image!';
    
    if ( $err == '' ) {
        $sql = "INSERT INTO channel (name, descrip) VALUES ('" .mysql_real_escape_string($name). "', '" .mysql_real_escape_string($desc). "')";
        $conn->execute($sql);
        $chid = $conn->Insert_ID();
        $err = upload_jpg($_FILES, 'picture', $chid. '.jpg', 120, $config['BASE_DIR']. '/chimg/');
        if ( $err != '' ) {
          $sql = "DELETE FROM channel WHERE CHID = '" .mysql_real_escape_string($chid). "' LIMIT 1";
            $conn->execute($sql);
        }
    }
    
    if ( $err == '' ) {
        $msg = 'Channel Successfuly added!';
        session_write_close();
        header('Location: channels.php?msg=' .$msg);
        die();
    }
}

STemplate::assign('channel', $channel);
?>
