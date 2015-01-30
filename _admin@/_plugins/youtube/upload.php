<?php
function cut_text($text,$number,$dots=false)
{
	if($dots){ $d=""; }else{ $d="..."; }
	$charset = 'UTF-8';
	$length = $number;
	$string = $text;
	if(mb_strlen($string, $charset) > $length) {
	$string = mb_substr($string, 0, $length, $charset) . $d;
	}
	else
	{
		$string=$text;
	}
	return $string; 
}
require('../../../config.php');
// update cron time
$update = mysql_query("UPDATE `website_croned` SET `date`='".time()."' WHERE `id`=2 AND `type`='youtubeUpload' ");
$select = mysql_query("SELECT
`website_youtube_videos`.`id` AS wyv_id,
`website_youtube_videos`.`title` AS wyv_title,
`website_youtube_videos`.`description` AS wyv_description, 
`website_youtube_videos`.`category` AS wyv_category, 
`website_youtube_videos`.`tags` AS wyv_tags, 
`website_youtube_videos`.`video_file` AS wyv_video_file, 
`website_youtube_videos`.`private` AS wyv_private, 
`website_youtube`.`key` AS wy_key, 
`website_youtube`.`email` AS wy_email, 
`website_youtube`.`app_password` AS wy_app_password 
FROM 
`website_youtube_videos`,`website_youtube` 
WHERE 
`website_youtube_videos`.`status`!=1 AND  
`website_youtube_videos`.`upload_status`='inprogress' AND  
`website_youtube_videos`.`channel_id`=`website_youtube`.`id` AND  
`website_youtube`.`status`!=1 ORDER BY `website_youtube_videos`.`id` ASC LIMIT 1 
");
if(!mysql_num_rows($select)){ exit(); }
$rows = mysql_fetch_array($select);
#######################################################################################################
$mimeType = array(
	"flv"=>"video/x-flv",
	"mp4"=>"video/mp4",
	"3gp"=>"video/3gpp", 
	"mov"=>"video/quicktime", 
	"avi"=>"video/x-msvideo", 
	"wmv"=>"video/x-ms-wmv",
	"mpeg4"=>"video/mpeg", 
	"3GPP"=>"video/3gpp", 
	"WebM"=>"application/vnd.xara", 
	"MPEGPS"=>""
);
$extention = end(explode(".",$rows['wyv_video_file']));
$developerKey = $rows['wy_key']; //'AIzaSyCk2iW6uKkfcLkNufI7xi4k-m4dvL_vrLQ';
$my_username = $rows['wy_email']; //'infohotge@gmail.com';
$my_password = $rows['wy_app_password']; //'X7y2zb4b17';
$vid_file = "file/".$rows['wyv_video_file']; //'1.mp4';
$vid_unlink = "file/".$rows['wyv_video_file'];
$vid_content_type = $mimeType[$extention];
$vid_title = cut_text(strip_tags(html_entity_decode($rows['wyv_title'])),33);
$vid_description = cut_text(strip_tags(html_entity_decode($rows['wyv_description'])),160);
$vid_category = strip_tags(html_entity_decode($rows['wyv_category']));
$vid_tags = strip_tags(html_entity_decode($rows['wyv_tags']));
$vid_private = (int)$rows['wyv_private'];
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
	echo $v_id;
	if ($v_id) {
		$update = mysql_query("UPDATE `website_youtube_videos` SET `croned_time`='".time()."', `video_link`='".mysql_real_escape_string($v_id)."', `upload_status`='uploaded' WHERE `id`='".(int)$rows['wyv_id']."' ");
		@unlink($vid_unlink);
	}
	else {
		$update = mysql_query("UPDATE `website_youtube_videos` SET `croned_time`='".time()."', `upload_error`='FALSE 1', `upload_status`='error' WHERE `id`='".(int)$rows['wyv_id']."' ");
	}
}

catch (Zend_Gdata_App_HttpException $httpException) { 
	$update = mysql_query("UPDATE `website_youtube_videos` SET `croned_time`='".time()."', `upload_error`='".mysql_real_escape_string($httpException->getRawResponseBody())."', `upload_status`='error' WHERE `id`='".(int)$rows['wyv_id']."' ");
}

catch (Zend_Gdata_App_Exception $e) { 
	$update = mysql_query("UPDATE `website_youtube_videos` SET `croned_time`='".time()."', `upload_error`='".mysql_real_escape_string($e->getMessage())."', `upload_status`='error' WHERE `id`='".(int)$rows['wyv_id']."' ");
}


#######################################################################################################


?>