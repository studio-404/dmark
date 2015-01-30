<?php
if (! $_SESSION['is_logged']) header("Location:index.html");
	$db_name = "dmark";
	$table  = "news";
	$host = "localhost";
	$user = "admin";
	$pass = "torpedo";
	$link = mysql_connect($host,$user,$pass) or die (mysql_errno($link).mysql_error($link));
	$db = mysql_select_db($db_name,$link) or die (mysql_errno($link).mysql_error($link));
	$date = $_POST['date'];
	$smalltexteng = $_POST['smalltexteng'];
	$bigtexteng = $_POST['bigtexteng'];
	$smalltextgeo = $_POST['smalltextgeo'];
	$bigtextgeo = $_POST['bigtextgeo'];	
	$newid = $_REQUEST['id'];
	
	$query = "UPDATE news SET smalltexteng = \"$smalltexteng\" WHERE ID = \"$newid\"";
	$result = mysql_query($query, $link)  or die (mysql_errno($link).mysql_error($link));
	
	$query = "UPDATE news SET bigtexteng = \"$bigtexteng\" WHERE ID = \"$newid\"";
	$result = mysql_query($query, $link)  or die (mysql_errno($link).mysql_error($link));
	
	$query = "UPDATE news SET smalltextgeo = \"$smalltextgeo\" WHERE ID = \"$newid\"";
	$result = mysql_query($query, $link)  or die (mysql_errno($link).mysql_error($link));
	
	$query = "UPDATE news SET bigtextgeo = \"$bigtextgeo\" WHERE ID = \"$newid\"";
	$result = mysql_query($query, $link)  or die (mysql_errno($link).mysql_error($link));
	
	
	mysql_close($link);
	header('location: news.php');
	echo $newdata;
	
?>