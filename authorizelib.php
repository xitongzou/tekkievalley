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

function convertToAuthorizeNetData($info){
        global $config;
        $data[x_First_Name] = $info[cc_fname_txt];
        $data[x_Last_Name] = $info[cc_lname_txt];
        $data[x_Address] = $info[cc_address1_txt]." ".$info[cc_address2_txt];
        $data[x_City] = $info[cc_city_txt];
        $data[x_State] = $info[cc_states_box];
        $data[x_Zip] = $info[cc_zipcode_txt];
        $data[x_Country] = $info[cc_country];
        $data[x_Email] = $info[cc_email_txt];
        $data[x_marchant_email] = $config[admin_email];
        $data[x_email_customer] = "TRUE";
        $data[x_description] = $info[cc_description];


        $data[x_Amount] = $info[cc_total];

        $data[x_Version] = "3.1";
        $data[x_Login] = $config[authorizelogin];
        $data[x_tran_key] = $config[authorizekey];

        $data[x_Card_Num] = $info[cc_num_txt];
        if($info[cc_exp_box1]<=9) $info[cc_exp_box1]="0".$info[cc_exp_box1];
        $data[x_Exp_Date] = $info[cc_exp_box1]."-".$info[cc_exp_box2];
        $data[x_card_code] = $info[cc_cvv_txt];

        $data[x_Delim_Data] = "TRUE";
        $data[x_Relay_Response] = "FALSE";
        $data[x_Delim_Char] = "|";
        $data[x_Currency_Code] = "USD";
        $data[x_Type] = "AUTH_CAPTURE";
        if($config['enable_test_payment'] == "yes")
                $data[x_Test_Request] = "TRUE";

        return $data;
                }



        function getNameValuePairs($info){
                foreach($info as $name => $value){
                        $array[] = "$name=$value";
                }
                        $pairs = @join("&", $array);
                        return $pairs;
        }
                
        //Then call it
        function approveAuthorizeNet($info){
                global $config;
                $curl = "/usr/bin/curl";
                $url = $config[authorizeurl];   //THIS IS THE AUTHORIZE.net url
                $pairs = getNameValuePairs($info);
                $cmd = "$curl -m 600 -d \"$pairs\" $url -L -s";

                $result = @`$cmd`;

                if(strlen($result)<5){
                        echo ("Unable to connect to $url with $curl");
                        exit;
                }

                $response = putAuthorizeNetResponseInArray($result);

                return $response;
        }


        function putAuthorizeNetResponseInArray($string){
                $array = @explode("|", $string);
                        return $array;
        }

        function getAuthorizeErrorMsg($code){
                        switch($code){

                                case 8:
                                        return "Credit card has expired.";
                                        break;

                                case 11:
                                        return "(Please wait 5 minutes before submitting again).";
                                        break;

                                case 17:
                                        return "$this->merchantURL doesn't accept this type of credit card.";
                                        break;

                                case 27:
                                        return "The transaction resulted in an AVS mismatch. The address provided does not match billing address of cardholder.";
                                        break;

                                case 78:
                                        return "The 3-4 digit code on the back of your credit card is invalid.";
                                        break;

                                default:
                                        return "";
                        }

                }

        //OK GET THE DATA AND PROCESS
        function check_authorize($info)
        {
                $data = convertToAuthorizeNetData($info);
                $response =  approveAuthorizeNet($data);
                if($response[0]==1) //SUCCESS
                {
                        $msg = "success";
                }
                else
                {
                        $msg=$response[3];
                }
                return $msg;
        }
?>
