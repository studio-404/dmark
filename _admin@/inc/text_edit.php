<?php
$msg = "";
/*change permition*/
if(isset($_POST["s"])){ change_permition("website_menu",false,$_GET["edit"]); insert_action("navigation","change permition",$_GET["edit"]); }
/* check if have permition */
$admin_permition = check_if_permition("website_menu",false,$_GET["edit"]);
if(isset($_POST["post"]) && $admin_permition)
{
	insert_action("text","edit",$_GET["edit"]);
	// image upload
	foreach($_POST["post"] as $key => $value){ 
		if(!empty($value["meta_title"]) && !empty($value["meta_desc"]) && !empty($value["title"])){	
			// insert action
			insert_action("text","edti",$_GET['edit']);
			$update = mysql_query("UPDATE `website_menu` SET 
															`meta_title`='".strip($value["meta_title"])."',  
															`meta_desc`='".strip($value["meta_desc"])."',  
															`title`='".strip($value["title"])."',  
															`text`='".strip($value["text"])."' 
															WHERE 
															`idx`='".(int)$_GET['edit']."' AND 
															`langs`='".strip($key)."'
															");
		}else{
			$msg = l("requiredfields");
			$theBoxColore = "red";
		}		
	}
	$msg = l("done");
	$theBoxColore = "orange";
	if(mysql_error()){
		$msg = l("erroroccurred");
		$theBoxColore = "red";
	}
}
/*
** file upload
*/
if(isset($_FILES["file"]["name"]) && $admin_permition){
	insert_action("text","attach file",$_GET["edit"]);
	for($x=0;$x<count($_FILES["file"]['name']);$x++)
	{
		$temp = explode(".", $_FILES["file"]["name"][$x]);
		$extension = strtolower(end($temp));
		$allowedExts = array("xls", "XLS", "xlsx", "XLSX","doc","DOC","docx","DOCX","zip","ZIP","rar","RAR","pdf","PDF");
		if(!empty($_FILES["file"]["name"][$x]) && in_array($extension, $allowedExts)){	
			$maxSize = 200000000;
			$newName = "text_".time().$x;
			$uploaded = multy_upload_files($allowedExts,"file",$x,$maxSize,"../public/files/".strtolower($extension)."/",$newName);
			if(!$uploaded){
				$msg = l("erroroccurred");
				$theBoxColore = "red";
			}else{
				$msg = l("done");
				$theBoxColore = "orange";
			}
			if($msg== l("done")){
			$newName = $newName.".".$extension;
			$insert_files = mysql_query("INSERT INTO `website_files` SET 
															`page_idx`='".(int)$_GET['edit']."', 
															`page_type`='text', 
															`outname`='".mysql_real_escape_string($_POST['text'][$x])."', 
															`filename`='".mysql_real_escape_string($newName)."', 
															`filetype`='".mysql_real_escape_string($extension)."', 
															`langs`='".mysql_real_escape_string($_POST['weblang'])."'
															");
			}
		}
	}
}
/*
** photo upload
*/
if(isset($_FILES["photo_upload"]["name"]) && $admin_permition){
	insert_action("text","attach photo",$_GET["edit"]);
	for($x=0;$x<count($_FILES["photo_upload"]['name']);$x++)
	{
		$temp = explode(".", $_FILES["photo_upload"]["name"][$x]);
		$extension = strtolower(end($temp));
		$allowedExts = array("png", "gif", "jpg", "jpeg");
		if(!empty($_FILES["photo_upload"]["name"][$x]) && in_array($extension, $allowedExts)){	
			$maxSize = 2000000;
			$newName = "text_".time().$x;
			$uploaded = multy_upload_files($allowedExts,"photo_upload",$x,$maxSize,"../image/gallery/",$newName);
			if(!$uploaded){
				$msg = l("erroroccurred");
				$theBoxColore = "red";
			}else{
				$msg = l("done");
				$theBoxColore = "orange";
			}
			$newName = $newName.".".$extension;
			$select_gallery = mysql_query("SELECT 
			`website_gallery`.`idx` 
			FROM 
			`website_gallery_attachment`, `website_gallery` 
			WHERE 
			`website_gallery_attachment`.`connect_id`='".(int)$_GET['edit']."' AND 
			`website_gallery_attachment`.`langs`='".strip($_GET['lang'])."' AND 
			`website_gallery_attachment`.`type`='text' AND 
			`website_gallery_attachment`.`gallery_idx`=`website_gallery`.`idx` AND 
			`website_gallery`.`langs`='".strip($_GET['lang'])."' AND 
			`website_gallery`.`status`!=1 
			");
			if(!mysql_num_rows($select_gallery))
			{
				//gallery max idx
				$maxcc = mysql_query("SELECT MAX( idx ) AS mm FROM website_gallery_attachment");
				$roMaxcc = mysql_fetch_array($maxcc);
				
				$admin_id = $_SESSION['admin_id'];
				$grand_id = implode(",",grand_admins());
				if(!in_array($admin_id,grand_admins())){
					$access_admins = $grand_id.",".$admin_id;
				}else{
					$access_admins = $grand_id;
				}
				
				$select_languages = select_languages();
				foreach($select_languages["language"] as $language){
					$select = mysql_query("SELECT * FROM `website_menu` WHERE 
					`idx`='".(int)$_GET['edit']."' AND 
					`langs`='".strip($language)."' ");
					$geo = mysql_fetch_array($select);
					$insert_gallery = mysql_query("INSERT INTO `website_gallery` SET `idx`='".(int)($roMaxcc['mm']+1)."', `date`='".time()."', `name`='".strip($geo['title'])."', `langs`='".strip($language)."', `access_admins`='".strip($access_admins)."'  ");
				}
				
				$max = mysql_query("SELECT MAX( idx ) AS mm FROM website_gallery_attachment");
				$roMax = mysql_fetch_array($max);
				$select_languages = select_languages(); 
				foreach($select_languages["language"] as $language){
					$insert_g_attach = mysql_query("INSERT INTO `website_gallery_attachment` SET 
																				`idx`= '".(int)($roMax['mm']+1)."',
																				`connect_id`='".(int)$_GET['edit']."', 
																				`gallery_idx`='".(int)($roMaxcc['mm']+1)."', 
																				`langs`='".strip($language)."',  
																				`type`='text'  
																				");
				}
			}
			$photox = mysql_query("SELECT MAX(idx) AS mm FROM  `website_gallery_photos` ");
			$photo_row_idx = mysql_fetch_array($photox);
			
			$select_website_gallery_attachment = mysql_query("SELECT 
			`website_gallery`.`idx` AS gallery_idx 
			FROM 
			`website_gallery_attachment`, `website_gallery`
			WHERE 
			`website_gallery_attachment`.`connect_id`='".(int)$_GET['edit']."' AND 
			`website_gallery_attachment`.`langs`='".strip($_GET['lang'])."' AND 
			`website_gallery_attachment`.`type`='text' AND 
			`website_gallery_attachment`.`gallery_idx`=`website_gallery`.`idx` AND 
			`website_gallery`.`langs`='".strip($_GET['lang'])."' AND 
			`website_gallery`.`status`!=1
			");
			$web_gal_att = mysql_fetch_array($select_website_gallery_attachment);
			
			$select_position = mysql_query("SELECT MAX(position) AS maxPosx FROM `website_gallery_photos` WHERE `gallery_id`='".(int)$web_gal_att['gallery_idx']."' AND `langs`='".strip($_GET['lang'])."' AND status!=1 ");
			$posit = mysql_fetch_array($select_position);
			
			$select_languages = select_languages();
			foreach($select_languages["language"] as $language){
				$select = mysql_query("SELECT * FROM `website_menu` WHERE 
				`idx`='".(int)$_GET['edit']."' AND 
				`langs`='".strip($language)."' ");
				$geo = mysql_fetch_array($select);
				
				$admin_id = $_SESSION['admin_id'];
				$grand_id = implode(",",grand_admins());
				if(!in_array($admin_id,grand_admins())){
					$access_admins = $grand_id.",".$admin_id;
				}else{
					$access_admins = $grand_id;
				}
				
				$insert_photo = mysql_query("INSERT INTO `website_gallery_photos` SET `idx`='".(int)($photo_row_idx['mm']+1)."', `gallery_id`='".(int)$web_gal_att['gallery_idx']."', `date`='".time()."', `photo`='".strip($newName)."', `title`='".strip($geo['title'])."', `langs`='".strip($language)."', `access_admins`='".strip($access_admins)."', `position`='".(int)($posit['maxPosx']+1)."' ");
			}
		}
	}
}

$select_languages = select_languages();
?>
<div class="cont">
	<?php
	$count = count($select_languages["name"]);
	$x = 1;
	if($count){
		echo '<ul>';
		foreach($select_languages["name"] as $name){
			echo '<li id="tab-'.$x.'" onclick="show(this, \'content-'.$x.'\');">'.$name.'</li>';
			$x++;
		}
		echo '</ul>';
	}
	?>
	
<form action="" method="post" enctype="multipart/form-data">
	<?php 
	if($count){		
		$y = 1;
		foreach($select_languages["name"] as $name){
		$select = mysql_query("SELECT `id`,`meta_title`,`meta_desc`,`title`,`text`,`url`,`type` FROM `website_menu` WHERE `idx`='".(int)$_GET['edit']."' AND `status`!=1 AND `langs`='".mysql_real_escape_string($select_languages["language"][$y-1])."' ");
		$rows = mysql_fetch_array($select);
	?>
		<div id="content-<?=$y?>" class="content">
			<?php
			if($msg) :
			?>
				<div class="boxes">
				<div class="error_msg <?=$theBoxColore?>"><i><?=$msg?> !</i></div>
				</div>
			<?php 
			endif;
			?>
			<?php
			if(!$admin_permition){ 
				echo '<div class="boxes">';
				echo '<div class="error_msg red"><i>'.l("noRight").' !</i></div>';
				echo '</div>';
			}
			?>
			<div class="boxes">
				<label for="meta_title"><i><?=l("meta_title")?></i> <font color="#f00">*</font></label>
				<input type="text" name="post[<?=$select_languages["language"][$y-1]?>][meta_title]" class="meta_title" id="meta_title" value="<?=(isset($rows['meta_title'])) ? $rows['meta_title'] : "";?>" />
				<div class="checker_none meta_title" onclick="$('.m_meta_title').fadeIn('slow');">
						<div class="msg m_meta_title"><?=l("fillmeta_title")?> !</div>
				</div>
			</div><div class="clearer"></div>
		
			<div class="boxes">
				<label for="meta_desc"><i><?=l("meta_desc")?></i> <font color="#f00">*</font></label>
				<input type="text" name="post[<?=$select_languages["language"][$y-1]?>][meta_desc]" class="meta_desc" id="meta_desc" value="<?=(isset($rows['meta_desc'])) ? $rows['meta_desc'] : "";?>" />
				<div class="checker_none meta_desc" onclick="$('.m_meta_desc').fadeIn('slow');">
						<div class="msg m_meta_desc"><?=l("fillmeta_desc")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="gotourl"><i><?=l("gotourl")?></i> <font color="#f00">*</font></label>
				<input type="text" name="post[<?=$select_languages["language"][$y-1]?>][gotourl]" class="gotourl" id="gotourl" value="<?=(isset($rows['url'])) ? $rows['url'] : "";?>" readonly="readonly" />
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="title"><i><?=l("title")?></i> <font color="#f00">*</font></label>
				<input type="text" name="post[<?=$select_languages["language"][$y-1]?>][title]" class="title" id="title" value="<?=(isset($rows['title'])) ? $rows['title'] : "";?>" />
				<div class="checker_none title" onclick="$('.m_title').fadeIn('slow');">
						<div class="msg m_title"><?=l("filltitle")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="text_geo"><i><?=l("text")?></i></label><div class="clearer"></div>
				<textarea name="post[<?=$select_languages["language"][$y-1]?>][text]" class="text_geo" id="text_ka_<?=$rows['id']?>"><?=(isset($rows['text'])) ? stripslashes($rows['text']) : "";?></textarea>
			</div>
			<div class="clearer"></div>
			
			<div class="boxes">
				<label for="phone"><i><?=l("photo")?></i></label>
				<a href="javascript:void(0)" onclick="openPop('fileuploda.php?lang=<?=$_GET['lang']?>&weblang=<?=$select_languages["language"][$y-1]?>')"><?=l("addphoto")?></a> / 
				<a href="<?=get_gallery_idx("text",$_GET['edit'])?>"><?=l("photo")?></a>				
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="phone"><i><?=l("files")?></i></label>
				<a href="javascript:void(0)" onclick="openPop('fileAttach.php?lang=<?=$_GET['lang']?>&weblang=<?=$select_languages["language"][$y-1]?>')"><?=l("fileAttach")?></a> /
				<a href="javascript:void(0)" onclick="openPop('showAttachs.php?lang=<?=$_GET['lang']?>&weblang=<?=$select_languages["language"][$y-1]?>&page_type=text&page_idx=<?=(int)$_GET['edit']?>')"><?=l("showfiles")?></a>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<?php $_SESSION["token"]=randomPassword(16); ?>
				<a href="javascript:void(0)" onclick="openPop('contentRight.php?lang=<?=$_GET['lang']?>&idx=<?=$_GET["edit"]?>&t=website_menu&weblang=<?=$_GET["lang"]?>&token=<?=$_SESSION["token"]?>')"><?=l("contentupdateright")?></a>
			</div><div class="clearer"></div>	
			
			<div class="boxes">				
				<input type="submit" class="submit" id="submit" value="<?=l("edit")?>" />
			</div><div class="clearer"></div><br />
		</div>
	<?php 
			$select = "";
			$rows = "";
			$y++;
		}
	}
	?>
</form>	
</div>
<div class="clearer"></div><br />