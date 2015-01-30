<?php
if (! $_SESSION['is_logged']) header("Location:index.html");
	$db_name = "dmark";
	$table  = "news";
	$host = "localhost";
	$user = "admin";
	$pass = "torpedo";
	$link = mysql_connect($host,$user,$pass) or die (mysql_errno($link).mysql_error($link));
	$db = mysql_select_db($db_name,$link) or die (mysql_errno($link).mysql_error($link));
	$newid = $_REQUEST['id'];
	$query = "DELETE FROM news WHERE ID = \"$newid\"";
	$result = mysql_query($query, $link)  or die (mysql_errno($link).mysql_error($link));
	mysql_close($link);
	header('location: news.php');
?>