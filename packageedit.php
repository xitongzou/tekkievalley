<?php
defined('_VALID') or die('Restricted Access!');

chk_admin_login();

$package    = array();
$PID        = ( isset($_GET['PID']) && is_numeric($_GET['PID']) ) ? $_GET['PID'] : NULL;
if ( !$PID )
    $err = 'Package id not set or not numeric!';
    
if ( isset($_POST['edit_package']) && $err == '' ) {
    $is_trial       = trim($_POST['is_trial']);
    $name           = $filterObj->process(trim($_POST['name']));
    $desc           = $filterObj->process(trim($_POST['desc']));
    $space          = trim($_POST['space']);
    $bandwidth      = trim($_POST['bandwidth']);
    $price          = ( isset($_POST['price']) ) ? trim($_POST['price']) : NULL;
    $period         = ( isset($_POST['period']) ) ? trim($_POST['period']) : NULL;
    $trial_period   = trim($_POST['trial_period']);
    $video_limit    = trim($_POST['video_limit']);
    $status         = trim($_POST['status']);
    
    if ( $name == '' )
        $err = 'Package name field cannot be blank!';
    else
        $package['name'] = $name;
    
    if ( $desc == '' )
        $err = 'Package description field cannot be blank!';
    else
        $package['desc'] = $desc;
        
    if ( $space == '' )
        $err = 'Space field cannot be blank!';
    elseif ( !is_numeric($space) )
        $err = 'Space field must have a numeric value!';
    else
        $package['space'] = $space;
    
    if ( $bandwidth == '' )
        $err = 'Bandwidth field cannot be blank!';
    elseif ( !is_numeric($bandwidth) )
        $err = 'Bandwidth field must have a numeric value!';
    else
        $package['bandwidth'] = $bandwidth;
    
    if ( $video_limit != '' && !is_numeric($video_limit) )
        $err = 'Video Limit field must have a numeric value!';
    else
        $package['limit'] = $video_limit;
    
    $package['price']           = NULL;
    $package['trial_period']    = NULL;
    if ( $is_trial == 'no' ) {
        if ( $price == '' )
            $err = 'Price field cannot be blank!';
        elseif ( !is_numeric($price) )
            $err = 'Price field must have a numeric value!';
        else
            $package['price'] = $price;
    } else {
        if ( $trial_period == '' )
            $err = 'Trial Period field cannot be blank!';
        elseif ( !is_numeric($trial_period) )
            $err = 'Trial Period field must have a numeric value!';
        else
            $package['trial_period'] = $trial_period;
    }
    
    if ( $err == '' ) {
        $package['status'] = $status;
        $package['period'] = $period;
        settype($package['space'], 'integer');
        settype($package['bandwidth'], 'integer');
        settype($package['limit'], 'integer');
        if ( $is_trial == 'no' )
            settype($package['price'], 'integer');
        else
            settype($package['trial_period'], 'integer');
        $sql = "UPDATE package SET pack_name = '" .mysql_real_escape_string($package['name']). "', pack_desc = '" .mysql_real_escape_string($package['desc']). "',
                                   space = '" .mysql_real_escape_string($package['space']). "', bandwidth = '" .mysql_real_escape_string($package['bandwidth']). "',
                                   price = '" .mysql_real_escape_string($package['price']). "', video_limit = '" .mysql_real_escape_string($package['limit']). "',
                                   period = '" .mysql_real_escape_string($package['period']). "', trial_period = '" .mysql_real_escape_string($package['trial_period']). "',
                                   status = '" .mysql_real_escape_string($package['status']). "'
                WHERE pack_id = '" .mysql_real_escape_string($PID). "' LIMIT 1";
        $conn->execute($sql);
        $msg = 'Package updated successfuly!';                                                                                     
    }    
}    

$sql    = "SELECT * FROM package WHERE pack_id = '" .mysql_real_escape_string($PID). "' LIMIT 1";
$rs     = $conn->execute($sql);
if ( $conn->Affected_Rows() )
    $package = $rs->getrows();
else
    $err = 'Invalid package ID! This package does not exist!?';

STemplate::assign('package', $package);
?>
