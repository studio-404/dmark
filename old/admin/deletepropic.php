<?php
session_start();
if (! $_SESSION['is_logged']) header("Location:index.html");
?>
<?php
	$db_name = "dmark_dmark";
//	$table  = "newsphotos";
	$host = "localhost";
	$user = "dmark_datval";
	$pass = "torpedo";
	$link = mysql_connect($host,$user,$pass) or die (mysql_errno($link).mysql_error($link));
	$db = mysql_select_db($db_name,$link) or die (mysql_errno($link).mysql_error($link));
	$picid = $_REQUEST['id'];
	$query = "DELETE FROM propics WHERE ID = \"$picid\"";
	$result = mysql_query($query, $link)  or die (mysql_errno($link).mysql_error($link));
	mysql_close($link);
	
	header('location: projects.php');
?>
