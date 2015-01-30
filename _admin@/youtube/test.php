<?php


#######################################################################################################
@include 'auth.php';


$vid_file = '1.mp4'; // video file path

$vid_content_type = 'video/flash';

$vid_title = 'My Test Movie 2'; // title 

$vid_description = 'My Test Movie 2'; //desc

$vid_category = 'Entertainment'; // category

$vid_tags = 'cars, funny'; // tags

$vid_private = 0;


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


$myVideoEntry = new Zend_Gdata_YouTube_VideoEntry();

$filesource = $yt->newMediaFileSource($vid_file);
$filesource->setContentType($vid_content_type);
$filesource->setSlug($vid_file);

$myVideoEntry->setMediaSource($filesource);
$myVideoEntry->setVideoTitle($vid_title);
$myVideoEntry->setVideoDescription($vid_description);
$myVideoEntry->setVideoCategory($vid_category);
$myVideoEntry->SetVideoTags($vid_tags);
if ($vid_private) $myVideoEntry->setVideoPrivate('private');

$uploadUrl = 'http://uploads.gdata.youtube.com/feeds/api/users/default/uploads';

try { 

	$newEntry = $yt->insertEntry($myVideoEntry, $uploadUrl, 'Zend_Gdata_YouTube_VideoEntry'); 
	$v_id = $newEntry->getVideoId();

	if ($v_id) echo "<p>The uploaded video ID is $v_id</p>\n";
	else echo "<p>The uploaded video is still being processed and has no ID yet!</p>\n";
}

catch (Zend_Gdata_App_HttpException $httpException) { 

	echo $httpException->getRawResponseBody(); 
}

catch (Zend_Gdata_App_Exception $e) { 

	echo $e->getMessage(); 
}


#######################################################################################################


?>