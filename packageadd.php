<?php
defined('_VALID') or die('Restricted Access!');

chk_admin_login();

$package    = array('name' => '', 'desc' => '', 'space' => '', 'bandwidth' => '', 'price' => '',
                    'limit' => '', 'status' => '');
if ( isset($_POST['add_package']) ) {
    $name           = $filterObj->process(trim($_POST['name']));
    $desc           = $filterObj->process(trim($_POST['desc']));
    $space          = trim($_POST['space']);
    $bandwidth      = trim($_POST['bandwidth']);
    $price          = trim($_POST['price']);
    $period         = trim($_POST['period']);
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
    
    if ( $price == '' )
        $err = 'Price field cannot be blank!';
    elseif ( !is_numeric($price) )
        $err = 'Price field must have a numeric value!';
    else
        $package['price'] = $price;
    
    if ( $err == '' ) {
        $package['status'] = $status;
        $package['period'] = $period;
        settype($package['space'], 'integer');
        settype($package['bandwidth'], 'integer');
        settype($package['limit'], 'integer');
        settype($package['price'], 'integer');
        $sql = "INSERT INTO package (pack_name, pack_desc, space, bandwidth, price, video_limit, period, status)
                VALUES ('" .mysql_real_escape_string($package['name']). "', '" .mysql_real_escape_string($package['desc']). "',
                        '" .mysql_real_escape_string($package['space']). "', '" .mysql_real_escape_string($package['bandwidth']). "',
                        '" .mysql_real_escape_string($package['price']). "', '" .mysql_real_escape_string($package['limit']). "',
                        '" .mysql_real_escape_string($package['period']). "', '" .mysql_real_escape_string($package['status']). "')";
        $conn->execute($sql);
        if ( $conn->Affected_Rows() ) {
            $msg = 'Package added successfuly!';
            session_write_close();
            header('Location: index.php?m=packages?msg=' .$msg);
            die();
        } else
            $err = 'Failed to add new package!';
    }    
}    

STemplate::assign('package', $package);
?>
