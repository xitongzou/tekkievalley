<?php
defined('_VALID') or die('Restricted Access!');
require $config['BASE_DIR']. '/classes/pagination.class.php';
chk_admin_login();

$remove         = NULL;
if ( isset($_GET['a']) ) {
    $action = trim($_GET['a']);
    $AID    = ( isset($_GET['AID']) ) ? intval(trim($_GET['AID'])) : NULL;
    switch ( $action ) {
    case 'delete':
        $sql    = "DELETE FROM adv_text WHERE adv_id = " .$AID. " LIMIT 1";
        $conn->execute($sql);
        if ( $conn->Affected_Rows() === 1 ) {
            $msg = 'Text advertise was successfuly deleted!';
        } else {
            $err = 'Failed to delete text advertise! Are you sure this advertise exists?!';
        }
        $remove = '&a=delete&AID=' .$AID;
        break;
    case 'activate':
    case 'suspend':
        $status     = ( $action == 'activate' ) ? 1 : 0;
        $sql        = "UPDATE adv_text SET status = '" .$status. "' WHERE adv_id = " .$AID. " LIMIT 1";
        $conn->execute($sql);
        if ( $conn->Affected_Rows() === 1 ) {
            $msg = 'Text advertise was successfuly ' .$action. 'ed!';
        } else {
            $err = 'Failed to ' .$action. ' advertise! Are you sure this advertise exists?!';
        }
        $remove = '&a=' .$action. '&AID=' .$AID;
        break;
    default:
        $err = 'Invalid action! Allowed actions: delete, activate and suspend!';
    }
}

$query          = constructQuery();
$rs             = $conn->execute($query['count']);
$total_advs     = $rs->fields['total_advs'];
$pagination     = new Pagination($items);
$limit          = $pagination->getLimit($total_advs);
$paging         = $pagination->getAdminPagination($remove);
$sql            = $query['select']. " LIMIT " .$limit;
$rs             = $conn->execute($sql);
$advs           = $rs->getrows();

function constructQuery()
{
    $query              = array();
    $query_count        = "SELECT COUNT(adv_id) AS total_advs FROM adv_text";
    $query_select       = "SELECT * FROM adv_text";
    $query_add          = NULL;
    $option             = array('sort' => 'adv_id', 'order' => 'DESC', 'display' => 20);
    $option             = ( isset($_SESSION['search_text_advertise']) ) ? $_SESSION['search_text_advertise'] : $option;
    if ( isset($_POST['search_text']) ) {
        $option['sort']     = trim($_POST['sort']);
        $option['order']    = trim($_POST['order']);
        $option['display']  = intval(trim($_POST['display']));

        $query_add = " ORDER BY " .$option['sort']. " " .$option['order'];

        $_SESSION['search_text_advertise'] = $option;
    }

    $query['select']    = $query_select . $query_add;
    $query['count']     = $query_count;
    $query['items']     = $option['display'];

    STemplate::assign('option', $option);

    return $query;
}

STemplate::assign('advs', $advs);
STemplate::assign('advs_total', $total_advs);
STemplate::assign('paging', $paging);
?>
