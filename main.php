<?php
defined('_VALID') or die('Restricted Access!');
chk_admin_login();

if ( isset($_POST['submit_settings']) ) {
	$site_name		        = trim($_POST['site_name']);
	$meta_description	    = trim($_POST['meta_description']);
	$meta_keywords		    = trim($_POST['meta_keywords']);
	$admin_name		        = trim($_POST['admin_name']);
	$admin_password		    = trim($_POST['admin_pass']);
	$admin_email		    = trim($_POST['admin_email']);
	$items_per_page		    = trim($_POST['items_per_page']);
	$enable_package		    = trim($_POST['enable_package']);
	$selLFUBannar		    = trim($_POST['selLFUBannar']);
	$selPPanel		        = trim($_POST['pollinganel']);
	$seo_urls		        = trim($_POST['seo_urls']);
	$language		        = trim($_POST['language']);
    $multilanguage          = trim($_POST['multilanguage']);
	$approve		        = trim($_POST['approve']);
	$captcha		        = trim($_POST['captcha']);
	$downloads		        = trim($_POST['downloads']);
	$gzip_encoding		    = trim($_POST['gzip_encoding']);
    $upload_by_file         = trim($_POST['upload_by_file']);
    $upload_by_embed        = trim($_POST['upload_by_embed']);
    $items_per_front_page   = trim($_POST['items_per_front_page']);
    $rel_video_per_page     = trim($_POST['rel_video_per_page']);
	if ( $config['enable_package'] == 'yes' ) {
                $payment_method 	= implode('|', $_POST['method']);
		$paypal_receiver_email	= trim($_POST['paypal_receiver_email']);
		$enable_test_payment	= trim($_POST['enable_test_payment']);
	}
	
	$sql = "UPDATE sconfig SET svalue = '" .mysql_real_escape_string($site_name). "' WHERE soption = 'site_name' LIMIT 1";
	$conn->execute($sql);
	$sql = "UPDATE sconfig SET svalue = '" .mysql_real_escape_string($meta_description). "' WHERE soption = 'meta_description' LIMIT 1";
	$conn->execute($sql);
	$sql = "UPDATE sconfig SET svalue = '" .mysql_real_escape_string($meta_keywords). "' WHERE soption = 'meta_keywords' LIMIT 1";
	$conn->execute($sql);
	$sql = "UPDATE sconfig SET svalue = '" .mysql_real_escape_string($admin_name). "' WHERE soption = 'admin_name' LIMIT 1";
	$conn->execute($sql);
	$sql = "UPDATE sconfig SET svalue = '" .mysql_real_escape_string($admin_password). "' WHERE soption = 'admin_pass' LIMIT 1";
	$conn->execute($sql);
	$sql = "UPDATE sconfig SET svalue = '" .mysql_real_escape_string($admin_email). "' WHERE soption = 'admin_email' LIMIT 1";
	$conn->execute($sql);
	$sql = "UPDATE sconfig SET svalue = '" .mysql_real_escape_string($items_per_page). "' WHERE soption = 'items_per_page' LIMIT 1";
	$conn->execute($sql);
	$sql = "UPDATE sconfig SET svalue = '" .mysql_real_escape_string($enable_package). "' WHERE soption = 'enable_package' LIMIT 1";
	$conn->execute($sql);
	$sql = "UPDATE sconfig SET svalue = '" .mysql_real_escape_string($selLFUBannar). "' WHERE soption = 'lfubannar' LIMIT 1";
	$conn->execute($sql);
	$sql = "UPDATE sconfig SET svalue = '" .mysql_real_escape_string($selPPanel). "' WHERE soption = 'pollinganel' LIMIT 1";
	$conn->execute($sql);
	$sql = "UPDATE sconfig SET svalue = '" .mysql_real_escape_string($seo_urls). "' WHERE soption = 'seo_urls' LIMIT 1";
	$conn->execute($sql);
	$sql = "UPDATE sconfig SET svalue = '" .mysql_real_escape_string($approve). "' WHERE soption = 'approve' LIMIT 1";
	$conn->execute($sql);
	$sql = "UPDATE sconfig SET svalue = '" .mysql_real_escape_string($captcha). "' WHERE soption = 'captcha' LIMIT 1";
	$conn->execute($sql);
	$sql = "UPDATE sconfig SET svalue = '" .mysql_real_escape_string($downloads). "' WHERE soption = 'downloads' LIMIT 1";
	$conn->execute($sql);
	$sql = "UPDATE sconfig SET svalue = '" .mysql_real_escape_string($language). "' WHERE soption = 'language' LIMIT 1";
	$conn->execute($sql);
	$sql = "UPDATE sconfig SET svalue = '" .mysql_real_escape_string($multilanguage). "' WHERE soption = 'multilanguage' LIMIT 1";
	$conn->execute($sql);
	$sql = "UPDATE sconfig SET svalue = '" .mysql_real_escape_string($gzip_encoding). "' WHERE soption = 'gzip_encoding' LIMIT 1";
	$conn->execute($sql);
	$sql = "UPDATE sconfig SET svalue = '" .mysql_real_escape_string($upload_by_file). "' WHERE soption = 'upload_by_file' LIMIT 1";
	$conn->execute($sql);
	$sql = "UPDATE sconfig SET svalue = '" .mysql_real_escape_string($upload_by_embed). "' WHERE soption = 'upload_by_embed' LIMIT 1";
	$conn->execute($sql);
	$sql = "UPDATE sconfig SET svalue = '" .mysql_real_escape_string($items_per_front_page). "' WHERE soption = 'items_per_front_page' LIMIT 1";
	$conn->execute($sql);
	$sql = "UPDATE sconfig SET svalue = '" .mysql_real_escape_string($rel_video_per_page). "' WHERE soption = 'rel_video_per_page' LIMIT 1";
	$conn->execute($sql);

    if( $config['enable_package'] == 'yes' ) {
	    if ( isset($_POST['method']) && $_POST['method'] == '' ) {
		    $err = 'Select one or more payment methods!';
		} else {
            $sql = "UPDATE sconfig SET svalue='" .mysql_real_escape_string($payment_method). "' WHERE soption='payment_method' LIMIT 1";
            $conn->execute($sql);
        }
                
	    $sql = "update sconfig set svalue = '" .$paypal_receiver_email. "' where soption='paypal_receiver_email'";
        $conn->execute($sql);
        $sql = "update sconfig set svalue = '" .$enable_test_payment. "' where soption='enable_test_payment'";
        $conn->execute($sql);
    }
    
    update_config_and_smarty();
    
    if ( $err == '' ) {
        $msg = 'System Settings Updated Successfuly!';
    }
}

function insert_language_select($options)
{
    global $languages;

    $output     = array();
    $language   = $options['language'];
    foreach ( $languages as $code => $value ) {
        $selected = ( $code == $language ) ? ' selected="selected"' : NULL;
        $output[] = '<option value="' .$code. '"' .$selected. '>' .htmlspecialchars($value['name'], ENT_QUOTES, 'UTF-8'). '</option>';
    }

    return implode("\n", $output);
}
?>
