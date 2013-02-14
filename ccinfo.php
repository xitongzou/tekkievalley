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

function validateCCnum($string, $type=""){
        $string = str_replace(" ", "", $string);

                        if(!$string || $string=="4111111111111111"){
                                return false;

                        } else {
                                $ltype = strtolower($type);

                                if($ltype=="amex" || $ltype=="american express"){
                                        if((strlen($string)==15 && substr($string, 0, 2)==37) || (strlen($string)==15 && substr($string, 0, 2)==34)){
                                                #if($this->mod10Approve($string."0")){
                                                #        return true;
                                                #
                                                #} else {
                                                #        return false;
                                                #
                                                #}

                                                return true;

                                        } else {
                                                return false;

                                        }

                                } elseif($ltype=="mastercard" || $ltype=="master card"){
                                        if(strlen($string)==16 && substr($string, 0, 1)==5 && ($string != 5424000000000015)){
                                                if(mod10Approve($string)){
                                                        return true;

                                                } else {
                                                        return false;

                                                }

                                        } else {
                                                return false;

                                        }

                                } elseif($ltype=="visa"){
                                        if(strlen($string)==16 && substr($string, 0, 1)==4 && ($string != 4242424242424242)){
                                                if(mod10Approve($string)){
                                                        return true;

                                                } else {
                                                        return false;

                                                }

                                        } else {
                                                return false;

                                        }

                                } elseif($ltype=="discover"){
                                        if(strlen($string)==16 && substr($string, 0, 4)==6011){
                                                if(mod10Approve($string)){
                                                        return true;

                                                } else {
                                                        return false;

                                                }

                                        } else {
                                                return false;

                                        }

                                } else {
                                        return true;

                                }
                        }
                }


                function mod10Sum($string){
                        $result = (($string%5)*2) + floor(($string/5));

                        return $result;
                }



                function mod10Approve($int){
                        if(strlen($int)!=16){
                                print("<b>not 16 numbers: $int</b>");

                        } else {
                                $string = strrev($int);

                                for($x=0; $x<16; $x++){
                                        $total = (($x%2))?(mod10Sum($string[$x])+$total):($string[$x]+$total);
                                }


                                if(!($total%10)) {
                                        return true;

                                } else {
                                        return false;

                                }
                        }
                }


                function validateCCDate($string){
                        $d = getdate();
                        $yr = substr($string, 3, 2);
                        $mon = substr($string, 0, 2);

                        // compare current date info
                        $year = substr($d[year], 2, 2);
                        $month = (strlen($d[mon]) < 2)?"0".$d[mon]:$d[mon];

                        if($mon<1 || $mon>12){
                                return false;

                        } elseif((strlen($string) < 5) ||
                           (!strstr($string, "/")) ||
                                ($yr < $year) ||
                                ($yr==$year && $mon < $month)){

                                return false;

                        } else {
                                return true;

                        }
                }

                function loopX($int){
                        for($x=0; $x<$int; $x++){
                                $xs .= "X";
                        }

                        return $xs;
                }

                function hideCardNumber($number){
                        $len = strlen($number);
                        $first_four = substr($number, 0, 4);
                        $last_four = substr($number, ($len-4), 4);
                        $extras = ($len-8);

                        $hidden = $first_four.loopX($extras).$last_four;

                        return $hidden;
                }

?>
