<?php 
require('include/config.php');
require('include/function.php');

$type = ( isset($_GET['type']) ) ? $_GET['type'] : NULL;
switch ( $type ) {
case 'new':
	$query = "SELECT A.*,B.UID,B.username FROM video A, signup B WHERE A.UID=B.UID AND A.type = 'public' ORDER BY A.VID desc LIMIT 20"; 
	$titel = "[20 Newest videos on ".$config['site_name']."]"; 
	$url   = $config['BASE_URL']."/rss/new/";
	break;
case 'views':
	$query = "SELECT A.*,B.UID,B.username FROM video A, signup B WHERE A.UID=B.UID AND A.type = 'public' ORDER BY A.viewnumber desc LIMIT 20"; 
	$titel = "[20 Most Viewed videos on ".$config['site_name']."]"; 
	$url = $config['BASE_URL']."/rss/views/";
	break;
case 'comments':
	$query = "SELECT A.*,B.UID,B.username FROM video A, signup B WHERE A.UID=B.UID AND A.type = 'public' ORDER BY A.com_num desc LIMIT 20"; 
	$titel = "[20 Most Commented videos on ".$config['site_name']."]"; 
	$url   = $config['BASE_URL']."/rss/comments/";
	break;
case 'rated':
    $query = "SELECT A.*,B.UID,B.username FROM video A, signup B WHERE A.UID=B.UID AND A.type = 'public' ORDER BY (A.ratedby*A.rate) desc LIMIT 20";
    $titel = "[20 Top Rated videos on ".$config['site_name']."]";
    $url   = $config['BASE_URL']."/rss/rated/";
    break;
case 'favorited':
    $query = "SELECT A.*,B.UID,B.username FROM video A, signup B WHERE A.UID=B.UID AND A.type = 'public' ORDER BY A.fav_num desc LIMIT 20";
    $titel = "[20 Top Favorited videos on ".$config['site_name']."]";
    $url   = $config['BASE_URL']."/rss/favorites/";
    break;
case 'featured':
    $query = "SELECT A.*,B.UID,B.username FROM video A, signup B WHERE A.UID=B.UID AND A.type = 'public' AND A.featured = 'yes' ORDER BY A.addtime desc LIMIT 20";
    $titel = "[20 Recently Featured videos on ".$config['site_name']."]";
    $url   = $config['BASE_URL']."/rss/favorites/";
    break;
case 'random':
    $query = "SELECT A.*,B.UID,B.username FROM video A, signup B WHERE A.UID=B.UID AND A.type = 'public' ORDER BY rand() desc LIMIT 20";
    $titel = "[20 Random videos on ".$config['site_name']."]";
    $url   = $config['BASE_URL']."/rss/random/";
    break;
default:
	$query = "SELECT A.*,B.UID,B.username FROM video A, signup B WHERE A.UID=B.UID AND A.type = 'public' ORDER BY A.VID desc LIMIT 20"; 
	$titel = "[20 Newest videos on ".$config['site_name']."]"; 
	$url   = $config['BASE_URL']."/rss/new/";
	break;
}


header("Content-Type: text/xml"); 
header("Expires: 0"); 

print "<?xml version=\"1.0\" encoding=\"iso-8859-1\" ?>\n";
print "<rss version=\"2.0\" xmlns:media=\"http://search.yahoo.com/mrss\">\n"; 
print "<channel>\n"; 
print "<title>".$config['site_name']."</title>\n"; 
print "<link>".$url."</link>\n"; 
print "<description>".$titel."</description>\n"; 
print "<copyright>Copyright (c) 2006-2007 by ".$config['site_name']." - All rights reserved.</copyright>\n"; 
print "<image>\n"; 
print "<url>".$config['BASE_URL']."/images/logo.jpg</url>\n";
print "<title>".$config['site_name']."</title>\n"; 
print "<link>".$config['BASE_URL']."/</link>\n";
print "</image>\n"; 

$db=mysql_connect ($DBHOST,$DBUSER,$DBPASSWORD) or die ('I cannot connect to the database because: ' . mysql_error());
mysql_select_db ($DBNAME); 

$num_rows = mysql_num_rows(mysql_query("select * from video")); 
$result = mysql_query($query) or die ('Query Error: ' . mysql_error()); 

while ($results = mysql_fetch_array($result)) {
	$photo       = $config['BASE_URL']."/thumb/".$results['thumb']."_".$results['VID'].".jpg"; 
	$video       = seo_url('video/' .$results['VID'], 'view_video.php?viewkey=' .$result['vkey'], $results['title']);
	$description = $results['description']; 
	$description = str_replace ("&amp","",htmlspecialchars(stripslashes($description), ENT_QUOTES, 'UTF-8')); 
	$photo       = str_replace ("&amp","&amp",htmlspecialchars(stripslashes($photo), ENT_QUOTES, 'UTF-8'));
    $username    = seo_url('users/' .$results['username'], 'uprofile.php?UID=' .$results['UID']);

print "<item>\n"; 
print "  <title>".htmlspecialchars($results['title'], ENT_QUOTES, 'UTF-8')."</title>\n";
print "  <link>".$video."</link>\n";
print "  <description>\n"; 
print "    <![CDATA["; 
print "<img src=\"$photo\" align=\"right\" border=\"0\" width=\"174\" height=\"130\" vspace=\"4\" hspace=\"4\" /><br /><br /> 
       <p>".$description."</p><p>".$key."</p> 
       <p>Added by: <a href=\"" .$username. "\">".$results['username']."</a><br/> 
       Tags: "; 
$tok = strtok($results['keyword'], " "); 
while ($tok !== false) { 
    print "<a href=\"$config[BASE_URL]/search_result.php?search_id=".$tok."\">".$tok."</a> "; 
    $tok = strtok(" "); 
} 

print "<br />Date: ".$results['adddate']."<br/></p><br /><hr>"; 
print "    ]]>\n"; 
print "  </description>\n"; 
print "  <author>".$results['username']."</author>\n"; 
print "</item>\n"; 
} 

mysql_close(); 
print "</channel>"; 
print "</rss>"; 
?> 
