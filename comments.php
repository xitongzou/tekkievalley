<?php
defined('_VALID') or die('Restricted Access!');

chk_admin_login();

require $config['BASE_DIR']. '/classes/pagination.class.php';

$remove         = NULL;
$VID            = ( isset($_GET['VID']) && is_numeric($_GET['VID']) ) ? $_GET['VID'] : NULL;
if ( isset($_GET['a']) && $_GET['a'] == 'delete' ) {
    $COMID = ( isset($_GET['COMID']) && is_numeric($_GET['COMID']) ) ? $_GET['COMID'] : NULL;
    if ( $COMID ) {
        $sql = "DELETE FROM comments WHERE COMID = '" .mysql_real_escape_string($COMID). "' LIMIT 1";
        $conn->execute($sql);
        if ( $conn->Affected_Rows() == 1 ) {
            $msg = 'Comment deleted successfully!';
        } else {
            $err = 'Failed to delete comment! Invalid comment id!?';
        }
    } else {
        $err = 'Invalid comment id or not set!';
    }
    $remove = '&a=delete&COMID=' .$COMID;
}

$sql            = sprintf("SELECT count(COMID) AS total_comments FROM comments WHERE VID = '%d'", $VID);
$rs             = $conn->execute($sql);
$total_comments = $rs->fields['total_comments'];
$pagination     = new Pagination(10);
$limit          = $pagination->getLimit($total_comments);
$paging         = $pagination->getAdminPagination($remove);
$sql            = sprintf("SELECT * FROM comments WHERE VID = '%d' LIMIT %s", $VID, $limit);
$rs             = $conn->execute($sql);
$comments       = $rs->getrows();

STemplate::assign('VID', $VID);
STemplate::assign('comments', $comments);
STemplate::assign('total_comments', $total_comments);
STemplate::assign('paging', $paging);
?>
