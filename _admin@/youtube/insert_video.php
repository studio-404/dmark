<?php
require_once '../ms_master.php';
require'auth.php';
require_once 'Zend/Loader.php';

function get($type,$connect_id) {

switch($type)
{
 case '13':
    $select2 = mysql_query("SELECT * FROM Transmission_db WHERE id='".$connect_id."' ");
	$rows2 = mysql_fetch_object($select2);
	$video_name = $rows2->video;
	$file_path = "/var/www/data-server/hotge/temp-video/".$video_name;
	return $file_path;
 break;
}

}

function update($type,$youtube_id,$id) {

switch($type)
{
 case '13':
	if($youtube_id)
	{
		$update = mysql_query("UPDATE youtube_process SET youtube_id='".$youtube_id."', status=1, process_time='".time()."' WHERE id='".$id."' ");
	}
 break;
}

}

$select = mysql_query("SELECT *, time as itime FROM youtube_process WHERE status=0 ORDER BY time LIMIT 1");
$rows = mysql_fetch_object($select);
$connect_id = $rows->connect_id;
$type = $rows->type;
$id = $rows->id;
$time = $rows->itime;
$title = $rows->title;
$description = $rows->description;
$update = mysql_query("UPDATE youtube_process SET status=2 WHERE id='".$id."' ");
if ((time()-108000)>$time) {
$aa = mysql_query("delete from youtube_process where id='".$id."' ");
exit;
}
if (!$id) { echo 'no process'; exit; }


$vid_file = get($type,$connect_id);
$vid_content_type = 'video/flash';
$vid_title = $title;
$vid_description = $description;
$vid_category = 'Entertainment';
$vid_tags = '';





Zend_Loader::loadClass('Zend_Gdata_YouTube');
Zend_Loader::loadClass('Zend_Gdata_ClientLogin');

$authenticationURL= 'https://www.google.com/accounts/ClientLogin';

$httpClient = Zend_Gdata_ClientLogin::getHttpClient(

              $username = $my_username,
              $password = $my_password,
              $service = 'youtube',
              $client = null,
              $source = 'MyYoutubeAPIApp',
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
if ($vid_title) $myVideoEntry->setVideoTitle(str_limit($vid_title, 33));
if (strlen($vid_description)>5) $myVideoEntry->setVideoDescription(str_limit($vid_description, 150));
$myVideoEntry->setVideoCategory($vid_category);
$myVideoEntry->SetVideoTags($vid_tags);
$myVideoEntry->setVideoPrivate('private');

$uploadUrl = 'http://uploads.gdata.youtube.com/feeds/api/users/default/uploads';

try { 
	$newEntry = $yt->insertEntry($myVideoEntry, $uploadUrl, 'Zend_Gdata_YouTube_VideoEntry'); 
	$v_id = $newEntry->getVideoId();
    if ($v_id) { update($type,$v_id,$id); }
	echo $v_id;
}

catch (Zend_Gdata_App_HttpException $httpException) { 

	echo $httpException->getRawResponseBody(); 
}

catch (Zend_Gdata_App_Exception $e) { 

	echo $e->getMessage(); 
}


#######################################################################################################


?>