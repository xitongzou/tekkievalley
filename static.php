<?php
defined('_VALID') or die('Restricted Access!');

chk_admin_login();

$allowed_pages  = array('about.tpl', 'dev.tpl', 'help.tpl', 'terms.tpl', 'privacy.tpl');
$page           = ( isset($_GET['page']) ) ? $_GET['page'] : 'about.tpl';
if ( !in_array($page, $allowed_pages) ) {
    $page   = NULL;
    $err    = 'Invalid page name!';
}

$edit = NULL;
if ( isset($_GET['a']) && $_GET['a'] == 'edit' && $page ) {
    $edit = true;
}

if ( isset($_POST['submit_static']) && $page ) {
    $file_path  = $config['BASE_DIR']. '/templates/' .$page;
    if ( file_exists($file_path) && is_file($file_path) && is_writable($file_path) ) {
        $handle = fopen($file_path, 'w');
        fwrite($handle, $_POST['static_content']);
        fclose($handle);
        $msg = 'Static page was successfully updated!';
    } else {
        $err = 'Static page not found or not writable (' .$file_path. ')!';
    }
}

STemplate::assign('page', $page);
STemplate::assign('edit', $edit);
?>
