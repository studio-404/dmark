<!DOCTYPE html>
<html>
<head>
	<title>test</title>
	<meta charset="utf-8" />
</head>
<body>
<?php
exit();
date_default_timezone_set("Asia/Tbilisi");
define("HOST","localhost");
define("USER","mclagovg_error");
define("PASS","so7Kg0tv");
define("DB","mclagovg_error");
$error=null;
$con = @mysql_connect(HOST,USER,PASS);
if(!$con){ $error="Error Code 1"; }
$db = @mysql_select_db(DB,$con);
if(!$db){ $error="Error Code 2"; }
@mysql_set_charset('utf8',$con); 
@mysql_query("set names 'utf8'");
@mysql_query("SET character_set_result = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8', character_set_system='utf-8'", $con);

$result = mysql_query("SHOW COLUMNS FROM `website_youtube_videos`");

/*while($column = mysql_fetch_array($result)){
		echo "<pre>"; 
		print_r($column["Field"]);
		echo "<pre>";
}
exit();*/
$select = mysql_query("SELECT * FROM `website_youtube_videos` ORDER BY `id` DESC");
while($rows = mysql_fetch_array($select)){
	$delete_old = mysql_query("DELETE FROM `website_youtube_videos` WHERE `id`='".(int)$rows["id"]."' "); 
	$insert_into = mysql_query("
						INSERT INTO `website_youtube_videos` SET 
						`date`='".time()."', 
						`croned_time`='".mysql_real_escape_string($rows["croned_time"])."', 
						`channel_id`='".mysql_real_escape_string($rows["channel_id"])."', 
						`title`='".mysql_real_escape_string($rows["title"])."', 
						`description`='".mysql_real_escape_string($rows["description"])."', 
						`category`='".mysql_real_escape_string($rows["category"])."', 
						`tags`='".mysql_real_escape_string($rows["tags"])."', 
						`video_file`='".mysql_real_escape_string($rows["video_file"])."', 
						`private`='".mysql_real_escape_string($rows["private"])."', 
						`video_link`='".mysql_real_escape_string($rows["video_link"])."', 
						`upload_status`='".mysql_real_escape_string($rows["upload_status"])."', 
						`upload_error`='".mysql_real_escape_string($rows["upload_error"])."', 
						`access_admins`='".mysql_real_escape_string($rows["access_admins"])."', 
						`status`='".mysql_real_escape_string($rows["status"])."' 
	");
	echo mysql_error();
	
	echo "done: ".$rows["id"]."<br />";
	
}


?>
</body>
</html>