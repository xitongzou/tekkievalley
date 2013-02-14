<?php
require('include/config.php');
require('classes/captcha.class.php');

$aFonts 	= array('fonts/VeraBd.ttf', 'fonts/VeraIt.ttf', 'fonts/Vera.ttf');
$oPhpCaptcha 	= new PhpCaptcha($aFonts, 158, 50);
$oPhpCaptcha->Create();
?>
