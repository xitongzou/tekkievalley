<?php
define('_VALID', true);
require('../include/config.php');
require('../include/function.php');
require('../include/function_admin.php');

chk_admin_login();

$module             = ( isset($_GET['m']) && $_GET['m'] != '' ) ? trim($_GET['m']) : 'banner';
$module_template    = 'ads_' .$module. '.tpl';
$modules_allowed    = array('banner', 'media', 'text', 'addbanner', 'addmedia', 'addtext', 'editbanner', 'editmedia', 'edittext',
                            'groups', 'addgroup', 'editgroup'); 
if ( !in_array($module, $modules_allowed) ) {
    $module             = 'banner';
    $module_template    = 'ads_banner.tpl';
    $err                = 'Invalid Advertising Module!';
}

require 'modules/ads/' .$module. '.php';

STemplate::assign('err', $err);
STemplate::assign('msg', $msg);
STemplate::assign('module', $module_keep);
STemplate::assign('active_menu', 'ads');
STemplate::display('siteadmin/header.tpl');
STemplate::display('siteadmin/leftmenu/ads.tpl');
STemplate::display('siteadmin/' .$module_template);
STemplate::display('siteadmin/footer.tpl');
?>
