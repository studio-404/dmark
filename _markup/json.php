<?php 
error_reporting(0);

$limit = (isset($_GET["limit"])) ? (int)$_GET["limit"] : 10;
$cat = (isset($_GET["cat"])) ? $_GET["cat"] : "public";
$datax = array();

for($x=0;$x<=$limit;$x++){
	$datax["t_".$x]["datax"] = $cat; 
	$datax["t_".$x]["urlx"] = "project_view.html"; 
	$datax["t_".$x]["imagex"] = "assets/img/project1.png";
	$datax["t_".$x]["titlex"] = "Title ".$x;
}

header('Content-Type: application/json');
echo json_encode($datax);
?>