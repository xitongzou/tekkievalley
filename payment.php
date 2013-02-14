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

include('include/config.php');
include('include/function.php');

$UID 	 = intval(base64_decode($_GET['uid']));
$pack_id = ( isset($_GET['pack']) ) ? intval($_GET['pack']) : NULL;

/* Get User Information */
$sql = "select * from signup where UID='" .mysql_real_escape_string($UID). "' limit 1";
$rs = $conn->execute($sql);
$email = $rs->fields['email'];
STemplate::assign('fname', $rs->fields['fname']);
STemplate::assign('lname', $rs->fields['lname']);
STemplate::assign('city', $rs->fields['city']);
STemplate::assign('country',country_box($rs->fields['country']));
        
/* Get Package Information*/
$sql = "select * from package where pack_id='" .mysql_real_escape_string($pack_id). "' limit 1";
$rs = $conn->execute($sql);
$package = $rs->getrows();
$totalprice = $_POST['period']*$package[0]['price'];

STemplate::assign('package', $package[0]);
STemplate::assign('totalprice',$totalprice);

if ( isset($_POST['submit']) ) {
	$method 	= trim($_POST['method']);
	$fname		= trim($_POST['fname']);
	$lname  	= trim($_POST['lname']);
	$city		= trim($_POST['city']);
	$country	= trim($_POST['country']);
	
	if ( $method == 'Paypal' ) {
    		$conn->execute("update signup set fname = '" .mysql_real_escape_string($fname). "', lname = '" .mysql_real_escape_string($lname). "',
                                                  city = '" .mysql_real_escape_string($city). "', country = '" .mysql_real_escape_string($country). "'
                                where UID = '" .$UID. "' limit 1");

                $s_period = $_POST['period']." ".$package['0']['period'];
                $theprice = $totalprice;
                $invoice = $UID. '|' .$pack_id. '|' .$s_period. '|' .$totalprice;
                
		/* Paypal Payment */
                $theamount=$theprice;
                $uniqueid=$invoice;
                $business =urlencode($config['paypal_receiver_email']);
                $item_name = urlencode("For Package : ".$package['0']['pack_name']);
                $return = $config['BASE_URL']. '/pmt_success.php?pack=' .$pack_id. '&is_success=1&period=' .$s_period;
                $cancel = $config['BASE_URL']. '/pmt_success.php?pack=' .$pack_id. '&is_success=0';
                $notify = $config['BASE_URL']. '/include/payment/notify_paypal.php';

                $return = urlencode($return);
                $cancel = urlencode($cancel);
                $notify = urlencode($notify);
                $first_name = urlencode($fname);
                $last_name = urlencode($lname);
                $city = urlencode($city);
                                
                if ( $config['enable_test_payment'] == 'yes' )
            		$url = 'www.sandbox.paypal.com';
                else
                        $url = 'www.paypal.com';

                $paypal_link = "https://$url/cgi-bin/webscr/?cmd=_xclick"
                              ."&business=$business"
                              ."&item_number=1&item_name=$item_name"
                              ."&amount=$theprice&on0=0&custom=$uniqueid"
                              ."&currency_code=USD"
                              ."&return=$return"
                              ."&cancel_return=$cancel"
                              ."&notify_url=$notify"
                              ."&first_name=$first_name"
                              ."&last_name=$last_name"
                              ."&city=$city";
                
		redirect($paypal_link);
        }
}        
        
STemplate::assign('err', $err);
STemplate::assign('msg', $msg);
STemplate::assign('head_bottom', 'blank.tpl');
STemplate::display('head1.tpl');
STemplate::display('err_msg.tpl');
STemplate::display('payment.tpl');
STemplate::display('footer.tpl');
STemplate::gzip_encode();
?>
