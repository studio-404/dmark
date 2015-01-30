<?php
$msg = "";
/*change permition*/
if(isset($_POST["s"])){ change_permition("website_news_items",false,$_GET["item"]); insert_action("newsItem","change permition",$_GET["item"]); }
/* check if have permition */
$admin_permition = check_if_permition("website_news_items",false,$_GET["item"]);
if(isset($_POST["post"]) && $admin_permition)
{
	// image upload
	foreach($_POST["post"] as $key => $value){ 
		if(!empty($value["date"]) && !empty($value["title"]) && !empty($value["short_text"]) && !empty($value["long_text"])){
			insert_action("news","edit news item",$_GET['item']);
			$ex = explode("/",$value["date"]);
			$dd = $ex[0]."-".$ex[1]."-".$ex[2];
			$date_ = strtotime($dd);	
			$update = mysql_query("UPDATE `website_news_items` SET 
															`date`='".(int)$date_."',  
															`title`='".strip($value["title"])."',  
															`short_text`='".strip($value["short_text"])."',  
															`long_text`='".strip($value["long_text"])."', 
															`httplink`='".strip($value["httplink"])."' 
															WHERE 
															`idx`='".(int)$_GET['item']."' AND 
															`news_idx`='".(int)$_GET['edit']."' AND 
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
	insert_action("news","attach file news item",$_GET['item']);
	for($x=0;$x<count($_FILES["file"]['name']);$x++)
	{
		$temp = explode(".", $_FILES["file"]["name"][$x]);
		$extension = strtolower(end($temp));
		$allowedExts = array("xls", "XLS", "xlsx", "XLSX","doc","DOC","docx","DOCX","zip","ZIP","rar","RAR","pdf","PDF");
		if(!empty($_FILES["file"]["name"][$x]) && in_array($extension, $allowedExts)){	
			$maxSize = 2000000;
			$newName = "news_".time().$x;
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
															`page_idx`='".(int)$_GET['item']."', 
															`page_type`='news', 
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
	insert_action("news","attach photo news item",$_GET['item']);
	for($x=0;$x<count($_FILES["photo_upload"]['name']);$x++)
	{
		$temp = explode(".", $_FILES["photo_upload"]["name"][$x]);
		$extension = strtolower(end($temp));
		$allowedExts = array("png", "gif", "jpg", "jpeg");
		if(!empty($_FILES["photo_upload"]["name"][$x]) && in_array($extension, $allowedExts)){	
			$maxSize = 2000000;
			$newName = "news_".time().$x;
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
			`website_gallery_attachment`.`connect_id`='".(int)$_GET['item']."' AND 
			`website_gallery_attachment`.`langs`='".strip($_GET['lang'])."' AND 
			`website_gallery_attachment`.`type`='news' AND 
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
					$select = mysql_query("SELECT * FROM `website_news_items` WHERE 
					`idx`='".(int)$_GET['item']."' AND 
					`news_idx`='".(int)$_GET['edit']."' AND 
					`langs`='".strip($language)."' ");
					$geo = mysql_fetch_array($select);
					$insert_gallery = mysql_query("INSERT INTO `website_gallery` SET `idx`='".(int)($roMaxcc['mm']+1)."', `date`='".time()."', `name`='".strip($geo['title'])."', `langs`='".strip($language)."', `access_admins`='".strip($access_admins)."' ");
				}
				
				$max = mysql_query("SELECT MAX( idx ) AS mm FROM website_gallery_attachment");
				$roMax = mysql_fetch_array($max);
				$select_languages = select_languages(); 
				foreach($select_languages["language"] as $language){
					$insert_g_attach = mysql_query("INSERT INTO `website_gallery_attachment` SET 
																				`idx`= '".(int)($roMax['mm']+1)."',
																				`connect_id`='".(int)$_GET['item']."', 
																				`gallery_idx`='".(int)($roMaxcc['mm']+1)."', 
																				`langs`='".strip($language)."',  
																				`type`='news' 
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
			`website_gallery_attachment`.`connect_id`='".(int)$_GET['item']."' AND 
			`website_gallery_attachment`.`langs`='".strip($_GET['lang'])."' AND 
			`website_gallery_attachment`.`type`='news' AND 
			`website_gallery_attachment`.`gallery_idx`=`website_gallery`.`idx` AND 
			`website_gallery`.`langs`='".strip($_GET['lang'])."' AND 
			`website_gallery`.`status`!=1
			");
			$web_gal_att = mysql_fetch_array($select_website_gallery_attachment);
			
			$select_position = mysql_query("SELECT MAX(position) AS maxPosx FROM `website_gallery_photos` WHERE `gallery_id`='".(int)$web_gal_att['gallery_idx']."' AND `langs`='".mysql_real_escape_string($_GET['lang'])."' AND status!=1 ");
			$posit = mysql_fetch_array($select_position);
			
			$select_languages = select_languages();
			foreach($select_languages["language"] as $language){
				$select = mysql_query("SELECT * FROM `website_news_items` WHERE 
				`idx`='".(int)$_GET['item']."' AND 
				`news_idx`='".(int)$_GET['edit']."' AND 
				`langs`='".strip($language)."' ");
				$geo = mysql_fetch_array($select);
				
				$admin_id = $_SESSION['admin_id'];
				$grand_id = implode(",",grand_admins());
				if(!in_array($admin_id,grand_admins())){
					$access_admins = $grand_id.",".$admin_id;
				}else{
					$access_admins = $grand_id;
				}
				
				$insert_photo = mysql_query("INSERT INTO `website_gallery_photos` SET `idx`='".(int)($photo_row_idx['mm']+1)."', `gallery_id`='".(int)$web_gal_att['gallery_idx']."', `date`='".time()."', `photo`='".mysql_real_escape_string($newName)."', `title`='".mysql_real_escape_string($geo['title'])."', `access_admins`='".$access_admins."', `langs`='".strip($language)."', `position`='".(int)($posit['maxPosx']+1)."' ");
			}
		}
	}
}

if(isset($_POST["moveToSlide"]) && $admin_permition)
{
	$insert_ = insert_slide_from_news($_POST["moveToSlide"],$_GET["edit"]);
	if(!$insert_){
		$msg = l("erroroccurred");
		$theBoxColore = "red";
	}else{
		$msg = l("done");
		$theBoxColore = "orange";
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
		$select = mysql_query("SELECT * FROM `website_news_items` WHERE 
		`idx`='".(int)$_GET['item']."' AND 
		`news_idx`='".(int)$_GET['edit']."' AND 
		`langs`='".mysql_real_escape_string($select_languages["language"][$y-1])."' ");
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
				<label for="date"><i><?=l("date")?></i> <font color="#f00">*</font></label>
				<input type="text" name="post[<?=$select_languages["language"][$y-1]?>][date]" class="datepicker" id="date<?=$rows["id"]?>" value="<?=(isset($rows['date'])) ? date("d/m/Y",$rows['date']) : date("d/m/Y");?>" />
				<div class="checker_none datex" onclick="$('.m_date').fadeIn('slow');">
						<div class="msg m_date"><?=l("filldate")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="title"><i><?=l("title")?></i> <font color="#f00">*</font></label>
				<input type="text" name="post[<?=$select_languages["language"][$y-1]?>][title]" class="title" id="title" value="<?=(isset($rows['title'])) ? stripslashes($rows['title']) : "";?>" />
				<div class="checker_none title" onclick="$('.m_title').fadeIn('slow');">
						<div class="msg m_title"><?=l("filltitle")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="short_text"><i><?=l("short_text")?></i> <font color="#f00">*</font></label><div class="clearer"></div>
				<textarea name="post[<?=$select_languages["language"][$y-1]?>][short_text]" class="short_text" id="short_text_<?=$rows["id"]?>"><?=(isset($rows['short_text'])) ? stripslashes($rows['short_text']) : "";?></textarea>
			</div>
			<div class="clearer"></div>
			
			<div class="boxes">
				<label for="text"><i><?=l("text")?></i> <font color="#f00">*</font></label><div class="clearer"></div>
				<textarea name="post[<?=$select_languages["language"][$y-1]?>][long_text]" class="text" id="text_<?=$rows["id"]?>"><?=(isset($rows['long_text'])) ? stripslashes($rows['long_text']) : "";?></textarea>
			</div>
			<div class="clearer"></div>

			<div class="boxes">
				<label for="httplink"><i><?=l("url")?></i> <font color="#f00">*</font></label>
				<input type="text" name="post[<?=$select_languages["language"][$y-1]?>][httplink]" class="httplink" id="httplink" value="<?=(isset($rows['httplink'])) ? stripslashes($rows['httplink']) : "";?>" />
				<div class="checker_none httplink" onclick="$('.m_httplink').fadeIn('slow');">
						<div class="msg m_httplink"><?=l("fillurl")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="phone"><i><?=l("photo")?></i></label>
				<a href="javascript:void(0)" onclick="openPop('fileuploda.php?lang=<?=$_GET['lang']?>&weblang=<?=$select_languages["language"][$y-1]?>')"><?=l("addphoto")?></a> / 
				<a href="<?=get_gallery_idx("news",$_GET['item'])?>"><?=l("photo")?></a>				
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label><i><?=l("files")?></i></label>
				<a href="javascript:void(0)" onclick="openPop('fileAttach.php?lang=<?=$_GET['lang']?>&weblang=<?=$select_languages["language"][$y-1]?>')"><?=l("fileAttach")?></a> /
				<a href="javascript:void(0)" onclick="openPop('showAttachs.php?lang=<?=$_GET['lang']?>&weblang=<?=$select_languages["language"][$y-1]?>&page_type=news&page_idx=<?=(int)$_GET['item']?>')"><?=l("showfiles")?></a>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<a href="javascript:void(0)" onclick="openPop('moveToSlide.php?lang=<?=$_GET['lang']?>&weblang=<?=$select_languages["language"][$y-1]?>&idx=<?=$_GET["item"]?>')"><?=l("moveToSlide")?></a>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<?php $_SESSION["token"]=randomPassword(16); ?>
				<a href="javascript:void(0)" onclick="openPop('contentRight.php?lang=<?=$_GET['lang']?>&idx=<?=$_GET["item"]?>&t=website_news_items&weblang=<?=$_GET["lang"]?>&token=<?=$_SESSION["token"]?>')"><?=l("contentupdateright")?></a>
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