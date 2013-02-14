<?php
////////////////////////////////////////////////
## THIS IS AJAX BACK HAND SCRIPT FOR RATING CALCULATION 
/////////////////////////////////////////////////

## My SMARTY INI
include('../include/config.php');
include('../include/function.php');

## My AJAX INI
require_once($config['BASE_DIR'] . '/ajax/cpaint2.inc.php'); 

$cp = new cpaint();
$cp->register('process_data');
$cp->register('process_comments');
$cp->register('process_Vote');
$cp->register('executeDB');
$cp->register('view_vote');
$cp->register('addToFavorites');
$cp->register('checkUsername');
$cp->register('reportVideo');
$cp->register('featureVideo');
$cp->start();
$cp->return_data(); 

//##############################   DB EXEXUTION START  ####
function executeDB($sql) {
	global $cp; 
	global $conn;
	$myFlag="";
		
	## Check sql 
	if(!strstr($sql, 'select')){
		if(!strstr($sql, 'SELECT')){
			$myFlag="2";
		} else{
			$myFlag="1";
		}
	}
				
	if($myFlag=="1"){
		$dbreport="1";
		$res=$conn->execute($sql);
		$dbarray=$res->getarray();
			
		for( $i=0;$dbarray[$i]['0'];$i++){
			for( $ii=0;$dbarray['0'][$ii];$ii++){				
				$ret_name="dbvalue";
				$ret_name.=$i;
				$ret_name.=$ii;
				$a_result_node =& $cp->add_node($ret_name);
				$a_result_node->set_data($dbarray[$i][$ii]);
			}
		}
			
		$a_result_node =& $cp->add_node('recordcount');
		$a_result_node->set_data($i);
		$a_result_node =& $cp->add_node('coloumcount');
		$a_result_node->set_data($ii);
	} else{
		$dbreport="2";
		$conn->execute($sql);
		if(mysql_affected_rows()<0){
			$dbreport="-1";
		}

	}
	
	$a_result_node =& $cp->add_node('dbreport');
	$a_result_node->set_data($dbreport);
}
//## End	


//# Rating video
function process_data($rated,$vid) {
	 global $cp; 
	
	settype($vid, 'integer');
	 	 
	if(is_numeric($rated) && $rated>=2 && $rated<=10) {
		$flag=video_rating($vid,$rated);
		if($flag) {
			global $conn;
			$sql="select rate,ratedby from video where VID='" .mysql_real_escape_string($vid). "' LIMIT 1";
			$rs=$conn->execute($sql);
			$x=$rs->getarray();
			$trate=$x['0']['0'];
			$tvote=$x['0']['1'];
				
			#PROCESS RATE TO FLAG
			$rate=ceil($trate);
			$cnt=floor($rate/2);
				
			$a_result_node =& $cp->add_node("trate");
			$a_result_node->set_data($cnt);
			$a_result_node =& $cp->add_node("tvote");
			$a_result_node->set_data($tvote);
		} else {
			$a_result_node =& $cp->add_node("trate");
			$a_result_node->set_data('exist');
		}	
	} else {
		$a_result_node =& $cp->add_node("tvote");
		$a_result_node->set_data('0');
		$a_result_node =& $cp->add_node("tvote");
		$a_result_node->set_data('0');
	}
}
//End Rating



function process_comments($comments_value,$uid,$vid) {
	global $cp; 
 	global $conn;
	global $config;
	global $filterObj;
	 
	settype($uid, 'integer');
	settype($vid, 'integer');
	
	$msg = 1;
	if ( $config['video_comments'] == 0 ) {
		$msg = 2;
    }

	if ( $config['video_comments_limit'] == 1 && $msg = 1 ) {
		$sql = "SELECT COMID FROM comments WHERE VID = '" .mysql_real_escape_string($vid)."' AND UID = '" .mysql_real_escape_string($uid). "' LIMIT 1";
		$conn->execute($sql);
		if ( $conn->Affected_Rows() == 1 ) {
			$msg = 0;
        }
	}
	
	if ( $msg == 1 ) {
		$comments_value = $filterObj->process(trim($comments_value));
		$comments_value = str_replace('\r', '', $comments_value);
		$comments_value = preg_replace('/\n\n+/', '\n', $comments_value);
		$comments_value = str_replace('\n', '<br />', $comments_value);
		$sql="INSERT INTO comments SET VID='" .mysql_real_escape_string($vid). "', UID='" .mysql_real_escape_string($uid). "',
              commen='" .mysql_real_escape_string($comments_value). "', addtime='".time()."'";
		$conn->execute($sql);
	
		if ( $conn->Affected_Rows() == 1 ) {
			$sql="update video set com_num=com_num+1 WHERE VID='" .mysql_real_escape_string($vid). "' limit 1";
			$conn->execute($sql);
		}
	}
	
	$a_result_node =& $cp->add_node("a");
 	$a_result_node->set_data($msg);
}



function process_Vote($id,$voteAnswer)
{
	global $cp; 	
	global $conn;
	global $config;
	
    $today  = date('Y-m-d');
	$myIP   = $_SERVER['REMOTE_ADDR'];
	
	$flag   = false;
	if ( $config['user_poll'] == 'Once' ) {
        if ( isset($_SESSION['UID']) ) {
            $sql = "SELECT vote_id FROM vote_result
                    WHERE vote_id = '" .mysql_real_escape_string($id). "'
                    AND voter_id = '" .mysql_real_escape_string($_SESSION['UID']). "'
                    LIMIT 1";
        } else {
            $sql = "SELECT vote_id FROM vote_result
                    WHERE vote_id = '" .mysql_real_escape_string($id). "'
                    AND client_ip = '" .mysql_real_escape_string($myIP). "'
                    LIMIT 1";
        }
        
        $conn->execute($sql);
        if ( $conn->Affected_Rows() === 1 ) {
            $flag = true;
        }
	}
	
	if ( !$flag ) {
        $uid    = ( isset($_SESSION['UID']) ) ? $_SESSION['UID'] : NULL;
        $sql    = "INSERT INTO vote_result
                   SET vote_id = '" .mysql_real_escape_string($id). "',
                       voter_id = '" .mysql_real_escape_string($uid). "',
                       answer = '" .mysql_real_escape_string($voteAnswer). "',
                       client_ip = '" .mysql_real_escape_string($myIP). "',
                       voted_date = '" .mysql_real_escape_string($today). "'";
		$conn->execute($sql);
        if ( $conn->Affected_Rows() > 0 ) {
		    $a_result_node =& $cp->add_node("result");
			$a_result_node->set_data('1');			
		} else {
			$a_result_node =& $cp->add_node("result");
			$a_result_node->set_data('-1');
			
            return false;
		}

		$sql         = "SELECT * from poll_question where poll_id='" .mysql_real_escape_string($id). "' limit 1";
		$rsc         = $conn->execute($sql);
		$poll_answer = $rsc->fields['poll_answer']; 		
		$list        = explode('|' ,$poll_answer);
		for ( $i=0; $list[$i]; $i++) {
			$sql            = "SELECT COUNT(*) AS poll_id FROM vote_result WHERE answer='" . mysql_real_escape_string($list[$i]) . "'"  ;
			$rs             = $conn->execute($sql);
			$Countlist[$i]  = $rs->fields['poll_id'];						
		}


		# CALCULATE THE PARCENTAGE 
		$Countlist = clulateParcentage($Countlist);
			
		# CRETE NODE AND BACK TO PAVILION 
		for ( $i=0; $list[$i]; $i++ ){
		    $a_result_node =& $cp->add_node("A1".$i);
			$a_result_node->set_data($list[$i]);							
		}

		# CRETE NODE AND BACK TO PAVILION 
		for ( $i=0;1;$i++ ) {
			$a_result_node =& $cp->add_node("P1".$i);
			$a_result_node->set_data($Countlist[$i]);			
			if ( $Countlist[$i] == '' ) {
					break;
			}				
		}
		
		$a_result_node =& $cp->add_node("count");
		$a_result_node->set_data($i);		
	} else {
		$a_result_node =& $cp->add_node("result");
		$a_result_node->set_data('2');
		
        return false;
	}					
}

function view_vote($id){
	global $cp, $conn;

	$sql            = "SELECT * from poll_question  where poll_id='" .mysql_real_escape_string($id). "'";
    $rsc            = $conn->execute($sql);
	$poll_answer    = $rsc->fields['poll_answer']; 
	$list           = explode('|', $poll_answer);
    $count          = count($list);
    
    for ( $i=0; $i<$count; $i++ ) {
        $sql            = "SELECT count(*) AS total_votes FROM vote_result WHERE answer = '" .mysql_real_escape_string($list[$i]). "'";
        $rs             = $conn->execute($sql);
        $Countlist[$i]  = $rs->fields['total_votes'];
    }
    
	$Countlist=clulateParcentage($Countlist);
		
	# CRETE NODE AND BACK TO PAVILION 
	for ( $i=0; $i<$count; $i++) {
	    $a_result_node =& $cp->add_node('A1' .$i);
		$a_result_node->set_data($list[$i]);						
	}

	# CRETE NODE AND BACK TO PAVILION 
	for ( $i=0; $i<$count; $i++) {
		$a_result_node =& $cp->add_node('P1' .$i);
		$a_result_node->set_data($Countlist[$i]);			
    }
	
    $a_result_node =& $cp->add_node("count");
	$a_result_node->set_data($i);		
}

function checkUsername( $username ) {
	global $cp;
	global $conn;
	
	$msg = '1';
	if ( $username == '' )
		$msg = '2';
	else {
		$sql = "SELECT UID FROM signup WHERE username = '" .mysql_real_escape_string($username). "' LIMIT 1";
		$conn->execute($sql);
		if ( $conn->Affected_Rows() >= 1 )
			$msg = '0';
	}
	
	$a_result_node =& $cp->add_node("checkusermsg");
	$a_result_node->set_data($msg);
}

function addToFavorites( $uid, $vid, $vuid ) {
	global $cp;
	global $conn;
	
	settype( $uid, 'integer' );
	settype( $vid, 'integer' );
	settype( $vuid, 'integer' );
	
	$msg = 1;
	$sql = "SELECT VID FROM favourite WHERE VID = '" .mysql_real_escape_string($vid). "' AND UID = '" .mysql_real_escape_string($uid). "' LIMIT 1";
	$conn->execute($sql);
	if ( $conn->Affected_Rows() >= 1 )
		$msg = 2;
	else {
		$sql = "INSERT INTO favourite SET UID = '" .mysql_real_escape_string($uid). "', VID = '" .mysql_real_escape_string($vid). "'";
		$conn->execute($sql);
		if ( $conn->Affected_Rows() == 1 )
	    		$msg = 0;
	}
	
	$a_result_node =& $cp->add_node("addFavMessage");
	$a_result_node->set_data($msg);
}

function reportVideo( $uid, $vid ) {
	global $cp;
	global $conn;
	
	settype( $uid, 'integer' );
	settype( $vid, 'integer' );

	$msg = 1;
	$sql = "SELECT VID AS total FROM inappro_req WHERE VID = '" .mysql_real_escape_string($vid). "'";
	$conn->execute($sql);
	if ( $conn->Affected_Rows() >= 1 )
		$sql = "UPDATE inappro_req SET req = req + 1, date = '" .date('Y-m-d'). "' where VID = '" .mysql_real_escape_string($vid). "'";
	else
		$sql = "INSERT inappro_req SET VID = '" .mysql_real_escape_string($vid). "', req = 1, date ='" .date('Y-m-d'). "'";
	
	$conn->execute($sql);
	if ( $conn->Affected_Rows() == 1 )
		$msg = 0;
	
	$a_result_node =& $cp->add_node("reportVideoMessage");
	$a_result_node->set_data($msg);
}

function featureVideo( $uid, $vid ) {
	global $cp;
	global $conn;
	
	settype( $uid, 'integer' );
	settype( $vid, 'integer' );

	$msg = 1;
	$sql = "SELECT VID AS total FROM feature_req WHERE VID = '" .mysql_real_escape_string($vid). "'";
	$conn->execute($sql);
	if ( $conn->Affected_Rows() >= 1 )
		$sql = "UPDATE feature_req SET req = req + 1, date = '" .date('Y-m-d'). "' where VID = '" .mysql_real_escape_string($vid). "'";
	else
		$sql = "INSERT feature_req SET VID = '" .mysql_real_escape_string($vid). "', req = 1, date ='" .date('Y-m-d'). "'";
	
	$conn->execute($sql);
	if ( $conn->Affected_Rows() == 1 )
		$msg = 0;
	
	$a_result_node =& $cp->add_node("featureVideoMessage");
	$a_result_node->set_data($msg);
}
?>
