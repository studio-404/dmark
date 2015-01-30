<?php
if (! $_SESSION['is_logged']) header("Location:index.html");
	$db_name = "dmark";
	$table = "newsphotos";
	$host = "localhost";
	$user = "admin";
	$pass = "torpedo";
	$link = mysql_connect($host,$user,$pass) or die (mysql_errno($link).mysql_error($link));
	$db = mysql_select_db($db_name,$link) or die (mysql_errno($link).mysql_error($link));
	$newid = $_REQUEST['id'];
	$query = "SELECT ID, address FROM newsphotos WHERE newsID = $newid";
	$result = mysql_query($query, $link)  or die (mysql_errno($link).mysql_error($link));
	echo "<table border = 1>";
	$th = explode("#","picture#Delete");
	echo "<tr><th>";
	echo implode ("</th><th>",$th);
	echo "</th></tr>";
	while ($data = mysql_fetch_row($result)){
		echo "<tr><td>";
//		echo implode ("</td><td>",$data);
		echo "<img src=\"$data[1]\" />";
		echo "</td><td><a href = 'deletenewspic.php?id=",$data[0],"'>Delete</a>";
		echo "</td> </tr>";		
	};
	mysql_free_result($result);
	mysql_close($link);
	echo "</table>";
	echo "<a href = 'news.php'> back</a>";
?>
