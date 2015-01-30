<?php
$msg="";
if(isset($_POST['title'],$_POST['text']))
{
	insert_action("photo","add","0");
	if(!empty($_POST['title']) && !empty($_POST['text']))
	{	
			$title = $_POST["title"];
			$text = $_POST["text"];
			$text = strip_tags($text,"<i><b><p><span><strong><table><tbody><tr><td><th><em><stroke><ul><ol><li><img><a>");	
			$fillsymbols = $_POST["fillsymbols"];

			$select = mysql_query("SELECT MAX(position) AS maxi FROM `website_gallery_photos` WHERE status!=1  ");
			$getMax = mysql_fetch_array($select);
			$Max = $getMax['maxi']+1;
			
			$selidx = mysql_query("SELECT MAX(idx) AS maxi FROM `website_gallery_photos` WHERE status!=1 ");
			$getMaxidx = mysql_fetch_array($selidx);
			$Maxidx = $getMaxidx['maxi']+1;
			
			if(isset($_FILES["photo"]["name"])){
				$temp = explode(".", $_FILES["photo"]["name"]);
				$extension = end($temp);
				$allowedExts = array("gif", "jpeg", "jpg", "png","GIF","JPEG","JPG","PNG");
				$maxSize = 2000000;
				$newName = "gallery_".time();
				$uploaded = upload_file($allowedExts,"photo",$maxSize,"../image/gallery/",$newName);
				if(!$uploaded){
					$msg = l("erroroccurred");
					$theBoxColore = "red";
				}
				$newName = $newName.".".$extension;
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
					$insert = mysql_query("INSERT INTO `website_gallery_photos` SET
														`idx`='".(int)$Maxidx."',  
														`gallery_id`='".(int)$_GET['addid']."',  
														`date`='".time()."',   
														`photo`='".strip($newName)."',  
														`title`='".strip($title)."',  
														`description`='".strip($text)."',  
														`langs`='".strip($language)."',
														`position`=".(int)$Max.", 
														`access_admins`='".strip($access_admins)."'
														");
				}
			
			}
			if(!$insert)
			{
				$msg = l("erroroccurred")." ".mysql_error();
				$theBoxColore = "red";
			}
			else
			{										
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
				<label for="text"><i><?=l("text")?></i> <font color="#f00">*</font></label><div class="clearer"></div>
				<textarea name="text" class="text" id="text"><?=(isset($_POST['text'])) ? $_POST['text'] : "";?></textarea>
			</div>
			<div class="clearer"></div>
			
			<div class="boxes">
				<label for="photo"><i><?=l("photo")?></i> <font color="#f00">*</font></label>
				<input type="file" name="photo" class="photo" id="photo" value="" />
			</div><div class="clearer"></div>
				
			<div class="boxes">				
				<input type="submit" class="submit" id="submit" value="<?=l("add")?>" />
				<input type="reset" class="reset" id="reset" value="<?=l("clear")?>" />	
			</div><div class="clearer"></div><br />
			
		</form>