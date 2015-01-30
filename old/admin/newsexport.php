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
	$result = mysql_query("SELECT ID FROM ".$table." ORDER BY ID DESC;",$link)  or die (mysql_errno($link).mysql_error($link));
	
	$fh = fopen("../news.xml", 'w') or die("can't open file");
	fwrite($fh, "<root>\n");
	while ($data = mysql_fetch_row($result)){
		fwrite($fh, " <news>\n");
		
		$res = mysql_query("SELECT Date FROM ".$table." WHERE ID = '$data[0]' ;",$link)  or die (mysql_errno($link).mysql_error($link));
		$dt = mysql_fetch_row($res);
		fwrite($fh,"<date>$dt[0]</date>\n");
		
		$res = mysql_query("SELECT smalltexteng FROM ".$table." WHERE ID = '$data[0]' ;",$link)  or die (mysql_errno($link).mysql_error($link));
		$dt = mysql_fetch_row($res);
		fwrite($fh,"<smalltexteng>$dt[0]</smalltexteng>\n");
		
		$res = mysql_query("SELECT bigtexteng FROM ".$table." WHERE ID = '$data[0]' ;",$link)  or die (mysql_errno($link).mysql_error($link));
		$dt = mysql_fetch_row($res);
		fwrite($fh,"<bigtexteng>$dt[0]</bigtexteng>\n");
		
	
		$res = mysql_query("SELECT smalltextgeo FROM ".$table." WHERE ID = '$data[0]' ;",$link)  or die (mysql_errno($link).mysql_error($link));
		$dt = mysql_fetch_row($res);
		fwrite($fh,"<smalltextgeo>$dt[0]</smalltextgeo>\n");
		
		$res = mysql_query("SELECT bigtextgeo FROM ".$table." WHERE ID = '$data[0]' ;",$link)  or die (mysql_errno($link).mysql_error($link));
		$dt = mysql_fetch_row($res);
		fwrite($fh,"<bigtextgeo>$dt[0]</bigtextgeo>\n");
		
		
		
		$res = mysql_query("SELECT address FROM newsphotos WHERE newsID = '$data[0]' ;",$link)  or die (mysql_errno($link).mysql_error($link));		
		while ($dt = mysql_fetch_row($res)){
			fwrite($fh,"<picture>admin/$dt[0]</picture>\n");			
			
		};
		
		
		fwrite($fh, " </news>\n");
	};
	fwrite($fh, "</root>");
	fclose($fh);	
	header("location:panel.html");
?>