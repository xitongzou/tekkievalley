<?php
require '../include/config.php';

$sql = "UPDATE adv_text SET views = views+1 WHERE status = '1'";
$conn->execute($sql);

$sql = "SELECT * FROM adv_text WHERE status = '1' ORDER BY rand() LIMIT 10";
$rs = $conn->execute($sql);

header('Content-Type: text/xml; charset=utf-8');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
?>
<xml>
<?php if ( $conn->Affected_Rows() > 0 ) {
    $advs = $rs->getrows();
    foreach ( $advs as $adv ) { ?>
    <adv>
        <title><?php echo htmlspecialchars($adv['title'], ENT_QUOTES, 'UTF-8'); ?></title>
        <descr><?php echo htmlspecialchars($adv['descr'], ENT_QUOTES, 'UTF-8'); ?></descr>
	<ads_url><?php echo $config['BASE_URL']; ?>/click.php?TID=<?php echo $adv['adv_id']; ?></ads_url>
	<ads_displayed_url><?php echo $adv['adv_url']; ?></ads_displayed_url>
    </adv>
<?php
    }
}
?>
</xml>
