<?php
session_start();
if (! $_SESSION['is_logged']) header("Location:index.html");
?>
<?php
	$db_name = "dmark_dmark";
	$table = "projects";
	$host = "localhost";
	$user = "dmark_datval";
	$pass = "torpedo";
	$link = mysql_connect($host,$user,$pass) or die (mysql_errno($link).mysql_error($link));
	$db = mysql_select_db($db_name,$link) or die (mysql_errno($link).mysql_error($link));
	$result = mysql_query("SELECT ID FROM ".$table." ORDER BY ID DESC;",$link)  or die (mysql_errno($link).mysql_error($link));
	
	$fh = fopen("../projects.xml", 'w') or die("can't open file");
	fwrite($fh, "<root>\n");
	while ($data = mysql_fetch_row($result)){
		fwrite($fh, " <project>\n");
		
		$res = mysql_query("SELECT NameENG FROM ".$table." WHERE ID = '$data[0]' ;",$link)  or die (mysql_errno($link).mysql_error($link));
		$dt = mysql_fetch_row($res);
		fwrite($fh,"<name_eng>$dt[0]</name_eng>\n");
		
		$res = mysql_query("SELECT NameGEO FROM ".$table." WHERE ID = '$data[0]' ;",$link)  or die (mysql_errno($link).mysql_error($link));
		$dt = mysql_fetch_row($res);
		fwrite($fh,"<name_geo>$dt[0]</name_geo>\n");
		
		$res = mysql_query("SELECT type FROM ".$table." WHERE ID = '$data[0]' ;",$link)  or die (mysql_errno($link).mysql_error($link));
		$dt = mysql_fetch_row($res);
		fwrite($fh,"<type>$dt[0]</type>\n");
		
		
		fwrite($fh,"<descroption_eng>\n");
	
		$res = mysql_query("SELECT NameE FROM ".$table." WHERE ID = '$data[0]' ;",$link)  or die (mysql_errno($link).mysql_error($link));
		$dt = mysql_fetch_row($res);
		fwrite($fh,"<name>$dt[0]</name>\n");

		$res = mysql_query("SELECT AddressEng FROM ".$table." WHERE ID = '$data[0]' ;",$link)  or die (mysql_errno($link).mysql_error($link));
		$dt = mysql_fetch_row($res);
		fwrite($fh,"<address>$dt[0]</address>\n");
		
		$res = mysql_query("SELECT date FROM ".$table." WHERE ID = '$data[0]' ;",$link)  or die (mysql_errno($link).mysql_error($link));
		$dt = mysql_fetch_row($res);
		fwrite($fh,"<date>$dt[0]</date>\n");

		$res = mysql_query("SELECT FunctionENG FROM ".$table." WHERE ID = '$data[0]' ;",$link)  or die (mysql_errno($link).mysql_error($link));
		$dt = mysql_fetch_row($res);
		fwrite($fh,"<function>$dt[0]</function>\n");
		
		fwrite($fh,"</descroption_eng>\n");


		fwrite($fh,"<descroption_geo>\n");
	
		$res = mysql_query("SELECT NameG FROM ".$table." WHERE ID = '$data[0]' ;",$link)  or die (mysql_errno($link).mysql_error($link));
		$dt = mysql_fetch_row($res);
		fwrite($fh,"<name>$dt[0]</name>\n");

		$res = mysql_query("SELECT AddressGeo FROM ".$table." WHERE ID = '$data[0]' ;",$link)  or die (mysql_errno($link).mysql_error($link));
		$dt = mysql_fetch_row($res);
		fwrite($fh,"<address>$dt[0]</address>\n");
		
		$res = mysql_query("SELECT date FROM ".$table." WHERE ID = '$data[0]' ;",$link)  or die (mysql_errno($link).mysql_error($link));
		$dt = mysql_fetch_row($res);
		fwrite($fh,"<date>$dt[0]</date>\n");

		$res = mysql_query("SELECT FunctionGEO FROM ".$table." WHERE ID = '$data[0]' ;",$link)  or die (mysql_errno($link).mysql_error($link));
		$dt = mysql_fetch_row($res);
		fwrite($fh,"<function>$dt[0]</function>\n");
		
		fwrite($fh,"</descroption_geo>\n");
		
		
		$res = mysql_query("SELECT thumb, image FROM propics WHERE proID = '$data[0]' ;",$link)  or die (mysql_errno($link).mysql_error($link));		
		while ($dt = mysql_fetch_row($res)){
			fwrite($fh,"<picture>\n");
			fwrite($fh,"<thumbs>admin/$dt[0]</thumbs>\n");
			fwrite($fh,"<big>admin/$dt[1]</big>\n");			
			fwrite($fh,"</picture>\n");
		};
		
		
		fwrite($fh, " </project>\n");
	};
	fwrite($fh, "</root>\n");
	fwrite($fh, $stringData);
	fclose($fh);	
	header("location:panel.html");	
?>