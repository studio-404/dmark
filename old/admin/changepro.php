<?php
session_start();
if (! $_SESSION['is_logged']) header("Location:index.html");
?>
<html>
<title> Change Projects </title>
<body>
<?php

	$db_name = "dmark_dmark";
	$table  = "projects";
	$host = "localhost";
	$user = "dmark_datval";
	$pass = "torpedo";
	$link = mysql_connect($host,$user,$pass) or die (mysql_errno($link).mysql_error($link));
	$db = mysql_select_db($db_name,$link) or die (mysql_errno($link).mysql_error($link));
	$proid = $_REQUEST['id'];
	$query = "SELECT * FROM projects WHERE ID = \"$proid\"";
	$result = mysql_query($query, $link)  or die (mysql_errno($link).mysql_error($link));
	$data = mysql_fetch_row($result);
	
	echo "<form method = \"post\" action = \"updatepro.php?id=$proid\">";
	echo "<input name=\"NameGEO\" type=\"text\" value = \"$data[2]\"><br>";
	echo "<input name=\"NameENG\" type=\"text\" value = \"$data[1]\"><br>";
	echo "<input name=\"Type\" type=\"text\" value = \"$data[3]\"><br>";
	echo "<input name=\"NameG\" type=\"text\" value = \"$data[5]\"><br>";
	echo "<input name=\"NameE\" type=\"text\" value = \"$data[4]\"><br>";
	echo "<input name=\"date\" type=\"text\" value = \"$data[6]\"><br>";
	echo "<input name=\"AddressGeo\" type=\"text\" value = \"$data[8]\"><br>";
	echo "<input name=\"AddressEng\" type=\"text\" value = \"$data[7]\"><br>";
	echo "<textarea rows =\"2 \" name = \"FunctionGEO\" cols = \"20\"> $data[10]</textarea><br>";
	echo "<textarea rows =\" 2 \" name = \"FunctionENG\" cols = \"20\"> $data[9]</textarea><br>";

	mysql_free_result($result);
	mysql_close($link);	
?>
<input type = "submit" value = "save" />
<input type="reset" value="clear" />
</form>
</body>
</html>