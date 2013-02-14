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
require('language/' .$_SESSION['language']. '/my_profile.lang.php');

// we need this for the avatar update
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: ' . date('r'));
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');

chk_member_login();

$uid = mysql_real_escape_string($_SESSION['UID']);

if ( isset($_POST['update_profile']) ) {
	$email 		= trim($_POST['email']);
	$prevemail	= trim($_POST['prevemail']);
	$password1	= trim($_POST['password1']);
	$password2	= trim($_POST['password2']);
	$year		= trim($_POST['year']);
	$month		= trim($_POST['month']);
	$day		= trim($_POST['day']);
    $bdate		= $year. '-' .$month. '-' .$day;
	
	if ( $email == '' )
		$err = $lang['my_profile.email_empty'];
	elseif ( check_field_exists($email, 'email', 'signup') == 1 && $prevemail != $email )
		$err = $lang['my_profile.email_exists'];
	elseif ( !check_email($email) )
		$err = $lang['my_profile.email_invalid'];
    
    if ( $config['force_password'] == '1' ) {
        if ( $password1 == '' )
            $err = $lang['my_profile.password_empty'];
        elseif ( $password1 != $password2 )
            $err = $lang['my_profile.password_mismatch'];
    }
    
    if ( $password1 != '' ) {
        if ( $password1 != $password2 )
            $err = $lang['my_profile.password_mismatch'];    
    }
    
	if ( $err == '' ) {
		if( $_FILES['userpic']['tmp_name'] != '' ) {
    	    $MyLogo     = $uid;
    		$imagesize  = getimagesize($_FILES['userpic']['tmp_name']);
    		if( $imagesize['2'] == 1 )
    			$MyLogo .= '.gif';
    		if( $imagesize['2'] == 2 )
    			$MyLogo .= '.jpg';
    		if( $imagesize['2'] == 3 )
    			$MyLogo .= '.png';
    			
			  if( $MyLogo == $uid. '.gif' or $MyLogo == $uid. '.jpg' or $MyLogo == $uid. '.png' ) {
    		      $UserImage = $_FILES['userpic']['name'];
    			  if ( $MyLogo != '' ) {
        		      $del 	    = $conn->execute("SELECT photo FROM signup WHERE UID = '" .$uid. "' LIMIT 1");
        			  $del_pic  = $del->fields['photo'];
        			  if ( $del_pic != '' ) {
					      @unlink($config['PHO_DIR']. '/' .$del_pic);
                      }
                      
        			  move_uploaded_file($_FILES['userpic']['tmp_name'], $config['PHO_DIR']. '/' .$MyLogo);
					  @chmod($config['PHO_DIR']. '/' .$MyLogo, 0644);
        			  $BildSize = getimagesize($config['PHO_DIR']. '/' .$MyLogo);
        			  if ( $BildSize['0'] > $config['photowidth'] )  {
        			      $source_file = $config['PHO_DIR']. '/' .$MyLogo;
        				  $destination_file = $config['PHO_DIR']. '/' .$MyLogo;
        				  create_picture($source_file, $destination_file, $config['photowidth']);
					  }
				  }
    		  } else {
			      $err = $lang['my_profile.invalid_picture_format'];
    		  }
		}
    }
    
    if ( $err == '' ) {
		$fname 		= $filterObj->process(trim($_POST['fname']));
        $lname      = $filterObj->process(trim($_POST['lname']));
		$gender		= $filterObj->process(trim($_POST['gender']));
		$relation	= $filterObj->process(trim($_POST['relation']));
		$aboutme	= $filterObj->process(trim($_POST['aboutme']));
		$website	= $filterObj->process(trim($_POST['url']));
		$town		= $filterObj->process(trim($_POST['hometown']));
		$city		= $filterObj->process(trim($_POST['city']));
		$zip		= $filterObj->process(trim($_POST['zip']));
		$occupation	= $filterObj->process(trim($_POST['occupation']));
		$company	= $filterObj->process(trim($_POST['companies']));
		$school		= $filterObj->process(trim($_POST['schools']));
		$hobbies	= $filterObj->process(trim($_POST['hobbies']));
		$fav_movie	= $filterObj->process(trim($_POST['movies']));
		$fav_music	= $filterObj->process(trim($_POST['music']));
		$fav_books	= $filterObj->process(trim($_POST['books']));
		$country	= $filterObj->process(trim($_POST['country']));
		$playlist	= $filterObj->process(trim($_POST['playlist']));
      
        $sql_add    = array();
        $sql_add[]  = "fname = '" .mysql_real_escape_string($fname). "'";
        $sql_add[]  = "lname = '" .mysql_real_escape_string($lname). "'";
        if ( $bdate != 'yyyy-mm-dd' )
            $sql_add[] = "bdate = '" .mysql_real_escape_string($bdate). "'";
		if ( $gender != '---' )
			$sql_add[] = "gender = '" .mysql_real_escape_string($gender). "'";
		if ( $relation != '---' )
			$sql_add[] = "relation = '" .mysql_real_escape_string($relation). "'";
    	$sql_add[]  = "aboutme = '" .mysql_real_escape_string($aboutme). "'";
    	$sql_add[]  = "website = '" .mysql_real_escape_string($website). "'";
    	$sql_add[]  = "town = '" .mysql_real_escape_string($town). "'";
    	$sql_add[]  = "city = '" .mysql_real_escape_string($city). "'";
    	$sql_add[]  = "zip = '" .mysql_real_escape_string($zip). "'";
		if ( $country != 'Select Country' )
    	    $sql_add[] = "country = '" .mysql_real_escape_string($country). "'";
    	$sql_add[]  = "occupation = '" .mysql_real_escape_string($occupation). "'";
    	$sql_add[]  = "company = '" .mysql_real_escape_string($company). "'";
    	$sql_add[]  = "school = '" .mysql_real_escape_string($school). "'";
    	$sql_add[]  = "interest_hobby = '" .mysql_real_escape_string($hobbies). "'";
    	$sql_add[]  = "fav_movie_show = '" .mysql_real_escape_string($fav_movie). "'";
    	$sql_add[]  = "fav_music = '" .mysql_real_escape_string($fav_music). "'";
    	$sql_add[]  = "fav_book = '" .mysql_real_escape_string($fav_books). "'";
        $sql_add[]  = "playlist = '" .mysql_real_escape_string($playlist). "'";
		// ADD
		// Userpicture Start
		if ( isset($UserImage) )
			$sql_add[] = "photo = '" .mysql_real_escape_string($MyLogo). "'";
		
		if ( isset($_POST['delete']) && $_POST['delete'] == '1' ) {
        		$sql_add[]  = "photo = ''";
        		$del        = $conn->execute("select photo from signup WHERE UID='" .$uid. "' limit 1");
        		$del_pic    = $del->fields['photo'];
        		$del_file   = $config['PHO_DIR']. '/' .$del_pic;
        		@unlink($del_file);
    		}
		// Userpicture End
		// END ADD
		
		if ( $password1 != '' )
			$sql_add[] = "pwd = '" .md5($password1). "'";
		
    	$sql = "update signup set email='" .mysql_real_escape_string($email). "', " .implode(', ', $sql_add). " WHERE UID='" .$uid. "' limit 1";
    	$conn->execute($sql);
        if ( $conn->Affected_Rows() == 1 ) {
            $msg = $lang['my_profile.success'];
        }
			
		// lets get the new email verified
		if ( $prevemail != $email && $config['email_verification'] == '1' ) {
            $ran    = time().rand(1,99999999);
            $sql    = "UPDATE verify AS v, signup AS s SET v.vcode = '" .mysql_real_escape_string($ran). "', s.emailverified = 'no' WHERE v.UID = s.UID and v.UID='" .$uid. "'";
            $conn->execute($sql);
            STemplate::assign('vcode',$ran);
            
            $to                 = $email;
            $_SESSION['EMAIL']  = $email;
            $name               = $config['site_name'];
            $from               = $config['admin_email'];
            $rs                 = $conn->execute("select * from emailinfo where email_id='verify_email'");
            $subj               = $rs->fields['email_subject'];
            $email_path         = $rs->fields['email_path'];
            $mailbody           = STemplate::fetch($email_path);
            mailing($to,$name,$from,$subj,$mailbody,$bcc='');
            session_to_db();
        }
    }
}

$sql        = "SELECT * FROM signup WHERE UID = '" .$uid. "' LIMIT 1";
$rs         = $conn->execute($sql);
$date       = explode('-', $rs->fields['bdate']);
$country    = ( isset($country) ) ? $country : $rs->fields['country'];

STemplate::assign('err', $err);
STemplate::assign('msg', $msg);
STemplate::assign('days', days($date['2']));
STemplate::assign('months' ,months($date['1']));
STemplate::assign('years', years($date['0']));
STemplate::assign('country', country_box($country));
STemplate::assign('answers', $rs->getarray());
STemplate::assign('head_bottom', 'homelinks.tpl');
STemplate::display('head1.tpl');
STemplate::display('err_msg.tpl');
STemplate::display('my_profile.tpl');
STemplate::display('footer.tpl');
STemplate::gzip_encode();
?>
