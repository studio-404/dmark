<?php
require'auth.php';
require_once 'Zend/Loader.php';
require_once '../ms_master.php';

/////////////////////// select START
$select = mysql_query("SELECT * FROM youtube_process WHERE status=1 ORDER BY updated_time ASC LIMIT 1");
$rows = mysql_fetch_object($select);
$id = $rows->id;
$youtube_id = $rows->youtube_id;
$type = $rows->type;
$connect_id = $rows->connect_id;
$updated_time = $rows->updated_time;
$process_time = $rows->process_time;
$video_status = $rows->video_status;
$ccount = $rows->ccount;
$schedule = $rows->schedule;
if (!$id) { echo 'no process'; exit; }
$selectTrans = mysql_query("UPDATE youtube_process SET updated_time='".time()."' WHERE id='".$id."'");
//////////////////// select END

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




/////// update video status
$myVideoEntry = new Zend_Gdata_YouTube_VideoEntry();
$myVideoEntry = $yt->getFullVideoEntry($youtube_id);

try {




	$yt->setMajorProtocolVersion(2);
	$youtubeEntry = $yt->getVideoEntry($youtube_id, null, true);
	$ggh=60*60;
    if ($ccount==0 && (time()-($ggh))>$process_time) { 
	if ($youtube_id) { $yt->delete($youtubeEntry); }
	$selectTrans = mysql_query("UPDATE youtube_process SET youtube_id='', status='0', ccount='1' WHERE id='".$id."' ");
	exit;
	}
	
	if ($ccount==1 && (time()-($ggh*2))>$process_time) {
	if ($youtube_id) { $yt->delete($youtubeEntry); }
    $aa = mysql_query("delete from youtube_process where id='".$id."' ");
	$selectTrans = mysql_query("UPDATE Transmission_db SET status='4' WHERE id='".$connect_id."' ");
	exit;
	} 
	
	if ($youtubeEntry->getControl()){
		$control = $youtubeEntry->getControl();
		$control->getState()->getName();
	}
	else
	{
		/////////////////////////// if uploaded finished START
		if($checkx=="")
		{
			switch($type)
			{//CHECK TYPE
				case 13:
				echo " : ) ";
				// if ($video_status==3) $myVideoEntry->setVideoPublic('public');
				
				// UPDATE youtube_process
				$update_youtube_process = mysql_query("delete from youtube_process where id='".$id."' ");
				
				// UPDATE TRANSMISSION
				$selectTrans = mysql_query("UPDATE Transmission_db SET youtube='".$youtube_id."', status='".$video_status."' WHERE id='".$connect_id."' ");
				
				// UPDATE VIDEO STATUS ON YOUTUBE BY schedule
				$insert = mysql_query("INSERT INTO youtube_update SET type='0', title='".$title."', description='".$description."', youtube_id='".$youtube_id."', time='".time()."', video_status='".$video_status."', schedule='".$schedule."' ");

               // Delete video file
			   $select = mysql_query("SELECT * FROM Transmission_db WHERE id='".$connect_id."'");
               $rows = mysql_fetch_object($select);
               $video = $rows->video;
               unlink('/var/www/data-server/hotge/temp-video/'.$video.''); 			   
			break;
			}
		}
		/////////////////////////// if uploaded finished END
	}
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