<?php 
error_reporting(0);
@require("config.php"); 
$limit = (isset($_GET["limit"])) ? (int)$_GET["limit"] : 5;
$lang = (isset($_GET["lang"])) ? $_GET["lang"] : "en";
$from = (isset($_GET["from"])) ? $_GET["from"] : 0;

function getMainImageCatalog($idx,$lang){
	$select = mysql_query("SELECT 
							`website_gallery_photos`.`photo` AS pho
							FROM 
							`website_gallery_attachment`, 
							`website_gallery`, 
							`website_gallery_photos` 
							WHERE 
							`website_gallery_attachment`.`connect_id`='".(int)$idx."' AND 
							`website_gallery_attachment`.`type`='news' AND 
							`website_gallery_attachment`.`langs`='".mysql_real_escape_string($lang)."' AND 
							`website_gallery_attachment`.`gallery_idx`=`website_gallery`.`idx` AND 
							`website_gallery`.`langs`='".mysql_real_escape_string($lang)."' AND 
							`website_gallery`.`status`!=1 AND 
							`website_gallery`.`idx`=`website_gallery_photos`.`gallery_id` AND 
							`website_gallery_photos`.`langs`='".mysql_real_escape_string($lang)."' AND 
							`website_gallery_photos`.`status`!=1 ORDER BY `website_gallery_photos`.`id` DESC LIMIT 1
							");
	if(mysql_num_rows($select)){
		$rows = mysql_fetch_array($select);
		return $rows["pho"];
	}else{
		return false;
	}		
}

$datax = array();

$select = mysql_query("SELECT * FROM `website_news_items` WHERE `news_idx`=1 AND `status`!=1 AND `langs`='".mysql_real_escape_string($lang)."' ORDER BY `date` DESC LIMIT ".$from.",5 ");
//echo "SELECT * FROM `website_catalogs_items` WHERE `catalog_id`=1 AND `sattus`!=1 ORDER BY `p_date` DESC LIMIT ".$from.",5 ";
$datax = array();
$x = 0;
while($rows = mysql_fetch_array($select)){
	$image = getMainImageCatalog($rows["idx"],$lang);
	$datax["t_".$x]["datex"] = date("d.m.Y",$rows["date"]); 
	$datax["t_".$x]["urlx"] = $rows["httplink"]; 

	$datax["t_".$x]["imgx"] = "crop.php?img=image/gallery/".$image."&width=430&height=300";
	$datax["t_".$x]["titlex"] = $rows["title"];
	$datax["t_".$x]["textx"] = $rows["long_text"];
	$x++;
}
header('Content-Type: application/json');
echo json_encode($datax);
?>