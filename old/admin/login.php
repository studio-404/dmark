<?php
	$db_name = "dmark_dmark";
	$table  = "users";
	$host = "localhost";
	$user = "dmark_datval";
	$pass = "torpedo";
	$link = mysql_connect($host,$user,$pass) or die (mysql_errno($link).mysql_error($link));
	$db = mysql_select_db($db_name,$link) or die (mysql_errno($link).mysql_error($link));
	$login = $_REQUEST['login'];
	$pass = $_REQUEST['pass'];
	if ($login != "admin") header('Location: index.php');
	$query = "SELECT password FROM users ";
	$result = mysql_query($query, $link)  or die (mysql_errno($link).mysql_error($link));
	$password = mysql_fetch_array($result);
	if ("dmark9i"!=$pass) {
		echo("Incorrect username or password");
		echo("<br><a href = \"index.php\"> back </a>");
	} else {
		session_start();
		$_SESSION['is_logged'] = TRUE;
		header('Location: panel.html');		
	};
	
?>