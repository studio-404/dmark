<?php
$msg="";
if(isset($_POST['title'],$_POST['url']))
{	
	if(!empty($_POST['title']) && !empty($_POST['url']))
	{	
		insert_action("banners","add","0");
		$title = $_POST["title"]; 
		$url = $_POST["url"]; 
		$select = mysql_query("SELECT MAX(position) AS maxi FROM `website_banners` WHERE `status`!=1 ");
		$getMax = mysql_fetch_array($select);
		$Max = $getMax['maxi']+1;
		
		$select2 = mysql_query("SELECT MAX(idx) AS maxi FROM `website_banners` WHERE `status`!=1 ");
		$getMax2 = mysql_fetch_array($select2);
		$Max2 = $getMax2['maxi']+1;
		
		if(isset($_FILES["banner"]["name"])){
			$temp = explode(".", $_FILES["banner"]["name"]);
			$extension = strtolower(end($temp));
			$allowedExts = array("gif", "jpeg", "jpg", "png","swf");
			$maxSize = 2000000;
			$newName = "banner_".time().".".$extension;
			$uploaded = upload_file($allowedExts,"banner",$maxSize,"../image/banners/",$newName);
			if(!$uploaded){
				$msg = l("erroroccurred");
				$theBoxColore = "red";
			}
			$newName = $newName.".".$extension;
			$banner_type = ($extension=="swf") ? "flash" : "img";
		}
		if(!$msg){
			$select_languages = select_languages(); 
			foreach($select_languages["language"] as $language){			
				$admin_id = $_SESSION['admin_id'];
				$grand_id = implode(",",grand_admins());
				if(!in_array($admin_id,grand_admins())){
					$access_admins = $grand_id.",".$admin_id;
				}else{
					$access_admins = $grand_id;
				}
				$insert = mysql_query("INSERT INTO `website_banners` SET 
					`idx`='".(int)$Max2."', 
					`date`='".time()."',  
					`title`='".strip($title)."',  
					`banner_type`='".strip($banner_type)."',  
					`img_name`='".strip($newName)."', 
					`url`='".strip($url)."', 
					`langs`='".strip($language)."', 
					`position`='".(int)$Max."', 
					`access_admins`='".strip($access_admins)."'
				");
			}
		} 
		
		if(!$insert)
		{
			$msg = l("erroroccurred");
			$theBoxColore = "red";
		}
		else
		{
			_refresh_404("/".ADMIN_FOLDER."/".$_GET["lang"]."/edit/banners/".$Max2);
			exit();
			$msg = l("done");
			$theBoxColore = "orange";	
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
		<label for="url"><i><?=l("url")?></i> <font color="#f00">*</font></label>
		<input type="text" name="url" class="url" id="url" value="<?=(isset($_POST['url'])) ? $_POST['url'] : "";?>" />
		<div class="checker_none url" onclick="$('.m_url').fadeIn('slow');">
			<div class="msg m_url"><?=l("fillurl")?> !</div>
		</div>
	</div><div class="clearer"></div>
	
	<div class="boxes">
		<label for="banner"><i><?=l("banner")?></i> <font color="#f00">*</font></label>
		<input type="file" name="banner" class="banner" id="banner" value="" />
	</div><div class="clearer"></div>
		
	<div class="boxes">				
		<input type="submit" class="submit" id="submit" value="<?=l("add")?>" />
		<input type="reset" class="reset" id="reset" value="<?=l("clear")?>" />	
	</div><div class="clearer"></div><br />
			
</form>