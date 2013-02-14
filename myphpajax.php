<?php
/////////////////////////////////////////////////
## THIS IS AJAX BACK HAND SCRIPT FOR RATING CALCULATION 
/////////////////////////////////////////////////

## My SMARTY INI
include('../include/config.php');
include('../include/function.php');

## My AJAX INI
require_once($config['BASE_DIR']. 'ajax/cpaint2.inc.php'); 

$cp = new cpaint();
$cp->register('process_uservote');
$cp->start();
$cp->return_data(); 

// User Voting
function process_uservote ($voter,$candate,$rate) {
        global $cp;
        global $conn;

        $sql="select count(*) as cnt from uservote where candate_id='" .mysql_real_escape_string($candate) ."' and voter_id='" .mysql_real_escape_string($voter) ."'";
        $res=$conn->execute($sql);
        $x=$res->fields['cnt'];
                        
        if( $x>0) {                
    		// My flag
                $myMsg='f';
                $sql="select rate from signup where UID='" .mysql_real_escape_string($candate). "' limit 1";
                $rs=$conn->execute($sql);
                $t=ceil($rs->fields['rate']);
                $cnt=ceil($t/2);
        } else {
                // My flag
                $myMsg='s';        
                $today=date('d-m-Y');
                $sql="insert into uservote set candate_id='" .mysql_real_escape_string($candate). "', voter_id='" .mysql_real_escape_string($voter). "', voted_date='$today', vote='1'";
                $rs=$conn->execute($sql);
                $newrate=user_rating($candate,$rate);
                $cnt=ceil($newrate/2);
        }
                        
        $cnt = ceil($cnt/2);
        $a_result_node =& $cp->add_node("cnt");
        $a_result_node->set_data($cnt);
        $a_result_node =& $cp->add_node("myMsg");
        $a_result_node->set_data($myMsg);                
}

// End user voting
?>
