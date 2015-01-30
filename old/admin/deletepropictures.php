<?php
session_start();
if (! $_SESSION['is_logged']) header("Location:index.html");
?>
<?php
	$db_name = "dmark_dmark";
//	$table = "newsphotos";
	$host = "localhost";
	$user = "dmark_datval";
	$pass = "torpedo";
	$link = mysql_connect($host,$user,$pass) or die (mysql_errno($link).mysql_error($link));
	$db = mysql_select_db($db_name,$link) or die (mysql_errno($link).mysql_error($link));
	$proid = $_REQUEST['id'];
	$query = "SELECT ID, thumb FROM propics WHERE proID = $proid";
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
		echo "</td><td><a href = 'deletepropic.php?id=",$data[0],"'>Delete</a>";
		echo "</td> </tr>";		
	};
	mysql_free_result($result);
	mysql_close($link);
	echo "</table>";
	echo "<a href = 'projects.php'> back</a>";
?>
