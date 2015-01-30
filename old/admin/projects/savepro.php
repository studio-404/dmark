<?php
//if (! $_SESSION['is_logged']) header("location:index.html");
	$db_name = "dmark";
	$table  = "news";
	$host = "localhost";
	$user = "admin";
	$pass = "torpedo";
	$link = mysql_connect($host,$user,$pass) or die (mysql_errno($link).mysql_error($link));
	$db = mysql_select_db($db_name,$link) or die (mysql_errno($link).mysql_error($link));
	
	$NameENG = $_POST['NameENG'];
	$NameGEO = $_POST['NameGEO'];
	$NameE = $_POST['NameE'];
	$NameG = $_POST['NameG'];
	$date = $_POST['date'];
	$AddressEng = $_POST['AddressEng'];
	$AddressGeo = $_POST['AddressGeo'];
	$FunctionENG = $_POST['FunctionENG'];
	$FunctionGEO = $_POST['FunctionGEO'];
	$Type = $_POST['Type'];	
	$query = "INSERT INTO projects ( NameENG , NameGEO, NameE, NameG, date, AddressEng, AddressGeo, FunctionENG, FunctionGEO, Type ) VALUES ( '$NameENG' , '$NameGEO' , '$NameE' , '$NameG' , '$date', '$AddressEng', '$AddressGeo', '$FunctionENG', '$FunctionGEO', '$Type')";
	$result = mysql_query($query, $link)  or die (mysql_errno($link).mysql_error($link));
	mysql_close($link);
	header('location: projects.php');
?>