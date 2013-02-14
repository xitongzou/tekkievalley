<?php
/**************************************************************************************************
| Software Name        : ClipShare - Video Sharing Community Script
| Software Author      : Clip-Share.Com / ScriptXperts.Com
| Website              : http://www.clip-share.com
| E-mail               : office@clip-share.com
|**************************************************************************************************
| This source file is subject to the ClipShare End-User License Agreement, available online at:
| http://www.clip-share.com/video-sharing-script-eula.html
| By using this software, you acknowledge having read this Agreement and agree to be bound thereby.
|**************************************************************************************************
| Copyright (c) 2006-2007 Clip-Share.com. All rights reserved.
|**************************************************************************************************/

require('include/config.php');
require('include/function.php');

$pack_id = ( isset($_GET['pack']) && is_numeric($_GET['pack']) ) ? $_GET['pack'] : NULL;
if ( !$pack_id )
	die();

$sql = "select * from package where pack_id='" .mysql_real_escape_string($pack_id). "'";
$rs = $conn->execute($sql);
$package = $rs->getrows();        
STemplate::assign('package', $package['0']);
        
$period_ops = "";
if($package['0']['period'] == 'Year') {
	for($i=1; $i<=5; $i++)
    		$period_ops .= "<option value='$i'>$i</option>";
}
elseif($package['0']['period'] == 'Month' ) {
        for($i=1; $i<=12; $i++)
                $period_ops .= "<option value='$i'>$i</option>";
}
STemplate::assign('period_ops', $period_ops);
        
if( $config['payment_method'] != '' ) {
	$method = explode('|', $config['payment_method']);
        $payment_method_ops = "";
        while(list($k, $v) = each($method)) {
                $payment_method_ops .= "<option value='$v'>$v</option>";
        }
        STemplate::assign('payment_method_ops', $payment_method_ops);
}

STemplate::assign('err', $err);
STemplate::assign('msg', $msg);
STemplate::assign('head_bottom',"blank.tpl");
STemplate::display('head1.tpl');
STemplate::display('err_msg.tpl');
STemplate::display('pack_ops.tpl');
STemplate::display('footer.tpl');
STemplate::gzip_encode();
?>
