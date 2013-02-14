<?php

if( $use_my_error_handler )
{
  // we will do our own error handling
  error_reporting( 0 );
  $old_error_handler = set_error_handler("userErrorHandler");
}

// user defined error handling function
function userErrorHandler ($errno, $errmsg, $filename, $linenum, $vars) {

	$send_to_mail = "ruan@ruansoft.net";

    // timestamp for the error entry
    $dt = date("Y-m-d H:i:s (T)");

    // define an assoc array of error string
    // in reality the only entries we should
    // consider are 2,8,256,512 and 1024
    $errortype = array (
                1   =>  "Error",
                2   =>  "Warning",
                4   =>  "Parsing Error",
                8   =>  "Notice",
                16  =>  "Core Error",
                32  =>  "Core Warning",
                64  =>  "Compile Error",
                128 =>  "Compile Warning",
                256 =>  "User Error",
                512 =>  "User Warning",
                1024=>  "User Notice"
                );
    // set of errors for which a var trace will be saved
    $user_errors = array(E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE);

    $err = "<errorentry>\n";
    $err .= "\t<datetime>".$dt."</datetime>\n";
    $err .= "\t<errornum>".$errno."</errornum>\n";
    $err .= "\t<errortype>".$errortype[$errno]."</errortype>\n";
    $err .= "\t<errormsg>".$errmsg."</errormsg>\n";
    $err .= "\t<scriptname>".$filename."</scriptname>\n";
    $err .= "\t<scriptlinenum>".$linenum."</scriptlinenum>\n";

    if (in_array($errno, $user_errors))
        $err .= "\t<vartrace>".wddx_serialize_value($vars,"Variables")."</vartrace>\n";
    $err .= "</errorentry>\n\n";

	if ($errno != 8)
	{
    	toLog($errmsg, $err);//save error message to log file
     	//mail($send_to_mail , "-error handler-$errortype[$errno]-$errmsg", $err);//send error by mail
	}
}
//---
function error( $text ){
	global $use_my_error_handler;
	$out = "<br><hr><font color=red>ERROR : $text</font><hr>";

	if(false && $use_my_error_handler)
	{
      trigger_error("USER EROR - $text", E_USER_ERROR);
	}else
	{
	  toLog("!!!ERROR!!!", $text);
	}

	//send error to XML stream
	openTag("mainerror", "");
	cdata($text);
	closeTag("mainerror");
	die("<!--$out-->");
}
//---

//---
function define_ex($name,$mixValue){
	if(!define($name,$mixValue));
	  //error( "Could not defined \"$name\"" );
}
//---
function print_ex($data){
	echo("<pre>");
	print_r($data);
	echo("</pre>");
}
//---
function toLog($title, $str)
{   global $writeLog;
	$fname = 'log.txt';

	//if( ! $writeLog ) return;

	if( !is_writable( $fname ) && file_exists( $fname ) ) return;

	$fp = fopen($fname,"a");
	fwrite($fp,"\n//-----------------------------------------------------");
	fwrite($fp,"\n//----$title");
	fwrite($fp,"\n//-----------------------------------------------------");

	if( is_array( $str ) ){
		ob_start();
		print_r( $str );
		$str = ob_get_contents();
		ob_end_clean();
	}

	fwrite ( $fp,"\n".$str);
	fclose ($fp);
	
	@chmod($fname, 0777);   
}
//------------------------------------------------------------------------------
// write() echo $text
//------------------------------------------------------------------------------
function write($text)
{
	global $writeBufCollect;
	if( isset($writeBufCollect) ) $writeBufCollect .= $text;
	else echo $text;
}
//------------------------------------------------------------------------------
// writeln() write from new line
//------------------------------------------------------------------------------
function writeln($text)
{
		write($text);
		//write("\n");
}
//------------------------------------------------------------------------------
// writeTag()
//------------------------------------------------------------------------------
function openTag($tag,$param = "")
{
		writeln("<$tag $param>");
}
//------------------------------------------------------------------------------
// closeTag()
//------------------------------------------------------------------------------
function closeTag($tag){
		writeln("</$tag>");
}
//------------------------------------------------------------------------------
// cdata()
//------------------------------------------------------------------------------
function cdata($data){
		writeln("<![CDATA[$data]]>");
}
//------------------------------------------------------------------------------
// lo return string to lower case
//------------------------------------------------------------------------------
function lo($str){
		$ret = strtolower($str);
		return $ret;
}

//------------------------------------------------------------------------------
// function for debuging
//------------------------------------------------------------------------------
$dbg_time_start = null;

function getmicrotime(){
   	 list($usec, $sec) = explode(" ",microtime());
   	 return ((float)$usec + (float)$sec);
}

function timer_start($msg = "Timer out", $start=true){
	  global $dbg_time_start;

	  if( $start )
	  {
	  		$dbg_time_start[ strtolower($msg) ] = getmicrotime();
	  }else
	  {
	  	  	$time_end = getmicrotime();

	  	  	$time = $time_end - $dbg_time_start[strtolower($msg)];

	  		if($time_end == $time)
	    		return "You NOT start timer!!!";
	  	    else
	    		return "[$msg]:time $time s.";
	  }
}

function get_time($msg = "Timer out"){

	  global $dbg_time_start;
	  $time_end = getmicrotime();

	  $time = $time_end - $dbg_time_start[strtolower($msg)];

	  if($time_end == $time)
	    return "You NOT start timer!!!";
	  else
	    return "[$msg]:time $time s.";

}

function special_replace( $instr ) 
{
	if(strcmp("#%5", $instr) == 0)  return ("");
	
	$instr = str_replace( "%103", "]", $instr);
	
	return ( str_replace( "%102", "\\r\\n", $instr) );
}	

function xmlErrMsg($msg)
{
	return "<mainerror><![CDATA[$msg]]></mainerror>";
}
?>