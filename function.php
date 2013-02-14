<?php
/**************************************************************************************************
| Software Name        : ClipShare - Video Sharing Community Script
| Software Version     : 1.5.5
| Software Author      : Clip-Share.Com / ScriptXperts.Com
| Website              : http://www.clip-share.com
| E-mail               : office@clip-share.com
|**************************************************************************************************
| This source file is subject to the ClipShare End-User License Agreement, available online at:
| http://www.clip-share.com/video-sharing-script-eula.html
| By using this software, you acknowledge having read this Agreement and agree to be bound thereby.
|**************************************************************************************************
| Copyright (c) 2006 Clip-Share.com. All rights reserved.
|**************************************************************************************************/


function create_picture($source_file, $destination_file, $max_dimension)
{
  list($img_width,$img_height) = getimagesize($source_file);
  $aspect_ratio = $img_width / $img_height;
   
  if ( ($img_width > $max_dimension) || ($img_height > $max_dimension) )
  {
    if ( $img_width > $img_height )
    {
      $new_width = $max_dimension;
      $new_height = $new_width / $aspect_ratio;
    }
    elseif ( $img_width < $img_height )
    {
      $new_height = $max_dimension;
      $new_width = $new_height * $aspect_ratio;
    }
    elseif ( $img_width == $img_height )
    {
      $new_width = $max_dimension;
      $new_height = $max_dimension;
    }
    else { echo "Error reading image size."; return FALSE; }
  }
  else { $new_width = $img_width; $new_height = $img_height; }
   
  $new_width = intval($new_width);
  $new_height = intval($new_height);
   
  $thumbnail = imagecreatetruecolor($new_width,$new_height);

  if ( strpos($source_file,".gif") ) { $img_source = imagecreatefromgif($source_file); }
  if ( (strpos($source_file,".jpg")) || (strpos($source_file,".jpeg")) )
  { $img_source = imagecreatefromjpeg($source_file); }
  if ( strpos($source_file,".bmp") ) { $img_source = imagecreatefromwbmp($source_file); }
  if ( strpos($source_file,".png") ) { $img_source = imagecreatefrompng($source_file); }
   
  imagecopyresampled($thumbnail, $img_source, 0, 0, 0, 0, $new_width, $new_height, $img_width, $img_height);
  imagejpeg( $thumbnail, $destination_file, 100 );
  @chmod($destination_file, 0644);
   
  imagedestroy($img_source);
  imagedestroy($thumbnail);
}


function chk_admin_login()
{
        global $config;
	
        if ( $_SESSION['AUID'] != $config['admin_name'] || $_SESSION['APASSWORD'] != $config['admin_pass'] ) {
		    session_write_close();
            header('Location:' .$config['BASE_URL']. '/siteadmin/login.php');
            die();
        }
}

function chk_member_login( $viewkey = '' )
{
	global $config, $conn;
	
	$uid    = ( isset($_SESSION['UID']) && is_numeric($_SESSION['UID']) ) ? $_SESSION['UID']: NULL;
	$email  = ( isset($_SESSION['EMAIL']) ) ? $_SESSION['EMAIL'] : NULL;
	
	$sql    = "SELECT UID FROM signup WHERE UID = '" .mysql_real_escape_string($uid). "' LIMIT 1";
	$rs     = $conn->execute($sql);
	if ( $uid == '' || $email == '' || $rs->recordcount() == 0 ) {
		session_register('redirect');
		$_SESSION['redirect'] = ( isset($_SERVER['REQUEST_URI']) ) ? $config['URL'].$_SERVER['REQUEST_URI'] : $config['URL'];
		session_write_close();
		header('Location: ' .seo_url('login', 'login.php'));
		die();
	}
	
}

function session_to_db()
{
        global $conn;
	
        $sql = "select * from signup where UID='" .mysql_real_escape_string($_SESSION['UID']). "' limit 1";
        $rs=$conn->execute($sql);
        if ( $rs->recordcount()>0 ) {
                $_SESSION['EMAILVERIFIED']=$rs->fields['emailverified'];
        }
}

//MAIL FUNCTIION
function mailing( $to, $name, $from, $subj, $body, $bcc = '' )
{
	global $config;	
	require_once $config['BASE_DIR']. '/include/phpmailer/class.phpmailer.php';
	
	$mail 			= new PHPMailer();
	$mail->IsMail();
	if ( $config['mailer'] == 'sendmail' ) {
		if ( $config['sendmail'] != '' && @file_exists($config['sendmail']) && @is_executable($config['sendmail']) ) {
			$mail->IsSendmail();
			$mail->Sendmail		= $config['sendmail'];
		}
	} elseif ( $config['mailer'] == 'smtp' ) {
		$mail->IsSMTP();
		$mail->Host 		= $config['smtp'];
		$mail->Port		= $config['smtp_port'];
		$mail->SMTPSecure	= $config['smtp_prefix'];
		if ( $config['smtp_auth'] == '1' ) {
			$mail->SMTPAuth = true;
			$mail->Username = $config['smtp_username'];
			$mail->Password = $config['smtp_password'];
		}
	}
	
	$mail->IsHTML(true);
	$mail->From     	= $from;
	$mail->FromName 	= $name;
	// Return-Path
	$mail->Sender		= $from;
	$mail->AddAddress($to);
	if ( $bcc ) {
		$mail->AddAddress($bcc);
    }
	$mail->AddReplyTo( $from, $name);
	$mail->Subject 		= $subj;
	$mail->AltBody		= $body;
	$mail->Body		= nl2br($body);		
	if ( !$mail->Send() ) {
        return false;
    }
    
    return true;
}

//EMAIL VERIFICATION
function isMailVerified()
{
        global $config;
        
	    if ( $config['email_verification'] == '0' )
		    return true;
	        
        if ( $_SESSION['EMAILVERIFIED'] == 'no' ) {
                header('Location: ' .$config['BASE_URL']. '/confirm_email.php');
        } else if ( $_SESSION['EMAILVERIFIED'] == 'off' ) {
                header('Location: ' .$config['BASE_URL']. '/confirm_email.php?flag=off');
        }
}


function is_commented ( $vid )
{
        global $config, $conn;
	
	if ( isset($_SESSION['UID']) ) {
    		$sql	= "SELECT count(*) AS cnt FROM comments WHERE VID = '" .mysql_real_escape_string($vid). "' AND
                        UID = '" .mysql_real_escape_string($_SESSION['UID']). "'";
    		$rs	= $conn->execute($sql);
    		if ( $rs->fields['cnt']>0 )
			return 'yes';
	}
}

function is_video_commented( $vid )
{
        global $config, $conn;
	
        $sql	= "select be_comment from video WHERE VID = '" .mysql_real_escape_string($vid). "'";
        $rs	= $conn->execute($sql);
        
	return $rs->fields['be_comment'];
}

function is_video_rated( $vid )
{
        global $config, $conn;
	
        $sql	= "select be_rated from video WHERE VID = '" .mysql_real_escape_string($vid). "'";
        $rs	= $conn->execute($sql);
        
	return $rs->fields['be_rated'];
}

function is_video_embabed( $vid )
{
        global $config, $conn;
        
	$sql	= "select  embed from video WHERE VID = '" .mysql_real_escape_string($vid). "'";
        $rs	= $conn->execute($sql);
        
	return $rs->fields['embed'];
}


//SOME YEARS CONSTRUCTION
function years( $sel = '' )
{
        $year = '';
        $init = date('Y');
        for ( $i=1900; $i<=$init; $i++) {
		$year .= ( $i == $sel ) ? "<option value='" .$i. "' selected>" .$i. "</option>" : "<option value='" .$i. "'>" .$i. "</option>";
        }

        return $year;
}

//SOME MONTHS CONSTRUCTION
function months($sel=""){
        $month="";
        $months=array("January","February","March","April","May","June","July","August","September","October","November","December");
        for($i=1;$i<=12;$i++)
        {
                if($i==$sel){
                        $month.="<option value='$i' selected>$i</option>";
                                }
                else{
                        $month.="<option value='$i'>$i</option>";
                                }
        }
        return $month;
}
//SOME DAYS CONSTRUCTION
function days($sel="")
{
        $day="";
        for($i=1;$i<=31;$i++)
        {
                if($i==$sel){
                        $day.="<option value='$i' selected>$i</option>";
                                }
                else{
                        $day.="<option value='$i'>$i</option>";
                                }
        }
        return $day;
}
//Populate country
function country_box($sel=""){
        $coun="";
        $country=array("United States","Afghanistan","Albania","Algeria","American Samoa","Andorra","Angola","Anguilla","Antartica","Antigua and Barbuda","Argentina","Armenia","Aruba","Ascension Island","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Botswana","Bouvet Island","Brazil","Brunei Darussalam","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde Islands","Cayman Islands","Chad","Chile","China","Christmas Island","Colombia","Comoros","Cook Islands","Costa Rica","Cote d Ivoire","Croatia/Hrvatska","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","East Timor","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Guiana","French Polynesia","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guadeloupe","Guam","Guatemala","Guernsey","Guinea","Guinea-Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Ireland","Isle of Man","Israel","Italy", "Jamaica", "Japan", "Jersey", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea", "Kuwait", "Kyrgyzstan", "Laos", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte Island", "Mexico", "Micronesia", "Moldova", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn Island", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion Island", "Romania", "Russian Federation", "Rwanda", "Saint Helena", "Saint Lucia", "San Marino", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovak Republic", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia", "Spain", "Sri Lanka", "Suriname", "Svalbard", "Swaziland", "Sweden", "Switzerland", "Syria", "Taiwan", "Tajikistan", "Tanzania", "Thailand", "Togo", "Tokelau", "Tonga Islands", "Tunisia", "Turkey", "Turkmenistan", "Tuvalu", "Uganda", "Ukraine", "United Kingdom", "Uruguay", "Uzbekistan", "Vanuatu", "Vatican City", "Venezuela", "Vietnam", "Western Sahara", "Western Samoa", "Yemen", "Yugoslavia", "Zambia","Zimbabwe");
        for($i=0;$i<count($country);$i++)
        {
                if($sel==$country[$i])
                         $coun .="<option value='$country[$i]' selected>$country[$i]</option>";
                else
                        $coun .="<option value='$country[$i]'>$country[$i]</option>";
        }
        return $coun;
}
//DROP STATE
function state_drop($sel="")
{
$coun="";
$state = array("Alabama", "Alaska", "Arizona", "Arkansas", "California", "Colorado", "Connecticut", "Delaware", "District of Columbia", "Florida", "Georgia", "Hawaii", "Idaho", "Illinois", "Indiana", "Iowa", "Kansas", "Kentucky", "Louisiana", "Maine", "Maryland", "Massachusetts", "Michigan", "Minnesota", "Mississippi", "Missouri", "Montana", "Nebraska", "Nevada", "New Jersey", "New Mexico", "New York", "North Carolina", "North Dakota", "Ohio", "Oklahoma", "Oregon", "Pennsylvania", "Rhode Island", "South Carolina", "South Dakota", "Tennessee", "Texas", "Utah", "Vermont", "Virginia", "Washington", "West Virginia", "Wisconsin", "Wyoming", "Others");

for($i=0;$i<count($state);$i++)
{
        if($sel==$state[$i])
                $coun .="<option value='$state[$i]' selected>$state[$i]</option>";
        else
                $coun .="<option value='$state[$i]'>$state[$i]</option>";
}
return $coun;
}

//REDIRECT PAGE USING JAVASCRIPT
function redirect($link)
{
        echo "<script language=Javascript>
                document.location.href='$link';
                </script>";
}

function format_size($v)
{
        $size = $v['size'];
        if($v['type']=="byte")
        {

        }
        else
        {
                if($size<1024)
                        $output = round($size,2) . " MB";
                elseif($size<1024*1024)
                        $output = round($size/1024,2) . " GB";
        }

        return $output;
}

function insert_duration ( $options )
{
    $duration_formated  = NULL;
    $duration           = round($options['duration']);
    if ( $duration > 3600 ) {
        $hours              = floor($duration/3600);
        $duration_formated .= sprintf('%02d',$hours). ':';
        $duration           = round($duration-($hours*3600));
    }
    if ( $duration > 60 ) {
        $minutes            = floor($duration/60);
        $duration_formated .= sprintf('%02d', $minutes). ':';
        $duration           = round($duration-($minutes*60));
    } else {
        $duration_formated .= '00:';
    }

    return $duration_formated . sprintf('%02d', $duration);
}

function video_to_frame($video, $vid)
{
        global $config;

        $fc = 0;
        for($i=1;$i<=27;$i+=8) {
		if ( $config['thumbs_tool'] == 'ffmpeg' ) {
			@mkdir($config['TMP_DIR']. '/thumbs/' .$vid);
			$cmd = $config['ffmpeg']. ' -i ' .$video. ' -f image2 -ss 00:00:' .$i. ' -s ' .$config['img_max_width']. 'x' .$config['img_max_height']. ' -vframes 2 -y ' .$config['TMP_DIR']. '/thumbs/' .$vid. '/%08d.jpg';
		} else
            $cmd = $config['mplayer']. ' ' .$video. ' -ss ' .$i. ' -nosound -vo jpeg:outdir=' .$config['TMP_DIR']. '/thumbs/' .$vid. ' -frames 2';
                
		log_conversion($config['LOG_DIR']. '/' .$vid. '.log', $cmd);
                exec($cmd. ' 2>&1', $output);
		log_conversion($config['LOG_DIR']. '/' .$vid. '.log', implode("\n", $output));
                if($fc==0)
                	$fd=$config['TMB_DIR']. '/' .$vid. '.jpg';
                else
                	$fd=$config['TMB_DIR']. '/' .$fc. '_' .$vid. '.jpg';
			
                $ff = $config['TMP_DIR']. '/thumbs/' .$vid. '/00000002.jpg';
		if(!file_exists($ff))
            		$ff = $config['TMP_DIR']. '/thumbs/' .$vid. '/00000001.jpg';
		if(!file_exists($ff))
                        $ff = $config['BASE_DIR']. '/images/default.gif';

	        createThumb($ff,$fd,$config['img_max_width'],$config['img_max_height']);
            	$fc++;
       }
}     

function video_to_frame2($video, $vid)
{
        global $config;
        $fc = 0;
        for($i=1;$i<=27;$i+=8)
        {
                        if($fc==0)
                        $fd=$config['TMB_DIR']. '/' .$vid. '.jpg';
                        else
                        $fd=$config['TMB_DIR']. '/' .$fc. '_' .$vid. '.jpg';

                        $ff = $config['BASE_DIR']. '/images/converting.gif';

	                createThumb($ff,$fd,$config['img_max_width'],$config['img_max_height']);
            		$fc++;
       }
}     


function createThumb($srcname,$destname,$maxwidth,$maxheight)
{
        global $config;
        $oldimg = $srcname;//$config['basepath']."/photo/".$srcname;
        $newimg = $destname;//$config['basepath']."/photo/".$destname;

        $imagedata = GetImageSize($oldimg);
        $imagewidth = $imagedata[0];
        $imageheight = $imagedata[1];
        $imagetype = $imagedata[2];

        $shrinkage = 1;
        if ($imagewidth > $maxwidth)
        {
                $shrinkage = $maxwidth/$imagewidth;
        }
        if($shrinkage !=1)
        {
                $dest_height = $shrinkage * $imageheight;
                $dest_width = $maxwidth;
        }
        else
        {
                $dest_height=$imageheight;
                $dest_width=$imagewidth;
        }
        if($dest_height > $maxheight)
        {
                $shrinkage = $maxheight/$dest_height;
                $dest_width = $shrinkage * $dest_width;
                $dest_height = $maxheight;
        }
        if($imagetype==2)
        {
                $src_img = @imagecreatefromjpeg($oldimg);
                $dst_img = @imageCreateTrueColor($dest_width, $dest_height);
                ImageCopyResampled($dst_img, $src_img, 0, 0, 0, 0, $dest_width, $dest_height, $imagewidth, $imageheight);
                imagejpeg($dst_img, $newimg, 100);
                imagedestroy($src_img);
                imagedestroy($dst_img);
        }
        elseif ($imagetype == 3)
        {
                $src_img = imagecreatefrompng($oldimg);
                $dst_img = imageCreateTrueColor($dest_width, $dest_height);
                ImageCopyResampled($dst_img, $src_img, 0, 0, 0, 0, $dest_width, $dest_height, $imagewidth, $imageheight);
                imagepng($dst_img, $newimg, 100);
                imagedestroy($src_img);
                imagedestroy($dst_img);
        }
        else
        {
                $src_img = imagecreatefromgif($oldimg);
                $dst_img = imageCreateTrueColor($dest_width, $dest_height);
                ImageCopyResampled($dst_img, $src_img, 0, 0, 0, 0, $dest_width, $dest_height, $imagewidth, $imageheight);
                imagejpeg($dst_img, $newimg, 100);
                imagedestroy($src_img);
                imagedestroy($dst_img);
        }
}

//CHECK IF EMAIL ADDRESS IS VALID OR NOT
function check_email($email)
{
       $email_regexp = "^([-!#\$%&'*+./0-9=?A-Z^_`a-z{|}~])+@([-!#\$%&'*+/0-9=?A-Z^_`a-z{|}~]+\\.)+[a-zA-Z]{2,4}\$";
       return eregi($email_regexp, $email);
}





function check_gurl($name)
{
       $email_regexp = "!([a-zA-Z0-9])$";
       return eregi($email_regexp, $name);
}

function check_field_exists($fvalue,$field,$table)
{
        global $conn;
        
        $sql    = "SELECT count(*) AS cnt FROM " .$table. " WHERE " .$field . " = '" .mysql_real_escape_string($fvalue). "'";
        $res    = $conn->execute($sql);
        if ( $conn->Affected_Rows() ) {
            if ( $res->fields['cnt'] > 0 ) {
                return 1;
            }
        }
        
        return 0;
}

function key_to_info($key)
{
        global $config,$conn;
    
        $sql="select VID,UID,keyword,viewnumber,type from video where vkey='" .mysql_real_escape_string($key). "'";
        
        $rs=$conn->execute($sql);
        
        if($rs->recordcount()>0){
                        $list[]=$rs->fields['VID'];
                        $list[]=$rs->fields['UID'];
                        $list[]=$rs->fields['keyword'];
                        $list[]=$rs->fields['viewnumber'];
						$list[]=$rs->fields['type'];
                        return $list;

                }
                
        else return false;
}

function delete_vdo($aid,$bid)

{

  global $config,$conn;


  $sql = "SELECT UID, vdoname from video WHERE VID = '" .mysql_real_escape_string($aid). "'";
  $rs = $conn->execute($sql);
  $tmp_uid = $rs->fields['UID'];
  $tmp_vdo = $rs->fields['vdoname'];

  $path1 = $config['FLVDO_DIR']."/".$aid.".flv";
  @chmod($path1, 0777);
  if(file_exists($path1)) @unlink($path1);
  $path2 = $config['VDO_DIR']."/".$tmp_vdo;
  @chmod($path2, 0777);
  if(file_exists($path2)) @unlink($path2);

  if($tmp_uid == $bid)
  {
    $table[] = "comments";
    $table[] = "favourite";
    $table[] = "feature_req";
    $table[] = "group_vdo";
    $table[] = "inappro_req"; 
    $table[] = "playlist"; 
    $table[] = "video";

    for($i=0;$table[$i];$i++)
    {
      $sql = "DELETE from ";
      $sql.= $table[$i];
      $sql.= " where VID='" .mysql_real_escape_string($aid). "'";
      $conn->Execute($sql);
    }

    $pic0 = $config['TMB_DIR']. '/' .$aid. '.jpg';
    $pic1 = $config['TMB_DIR']. '/1_' .$aid. '.jpg';
    $pic2 = $config['TMB_DIR5']. '/2_' .$aid. '.jpg';
    $pic3 = $config['TMB_DIR']. '/3_' .$aid. '.jpg';
    if(file_exists($pic0)) @unlink($pic0);
    if(file_exists($pic1)) @unlink($pic1);
    if(file_exists($pic2)) @unlink($pic2);
    if(file_exists($pic3)) @unlink($pic3);

    $picA = $config['TMP_DIR']. '/thumbs/' .$aid. '/00000001.jpg';
    $picB = $config['TMP_DIR']. '/thumbs/' .$aid. '/00000002.jpg';
    $picC = $config['TMP_DIR']. '/thumbs/' .$aid. '/00000003.jpg';
    $picD = $config['TMP_DIR']. '/thumbs/' .$aid. '/00000004.jpg';
    if(file_exists($picA)) @unlink($picA);
    if(file_exists($picB)) @unlink($picB);
    if(file_exists($picC)) @unlink($picC);
    if(file_exists($picD)) @unlink($picD);

    @rmdir($config['TMP_DIR']. '/thumbs/' .$aid);

    return true;
  } else 
    return false;
}


function group_tags($query)
{
      if ( !$query )
          return false;

      global $conn;
      
      $list = '';
      $rs   = $conn->execute($query);
      if ( $conn->Affected_Rows() ) {
          while(!$rs->EOF) {
              $tarray = explode(' ', $rs->fields['keyword']);
	      $count  =	count($tarray);
              for ($i=0; $i<$count; $i++) {		
		  if ( isset($tarray[$i]) && $tarray[$i] != '' ) {
		  if ( $list == '' ) {
			$list    .= $tarray[$i]. ' ';
		  } else {
                  if(stristr($list,$tarray[$i]) === FALSE) {
                       $list    .= $tarray[$i]. " ";
                  }
		  }
		  }
              }

              $rs->movenext();
        }
      }

      $list     = trim($list);
      $taglist  = explode(' ', $list);
      if ( $list != '' ) {
          return $taglist;
      }
}
//END


	function cloudTags($cloudquery) 
	{
		global $config;
		$tags  = array();
		$cloud = array();
		$keyword = array();
		
		$query = mysql_query($cloudquery);
		while($t = mysql_fetch_array($query)) {
	        $db = explode(' ', $t['0']);
	    	while(list($key, $value) = each($db)) {
                if ( isset($keyword[$value]) ) {
	       	        $keyword[$value] += 1;
                } else {
                    $keyword[$value] = 0;
                }
	    	}
		}
		
		if ( is_array($keyword) && $keyword ) {
			$minFont=11;
			$maxFont=22;
			$min = min(array_values($keyword));
			$max = max(array_values($keyword));
			$fix = ($max - $min == 0) ? 1 : $max - $min;
			
			// Display the tags
			foreach ($keyword as $tag => $count) {
				$url = seo_url( 'tags/' .$tag, 'search_result.php?search_id=' .$tag);
				$size = $minFont + ($count - $min) * ($maxFont - $minFont) / $fix;
				$cloud[] = '<a class=cloudtags style="font-size: '. floor($size) .'px;" href="' .$url. '" title="Tags: '. ucfirst($tag) .' was used '. $count .' times"><span>'. htmlspecialchars(stripslashes(ucfirst($tag))) . '</span></a>';
			}

			$shown = join("\n", $cloud) . "\n";
			return $shown;
		}
	}


function video_rating($vid,$urate)
{
                global $config,$conn;
                $sql        = "select ratedby,rate,voter_id from video where VID='" .mysql_real_escape_string($vid). "' limit 1";
                $rs         = $conn->execute($sql);
                $voter_id   = $rs->fields['voter_id'];                
                
                $flag=false;
                if($config['video_rating'] == 'Once')
                {
                        $niddle     = '|';
                        $niddle    .= $_SESSION['UID'];
                        $niddle    .= '|';
                        $flag       = strstr($voter_id,$niddle);
                }
                
                
                if(!$flag){
                        if($voter_id == ''){
                                $voter_id   .= '|';
                        }                
                        $voter_id   .=  $_SESSION['UID'];
                        $voter_id   .= '|';

                        
                        $t          = $rs->fields['ratedby']*$rs->fields['rate'];
                        $newrby     = ($rs->fields['ratedby']+1);
                        $newrate    = ($t+$urate)/$newrby;
                        
                        $sql="UPDATE video SET ratedby = '" .mysql_real_escape_string($newrby). "', 
                                               rate = '" .mysql_real_escape_string($newrate). "', 
                                               voter_id='" .mysql_real_escape_string($voter_id) ."' 
                              WHERE VID='" .mysql_real_escape_string($vid). "'";
                        $conn->execute($sql);
                        return true;
                }
                else{
                        return false;
                }
}

function user_rating($uid,$urate)
{
        global $conn;
        $sql="select ratedby,rate from signup  where  UID='" .mysql_real_escape_string($uid). "'";
        $rs=$conn->execute($sql);
        $t=$rs->fields[ratedby]*$rs->fields[rate];

                $newrby=($rs->fields[ratedby]+1);
        $newrate=($t+$urate)/$newrby;
        
                $sql="update  signup set
                ratedby=$newrby,
                rate=$newrate WHERE UID='" .mysql_real_escape_string($uid). "'";
        $conn->execute($sql);
                return ceil($newrate);
}

function login_data($tbl="")
{
        global $conn;
        
        $sql = "SELECT count(*) AS ttl FROM $tbl";
        $rs = $conn->execute($sql);
        
        if ( $rs->fields['ttl'] >= 10 ) {
            $sql    = "select min(LOGID) as log from $tbl";
            $rs     = $conn->execute($sql);
            $sql    = "delete from $tbl WHERE LOGID=".$rs->fields['log'];
            $rs     = $conn->execute($sql);
        }
        
        $sql    = "insert into $tbl set UID=" .$_SESSION['UID'];
        $rs     = $conn->execute($sql);
}

function insert_id_to_name($id)
{
        global $config,$conn;

        $sql="select username from signup where UID='" .mysql_real_escape_string($id['un']). "' LIMIT 1";
        $rs=$conn->execute($sql);
        return $rs->fields['username'];
}

function insert_id_to_email($id)
{
        global $config,$conn;

        $sql="select email from signup where UID = '" .mysql_real_escape_string($id['un']). "' LIMIT 1";
        $rs=$conn->execute($sql);
        return $rs->fields['email'];
}

function insert_tag_to_name($a)
{
        if($a[tag]=="mr") $res="Most Recent";
        elseif($a[tag]=="mv") $res="Most Viewed";
        elseif($a[tag]=="md") $res="Most Discussed";
        elseif($a[tag]=="tf") $res="Top Favourites";
        elseif($a[tag]=="tr") $res="Top Rated";
        elseif($a[tag]=="rf") $res="Recently Featured";
        elseif($a[tag]=="rf") $res="Recently Featured";
        elseif($a[tag]=="rd") $res="Random";
        return $res;
}
//CACULATION OF TIME
function insert_time_range($info)
{
        global $config, $conn, $lang;
        
        $days_lang      = $lang['global.days'];
        $minutes_lang   = $lang['global.minutes'];
        $hours_lang     = $lang['global.hours'];
        $seconds_lang   = $lang['global.seconds'];
        $ago_lang       = $lang['global.ago'];
        $justnow_lang   = $lang['global.now'];
        
        $present=time();
        $sql="select $info[field] from $info[tbl] where $info[IDFR]= '" .mysql_real_escape_string($info['id']). "'";
        $rs=$conn->execute($sql);
        $addtime=$rs->fields[$info[field]];
        $interval=$present-$addtime;
        if($interval>0)
        {
        $day=$interval/(60*60*24);
        if($day>=1) {$range=floor($day)." " .$days_lang. " ";$interval=$interval-(60*60*24*floor($day));}
        if($interval>0 && $range=="")
        {
        $hour=$interval/(60*60);
        if($hour>=1) {$range=floor($hour)." " .$hours_lang. " ";$interval=$interval-(60*60*floor($hour));}
        }
        if($interval>0 && $range=="")
        {
        $min=$interval/(60);
        if($min>=1) {$range=floor($min)." " .$minutes_lang. " ";$interval=$interval-(60*floor($min));}
        }
        if($interval>0 && $range=="")
        {
        $scn=$interval;
        if($scn>=1) {$range=$scn." " .$seconds_lang. " ";}
        }
        if($range!="")$range=$range." " .$ago_lang; else $range=$justnow_lang;
        return $range;
        }
}
//END
function insert_time_to_date($a)
{
        return date("F j, Y, g:i a", $a['tm']);
}
//VIDEO KEYWORDS
function insert_video_keyword($a)
{
        global $conn;
        $sql="select keyword from video where VID='" .mysql_real_escape_string($a['vid']). "'";
        $rs=$conn->execute($sql);
        $a=$rs->fields[keyword];
        $list=explode(" ",$a);
        return $list;
}

function insert_list_channel()
{
        global $conn;
        $sql="select * from channel";
        $rs=$conn->execute($sql);
        $i=0;
        while(!$rs->EOF)
        {
        $list[$i]['ch']=$rs->fields['name'];
        $list[$i]['id']=$rs->fields['CHID'];
        $i++;
        $rs->movenext();
        }
        return $list;
}
function insert_video_channel($a)
{
        global $conn;
        
        if ( $a['tbl'] == '' )
            $sqlx="channel from video where VID = '" .mysql_real_escape_string($a['vid']). "'";
        else
            $sqlx="channel from " .$a['tbl']. " where GID = '" .mysql_real_escape_string($a['gid']). "'";
            
        $sql    = "select " .$sqlx;
        $rs     = $conn->execute($sql);
        $a      = $rs->fields['channel'];
        if ( $a != '' ) {
            $temp = explode('|', $a);
            if ( count($temp) >= 1 ) {
                $list = NULL;
                for ( $i=1; $i<count($temp); $i++) {
                    $list .= " or CHID = '" .mysql_real_escape_string($temp[$i]). "'";
                }
            }
            
            $sql    = "select CHID,name from channel where CHID = '" .mysql_real_escape_string($temp['0']). "' " .$list;
            $rsx    = $conn->execute($sql);
            $res    = $rsx->getrows();
        
            return $res;
        }
}

function insert_uid_to_rate ($var)
{
        global $conn;

       $sql="select rate from signup  where  UID='" .mysql_real_escape_string($var['uid']). "'";
       $rs=$conn->execute($sql);
       $t=ceil($rs->fields[rate]);
       $cnt=ceil($t/2);
       
        return $cnt;
}
function insert_show_rate($a)
{
        global $conn,$config, $lang;
        
        $rate=ceil($a[rte]);

        $cnt=ceil($rate/2);

        for($i=0;$i<$cnt;$i++)$list.="<img src='" .$config['IMG_URL']. "/tpl_icon_star_full.gif' width=11 />&nbsp;";
        for($i=0;$i<(5-$cnt);$i++)
        {
                        if($rate-($cnt*2)==1){$list.="<img src='" .$config['IMG_URL']. "/tpl_icon_star_half.gif' width=11 />";$rate=0;}
                        else $list.="<img src='" .$config['IMG_URL']. "/tpl_icon_star_empty.gif' width=11 />";
        }
        if($rate>0) return $list; else return $lang['global.not_yet_rated'];
}



function insert_row_count($a)
{
        global $conn;
        $sql="select count(*) as cnt from $a[tbl] where GID='" .mysql_real_escape_string($a['gid']). "'";
        $res=$conn->execute($sql);
        return $res->fields['cnt'];
}

function insert_channel_count($a)
{
        global $conn;

		global $config;
		if ($config['approve'] == 1) {$active = "and active = '1'";}
		if ($config['approve'] == 1) {$active2 = "and v.active = '1'";}
        $dt=date("Y-m-d");
        $sql="select count(*) as dytotal from video WHERE channel like '%|" .mysql_real_escape_string($a['cid']). "|%' and adddate='" .$dt. "' $active";
        $rs=$conn->execute($sql);
        $list['0']=$rs->fields['dytotal'];
        $sql="select count(*) as chtotal from video WHERE channel like '%|" .mysql_real_escape_string($a['cid']). "|%' $active";
        $rs=$conn->execute($sql);
        $list['1']=$rs->fields['chtotal'];
        $sql="select count(*) as grtotal from group_own as g WHERE g.channel like '%|" .mysql_real_escape_string($a['cid']). "|%' $active2";
        $rs=$conn->execute($sql);
        $list['2']=$rs->fields['grtotal'];

        return $list;
}
function insert_get_photo($a)
{
        global $conn;
        $sql="select max(VID) as vid from video where UID='" .mysql_real_escape_string($a['uid']). "'";
        $rs=$conn->execute($sql);
        return $rs->fields['vid'];
}

function insert_video_info($a)
{      global $conn;
       $sql="select * from video where VID='" .mysql_real_escape_string($a['vid']). "'";
       $rs=$conn->execute($sql);
       $x=$rs->getarray();
       return $x;

}

function insert_comment_info($a)
{
        global $conn;
        $sql="select * from comments where VID='" .mysql_real_escape_string($a['vid']). "' order by addtime desc";
        $rs=$conn->execute($sql);
        return $rs->getarray();
}

function insert_comment_info_user($a)
{
        global $conn;
        $sql="select photo from signup where UID='" .mysql_real_escape_string($a['uid']). "'";
        $rs=$conn->execute($sql);
        return $rs->getarray();

}

function insert_comment_count($a)
{
        global $conn;
        $sql="select count(*) as ttl from comments where VID='" .mysql_real_escape_string($a['vid']). "'";
        $rs=$conn->execute($sql);
        return $rs->fields[ttl];
}

function insert_video_count($a)
{

        global $conn;
		global $config;
		if ($config['approve'] == 1) {$active = "and active = '1'";}
        if($a[type]=="public")$add="and type='" .mysql_real_escape_string($a['type']). "'";
        if($a[type]=="private")$add="and type='" .mysql_real_escape_string($a['type']). "'";
        $sql="select count(*) as ttl from video where UID='" .mysql_real_escape_string($a['uid']). "' $add $active";
        $rs=$conn->execute($sql);
        return $rs->fields['ttl'];
}

function insert_favour_count($a)
{
        global $conn;
		global $config;
		if ($config['approve'] == 1) {$active = "and v.active = '1'";}
        $sql="select count(*) as ttl from favourite as f, video as v where f.UID='" .mysql_real_escape_string($a['uid']). "' and f.VID=v.VID $active";
        $rs=$conn->execute($sql);
        return $rs->fields['ttl'];
}

function insert_playlist_count($a)
{
        global $conn;
		global $config;
		if ($config['approve'] == 1) {$active = "and v.active = '1'";}
        $sql="select count(*) as ttl from playlist as p, video as v where p.UID='" .mysql_real_escape_string($a['uid']). "' and p.VID=v.VID $active";
        $rs=$conn->execute($sql);
        return $rs->fields['ttl'];
}

function insert_msg_count()
{
        global $conn;
        $sql="select count(*) as ttl from pm where receiver='" .mysql_real_escape_string($_SESSION['USERNAME']). "' and seen=0 and inbox_track=2";
        $rs=$conn->execute($sql);
        return $rs->fields['ttl']+0;
}

function insert_friends_count($a)
{
        global $conn;
        $sql="select count(*) as ttl from friends where UID='" .mysql_real_escape_string($a['uid']). "' and friends_status='Confirmed'";
        $rs=$conn->execute($sql);
        return $rs->fields['ttl'];
}

function insert_5users_count($a)
{
        global $conn;
        if($_SESSION['UID']!="") $add="";
        $sql="select distinct UID from " .$a['tbl']." $add order by LOGID desc limit 5";
        $rs=$conn->execute($sql);
                
        return $rs->getarray();
}

function insert_group_count($a)
{
        global $conn;
        if($a[chid]!="")
        {
                $from ="group_own";
                $add1="where channel like '%|" .mysql_real_escape_string($a['chid']). "|%' ";
        }
        if($a[uid]!="")
        {
                $add1="where m.GID=o.GID and m.MID='" .mysql_real_escape_string($a['uid']). "'";
                $from="group_own as o, group_mem as m";
        }
        if($a[type]=="public")$add2="and type='" .mysql_real_escape_string($a['type']). "'";
        if($a[type]=="private")$add2="and type='" .mysql_real_escape_string($a['type']). "'";
        $sql="select count(*) as ttl from $from $add1 $add2";
        //count(m.GID) as total from group_own as o, group_mem as m WHERE m.GID=o.GID and m.MID=$_REQUEST[UID]
        $rs=$conn->execute($sql);
        return $rs->fields[ttl];
}
function insert_group_info_count($a)
{
        global $conn;
        $sql="select count(*) as ttl from $a[tbl] where GID='" .mysql_real_escape_string($a['gid']). "' $a[query]";
        $rs=$conn->execute($sql);
        return $rs->fields[ttl];
}
function insert_topic_count($a)
{
        global $conn;
        $sql="select count(*) as ttl from group_tps where GID='" .mysql_real_escape_string($a['GID']). "' and approved='yes'";
        $rs=$conn->execute($sql);
        return $rs->fields[ttl];
}
function insert_post_count($a)
{
        global $conn;
        $sql="select count(*) as ttl from group_tps_post where TID='" .mysql_real_escape_string($a['TID']). "'";
        $rs=$conn->execute($sql);
        return $rs->fields[ttl];
}

function insert_gid_to_gurl($a)
{

        global $conn;
        $sql="select gurl  from group_own  where GID='" .mysql_real_escape_string($a['gid']). "'";
        $rs=$conn->execute($sql);
        return $rs->fields[gurl];
}



function insert_group_img($a)
{
        global $conn;
        $sql = "select * from group_own where GID='" .mysql_real_escape_string($a['gid']). "'";
        $rs = $conn->execute($sql);
        if($rs->fields['gimage']=='owner_only')
        {
                return $rs->fields['gimage_vdo'];
        }
        else
        {
                $sql="select VID from $a[tbl] where GID='" .mysql_real_escape_string($a['gid']). "' order by AID desc limit 1";
                $res=$conn->execute($sql);
                return $res->fields['VID'];
        }

}

function insert_member_img($a)
{
        global $conn, $config;
        
        $sql="select VID from video where UID='" .mysql_real_escape_string($a['UID']). "' order by VID desc limit 1";
        $res=$conn->execute($sql);

        if ($res->fields['VID'] == '')
                echo "<IMG class=moduleEntryThumb height=90 src='" .$config['BASE_URL']. "/images/no_videos_groups.gif' width=120>";
        else
                echo "<IMG class=moduleEntryThumb height=90 src='" .$config['BASE_URL']. "/thumb/1_".$res->fields['VID'].".jpg' width=120>";
}



function insert_check_group_own($a)
{
        global $conn;
        $sql="select OID from group_own where GID='" .mysql_real_escape_string($a['gid']). "'";
        $rs=$conn->execute($sql);
        return $rs->fields[OID];
}
function insert_check_group_mem($a)
{
        global $conn;
        if($_SESSION['UID']!=""){
        $sql="select count(*) as cnt from group_mem where GID='" .mysql_real_escape_string($a['gid']). "' and MID='" .mysql_real_escape_string($_SESSION['UID']). "'";
        $rs=$conn->execute($sql);
        }
        if($_SESSION['UID']!="")$rss=$rs->fields['cnt'];else $rss=0;
        return $rss;
}
function insert_home_info()
{
        global $conn;
        if($_SESSION['UID']!="")
        {
        $sql="select video_viewed,profile_viewed,watched_video from signup WHERE UID='" .mysql_real_escape_string($_SESSION['UID']). "'";
        $rs=$conn->execute($sql);
        $rss=$rs->getarray();
        }
        return $rss;
}
/*
function insert_friends_count($a)
{
        global $conn;
        if($_SESSION[UID]!="")
        {
        $sql="select count(*) as cnt from relation WHERE (FAID=$_SESSION[UID] or FBID=$_SESSION[UID]) and status='yes'";
        $rs=$conn->execute($sql);
        }
        return $rs->fields[cnt];
}
*/
function insert_frndreq_count($a)
{
        global $conn;
        if($_SESSION['UID']!="")
        {
                $sql="select count(*) as cnt from friends WHERE FID='" .mysql_real_escape_string($_SESSION['UID']). "' and friends_status='Pending'";
                $rs=$conn->execute($sql);
        }
        
        return $rs->fields['cnt']+0;
}

function insert_timediff($var)
{
        global $lang;

        $mytime = strtotime($var['time']);
        $now = time();

        $diff = $now-$mytime;
        $second = $diff%60;
        $minutes = ($diff/60)%60;
        $hours = ($diff/3600)%24;
        $days = ($diff/(3600*24))%30;
        $months = ($diff/(3600*24*30))%12;
        $years = ($diff/(3600*24*30*12))%10000;
        
        $x = array();
        $x['days']=$days;
        $x['hours']=$hours;
        $x['minutes']=$minutes;
        $x['seconds']=$second;

        if($years==1)
                echo "$years " .$lang['global.year']. " " .$lang['global.ago'];
        elseif($years>1)
                echo "$years " .$lang['global.years']. " " .$lang['global.ago'];
        elseif($months==1)
                echo "$months " .$lang['global.months']. " " .$lang['global.ago'];
        elseif($months>1)
                echo "$months " .$lang['global.month']. " " .$lang['global.ago'];
        elseif($days==1)
                echo "$days " .$lang['global.days']. " " .$lang['global.ago'];
        elseif($day>1)
                echo "$days " .$lang['global.day']. " " .$lang['global.ago'];
        elseif($hours==1)
                echo "$hours " .$lang['global.hour']. " " .$lang['global.ago'];
        elseif($hours>1)
                echo "$hours " .$lang['global.hours']. " " .$lang['global.ago'];
        elseif($minutes==1)
                echo "$minutes " .$lang['global.minute']. " " .$lang['global.ago'];
        elseif($minutes>1)
                echo "$minutes " .$lang['global.minutes']. " " .$lang['global.ago'];
        elseif($second==1)
                echo "$second " .$lang['global.second']. " " .$lang['global.ago'];
        elseif($second>1)
                echo "$second " .$lang['global.seconds']. " " .$lang['global.ago'];

}

/*
        Calculate time difference from $latest_time and $mytime.
        If $latest_time is empty then get difference from current time.
        Time Format: yyyy-mm-dd hh:mm:ss
*/
function timediff($mytime, $latest_time="")
{
        $time1 = strtotime($mytime);

        if($latest_time=="")
                $time2 = time();
        else
                $time2 = strtotime($latest_time);

        $diff = $time2-$time1;
        $second = $diff%60;
        $minutes = ($diff/60)%60;
        $hours = ($diff/3600)%24;
        $days = ($diff/(3600*24))%30;
        $x = array();
        $x['days']=$days;
        $x['hours']=$hours;
        $x['minutes']=$minutes;
        $x['seconds']=$second;

        return $x;
}

/* To add item in a field seperating with | pipe */
function add_item($table, $field, $query, $new)
{
        global $conn;
        
        $sql = "select $field from $table where $query";
        $rs = $conn->execute($sql);
        $type = explode("|", $rs->fields[$field]);
        $type[] = $new;
        $type = array_unique($type);
        sort($type);
        $new_type = implode("|", $type);
        $conn->execute("update $table set $field='" .mysql_real_escape_string($new_type). "|' where $query");
}

/* To remove item in a field seperated with | pipe */
function remove_item($table, $field, $query, $item)
{
        global $conn;
        $sql = "select $field from $table where $query";
        $rs = $conn->execute($sql);
        $new_type = str_replace("|" .mysql_real_escape_string($item). "|", "|", $rs->fields[$field]);
        $conn->execute("update $table set $field='" .mysql_real_escape_string($new_type). "' where $query");
}

function insert_showlist($v)
{
        global $conn;
        $sql = "select friends_type from friends where id='" .mysql_real_escape_string($v['id']). "'";
        $rs = $conn->execute($sql);
        $type = str_replace("All|", "", $rs->fields['friends_type']);
        $type = str_replace("All", "", $type);
        $type = str_replace("|", ", ", $type);
        return $type;
}

/* Get value from a field
       {insert name=getfield assign=myfield field=$field table=$table qfield=$qfield qvalue=$qvalue order=$order}
*/
function insert_getfield($v)
{
        global $conn;
        $sql = "select " .$v['field']. " from " .$v['table']. " where " .$v['qfield']. " = '" .mysql_real_escape_string($v['qvalue']). "' " .$v['order'];
        $rs = $conn->execute($sql);
        return $rs->fields[ $v['field'] ];
}

function insert_format_size($v)
{
        $size = $v['size'];
        if($v['type']=="byte")
        {

        }
        else
        {
                if($size<1024)
                        $output = round($size,2) . " MB";
                elseif($size<1024*1024)
                        $output = round($size/1024,2) . " GB";
        }

        echo $output;
}

function insert_advertise( $options )
{
    global $conn, $config;
    
    if ( isset($config['ads']) && $config['ads'] == '0' ) {
        return false;
    }

    $adv        = NULL;
    $adv_group  = $options['group'];
    $sql        = "SELECT advgrp_id, advgrp_rotate FROM adv_group 
                   WHERE advgrp_name = '" .mysql_real_escape_string($adv_group). "' AND advgrp_status = '1' LIMIT 1";
    $rs         = $conn->execute($sql);
    if ( $conn->Affected_Rows() == 1 ) {
        $adv_rotate = $rs->fields['advgrp_rotate'];
        $adv_group  = $rs->fields['advgrp_id'];
        if ( $adv_rotate == '1' ) {
            $sql    = "SELECT adv_id, adv_text FROM adv WHERE adv_group = " .intval($adv_group). " 
                       AND adv_status = '1' ORDER BY adv_addtime ASC";
        } else {
            $sql    = "SELECT adv_id, adv_text FROM adv WHERE adv_group = " .intval($adv_group). " 
                       AND adv_status = '1' LIMIT 1";
        }

        $rs     = $conn->execute($sql);
        if ( $conn->Affected_Rows() > 0 ) {
            if ( $adv_rotate == '1' ) {
                $advs       = $rs->getrows();
                $adv_count  = count($advs)-1;
                $random     = rand(0, $adv_count);
                $adv        = $advs[$random]['adv_text'];
                $adv_id     = $advs[$random]['adv_id'];
            } else {
                $adv        = $rs->fields['adv_text'];
                $adv_id     = $rs->fields['adv_id'];
            }
                
            $sql    = "UPDATE adv SET adv_views = adv_views+1 WHERE adv_id = " .$adv_id. " LIMIT 1";
            $conn->execute($sql);
        }
    }
        
    return $adv;
}

function check_expirity()
{
        $date = "2006-04-15";
        if(date("Y-m-d")>=$date)
        {
                echo "<br><br><font color=red><center><h1>The site is expired</h1></center></font>";
                exit;
        }
}

function upload_jpg($HTTP_POST_FILES, $var_name, $file_name, $img_width=128, $dir="upload/", $rename="")
{
        $err = '';
        if($HTTP_POST_FILES[$var_name]["name"])
        {
                $file_url = $dir . uniqid(''). '.tmp';
                $ext = strrchr($HTTP_POST_FILES[$var_name]['name'], '.');
                move_uploaded_file($HTTP_POST_FILES[$var_name]['tmp_name'], $file_url);

                if($HTTP_POST_FILES[$var_name]["error"]>0)
                {
                        $err = "Error occurs while uploading file";
                }
                elseif(strtolower($ext)=='.jpg')
                {
                        $img = @imagecreatefromjpeg($file_url);
                        $size = @getimagesize($file_url);
                        $width= $size[0];
                        $height= $size[1];

                        if ($width>$img_width)
                        {
                                $percentage = $img_width / $width;
                                $width *= $percentage;
                                $height *= $percentage;

                                $img_r = @imagecreatetruecolor ($width, $height);
                                @imagecopyresampled($img_r, $img, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
                        }
                        else
                        {
                                $img_r = $img;
                        }

                        $pic_name = $dir. $file_name;
                        @ImageJpeg($img_r, $pic_name, 100);
//                        rename("$pic_name", "$dir"."$rename");
                        @unlink($file_url);
                }
                else
                {
                        @unlink($file_url);
                        $err = "File must be as .jpg format";
                }
        }

        return $err;
}


//Validate Credit Card Info Form For Member Area
function validate_billing($VALS)
{
        $msg="";

        //CC VALIDATION
        if($VALS['cc_fname_txt']=="")
                $msg="Please Enter First Name Appearing on Credit Card.";
        elseif($VALS['cc_lname_txt']=="")
                $msg="Please Enter Lirst Name Appearing on Credit Card.";
        elseif($VALS['cc_email_txt']=="")
                $msg="Please Enter Your Email Address";
        elseif(!check_email($VALS['cc_email_txt']))
                $msg="Please Provide a Valid Email Address";
        elseif($VALS['cc_num_txt']=="")
                $msg="Please Enter Credit Card number.";
        elseif(validateCCnum($VALS['cc_num_txt'],$VALS['cc_type_box'])==false)
                $msg="Please Provide Valid Credit Card Number.";

        //CC ADDRESS VALIDATION
        elseif($VALS['cc_address1_txt']=="")
                $msg="Please Enter Billing Street Address Properly.";
        elseif($VALS['cc_city_txt']=="")
                $msg="Please Enter The Billing City Name.";
        elseif($VALS['cc_zipcode_txt']=="")
                $msg="Please Enter Billing Zip Code.";
        elseif(strlen($VALS['cc_zipcode_txt'])!=5)
                $msg="Please Enter Valid US Zip Code For Billing.";

        return $msg;
}

//GET CC MONTH BOX
function cc_month($sel="")
{
        $month="";
        for($i=1;$i<=12;$i++)
        {
                if($i<=9)
                        $j="0".$i; else $j=$i;
                if($i==$sel)
                        $month.="<option value='$i' selected>$j</option>";
                else
                        $month.="<option value='$i'>$j</option>";
        }
        return $month;
}

//GET CC MONTH BOX
function cc_year($sel="")
{
        $year="";
        for($i=2004;$i<=2020;$i++)
        {
                if($i==$sel)
                        $year.="<option value='$i' selected>$i</option>";
                else
                        $year.="<option value='$i'>$i</option>";
        }
        return $year;
}

//check_expirity();
/* $var[space], $var[bw]*/
function check_subscriber($space=0)
{
       
	    global $conn, $config;
        
        $err    = NULL;
        $sql    = "SELECT * FROM subscriber WHERE UID='" .mysql_real_escape_string($_SESSION['UID']). "'";
        $rs     = $conn->execute($sql);
        $subs   = $rs->getrows();        
        $sql    = "SELECT * FROM package WHERE pack_id='" .mysql_real_escape_string($subs['0']['pack_id']). "'";
        $rs     = $conn->execute($sql);
        $pack   = $rs->getrows();
        
        if( $pack['0']['video_limit']!=0 and $subs['0']['total_video']>=$pack['0']['video_limit'] ) {
                $err = "You cannot upload more than ".$pack['0']['video_limit']." videos";
                $type = "limit";
        } elseif($subs['0']['used_bw']+$space>=$pack['0']['bandwidth']) {
                $err = "You cannot use more than ".format_size($pack['0']['bandwidth'])." bandwidth per month";
                $type = "bw";
        } elseif($subs['0']['used_space']>=$pack['0']['space']) {
                $err = "You cannot upload more than ".format_size($pack['0']['space'])." space";
                $type = "space";
        }
        
        if ( $err != '' ) {
            $uid_64_en = base64_encode($_SESSION['UID']);
            header("Location: " . $config['BASE_URL'] . "/renew_account.php?uid=$uid_64_en&err=$err" );
	        die();
	    }
}

function insert_subscriber_info($v)
{
        global $conn;
        $sql = "select s.pack_id, pack_name, used_space, used_bw, total_video, expired_time from subscriber s, package p
                where s.UID='" .mysql_real_escape_string($v['uid']). "' and s.pack_id=p.pack_id";
        $rs = $conn->execute($sql);
        
        $subscriber = $rs->getrows();
        
        return $subscriber['0'];
}

function insert_id_to_uploaddate($v)
{
       
                global $conn;
                $sql="SELECT  adddate FROM video WHERE VID='" .mysql_real_escape_string($v['un']). "'";
                $rss=$conn->execute($sql);
                 $list=explode('-',$rss->fields[adddate]);

                 print_r($list[2]);print_r('-');
                 print_r($list[1]);print_r('-');
                  print_r($list[0]);
                //$my_array=$rss->getarray();
                //print_r($my_array);


                
        #$sql = "select s.pack_id, pack_name, used_space, used_bw, total_video, expired_time from subscriber s, #package p where UID='" .mysql_real_escape_string($v['uid']). "' and s.pack_id=p.pack_id";
        #$rs = $conn->execute($sql);
        
       # $subscriber = $rs->getrows();
        
        #$return $subscriber['0'];
}


function insert_pollanswer($v){
        return explode("|",$v['anspot']);
        
}




        function insert_pollresult($id){
                global $conn;
        
                # GET ANSWER OF VOTE CATE GORY
                $sql="SELECT * from poll_question  where poll_id=' " .mysql_real_escape_string($id['pollid']). "'";
                $rsc=$conn->execute($sql);
                $poll_answer=$rsc->fields['poll_answer']; 
                
                # SPLIT IN ARRAY 
                $list=explode("|",$poll_answer);

                #COUT OF EACH CATEGORY
                for($i=0;$list[$i];$i++){
                        $sql="select count(*) as poll_id from vote_result WHERE answer='" . mysql_real_escape_string($list[$i]) . "'"  ;
                        $rs=$conn->execute($sql);
                        $Countlist[$i]=$rs->fields['poll_id'];
                        
                        
                }


                # CALCULATE THE PARCENTAGE 
                return clulateParcentage($Countlist);
        }


# PARCENTAGE CALCULATING  FUNCTION 
        function clulateParcentage($Countlist){
                
                # Get Totla
                $total = 0;
                $count = count($Countlist);
                for ( $i=0; $i<$count; $i++ ) {
                    $total = $total+$Countlist[$i];
                }
                
                $result = array();
                for ( $i=0; $i<$count; $i++ ) {
                    $result[$i] = ceil(($Countlist[$i]*100)/$total);
                }

                return $result;
        }

function fx_replace($key, $value,$new_value){        
        $re_value=str_replace($key,$new_value,$value);
        return $re_value;
}

function checklogin(){
        if ($_SESSION['UID']!="")return true;
        else false;
}

function send_subscribed_mail($uid, $username, $from, $vid, $title, $key) 
{ 
    global $conn, $key; 
  
    $rs         = $conn->execute("select * from emailinfo where email_id='subscribe_email'"); 
    $subj       = $rs->fields['email_subject']; 
    $subj       = str_replace('$sender_name', $username, $subj); 
    $email_path = $rs->fields['email_path']; 
    
    $sql            = "SELECT * FROM subscribe_video WHERE subscribe_to = '" .mysql_real_escape_string($uid). "' AND status = 'on'"; 
    $rs             = $conn->execute( $sql ); 
    if ( $conn->Affected_Rows() ) {
        while ( !$rs->EOF ) {
            $id         = array('un' => $rs->fields['subscribe_from']);
            $email      = insert_id_to_email( $id );
            $name       = insert_id_to_name( $id );
            
            STemplate::assign('key', $key); 
            STemplate::assign('vid', $vid);
            STemplate::assign('title', $title);
            STemplate::assign('uname', $name);
            STemplate::assign('sender_name', $username);
    
            $mailbody   = STemplate::fetch($email_path);

            mailing($email, $name, $from, $subj, $mailbody); 
            $rs->MoveNext();            
        }
    }
} 

function vid_to_space( $vid )
{
       global $conn;
       $sql = "select space  from video where VID='" .mysql_real_escape_string($vid). "'";
       $rs = $conn->execute( $sql );
       return $rs->fields['space'];
}



function insert_id_to_f_l_name($id)
{
         global $config, $conn;

        $sql="select fname,lname from signup where UID='" .mysql_real_escape_string($id['un']). "'";
        $rs=$conn->execute($sql);
                return $rs->getarray();

}



# convertine row to col
/************************************************************************************
*                          Convert all row in to column
**********************************************************/
/*$myarray = array (
    "0"  => array(11,12,13,14),
    "1" => array(21,22, 23,24),
    "2"   => array(31,32,33,34),
    "3"   => array(41,42,43,44)
        );

$myarray=array_rowtocol($myarray);
 for($j=0;$j<=3;$j++)
          {
                         "[" .  $myarray[0][$j] . "]" ;
          }

*////*/


function array_rowtocol($myarray){
  for($i=0;$myarray[$i][0];$i++)
  {
          for($j=0;$j<=count($myarray[0]);$j++)
          {
                           $myarray2[$i][$j] = $myarray[$j][$i];
          }
          
  }
  return $myarray2;
}

function insert_is_subscribe($var)
{
        global $conn;

        $sql = "SELECT * from subscribe_video where subscribe_to ='" .mysql_real_escape_string($var['id_to_subscribe']). "'and subscribe_from ='" .mysql_real_escape_string($_SESSION['UID']). "'";
        $rs = $conn->execute($sql);
        $status = $rs->fields['status'];
        return $status;

}

function insert_id_to_photo($id)
{
        global $config,$conn;

        $sql="select photo from signup where UID='" .mysql_real_escape_string($id['un']). "'";
        $rs=$conn->execute($sql);
        return $rs->fields['photo'];
}

/**
 * creates a 6 char string [a-z A-Z 0-9]
 *
 * @return string
 */
function pw_gen() {
    $buchstaben = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','P','Q','R','S','T','U','V','W','X','Y','Z','1','2','3','4','5','6','7','8','9','0');
    $pw_gen = '';
    
    for($i=1; $i<=6; $i++) {
        mt_srand ((double)microtime()*1000000);
        $tmp=mt_rand(0,count($buchstaben)-1);
        $pw_gen.=$buchstaben[$tmp];
    }

    return $pw_gen;
}

//used in siteadmin
function update_config_and_smarty()
{
	global $conn;
	global $config;

	$sql = "SELECT * from sconfig";
	$rsc = $conn->Execute($sql);
	if ( $rsc ) {
    		while(!$rsc->EOF) {
	    		$field = $rsc->fields['soption'];
			$config[$field] = $rsc->fields['svalue'];
			STemplate::assign($field, $config[$field]);
			@$rsc->MoveNext();
		}
	}									
}

function log_conversion($file_path, $text)
{
	$file_dir = dirname($file_path);
	if( !file_exists($file_dir) or !is_dir($file_dir) or !is_writable($file_dir) )
		return false;
	
	$write_mode = 'w';
	if( file_exists($file_path) && is_file($file_path) && is_writable($file_path) )
		$write_mode = 'a';
	
	if( !$handle = fopen($file_path, $write_mode) )
		return false;
	
	if( fwrite($handle, $text. "\n") == FALSE )
		return false;
	
	@fclose($handle);
}

if ( !function_exists('scandir') ) {
function scandir($dir, $listDirectories=false, $skipDots=true) 
{
	$dirArray = array();
        if ($handle = opendir($dir)) {
		while (false !== ($file = readdir($handle))) {
			if (($file != '.' && $file != '..') || $skipDots == true) {
				if($listDirectories == false) { 
					if(is_dir($file)) { 
						continue; 
					}
				}
			}
			
			array_push($dirArray,basename($file));
		}
	}
	
	closedir($handle);
	
	return $dirArray;
}
}

function get_online_users()
{
	global $config, $conn;
    
    $sql    = "SELECT COUNT(UID) AS online_users FROM users_online WHERE online > " .(time()-300);
    $rs     = $conn->execute($sql);
    
    return $rs->fields['online_users'];
}

function seo_url( $rewrite, $url, $clean = NULL)
{
	global $config;
	
	$baseurl 	= $config['BASE_URL'];
	$clean		= ( $clean != '' ) ? clean_seo_text($clean) : NULL;
	if ( $config['seo_urls'] == '1' )
		return $baseurl. '/' .$rewrite.$clean;
	
	return $baseurl. '/' .$url;
}

function translate( $item ) {
	global $lang;

	if ( isset($lang[$item]) )
		return $lang[$item];
	
	return $item;
}

function insert_select_language( $options ) {
    global $config, $languages;
    
    $language   = $_SESSION['language'];
    $output     = array();
    $output[]   = '<ul id="lang">';
    $output[]   = '<li><a href="#" id="language_' .$language. '_disabled" class="first"><img src="' .$config['BASE_URL']. '/images/flags/' .$languages[$language]['flag']. '.gif" width="16" height="11"></a>';
    if ( $config['multilanguage'] == '1' ) {
        $output[]   = '<ul>';
        foreach ( $languages as $key => $value ) {
            $output[] = '<li><a href="#" id="language_' .$key. '_active"><img src="' .$config['BASE_URL']. '/images/flags/' .$value['flag']. '.gif" width="16" height="11">' .$value['name']. '</a></li>';
        }    
        $output[]   = '</ul>';
    }
    $output[]   = '</li>';
    $output[]   = '</ul>';
                                
    return implode("\n", $output);
}
                                    

function clean_seo_text( $text, $slash=true ) {
	$entities_match		= array(' ','--','&quot;','!','@','#','%','^','&','*','_','(',')','+','{','}','|',':','"','<','>','?','[',']','\\',';',"'",',','.','/','*','+','~','`','=');
	$entities_replace   = array('-','-','','','','','','','','','','','','','','','','','','','','','','','','');
	$clean_text	 	    = str_replace($entities_match, $entities_replace, $text);
//    $clean_text         = preg_replace('/[^a-zA-Z0-9\-]/', '', $clean_text);
    if ( $clean_text != '' )
        $slash              = ( $slash ) ? '/' : NULL;
	
	return $slash . $clean_text;
}
?>
