<?php
$actual_link = $_SERVER['REQUEST_URI'];
$path = $_GET['lang']."/slide/pn/";
$p = pagination("SELECT * FROM website_slider WHERE status!=1 AND langs='".mysql_real_escape_string($_GET['lang'])."' ORDER BY position ASC",$path,10);
?>