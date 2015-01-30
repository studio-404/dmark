<?php
exit();
error_reporting(0);
@include("_constants.php");
@include("rd_config.php");
@include(ADMIN_FOLDER."/functions/functions.php");
?>
<!DOCTYPE html>
<html lang="<?=$_GET["langs"]?>">
<head>
	<meta charset="UTF-8" />
	<title><?=$_GET["title"]?></title>
	<link rel="stylesheet" type="text/css" href="public/css/style.css" />
	<link rel="stylesheet" type="text/css" href="public/css/<?=$_GET["langs"]?>.css" />
	<script src="public/scripts/jquery-1.11.1.min.js" type="text/javascript"></script>
	<!--[if IE]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
<style type="text/css">
.copyright{ font-size:12px; line-height:14px; padding:0 0 20px 0px; }
@media print {
.top{
    background-color: #0030b8 !important;
    -webkit-print-color-adjust: exact; 
}
.nav_bg{
	background-color: #9197a6 !important;
    -webkit-print-color-adjust: exact; 
}
.top .center h1{
	margin-left:30px;
}
.top .center h1 img{ left:30px; }
}
</style>	
<script type="text/javascript">
/*
window.onload = function () {
    window.print();
}
*/
</script>
</head>
<body>
	<header class="top">
		<div class="center">
			<h1>
				<img src="public/img/logo.png" width="115" height="136" alt="logo" title="logo" />
				<span><?=$_GET["title"]?></span> 
			</h1>		
		</div>
	</header>
	<div class="nav_bg"></div>

	
	<main>
		<section class="content">
			<h2 class="hidden">&nbsp;</h2>
			<div class="center">
				<aside class="text-left" style="width:1000px; margin:0 0 20px 0">
					<?php
					if($_GET["type"]=="text"){
						//http://error.404.ge/print.php?title=%E1%83%A1%E1%83%90%E1%83%A5%E1%83%90%E1%83%A0%E1%83%97%E1%83%95%E1%83%94%E1%83%9A%E1%83%9D%E1%83%A1%20%E1%83%A1%E1%83%90%E1%83%A1%E1%83%AF%E1%83%94%E1%83%9A%E1%83%90%E1%83%A6%E1%83%A1%E1%83%A0%E1%83%A3%E1%83%9A%E1%83%94%E1%83%91%E1%83%98%E1%83%A1%E1%83%90%20%E1%83%93%E1%83%90%20%E1%83%9E%E1%83%A0%E1%83%9D%E1%83%91%E1%83%90%E1%83%AA%E1%83%98%E1%83%98%E1%83%A1%20%E1%83%A1%E1%83%90%E1%83%9B%E1%83%98%E1%83%9C%E1%83%98%E1%83%A1%E1%83%A2%E1%83%A0%E1%83%9D&langs=ka&type=text&idx=8&return=http://error.404.ge/ka/internationalOrganizations
						$select = mysql_query("SELECT `title`, `text` FROM `website_menu` WHERE `idx`='".(int)$_GET["idx"]."' AND `langs`='".mysql_real_escape_string($_GET["langs"])."' ");
						$rows = mysql_fetch_array($select);
						$sql = "
								SELECT 
								`website_gallery_photos`.`photo` AS wgp_photo 
								FROM 
								`website_menu`, `website_gallery_attachment`, `website_gallery`, `website_gallery_photos` 
								WHERE 
								`website_menu`.`idx` = '".(int)$_GET["idx"]."' AND 
								`website_menu`.`langs`= '".mysql_real_escape_string($_GET['langs'])."' AND 
								`website_gallery_attachment`.`connect_id`=`website_menu`.`idx` AND 								
								`website_gallery_attachment`.`type`='text' AND 
								`website_gallery_attachment`.`langs`= '".mysql_real_escape_string($_GET['langs'])."' AND 
								`website_gallery_attachment`.`gallery_idx`=`website_gallery`.`idx` AND 			
								`website_gallery`.`langs`='".mysql_real_escape_string($_GET['langs'])."' AND 
								`website_gallery`.`idx`=`website_gallery_photos`.`gallery_id` AND 	
								`website_gallery_photos`.`langs`='".mysql_real_escape_string($_GET['langs'])."' AND 
								`website_gallery_photos`.`status` != 1 
								ORDER BY `website_gallery_photos`.`position` ASC LIMIT 1
								";
						$select_image = mysql_query($sql);
						if(mysql_num_rows($select_image)){
							$image = mysql_fetch_array($select_image);
						}else{ $image=false; }
					}else if($_GET["type"]=="catalog" && isset($_GET["item"])){
					// http://error.404.ge/print.php?title=%E1%83%A1%E1%83%90%E1%83%A5%E1%83%90%E1%83%A0%E1%83%97%E1%83%95%E1%83%94%E1%83%9A%E1%83%9D%E1%83%A1%20%E1%83%A1%E1%83%90%E1%83%A1%E1%83%AF%E1%83%94%E1%83%9A%E1%83%90%E1%83%A6%E1%83%A1%E1%83%A0%E1%83%A3%E1%83%9A%E1%83%94%E1%83%91%E1%83%98%E1%83%A1%E1%83%90%20%E1%83%93%E1%83%90%20%E1%83%9E%E1%83%A0%E1%83%9D%E1%83%91%E1%83%90%E1%83%AA%E1%83%98%E1%83%98%E1%83%A1%20%E1%83%A1%E1%83%90%E1%83%9B%E1%83%98%E1%83%9C%E1%83%98%E1%83%A1%E1%83%A2%E1%83%A0%E1%83%9D&langs=ka&type=catalog&idx=2&item=4&return=http://error.404.ge/ka/internationalOrganizations#
						$select = mysql_query("SELECT 
						`website_catalogs_items`.`namelname` as title,  
						`website_catalogs_items`.`shortbio` as short_bio,  
						`website_catalogs_items`.`startjob` as startjob, 
						`website_catalogs_items`.`profesion` as profesion, 
						`website_catalogs_items`.`dob` as dob, 
						`website_catalogs_items`.`bornplace` as bornplace, 
						`website_catalogs_items`.`livingplace` as livingplace,  
						`website_catalogs_items`.`phonenumber` as phonenumber, 
						`website_catalogs_items`.`email` as email,  
						`website_catalogs_items`.`education` as education,  
						`website_catalogs_items`.`workExperience` as workExperience,   
						`website_catalogs_items`.`treinings` as treinings,   
						`website_catalogs_items`.`certificate` as certificate,   
						`website_catalogs_items`.`languages` as languages    
						FROM 
						`website_catalogs_items` 
						WHERE 
						`website_catalogs_items`.`idx`='".(int)$_GET["item"]."' AND 
						`website_catalogs_items`.`catalog_id`='".(int)$_GET["idx"]."' AND 
						`website_catalogs_items`.`langs`='".mysql_real_escape_string($_GET["langs"])."' AND 
						`website_catalogs_items`.`status`!=1 
						");
						$rows = mysql_fetch_array($select);
						
						$sql = "
								SELECT 
								`website_gallery_photos`.`photo` AS wgp_photo 
								FROM 
								`website_catalogs_items`, `website_gallery_attachment`, `website_gallery`, `website_gallery_photos` 
								WHERE 
								`website_catalogs_items`.`idx` = '".(int)$_GET["item"]."' AND 
								`website_catalogs_items`.`langs`= '".mysql_real_escape_string($_GET['langs'])."' AND 
								`website_gallery_attachment`.`connect_id`=`website_catalogs_items`.`idx` AND 								
								`website_gallery_attachment`.`type`='catalog' AND 
								`website_gallery_attachment`.`langs`= '".mysql_real_escape_string($_GET['langs'])."' AND 
								`website_gallery_attachment`.`gallery_idx`=`website_gallery`.`idx` AND 			
								`website_gallery`.`langs`='".mysql_real_escape_string($_GET['langs'])."' AND 
								`website_gallery`.`idx`=`website_gallery_photos`.`gallery_id` AND 	
								`website_gallery_photos`.`langs`='".mysql_real_escape_string($_GET['langs'])."' AND 
								`website_gallery_photos`.`status` != 1 
								ORDER BY `website_gallery_photos`.`position` ASC LIMIT 1
								";
						$select_image = mysql_query($sql);
						if(mysql_num_rows($select_image)){
							$image = mysql_fetch_array($select_image);
						}else{ $image=false; }
						$rows["text"]="";
						if($rows["short_bio"]):
						$rows["text"] .= "<b>".l("shortbio",$_GET["langs"])."</b>: ".$rows["short_bio"]."<br />"; 
						endif;
						if($rows["startjob"]):
						$rows["text"] .= "<b>".l("startjob",$_GET["langs"])."</b>: ".date("d/m/Y",$rows["startjob"])."<br />";
						endif;
						if($rows["profesion"]):
						$rows["text"] .= "<b>".l("profesion",$_GET["langs"])."</b>: ".$rows["profesion"]."<br />";
						endif;
						if($rows["dob"]):
						$rows["text"] .= "<b>".l("dob",$_GET["langs"])."</b>: ".date("d/m/Y",$rows["dob"])."<br />";
						endif;
						if($rows["bornplace"]):
						$rows["text"] .= "<b>".l("bornplace",$_GET["langs"])."</b>: ".$rows["bornplace"]."<br />";
						endif;
						if($rows["livingplace"]):
						$rows["text"] .= "<b>".l("livingplace",$_GET["langs"])."</b>: ".$rows["livingplace"]."<br />";
						endif;
						if($rows["email"]):
						$rows["text"] .= "<b>".l("email",$_GET["langs"])."</b>: ".$rows["email"]."<br />";
						endif;
						if($rows["education"]):
						$rows["text"] .= "<b>".l("education",$_GET["langs"])."</b>: ".$rows["education"]."<br />";
						endif;
						if($rows["workExperience"]):
						$rows["text"] .= "<b>".l("workExperience",$_GET["langs"])."</b>: ".$rows["workExperience"]."<br />";
						endif;
						if($rows["treinings"]):
						$rows["text"] .= "<b>".l("treinings",$_GET["langs"])."</b>: ".$rows["treinings"]."<br />";
						endif;
						if($rows["certificate"]):
						$rows["text"] .= "<b>".l("certificate",$_GET["langs"])."</b>: ".$rows["certificate"]."<br />";
						endif;
						if($rows["languages"]):
						$rows["text"] .= "<b>".l("languages",$_GET["langs"])."</b>: ".$rows["languages"]."<br />";
						endif;
					}
					else if($_GET["type"]=="news")
					{
						$select = mysql_query("SELECT 
						`website_news_items`.`date` as date, 
						`website_news_items`.`title` as title,  
						`website_news_items`.`long_text` as text 
						FROM 
						`website_news_items` 
						WHERE 
						`website_news_items`.`idx`='".(int)$_GET["item"]."' AND 
						`website_news_items`.`news_idx`='".(int)$_GET["idx"]."' AND 
						`website_news_items`.`langs`='".mysql_real_escape_string($_GET["langs"])."' AND 
						`website_news_items`.`status`!=1 
						");
						$rows = mysql_fetch_array($select);
						$sql = "
								SELECT 
								`website_gallery_photos`.`photo` AS wgp_photo 
								FROM 
								`website_news_items`, `website_gallery_attachment`, `website_gallery`, `website_gallery_photos` 
								WHERE 
								`website_news_items`.`idx` = '".(int)$_GET["item"]."' AND 
								`website_news_items`.`langs`= '".mysql_real_escape_string($_GET['langs'])."' AND 
								`website_gallery_attachment`.`connect_id`=`website_news_items`.`idx` AND 								
								`website_gallery_attachment`.`type`='news' AND 
								`website_gallery_attachment`.`langs`= '".mysql_real_escape_string($_GET['langs'])."' AND 
								`website_gallery_attachment`.`gallery_idx`=`website_gallery`.`idx` AND 			
								`website_gallery`.`langs`='".mysql_real_escape_string($_GET['langs'])."' AND 
								`website_gallery`.`idx`=`website_gallery_photos`.`gallery_id` AND 	
								`website_gallery_photos`.`langs`='".mysql_real_escape_string($_GET['langs'])."' AND 
								`website_gallery_photos`.`status` != 1 
								ORDER BY `website_gallery_photos`.`position` ASC LIMIT 1
								";
						$select_image = mysql_query($sql);
						if(mysql_num_rows($select_image)){
							$image = mysql_fetch_array($select_image);
						}else{ $image=false; }
					}
					?>
					<?php if($image) :?>
					<a href="#" class="gallery" title=""><img src="crop.php?img=image/gallery/<?=$image["wgp_photo"]?>&width=350&height=225" width="350" height="225" alt="" class="popup" align="left" /></a>
					<?php endif; ?>
					<h2><?=html_entity_decode($rows["title"])?></h2>
					<div class="text">
					<?=html_entity_decode($rows["text"])?>
					</div>
					
				</aside>
				
			</div>
		</section>
	</main><div class="clearer"></div>
	<div class="copyright">
		<div class="center">
		&copy; 2014. საქართველოს სასჯელაღსრულების, პრობაციისა და იურიდიული დახმარების საკითხთა სამინისტრო. ყველა უფლება დაცულია
		</div>
	</div>
	
</body>
</html>