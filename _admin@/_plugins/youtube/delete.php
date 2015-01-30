<?php
require('../../../../config.php');
require('yt_functions.php');
// update cron time
$update = mysql_query("UPDATE `website_croned` SET `date`='".time()."' WHERE `id`=4 AND `type`='youtubeDelete' ");
$select = mysql_query("SELECT
`website_youtube_videos`.`id` AS wyv_id,
`website_youtube_videos`.`title` AS wyv_title,
`website_youtube_videos`.`description` AS wyv_description, 
`website_youtube_videos`.`category` AS wyv_category, 
`website_youtube_videos`.`tags` AS wyv_tags, 
`website_youtube_videos`.`video_link` AS wyv_video_link, 
`website_youtube_videos`.`private` AS wyv_private, 
`website_youtube`.`key` AS wy_key, 
`website_youtube`.`email` AS wy_email, 
`website_youtube`.`app_password` AS wy_app_password 
FROM 
`website_youtube_videos`,`website_youtube` 
WHERE 
`website_youtube_videos`.`status`=1 AND 
`website_youtube_videos`.`upload_status`!='deleted' AND 
`website_youtube_videos`.`upload_status`!='error' AND  
`website_youtube_videos`.`channel_id`=`website_youtube`.`id` AND  
`website_youtube`.`status`!=1
");
if(!mysql_num_rows($select)){ exit(); }
$rows = mysql_fetch_array($select);
$update = mysql_query("UPDATE `website_youtube_videos` SET `croned_time`='".time()."', `upload_status`='deleted' WHERE `id`='".(int)$rows['wyv_id']."' "); 
#######################################################################################################
$developerKey = $rows['wy_key']; //'AIzaSyCk2iW6uKkfcLkNufI7xi4k-m4dvL_vrLQ';
$my_username = $rows['wy_email']; //'infohotge@gmail.com';
$my_password = $rows['wy_app_password']; //'X7y2zb4b17';
$video_link = $rows['wyv_video_link'];
$vid_title = html_entity_decode(strip_tags($rows['wyv_title']));
$vid_description = html_entity_decode(strip_tags($rows['wyv_description']));
$vid_category = html_entity_decode(strip_tags($rows['wyv_category']));
$vid_tags = html_entity_decode(strip_tags($rows['wyv_tags']));
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
	$authenticationURL
);

$yt = new Zend_Gdata_YouTube($httpClient, "Null", "Null", $developerKey);


#######################################################################################################


$myVideoEntry = new Zend_Gdata_YouTube_VideoEntry();


if ($vid_private) $myVideoEntry->setVideoPrivate('private');

$myVideoEntry = $yt->getVideoEntry($video_link, null, true);

if ($myVideoEntry->getEditLink() !== null) {
}
$yt->delete($myVideoEntry);
?>