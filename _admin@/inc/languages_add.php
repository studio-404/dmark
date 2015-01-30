<?php
$msg="";
if(isset($_POST['title'],$_POST['url']))
{	
	if(!empty($_POST['title']) && !empty($_POST['url']))
	{	
		$title = $_POST["title"]; 
		$url = $_POST["url"]; 
		$checkExists = mysql_query("SELECT `id` FROM `website_languages` WHERE `shortname`='".mysql_real_escape_string($url)."' ");
		if(!mysql_num_rows($checkExists))
		{
			//insert action
			insert_action("language","add","0");
			if(isset($_FILES["image"]["name"]) && !empty($_FILES["image"]["name"])){
				$temp = explode(".", $_FILES["image"]["name"]);
				$extension = strtolower(end($temp));
				$allowedExts = array("gif", "jpeg", "jpg", "png","swf");
				$maxSize = 2000000;
				$newName = "language_".time();
				$uploaded = upload_file($allowedExts,"image",$maxSize,"../image/language/",$newName);
				if(!$uploaded){
					$msg = l("erroroccurred");
					$theBoxColore = "red";
				}
				$newName = $newName.".".$extension;
			}
			if(!$msg){
				$admin_id = $_SESSION['admin_id'];
				$grand_id = implode(",",grand_admins());
				if(!in_array($admin_id,grand_admins())){
					$access_admins = $grand_id.",".$admin_id;
				}else{
					$access_admins = $grand_id;
				}
				$insert = mysql_query("INSERT INTO `website_languages` SET 
					`outname`='".strip($title)."', 
					`shortname`='".strip($url)."', 
					`img`='".strip($newName)."', 
					`visibility`='1',
					`access_admins`='".strip($access_admins)."'
				");
				if($insert)
				{
					insert_language_items("contactus",$url,0);
					insert_language_items("plain_text",$url,1);
					insert_language_items("website_catalogs",$url,1);
					insert_language_items("website_catalogs_attachment",$url,0);
					insert_language_items("website_catalogs_items",$url,1);
					insert_language_items("website_gallery",$url,1);
					insert_language_items("website_gallery_attachment",$url,0);
					insert_language_items("website_gallery_photos",$url,1);
					insert_language_items("website_menu",$url,1);
					insert_language_items("website_news",$url,1);
					insert_language_items("website_news_attachment",$url,0);
					insert_language_items("website_news_items",$url,1);
					insert_language_items("website_slider",$url,1);
					insert_language_items("website_poll",$url,1);					
					insert_language_items("website_banners",$url,1);					
					insert_language_items("website_charts",$url,1);					
					insert_language_items("website_charts_items",$url,1);			
					l("add",$url);	// to create language file	
					$newfile = "../public/css/".$url.".css";
					_copy_file_404("../public/css/ka.css",$newfile);
				}
				
			} 
			
			if(!$insert)
			{
				$msg = l("erroroccurred");
				$theBoxColore = "red";
			}
			else
			{	
				_refresh_404("/".ADMIN_FOLDER."/".$_GET["lang"]."/table/languages");
				exit();
				$msg = l("done");
				$theBoxColore = "orange";	
			}
		}
		else
		{
			$msg = l("erroroccurred");
			$theBoxColore = "red";
		}
	}
	else
	{
		$msg = l("requiredfields");
		$theBoxColore = "red";
	}
}
?>
<form action="" method="post" enctype="multipart/form-data">
	<?php
	if($msg) :
	?>
	<div class="boxes">
		<div class="error_msg <?=$theBoxColore?>"><i><?=$msg?> !</i></div>
	</div>
	<?php 
	endif;
	?>
	
	<div class="boxes">
		<label for="title"><i><?=l("title")?></i> <font color="#f00">*</font></label>
		<input type="text" name="title" class="title" id="title" value="<?=(isset($_POST['title'])) ? $_POST['title'] : "";?>" />
		<div class="checker_none title" onclick="$('.m_title').fadeIn('slow');">
			<div class="msg m_title"><?=l("filltitle")?> !</div>
		</div>
	</div><div class="clearer"></div>
	
	<div class="boxes">
		<label for="url"><i><?=l("url")?></i> <font color="#f00">*</font> <a href="http://www.sitepoint.com/web-foundations/iso-2-letter-language-codes/" target="_blank">{2}</a></label>
		<input type="text" name="url" class="url" id="url" value="<?=(isset($_POST['url'])) ? $_POST['url'] : "";?>" />
		<div class="checker_none url" onclick="$('.m_url').fadeIn('slow');">
			<div class="msg m_url"><?=l("fillurl")?> !</div>
		</div>
	</div><div class="clearer"></div>
	
	<!--<div class="boxes">
		<label for="image"><i><?=l("image")?></i> <font color="#f00">*</font></label>
		<input type="file" name="image" class="image" id="image" value="" />
	</div><div class="clearer"></div>-->
	
	<div class="boxes">				
		<input type="submit" class="submit" id="submit" value="<?=l("add")?>" />
		<input type="reset" class="reset" id="reset" value="<?=l("clear")?>" />	
	</div><div class="clearer"></div><br />
			
</form>