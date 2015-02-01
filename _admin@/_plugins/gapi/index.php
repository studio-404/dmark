<?php
if(file_exists("/home/dmark/domains/dmark.ge/public_html/_admin@/_plugins/gapi/gapi.class.php") && file_exists("/home/dmark/domains/dmark.ge/public_html/config.php")){
	require_once("/home/dmark/domains/dmark.ge/public_html/_admin@/_plugins/gapi/gapi.class.php");
	require_once("/home/dmark/domains/dmark.ge/public_html/config.php");
}else{ exit(); }
$email = "giorgigvazava87@gmail.com"; // akademqalaqi@gmail.com
$password = "afpbkqfhitxbddse"; // education201
$profile_id = 97203144; // 87806577 path after {p}
$ga = new gapi($email,$password);
if(isset($_POST["start"],$_POST["end"]) && $_POST["start"]<$_POST["end"]){
	$explodeS = explode("/",$_POST['start']);
	$explodeE = explode("/",$_POST['end']);	
	$start = $explodeS[2]."-".$explodeS[1]."-".$explodeS[0];
	$end = $explodeE[2]."-".$explodeE[1]."-".$explodeE[0];
}else{
	$start = date("Y-m-d");
	$end = date("Y-m-d");
}
$ga->requestReportData($profile_id,array('browser','browserVersion'),array('sessions','users','pageviews','visits','uniquepageviews'),null,null,$start,$end);

$pageViews = 0;
$visits = 0;
$users = 0;
$session = 0;
$unique_pageviews = 0;
$chrome = 0;
$Mozilla = 0;
$Explorer = 0;
$Opera = 0;
foreach($ga->getResults() as $result)
{
	$out["pageViews"][] = $result->getPageviews();
	$out["visits"][] = $result->getVisits();
	$out["users"][] = $result->getUsers();
	$out["session"][] = $result->getSessions();
	$out["unique_pageviews"][] = $result->getUniquePageviews();
	$out["browser"][] = $result->getBrowser();	
	$pageViews += $result->getPageviews();
	$visits += $result->getVisits();
	$users += $result->getUsers();
	$session += $result->getSessions();
	$unique_pageviews += $result->getUniquePageviews();
	if($result->getBrowser() == "Chrome"){
		$chrome += $result->getSessions();
	}
	if($result->getBrowser() == "Firefox"){
		$Mozilla += $result->getSessions();
	}
	if($result->getBrowser() == "Internet Explorer"){
		$Explorer += $result->getSessions();
	}
	if($result->getBrowser() == "Opera"){
		$Opera += $result->getSessions();
	}
}

$ga2 = new gapi($email,$password);
$ga2->requestReportData($profile_id,array('pagePath'),array('pageviews'),null,null,$start,$end);
foreach($ga2->getResults() as $res)
{
	$urlx["pagePath"][] = $res->getPagePath();
	$urlx["pageViews"][] = $res->getPageviews();
} 
?>