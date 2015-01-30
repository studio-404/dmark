<?php
session_start();
if (! $_SESSION['is_logged']) header("Location:index.html");
?>
<?php
	$db_name = "dmark_dmark";
//	$table  = "news";
	$host = "localhost";
	$user = "dmark_datval";
	$pass = "torpedo";
	$link = mysql_connect($host,$user,$pass) or die (mysql_errno($link).mysql_error($link));
	$db = mysql_select_db($db_name,$link) or die (mysql_errno($link).mysql_error($link));
	$proid = $_REQUEST['id'];
	$query = "DELETE FROM projects WHERE ID = \"$proid\"";
	$result = mysql_query($query, $link)  or die (mysql_errno($link).mysql_error($link));
	mysql_close($link);
	header('location: projects.php');
?>