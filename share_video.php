<?php

error_reporting(0);

?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<style type="text/css">

.boldfont {

	font-family: Arial;

	font-size: 12px;

}

.mainfont {

	font-family: Arial;

	font-size: 13px;

}

</style>

</head>

<body class="mainfont">

<?php

include("./include/dbconfig.php");

include_once("./mailing/class.phpmailer.php");

include_once("./include/tools/myxml.inc.php");

include_once("./include/tools/tool.inc.php");



function edit_mails($str)

{

	$ret_str = $str;

	while($pos = strpos($ret_str, '%'))

	{

		substr_replace($ret_str, '', $pos, 6);

	}

    return $ret_str;

}



function sendMail($from,$fromname, $to, $subject, $body, $attachment=array() )

{

	$mail = new phpmailer();



	$mail->SetLanguage('en',LIBPATH.'/mailing/');



	$mail->From     = $from;

	$mail->FromName = $fromname;

	$mail->Subject  = $subject;



	//$mail->Mailer   = "mail";

 	$mail->Mailer   = "mail";//smtp";



	$mail->CharSet = "UTF-8";

	$mail->ContentType = "text/html";



	$body = utf8_encode($body);

	$body_html = '<HTML><HEAD><meta http-equiv="Content-Type" content="text/html"></HEAD><BODY>' . $body . '</BODY></HTML>';



 	$mail->Body    = nl2br($body_html);

 	$mail->AltBody = $body;

 	$mail->AddAddress( $to );





	if( sizeof($attachment) != 0 )

	{

		foreach($attachment as $k=>$v)

		{

			$mail->AddStringAttachment($v, $k);

		}

	}





 	$res = $mail->Send();

	$ErrorInfo = $mail->ErrorInfo;

	unset( $mail );



	//toLog("Send to - $to - $res", $ErrorInfo);



	if( $res ) return true;

	else

		return false;

	//return $ErrorInfo;



}



if($_POST['first_name']!=null)

{

	$mails_str = edit_mails($_POST['emails']);





	$mails = array();

	$k=1;



	array_push($mails, strtok($mails_str, ','));



	while($temp=strtok(','))

	{

		array_push($mails, $temp);

		$k++;

	}



	// subject

	$subject = $_POST['first_name'].' sent you a video!';



	//reading message text

	$file = $_POST['config_file'];



	$handle = fopen($file, "r");

	$contents = fread($handle, filesize($file));

	fclose($handle);



	$xml = new myXML($contents);



	foreach ($xml->root->children as $child)

	{

		if($child->name == 'SHARE_FROM_MAIL')

		{

			$share_from_mail = $child->value[0];

		}

		if($child->name == 'SHARE_FROM_NAME')

		{

			$share_from_name = $child->value[0];

		}

		if($child->name == 'SHARE_TEXT')

		{

			$message = implode('', $child->value);

		}

	}


$vkey = $_POST['v'];
$vkey = substr($vkey, 0, -4);
$query = "SELECT vkey FROM video WHERE VID='".$vkey."'";
$db=mysql_connect ($DBHOST,$DBUSER,$DBPASSWORD) or die ('I cannot connect to the database because: ' . mysql_error());
mysql_select_db ($DBNAME);
$result = mysql_query($query) or die ('Query Error: ' . mysql_error());
$vkey = mysql_result($result, 0);
mysql_close();

	$arr_to_replace = array('##VIDEO_NAME##', '#PERS_MESSAGE#', '##FIRST_NAME##');

	$replace_to = array($vkey, $_POST['pers_message'], $_POST['first_name']);


	$message = str_replace($arr_to_replace, $replace_to, $message);



	echo '<h3 align=center>Thank you for sharing!</h3>';

	echo '<table  border=0 bordercolor=brown align=center>';

	echo '<tr><td>';

	echo ' Video has been sent to:<BR><UL>';

	echo '</td></tr>';

	echo '<tr><td>';



	for($i=0; $i<$k; $i++)

	{

		$to  = $mails[$i];

		if( sendMail($share_from_mail, $share_from_name, $to, $subject, $message) )

		{

			echo '<LI>'.$to.'</LI>';

		}

	}



	echo '</UL>';

	echo '</td></tr></table>';

}

else

echo '<form action=share_video.php method=post>

<B class="boldfont">Email To:</B><BR>

Enter email addresses, separated by commas.<BR>

Maximum 200 characters.<BR>

<textarea name=emails cols=40 rows=8>

</textarea>

<BR>

<input type=HIDDEN name=v value='.$_POST['v'].'>

<input type=HIDDEN name=config_file value='.$_POST['config_file'].'>

<BR><BR>

<B class="boldfont">Your First Name:</B> (optional)<BR>

<input type=text name=first_name size=30>

<BR><BR>

<B>Add a personal message:</B> (optional)<BR>

<textarea name=pers_message cols=40 rows=3>

This video is awesome!

</textarea>

<BR><BR>

<input type="submit" value="Send">

</form>';

?>

</body>

</html>
