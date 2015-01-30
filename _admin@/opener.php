<?php
session_start();
if(!isset($_GET['lang']) && ($_GET['lang']!="ka" || $_GET['lang']!="en")){ die("Fatal Error"); }

if(isset($_GET["configuration"]))
{
@require_once('../config.php');
@require('functions/functions.php');
@require('../_constants.php');
}else{ exit(); }

/* DISALLOW IPs*/
$select_ip = mysql_query("SELECT `ip_address` FROM `system_ips` WHERE `ip_address`='".strip($_SERVER['REMOTE_ADDR'])."' AND `status`!=1 ");
if(!mysql_num_rows($select_ip)){ die("<b>You dont have a permission ! Please tell website administrator to add your ip address to our database; your ip is: </b>".$_SERVER['REMOTE_ADDR']); }
else{ define("ALLOW",time()); }

/* open pages */
if(isset($_GET['404']))
{
$page = $_GET['404'];
if($page=="login")
{
	@require('login.php');
}else{
if(!$_SESSION['admin_id']){ echo '<meta http-equiv="refresh" content="0; URL=http://dmark.ge/_admin@/ka/login" />'; exit(); }

switch($page)
{
case "error":
@require('pages/error.php');
break;
case "home": 
@require('parts/header.php');
@require('controller/home.php');
@require('pages/home.php');
@require('parts/footer.php');
break;
case "table":
@require('parts/header.php');
@require('controller/table.php');
@require('pages/table.php');
@require('parts/footer.php');
break;
case "add":
@require('parts/header.php');
@require('controller/add.php');
@require('pages/add.php');
@require('parts/footer.php');
break;
case "edit":
@require('parts/header.php');
@require('controller/edit.php');
@require('pages/edit.php');
@require('parts/footer.php');
break;
case "slide":
@require('parts/header.php');
@require('controller/slide.php');
@require('pages/slide.php');
@require('parts/footer.php');
break;
case "googleAnalitics":
@require('parts/header.php');
@require('controller/googleAnalitics.php');
@require('pages/googleAnalitics.php');
@require('parts/footer.php');
break;
}
}
}
?>