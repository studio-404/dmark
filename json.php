<?php 
error_reporting(0);
@require("config.php"); 
$limit = (isset($_GET["limit"])) ? (int)$_GET["limit"] : 10;
$cat = (isset($_GET["cat"])) ? $_GET["cat"] : "public";
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
							`website_gallery_attachment`.`type`='catalog' AND 
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

$select = mysql_query("SELECT * FROM `website_catalogs_items` WHERE `catalog_id`=1 AND `status`!=1 AND `langs`='".mysql_real_escape_string($lang)."' ORDER BY `p_date` DESC LIMIT ".$from.",5 ");
//echo "SELECT * FROM `website_catalogs_items` WHERE `catalog_id`=1 AND `sattus`!=1 ORDER BY `p_date` DESC LIMIT ".$from.",5 ";
$datax = array();
$x = 0;
while($rows = mysql_fetch_array($select)){
	$image = getMainImageCatalog($rows["idx"],$lang);
	$datax["t_".$x]["datax"] = $rows["p_date"]; 
	$datax["t_".$x]["urlx"] = $lang."/projects/".$rows["idx"]; 
	$datax["t_".$x]["imagex"] = $image;
	$datax["t_".$x]["titlex"] = $rows["p_title"];
	$x++;
}

// for($x=0;$x<=$limit;$x++){
// 	$datax["t_".$x]["datax"] = $cat; 
// 	$datax["t_".$x]["urlx"] = $lang."/projects/".$x; 
// 	$datax["t_".$x]["imagex"] = "public/img/project1.png";
// 	$datax["t_".$x]["titlex"] = "Title ".$x;
// }

header('Content-Type: application/json');
echo json_encode($datax);
?>