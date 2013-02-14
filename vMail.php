<?php
require '../include/config.php';

function valid_email($email)
{
	return eregi("^([-!#\$%&'*+./0-9=?A-Z^_`a-z{|}~^?])+@([-!#\$%&'*+/0-9=?A-Z^_`a-z{|}~^?]+\\.)+[a-zA-Z]{2,4}\$", $email);
}

function clean_title( $string )
{
    $string = ereg_replace('[^ 0-9a-zA-Z]', ' ', $string);
    $string = preg_replace('/\s\s+/', ' ', $string);
    $string = trim($string);
    $string = str_replace(' ', '-', $string);

    return $string;
}

$video_id	= ( isset($_GET['video_id']) && is_numeric($_GET['video_id']) ) ? intval($_GET['video_id']) : NULL;
if ( isset($_POST['me']) &&
     isset($_POST['to']) &&
	 isset($_POST['message']) ) {
	
	$from		= trim($_POST['me']);
	$to			= trim($_POST['to']);
	$message	= htmlspecialchars(trim($_POST['message']), ENT_QUOTES, 'UTF-8');
	if ( valid_email($from) && valid_email($to) ) {
		if ( $video_id ) {
			$sql	= "SELECT VID, title, vkey FROM video WHERE VID = " .$video_id. " LIMIT 1";
			$rs		= $conn->execute($sql);
			if ( $conn->Affected_Rows() === 1 ) {
				$title	= clean_title($rs->fields['title']);
				$vkey	= $rs->fields['vkey'];
				if ( $config['seo_urls'] == '1' ) {
					$url	= $config['BASE_URL']. '/video/' .$video_id. '/' .$title;
				} else {
					$url	= $config['BASE_URL']. '/view_video.php?viewkey=' .$vkey;
				}
				
				$sql 	= "SELECT * FROM emailinfo WHERE email_id='player_email' LIMIT 1";
				$rs		= $conn->execute($sql);
				if ( $conn->Affected_Rows() === 1 ) {
					STemplate::assign('video_url', $url);
					STemplate::assign('message', $message);
				
					$subject	= $rs->fields['email_subject'];
					$path		= $rs->fields['email_path'];
					$body		= STemplate::fetch($path);
					
					$mail           = new PHPMailer();
  					$mail->IsMail();
  					if ( $config['mailer'] == 'sendmail' ) {
      					if ( $config['sendmail'] != '' && @file_exists($config['sendmail']) && @is_executable($config['sendmail']) ) {
          					$mail->IsSendmail();
          					$mail->Sendmail     = $config['sendmail'];
      					}
  					} elseif ( $config['mailer'] == 'smtp' ) {
      					$mail->IsSMTP();
      					$mail->Host         = $config['smtp'];
      					$mail->Port     = $config['smtp_port'];
      					$mail->SMTPSecure   = $config['smtp_prefix'];
      					if ( $config['smtp_auth'] == '1' ) {
          					$mail->SMTPAuth = true;
          					$mail->Username = $config['smtp_username'];
          					$mail->Password = $config['smtp_password'];
      					}
  					}

  					$mail->IsHTML(true);
  					$mail->From         = $from;
  					// Return-Path
  					$mail->Sender       = $from;
  					$mail->AddAddress($to);
  					if ( $bcc ) {
      					$mail->AddAddress($bcc);
  					}
  					$mail->AddReplyTo( $from, $name);
  					$mail->Subject      = $subject;
  					$mail->AltBody      = $body;
  					$mail->Body     = nl2br($body);
					$mail->Send();
				}
			}
		}
	}
}
?>
