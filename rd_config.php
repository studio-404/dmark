<?php
date_default_timezone_set("Asia/Tbilisi");
define("HOST","localhost");
define("USER","mclagovg_error");
define("PASS","so7Kg0tv");
define("DB","mclagovg_error");
$error=null;
$con = @mysql_connect(HOST,USER,PASS);
if(!$con){ $error="Error Code 1"; }
$db = @mysql_select_db(DB,$con);
if(!$db){ $error="Error Code 2"; }
@mysql_set_charset('utf8',$con); 
@mysql_query("set names 'utf8'");
@mysql_query("SET character_set_result = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8', character_set_system='utf-8'", $con);
?>