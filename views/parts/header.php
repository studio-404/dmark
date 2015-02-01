<!DOCTYPE html>
<html lang="<?=$_GET["lang"]?>">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
	<?php 
	if($this->news_page_item['wni_title']){ $this->text_title = $this->news_page_item['wni_title']." - ".strtoupper($websitemetatitle); }
	if($this->text_title==$websitemetatitle){ $websitemetatitle=""; }
	else{ $websitemetatitle = " - ".$websitemetatitle; }
	echo $this->text_title.strtoupper($websitemetatitle);
	?> 
	</title>
	<link rel="icon" type="image/gif" href="<?=MAIN_DIR?>/public/img/favicon.gif" />
	<base href="<?=MAIN_DIR?>/" />
	<!-- FB Meta tags (start) -->
	<meta property="og:title" content="<?=$this->text_title.strtoupper($websitemetatitle)?>" />
	<meta property="og:type" content="website" />
	<meta property="og:url" content="http://<?=$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI]?>" />
	<meta property="og:image" content="<?=MAIN_DIR?>/public/img/logo.png" />
	<meta property="og:site_name" content="<?=strip_tags($this->text_title)?>"/>
	<meta property="og:description" content="<?=strip_tags($this->text_text)?>"/>
	<!-- FB Meta tags (end)-->
	<meta name="keywords" content="<?=strip_tags(str_replace("%websitemetatitle%",str_replace(" ",",",$websitemetatitle),$this->keywords))?>">
	<meta name="author" content="სტუდია 404">	
	<?php echo $this->javascripts; ?>
</head>
<?php
if($_GET["url"]=="home"){	
	$files = scandir('morefiles/welcome_page/');
	$i = rand (2,(count($files)-1));	
}else{ $i=0; $files[$i] = ""; }
?>
<body>
<?php
@include("views/parts/analyticstracking.php");
?>
<div style="display:none" id="bgx"><?=$files[$i]?></div>