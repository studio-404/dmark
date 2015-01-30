<?php


#######################################################################################################


$developerKey = "AI39si4MkkISOFGlbk3woyUX3Y30mXPb6AKyjWCowZkxXmJkdTRPjLaQIcjlZIEOcgZeCnirLIWQtybrvfuRoYpg8Dd3TuGkSg";

$my_username = 'dustafo13@gmail.com';

$my_password = 'ratiug31';


#######################################################################################################


require_once 'Zend/Loader.php';

Zend_Loader::loadClass('Zend_Gdata_YouTube');
Zend_Loader::loadClass('Zend_Gdata_ClientLogin');

$authenticationURL= 'https://www.google.com/accounts/ClientLogin';

$httpClient = Zend_Gdata_ClientLogin::getHttpClient(

              $username = $my_username,
              $password = $my_password,
              $service = 'youtube',
              $client = null,
              $source = 'MyYoutubeAPIApp', // a short string identifying your application
              $loginToken = null,
              $loginCaptcha = null,
              $authenticationURL);

$yt = new Zend_Gdata_YouTube($httpClient, "Null", "Null", $developerKey);


#######################################################################################################

/////////////////////////////////////////////////////////////////////////////////////////////////////////// get data
$deleted_youtube = mysql_query("SELECT * FROM youtube_update WHERE type=1 ORDER BY time ASC LIMIT 1");
$deleted_youtube_rows = mysql_fetch_object($deleted_youtube);


$myVideoEntry = new Zend_Gdata_YouTube_VideoEntry();

$myVideoEntry = $yt->getFullVideoEntry($deleted_youtube_rows->youtube_id);
$putUrl = $myVideoEntry->getEditLink()->getHref();
$myVideoEntry->setVideoTitle('New Title');
$myVideoEntry->setVideoDescription('New Description');
$myVideoEntry->setVideoPublic('private');





try { 

	$yt->updateEntry($myVideoEntry, $putUrl, 'Zend_Gdata_YouTube_VideoEntry'); 
}

catch (Zend_Gdata_App_HttpException $httpException) { 

	echo $httpException->getRawResponseBody(); 
}

catch (Zend_Gdata_App_Exception $e) { 

	echo $e->getMessage(); 
}


#######################################################################################################


?>