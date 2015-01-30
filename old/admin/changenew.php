<?php
session_start();
if (! $_SESSION['is_logged']) header("Location:index.html");
?><html>
<title> Change News </title>
<body>
<?php

	$db_name = "dmark_dmark";
	$table  = "news";
	$host = "localhost";
	$user = "dmark_datval";
	$pass = "torpedo";
	$link = mysql_connect($host,$user,$pass) or die (mysql_errno($link).mysql_error($link));
	$db = mysql_select_db($db_name,$link) or die (mysql_errno($link).mysql_error($link));
	$newid = $_REQUEST['id'];
	$query = "SELECT * FROM news WHERE ID = \"$newid\"";
	$result = mysql_query($query, $link)  or die (mysql_errno($link).mysql_error($link));
	$data = mysql_fetch_row($result);
	echo "<form method = \"post\" action = \"updatenew.php?id=$newid\">";
	echo "Date:<br>";
	echo "<input name=\"date\" type=\"text\"  value=\"$data[1]\"><br>";
	echo "Small English Text:<br>";
	echo "<textarea rows =\" 5 \" name = \"smalltexteng\" cols = \"100\"> $data[2]</textarea><br>";
	echo "Big English Text:<br>";	
	echo "<textarea rows =\" 10 \" name = \"bigtexteng\" cols = \"100\"> $data[3]</textarea><br>";
	echo "Small Georgian Text:<br>";
	echo "<textarea rows =\" 5 \" name = \"smalltextgeo\" cols = \"100\"> $data[4]</textarea><br>";
	echo "Big Georgian Text:<br>";	
	echo "<textarea rows =\" 10 \" name = \"bigtextgeo\" cols = \"100\"> $data[5]</textarea><br>";
	
	mysql_free_result($result);
	mysql_close($link);	
?>
<input type = "submit" value = "save" />
<input type="reset" value="clear" />
</form>
</body>
</html>