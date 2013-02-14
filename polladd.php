<?php
defined('_VALID') or die('Restricted Access!');

chk_admin_login();

$start_date     = makeTimeStamp();
$end_date       = makeTimeStamp(date('Y')+1, date('m'), date('d'));
$question       = NULL;
$answers        = NULL;
if ( isset($_POST['add_poll']) ) {
    $start_day      = trim($_POST['start_Day']);
    $start_month    = trim($_POST['start_Month']);
    $start_year     = trim($_POST['start_Year']);
    $end_day        = trim($_POST['end_Day']);
    $end_month      = trim($_POST['end_Month']);
    $end_year       = trim($_POST['end_Year']);
    $question       = trim($_POST['question']);
    $answers        = trim($_POST['answers']);
    
    $start_formated = $start_year. '-' .$start_month. '-' .$start_day;
    $end_formated   = $end_year. '-' .$end_month. '-' .$end_day;
    
    if ( $question == '' ) {
        $err = 'Please enter your question and answers!';
    }
    
    if ( $start_year > $end_year ) {
        $err = 'Invalid date range or cannot overlap (start year > end year)!';
    } else {
        if ( $start_year == $end_year ) {
            if ( $start_month > $end_month ) {
                $err = 'Invalid date range or cannot overlap (start month > end_month)!';
            } else {
                if ( $start_month == $end_month ) {
                    if ( $start_day > $end_day ) {
                        $err = 'Invalid date range or cannot overlap (start day > end day)!';
                    }
                }
            }
        }
    }
        
    if ( $err == '' ) {    
        $start_time     = mktime( date('h'), date('i'), date('s'), $start_month, $start_day, $start_year);
        $end_time       = mktime( '00', '00', '00', $end_month, $end_day, $end_year);
        $current_time   = mktime( date('h'), date('i'), date('s'), date('m'), date('d'), date('Y'));
        if ( $start_time < $current_time )
            $err = 'Poll start time is in the past!';
        elseif ( $end_time < $current_time )
            $err = 'Poll end time is in the past!';
    }
    
    if ( $err == '' ) {
        $sql = "SELECT poll_id FROM poll_question WHERE start_date >= '" .$start_formated. "' AND end_date >= '" .$start_formated. "' 
                                                  OR start_date >= '" .$end_formated. "' AND end_date >= '" .$end_formated. "' LIMIT 1";
        $conn->execute($sql);
        if ( $conn->Affected_Rows() )
            $err = 'Poll overlaps with another previosly added poll!';
    }
    
    if ( $err == '' ) {
        $start_date = $start_time;
        $end_date   = $end_time;
        
        settype($answers, 'integer');
        $answersFormated = NULL;
        for ( $i=0; $i<$answers; $i++ ) {
            if ( $answersFormated != '' )
                $answersFormated .= '|';
            $answersFormated .= ( isset($_POST['voteAnsBox' .$i]) ) ? trim($_POST['voteAnsBox' .$i]) : NULL;
        }
        
        $sql = "INSERT INTO poll_question SET poll_qty = '" .mysql_real_escape_string($question). "', poll_answer = '" .mysql_real_escape_string($answersFormated). "',
                                              start_date = '" .mysql_real_escape_string($start_formated). "', end_date = '" .mysql_real_escape_string($end_formated). "'";
        $conn->execute($sql);
        if ( $conn->Affected_Rows() )
            $msg = 'Poll successfully added!';
        else
            $err = 'Failed to add poll! Application error !?';                                
    }
}

STemplate::assign('start_date', $start_date);
STemplate::assign('end_date', $end_date);
STemplate::assign('question', $question);
STemplate::assign('answers', $answers);
?>
