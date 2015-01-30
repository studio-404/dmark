<?php
require'auth.php';
require_once '../ms_master.php';

/////////////////////// select START
$select = mysql_query("SELECT * FROM youtube_update where schedule<'".time()."' order by time ASC LIMIT 1");
$rows = mysql_fetch_object($select);
$id = $rows->id;
$youtube_id = $rows->youtube_id;
$type = $rows->type;
$video_status = $rows->video_status;
$title = $rows->title;
$description = $rows->description;
$aa = mysql_query("delete from youtube_update where id='".$id."' ");
if (!$id) { echo 'no process'; exit; }

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



$myVideoEntry = new Zend_Gdata_YouTube_VideoEntry();
$myVideoEntry = $yt->getFullVideoEntry($youtube_id);
    if ($type==1) {
	$yt->delete($myVideoEntry);
	$select = mysql_query("SELECT * FROM Transmission_db WHERE youtube='".$youtube_id."'");
    $rows = mysql_fetch_object($select);
    $video = $rows->video;
	unlink('/var/www/data-server/hotge/temp-video/'.$video.'');
	exit;
    }
if ($video_status!=3) $myVideoEntry->setVideoPrivate('private');
if ($video_status==3) $myVideoEntry->setVideoPublic('public');
if ($title) $myVideoEntry->setVideoTitle(str_limit($title, 33));
if (strlen($description)>5) $myVideoEntry->setVideoDescription(str_limit($description, 150));
try { 

		$yt->updateEntry($myVideoEntry, $putUrl, 'Zend_Gdata_YouTube_VideoEntry'); 

}


catch (Zend_Gdata_App_HttpException $httpException) { 

	echo $httpException->getRawResponseBody(); 
}

catch (Zend_Gdata_App_Exception $e) { 

	echo $e->getMessage(); 
}

?>