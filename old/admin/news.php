<?php
session_start();
if (! $_SESSION['is_logged']) header("Location:index.html");
?>

<?php
	$db_name = "dmark_dmark";
	$table = "news";
	$host = "localhost";
	$user = "dmark_datval";
	$pass = "torpedo";
	$link = mysql_connect($host,$user,$pass) or die (mysql_errno($link).mysql_error($link));
	$db = mysql_select_db($db_name,$link) or die (mysql_errno($link).mysql_error($link));
	$result = mysql_query("SELECT ID, smalltexteng, date FROM ".$table." ORDER BY date DESC;",$link)  or die (mysql_errno($link).mysql_error($link));
	echo "<table border = 1>";
	$th = explode("#","ID#small text#Date#Change#Delete");
	echo "<tr><th>";
	echo implode ("</th><th>",$th);
	echo "</th></tr>";
	while ($data = mysql_fetch_row($result)){
		echo "<tr><td>";
		echo implode ("</td><td>",$data);
		echo "</td><td><a href = 'changenew.php?id=",$data[0],"'>Change</a>";
		echo "</td><td><a href = 'deletenew.php?id=",$data[0],"'>Delete</a>";
		echo "</td><td><a href = 'addnewspictures.php?id=",$data[0],"'>Add Picture</a>";
		echo "</td><td><a href = 'deletenewspictures.php?id=",$data[0],"'>Delete Picture</a>";
		echo "</td> </tr>";		
	};
	mysql_free_result($result);
	mysql_close($link);
	echo "</table>";
	echo "<a href = 'addnews.php'> Add news</a>";
	echo "<br> <a href = 'panel.html'>back to control panel</a>";
?>
