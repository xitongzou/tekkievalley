<?php
// WARNING:
// This might destroy your database, depending on your content, read here:
// http://dev.mysql.com/doc/refman/5.0/en/alter-table.html
require('include/config.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

$sql = "ALTER DATABASE " .$DBNAME. " CHARACTER SET utf8 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT COLLATE utf8_general_ci";
echo htmlspecialchars($sql). '<br>';
$conn->execute($sql);

$tables = array('adv', 'bans', 'buddy_list', 'channel', 'comments', 'emailinfo', 'favourite',
	    'feature_req', 'friends', 'group_mem', 'group_own', 'group_tps',
		'group_tps_post', 'group_vdo', 'guest_info', 'inappro_req', 'last_5users', 'package',
		'playlist', 'pm', 'poll_question', 'relation', 'sconfig', 'signup', 'subscribe_video',
		'subscriber', 'uservote', 'verify', 'video', 'vote_result');

foreach ( $tables as $table ) {
	$sql = "ALTER TABLE " .$table. " DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
	echo htmlspecialchars($sql). '<br>';
	$conn->execute($sql);
    $sql = "ALTER TABLE " .$table. " CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;";
    echo htmlspecialchars($sql). '<br>';
    $conn->execute($sql);
}
?>
