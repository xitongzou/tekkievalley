<?PHP

 
// ---- PayPal IPN pocessing ------------

    include("../include/payment/class.paypal_ipn.php");
    include("../include/config.php");
    include("../include/function.php");
    global $config,$conn;
    $paypal_info=$_POST;
        
    $paypal_ipn = new paypal_ipn($paypal_info, "support@yoursite.com",  'Notify');

    $paypal_ipn->send_response();
    
    if (!isset($receiver_email)){
            $paypal_ipn->error_out("Fraud attempt was detected. (PayPal's receiver email is not set)");
            exit;
    } 
    
    $paypal_currency = 'USD';
    
    if ($paypal_currency != $mc_currency) {
            $paypal_ipn->error_out("Fraud attempt was detected. (Payer uses another currency then site)");
            exit;
    }

    // should be changed:
    
    if(strtolower($receiver_email) != strtolower($config[paypal_receiver_email])) {
        $paypal_ipn->error_out("Fraud attempt was detected. (PayPal's receiver email is not equal to attempting's receiver email: $receiver_email)");
            exit;
    }

        if($paypal_ipn->is_verified())
        {
                $uniqueid = explode("|", $custom);
                $userid = $uniqueid[0];
                $pack_id = $uniqueid[1];
                $period = $uniqueid[2];
                $theprice = $uniqueid[3];



                $expired_time = date("Y-m-d H:i:s", strtotime("+$period"));

                $sql = "update subscriber set
                        pack_id=$pack_id,
                        subscribe_time='".date("Y-m-d H:i:s")."',
                        expired_time='$expired_time'
                        where UID = $userid";
                $conn->execute($sql);
                
                $sql = "update signup set
                        account_status = 'Active'
                        where UID=$userid";
                $conn->execute($sql);
                
                $sql = "select * from signup where UID=$userid";
                $rs_u = $conn->execute($sql);

                        $to = $rs_u->fields['email'];
                        $name = $config['site_name'];
                        $from = $config['admin_email'];
                        $subj = "Payment is received  successfully";

                        STemplate::assign("userid",$rs_u->fields['UID']);
                        STemplate::assign("username",$rs_u->fields['username']);
                        STemplate::assign("pack_id",$pack_id);
                        STemplate::assign("pack_name",$rs_p->fields['pack_name']);
                        STemplate::assign("amount", $theprice);
                        STemplate::assign("period", $period);
                        STemplate::assign("expired_time", $expired_time);
                        $body = STemplate::fetch("mail/notify_payment.tpl");
                        mailing($to,$name,$from,$subj,$body);
        }
        else
        {
                   $paypal_ipn->error_out("Fraud attempt was detected. (PayPal didn't validate the request data)");
        }
    
        exit;
   // ---- end of PayPal IPN pocessing -----
?>
