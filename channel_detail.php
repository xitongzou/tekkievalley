<?php
require('include/config.php');
require('include/function.php');
require('classes/pagination.class.php');
require('language/' .$_SESSION['language']. '/channel_detail.lang.php');
require('language/' .$_SESSION['language']. '/video.lang.php');

$placement  = NULL;
$viewtype   = 'basic';
$active     = ( $config['approve'] == 1 ) ? " AND active = '1'" : NULL;
$approv     = ( $config['approve'] == 1 ) ? " AND v.active = '1'" : NULL;
$page	    = ( isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) ) ? $_REQUEST['page'] : 1;
$chid       = ( isset($_REQUEST['chid']) && is_numeric($_REQUEST['chid']) ) ? mysql_real_escape_string($_REQUEST['chid']) : NULL;
$chname     = NULL;
if ( $config['seo_urls'] == 1 ) {
	$sql    = "SELECT name FROM channel WHERE CHID = '" .$chid. "' LIMIT 1";
	$rs	    = $conn->execute($sql);
	$chname = $rs->fields['name'];
	$chname = clean_seo_text($chname, false);
}

$sql_count      = "SELECT count(VID) AS total_videos FROM video WHERE channel LIKE '%|" .$chid. "|%' AND type = 'public'";
$ars            = $conn->execute($sql_count);
$total          = $ars->fields['total_videos'];
$pagination     = new Pagination(6);
$limit          = $pagination->getLimit($total);
$pagination_url = $config['BASE_URL']. '/categories/' .$chid. '/{#PAGE#}/' .$chname;
$page_link      = $pagination->getPagination($pagination_url);
$start_num      = $pagination->getStartItem();
$end_num        = $pagination->getEndItem();
$sql            = "SELECT * FROM channel WHERE CHID = '" .$chid. "' LIMIT 1";
$rs             = $conn->execute($sql);
if ( $conn->Affected_Rows() == 1 ) {
	$channel    = $rs->getrows();

	$sql        = "SELECT count(VID) AS total, UID FROM video WHERE channel LIKE '%|" .$chid. "|%'" .$active. " GROUP BY UID ORDER BY total DESC LIMIT 5";
	$rsx        = $conn->execute($sql);
	$tmpary     = $rsx->getrows();
	STemplate::assign('actuser', $tmpary);

	$sql        = "SELECT v.*, s.username FROM video AS v, signup AS s
                   WHERE v.type = 'public' AND v.channel LIKE '%|" .$chid. "|%' AND v.UID = s.UID" .$approv. "
                   ORDER BY v.viewnumber DESC LIMIT 6";
	$rsx        = $conn->execute($sql);
	$tmpary     = $rsx->getrows();
	STemplate::assign('mostview', $tmpary);

	$sql        = "SELECT v.*, s.username FROM video AS v, signup AS s
                   WHERE v.type = 'public' AND v.channel LIKE '%|" .$chid. "|%' AND v.UID = s.UID" .$active. "
                   ORDER BY v.addtime DESC LIMIT " .$limit;
	$rsx        = $conn->execute($sql);
	$tmpary     = $rsx->getrows();
	STemplate::assign('recadd', $tmpary);
}
$rs=$conn->execute("select * from channel order by name ASC");

//RECENT CLOUD TAGS
$recenttagsquery    = "SELECT keyword FROM video WHERE type = 'public' AND channel LIKE '%|" .$chid. "|%'" .$active. " ORDER BY addtime DESC LIMIT 20";
$recenttags         = cloudTags($recenttagsquery);
STemplate::assign('recenttags', $recenttags);
//END CLOUD TAGS

STemplate::assign('err', $err);
STemplate::assign('msg', $msg);
STemplate::assign('page', $page);
STemplate::assign('start_num', $start_num);
STemplate::assign('end_num', $end_num);
STemplate::assign('placement',  $placement);
STemplate::assign('page_link', $page_link);
STemplate::assign('total', $total);
if ($rsx)
	STemplate::assign('total2', $rsx->recordcount());
STemplate::assign('answers', $channel);
STemplate::assign('channels', $rs->getrows());
STemplate::assign('viewtype', $viewtype);
STemplate::assign('head_bottom', 'videolinks.tpl');
STemplate::display('head1.tpl');
STemplate::display('err_msg.tpl');
STemplate::display('channel_detail.tpl');
STemplate::display('footer.tpl');
STemplate::gzip_encode();
?>
