<?php
function printVideoEntry($videoEntry) 
{
	$out = array();
	$out['Video'] = $videoEntry->getVideoTitle();
	$out['VideoId'] = $videoEntry->getVideoId();
	$out['VideoUpdated'] = $videoEntry->getUpdated();
	$out['VideoDesc'] = $videoEntry->getVideoDescription();
	$out['VideoCat'] = $videoEntry->getVideoCategory();
	$out['VideoTags'] = implode(", ", $videoEntry->getVideoTags());
	$out['VideoWachPage'] = $videoEntry->getVideoWatchPageUrl();
	$out['VideoFlashPlayerUrl'] = $videoEntry->getFlashPlayerUrl();
	$out['VideoDuration'] = $videoEntry->getVideoDuration();
	$out['VideoViewCount'] = $videoEntry->getVideoViewCount();
	$out['VideoRating'] = $videoEntry->getVideoRatingInfo();
	$out['VideoGeoLocation'] = $videoEntry->getVideoGeoLocation();
	$out['VideoRecordedOn'] = $videoEntry->getVideoRecorded();
	foreach ($videoEntry->mediaGroup->content as $content)
	{
		if ($content->type === "video/3gpp") {
			$out['VideoMobileRTSP'][] = $content->url;
		}
	}
  $videoThumbnails = $videoEntry->getVideoThumbnails();

  foreach($videoThumbnails as $videoThumbnail) {
    $out['VideoThumTime'][] = $videoThumbnail['time']; 
	$out['VideoThumUrl'][] = $videoThumbnail['url'];
    $out['VideoThumHeight'] = $videoThumbnail['height'];
    $out['VideoThumWidth'] = $videoThumbnail['width'];
  }
  return $out;
}
?>