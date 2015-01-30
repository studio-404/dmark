<?php
$msg = "";

if($_GET["edit"]==3) : 
/*change permition*/
if(isset($_POST["s"])){ change_permition("website_catalogs_items",false,$_GET["item"]); insert_action("catalogItem","change permition",$_GET["item"]); }
/* check if have permition */
$admin_permition = check_if_permition("website_catalogs_items",false,$_GET["item"]);
if(isset($_POST["post"]) && $admin_permition)
{
	insert_action("catalog","edit catalog item",$_GET['item']);
	// image upload
	foreach($_POST["post"] as $key => $value){ 
		if(!empty($value["namelname"]) && !empty($value["profesion"]) && !empty($value["shortbio"])){			
			$ex1 = explode("/",$value["startjob"]);
			$dd1 = $ex1[1]."/".$ex1[0]."/".$ex1[2];
			$date_1 = strtotime($dd1);

			$ex2 = explode("/",$value["dob"]);
			$dd2 = $ex2[1]."/".$ex2[0]."/".$ex2[2];
			$date_2 = strtotime($dd2);
			$update = mysql_query("UPDATE `website_catalogs_items` SET 
												`startjob`='".(int)$date_1."', 
												`namelname`='".strip($value["namelname"])."',  
												`profesion`='".strip($value["profesion"])."',  
												`dob`='".(int)$date_2."',  
												`bornplace`='".strip($value["bornplace"])."', 
												`livingplace`='".strip($value["livingplace"])."', 
												`phonenumber`='".strip($value["phonenumber"])."', 
												`email`='".strip($value["email"])."', 
												`shortbio`='".strip($value["shortbio"])."', 
												`workExperience`='".strip($value["workExperience"])."', 
												`education`='".strip($value["education"])."', 
												`treinings`='".strip($value["treinings"])."', 
												`certificate`='".strip($value["certificate"])."', 
												`languages`='".strip($value["languages"])."' 
												WHERE 
												`idx`='".(int)$_GET['item']."' AND 
												`catalog_id`='".(int)$_GET['edit']."' AND 
												`langs`='".strip($key)."' 
												");
		}else{
			$msg = l("requiredfields");
			$theBoxColore = "red";
		}		
	}
	if(!$msg){
		$msg = l("done");
		$theBoxColore = "orange";
		if(mysql_error()){
			$msg = l("erroroccurred");
			$theBoxColore = "red";
		}
	}
	
}
/*
** file upload
*/
if(isset($_FILES["file"]["name"]) && $admin_permition){
	insert_action("catalog","attach file catalog item",$_GET['item']);
	for($x=0;$x<count($_FILES["file"]['name']);$x++)
	{
		$temp = explode(".", $_FILES["file"]["name"][$x]);
		$extension = strtolower(end($temp));
		$allowedExts = array("xls", "XLS", "xlsx", "XLSX","doc","DOC","docx","DOCX","zip","ZIP","rar","RAR","pdf","PDF");
		if(!empty($_FILES["file"]["name"][$x]) && in_array($extension, $allowedExts)){	
			$maxSize = 2000000;
			$newName = "catalogs_".time().$x;
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
															`page_type`='catalog', 
															`outname`='".strip($_POST['text'][$x])."', 
															`filename`='".strip($newName)."', 
															`filetype`='".strip($extension)."', 
															`langs`='".strip($_POST['weblang'])."' 
															");
			}
		}
	}
}
/*
** photo upload
*/
if(isset($_FILES["photo_upload"]["name"]) && $admin_permition){
	insert_action("catalog","attach photo catalog item",$_GET['item']);
	for($x=0;$x<count($_FILES["photo_upload"]['name']);$x++)
	{
		$temp = explode(".", $_FILES["photo_upload"]["name"][$x]);
		$extension = strtolower(end($temp));
		$allowedExts = array("png", "gif", "jpg", "jpeg");
		if(!empty($_FILES["photo_upload"]["name"][$x]) && in_array($extension, $allowedExts)){	
			$maxSize = 2000000;
			$newName = "catalogs_".time().$x;
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
			`website_gallery_attachment`.`type`='catalog' AND 
			`website_gallery_attachment`.`gallery_idx`=`website_gallery`.`idx` AND 
			`website_gallery`.`langs`='".strip($_GET['lang'])."' AND 
			`website_gallery`.`status`!=1 
			");
			if(!mysql_num_rows($select_gallery))
			{
				//gallery max idx
				$maxcc = mysql_query("SELECT MAX( idx ) AS mm FROM website_gallery_attachment");
				if(mysql_num_rows($maxcc)){ $roMaxcc = mysql_fetch_array($maxcc); }else{ $roMaxcc["mm"]=0; }
				$select_languages = select_languages(); 
				foreach($select_languages["language"] as $language){
					$select = mysql_query("SELECT * FROM `website_catalogs_items` WHERE 
					`idx`='".(int)$_GET['item']."' AND 
					`catalog_id`='".(int)$_GET['edit']."' AND 
					`langs`='".strip($language)."' ");
					$geo = mysql_fetch_array($select);
					$admin_id = $_SESSION['admin_id'];
					$grand_id = implode(",",grand_admins());
					if(!in_array($admin_id,grand_admins())){
						$access_admins = $grand_id.",".$admin_id;
					}else{
						$access_admins = $grand_id;
					}
					$insert_gallery = mysql_query("INSERT INTO `website_gallery` SET `idx`='".(int)($roMaxcc['mm']+1)."', `date`='".time()."', `name`='".$geo['namelname']."', `langs`='".strip($language)."', `access_admins`='".strip($access_admins)."' ");
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
																				`type`='catalog' 
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
			`website_gallery_attachment`.`type`='catalog' AND 
			`website_gallery_attachment`.`gallery_idx`=`website_gallery`.`idx` AND 
			`website_gallery`.`langs`='".strip($_GET['lang'])."' AND 
			`website_gallery`.`status`!=1
			");
			$web_gal_att = mysql_fetch_array($select_website_gallery_attachment);
			
			$select_position = mysql_query("SELECT MAX(position) AS maxPosx FROM `website_gallery_photos` WHERE `gallery_id`='".(int)$web_gal_att['gallery_idx']."' AND `langs`='".mysql_real_escape_string($_GET['lang'])."' AND status!=1 ");
			$posit = mysql_fetch_array($select_position);
			
			$select_languages = select_languages();
			foreach($select_languages["language"] as $language){
				$select = mysql_query("SELECT * FROM `website_catalogs_items` WHERE 
				`idx`='".(int)$_GET['item']."' AND 
				`catalog_id`='".(int)$_GET['edit']."' AND 
				`langs`='".strip($language)."' ");
				$geo = mysql_fetch_array($select);
				$admin_id = $_SESSION['admin_id'];
				$grand_id = implode(",",grand_admins());
				if(!in_array($admin_id,grand_admins())){
					$access_admins = $grand_id.",".$admin_id;
				}else{
					$access_admins = $grand_id;
				}
				$insert_photo = mysql_query("INSERT INTO `website_gallery_photos` SET `idx`='".(int)($photo_row_idx['mm']+1)."', `gallery_id`='".(int)$web_gal_att['gallery_idx']."', `date`='".time()."', `photo`='".mysql_real_escape_string($newName)."', `title`='".mysql_real_escape_string($geo['namelname'])."', `langs`='".strip($language)."', `position`='".(int)($posit['maxPosx']+1)."', `access_admins`='".strip($access_admins)."' ");
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
		$select = mysql_query("
		SELECT 
		`website_catalogs_items`.*, 
		`website_catalogs_attachment`.`connect_id` AS cid 
		FROM 
		`website_catalogs_items`, `website_catalogs_attachment` 
		WHERE 
		`website_catalogs_attachment`.`catalog_id`='".(int)$_GET['edit']."' AND 
		`website_catalogs_attachment`.`langs`='".strip($select_languages["language"][$y-1])."' AND 
		`website_catalogs_attachment`.`catalog_id`=`website_catalogs_items`.`catalog_id` AND 
		`website_catalogs_items`.`langs`='".strip($select_languages["language"][$y-1])."' AND 
		`website_catalogs_items`.`idx`='".(int)$_GET['item']."' AND 
		`website_catalogs_items`.`status`!=1 
		");
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
				<label for="startjob"><i><?=l("startjob")?></i></label>
				<input type="text" name="post[<?=$select_languages["language"][$y-1]?>][startjob]" class="datepicker" id="startjob_<?=$rows["id"]?>" value="<?=(isset($rows['startjob'])) ? date("d/m/Y",$rows['startjob']) : date("d/m/Y");?>" />
				<div class="checker_none datex" onclick="$('.m_startjob').fadeIn('slow');">
						<div class="msg m_startjob"><?=l("fillstartjob")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="namelname"><i><?=l("namelname")?></i> <font color="#f00">*</font></label>
				<input type="text" name="post[<?=$select_languages["language"][$y-1]?>][namelname]" class="namelname" value="<?=(isset($rows['namelname'])) ? $rows['namelname'] : "";?>" />
				<div class="checker_none namelname" onclick="$('.m_title').fadeIn('slow');">
						<div class="msg m_title"><?=l("fillnamelname")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="profesion"><i><?=l("profesion")?></i> <font color="#f00">*</font></label>
				<input type="text" name="post[<?=$select_languages["language"][$y-1]?>][profesion]" class="profesion" value="<?=(isset($rows['profesion'])) ? $rows['profesion'] : "";?>" />
				<div class="checker_none profesion" onclick="$('.m_profesion').fadeIn('slow');">
						<div class="msg m_profesion"><?=l("fillprofesion")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="dob"><i><?=l("dob")?></i></label>
				<input type="text" name="post[<?=$select_languages["language"][$y-1]?>][dob]" class="datepicker" id="dob_<?=$rows["id"]?>" value="<?=(isset($rows['dob'])) ? date("d/m/Y",$rows['dob']) : date("d/m/Y");?>" />
				<div class="checker_none datex" onclick="$('.m_dob').fadeIn('slow');">
						<div class="msg m_dob"><?=l("filldob")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="bornplace"><i><?=l("bornplace")?></i></label>
				<input type="text" name="post[<?=$select_languages["language"][$y-1]?>][bornplace]" class="bornplace" value="<?=(isset($rows['bornplace'])) ? $rows['bornplace'] : "";?>" />
				<div class="checker_none bornplace" onclick="$('.m_bornplace').fadeIn('slow');">
						<div class="msg m_bornplace"><?=l("fillbornplace")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="livingplace"><i><?=l("livingplace")?></i> </label>
				<input type="text" name="post[<?=$select_languages["language"][$y-1]?>][livingplace]" class="livingplace" value="<?=(isset($rows['livingplace'])) ? $rows['livingplace'] : "";?>" />
				<div class="checker_none livingplace" onclick="$('.m_livingplace').fadeIn('slow');">
						<div class="msg m_livingplace"><?=l("filllivingplace")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="phonenumber"><i><?=l("phonenumber")?></i></label>
				<input type="text" name="post[<?=$select_languages["language"][$y-1]?>][phonenumber]" class="phonenumber" value="<?=(isset($rows['phonenumber'])) ? $rows['phonenumber'] : "";?>" />
				<div class="checker_none phonenumber" onclick="$('.m_phonenumber').fadeIn('slow');">
						<div class="msg m_phonenumber"><?=l("fillphonenumber")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="email"><i><?=l("email")?></i></label>
				<input type="text" name="post[<?=$select_languages["language"][$y-1]?>][email]" class="email" value="<?=(isset($rows['email'])) ? $rows['email'] : "";?>" />
				<div class="checker_none email" onclick="$('.m_email').fadeIn('slow');">
						<div class="msg m_email"><?=l("fillemail")?> !</div>
				</div>
			</div><div class="clearer"></div>	
			
			<div class="boxes">
				<label for="shortbio"><i><?=l("shortbio")?></i><font color="#f00">*</font><div class="clearer"></div>
				<textarea name="post[<?=$select_languages["language"][$y-1]?>][shortbio]" class="shortbio" id="shortbio_<?=$rows["id"]?>"><?=(isset($rows['shortbio'])) ? stripslashes($rows['shortbio']) : "";?></textarea>
			</div>
			<div class="clearer"></div>
			
			<div class="boxes">
				<label for="workExperience"><i><?=l("workExperience")?></i><div class="clearer"></div>
				<textarea name="post[<?=$select_languages["language"][$y-1]?>][workExperience]" class="workExperience" id="workExperience_<?=$rows["id"]?>"><?=(isset($rows['workExperience'])) ? stripslashes($rows['workExperience']) : "";?></textarea>
			</div>
			<div class="clearer"></div>
			
			<div class="boxes">
				<label for="education"><i><?=l("education")?></i></label><div class="clearer"></div>
				<textarea name="post[<?=$select_languages["language"][$y-1]?>][education]" class="education" id="education_<?=$rows["id"]?>"><?=(isset($rows['education'])) ? stripslashes($rows['education']) : "";?></textarea>
			</div>
			<div class="clearer"></div>
			
			<div class="boxes">
				<label for="treinings"><i><?=l("treinings")?></i></label><div class="clearer"></div>
				<textarea name="post[<?=$select_languages["language"][$y-1]?>][treinings]" class="treinings" id="treinings_<?=$rows["id"]?>"><?=(isset($rows['treinings'])) ? $rows['treinings'] : "";?></textarea>
			</div>
			<div class="clearer"></div>
			
			<div class="boxes">
				<label for="certificate"><i><?=l("certificate")?></i></label><div class="clearer"></div>
				<textarea name="post[<?=$select_languages["language"][$y-1]?>][certificate]" class="certificate" id="certificate_<?=$rows["id"]?>"><?=(isset($rows['certificate'])) ? $rows['certificate'] : "";?></textarea>
			</div>
			<div class="clearer"></div>
			
			<div class="boxes">
				<label for="languages"><i><?=l("languages")?></i></label><div class="clearer"></div>
				<textarea name="post[<?=$select_languages["language"][$y-1]?>][languages]" class="languages" id="languages_<?=$rows["id"]?>"><?=(isset($rows['languages'])) ? stripslashes($rows['languages']) : "";?></textarea>
			</div>
			<div class="clearer"></div>
			
			<div class="boxes">
				<label for="phone"><i><?=l("photo")?></i></label>
				<a href="javascript:void(0)" onclick="openPop('fileuploda.php?lang=<?=$_GET['lang']?>&weblang=<?=$select_languages["language"][$y-1]?>')"><?=l("addphoto")?></a> / 
				<a href="<?=get_gallery_idx("catalog",$_GET['item'])?>"><?=l("photo")?></a>				
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label><i><?=l("files")?></i></label>
				<a href="javascript:void(0)" onclick="openPop('fileAttach.php?lang=<?=$_GET['lang']?>&weblang=<?=$select_languages["language"][$y-1]?>')"><?=l("fileAttach")?></a> /
				<a href="javascript:void(0)" onclick="openPop('showAttachs.php?lang=<?=$_GET['lang']?>&weblang=<?=$select_languages["language"][$y-1]?>&page_type=catalog&page_idx=<?=(int)$rows['idx']?>')"><?=l("showfiles")?></a>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<?php $_SESSION["token"]=randomPassword(16); ?>
				<a href="javascript:void(0)" onclick="openPop('contentRight.php?lang=<?=$_GET['lang']?>&idx=<?=$_GET["item"]?>&t=website_catalogs_items&weblang=<?=$_GET["lang"]?>&token=<?=$_SESSION["token"]?>')"><?=l("contentupdateright")?></a>
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
<?php
endif;
//////////////////////////////////////////////////////////////////////////////////////////////
if($_GET["edit"]==1) : 
/*change permition*/
if(isset($_POST["s"])){ change_permition("website_catalogs_items",false,$_GET["item"]); insert_action("catalogItem","change permition",$_GET["item"]); }
/* check if have permition */
$admin_permition = check_if_permition("website_catalogs_items",false,$_GET["item"]);
if(isset($_POST["post"]) && $admin_permition)
{
	insert_action("catalog","edit catalog item",$_GET['item']);
	// image upload
	foreach($_POST["post"] as $key => $value){ 
		if(!empty($value["p_title"]) && !empty($value["p_date"])){			
			$ex1 = explode("/",$value["p_date"]);
			$dd1 = $ex1[1]."/".$ex1[0]."/".$ex1[2];
			$date_1 = strtotime($dd1);

			$update = mysql_query("UPDATE `website_catalogs_items` SET 
												`p_date`='".(int)$date_1."', 
												`p_title`='".strip($value["p_title"])."',  
												`p_type`='".strip($value["p_type"])."',  
												`p_client`='".strip($value["p_client"])."',  
												`p_location`='".strip($value["p_location"])."', 
												`p_buildingsize`='".strip($value["p_buildingsize"])."', 
												`p_budget`='".strip($value["p_budget"])."', 
												`p_programe`='".strip($value["p_programe"])."', 
												`p_status`='".strip($value["p_status"])."', 
												`p_credit`='".strip($value["p_credits"])."', 
												`p_competitionphrase`='".strip($value["p_competitionphrase"])."', 
												`p_advisors`='".strip($value["p_adviser"])."' 
												WHERE 
												`idx`='".(int)$_GET['item']."' AND 
												`catalog_id`='".(int)$_GET['edit']."' AND 
												`langs`='".strip($key)."' 
												");
		}else{
			$msg = l("requiredfields");
			$theBoxColore = "red";
		}		
	}
	if(!$msg){
		$msg = l("done");
		$theBoxColore = "orange";
		if(mysql_error()){
			$msg = l("erroroccurred");
			$theBoxColore = "red";
		}
	}
	
}
/*
** file upload
*/
if(isset($_FILES["file"]["name"]) && $admin_permition){
	insert_action("catalog","attach file catalog item",$_GET['item']);
	for($x=0;$x<count($_FILES["file"]['name']);$x++)
	{
		$temp = explode(".", $_FILES["file"]["name"][$x]);
		$extension = strtolower(end($temp));
		$allowedExts = array("xls", "XLS", "xlsx", "XLSX","doc","DOC","docx","DOCX","zip","ZIP","rar","RAR","pdf","PDF");
		if(!empty($_FILES["file"]["name"][$x]) && in_array($extension, $allowedExts)){	
			$maxSize = 2000000;
			$newName = "catalogs_".time().$x;
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
															`page_type`='catalog', 
															`outname`='".strip($_POST['text'][$x])."', 
															`filename`='".strip($newName)."', 
															`filetype`='".strip($extension)."', 
															`langs`='".strip($_POST['weblang'])."' 
															");
			}
		}
	}
}
/*
** photo upload
*/
if(isset($_FILES["photo_upload"]["name"]) && $admin_permition){
	insert_action("catalog","attach photo catalog item",$_GET['item']);
	for($x=0;$x<count($_FILES["photo_upload"]['name']);$x++)
	{
		$temp = explode(".", $_FILES["photo_upload"]["name"][$x]);
		$extension = strtolower(end($temp));
		$allowedExts = array("png", "gif", "jpg", "jpeg");
		if(!empty($_FILES["photo_upload"]["name"][$x]) && in_array($extension, $allowedExts)){	
			$maxSize = 2000000;
			$newName = "catalogs_".time().$x;
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
			`website_gallery_attachment`.`type`='catalog' AND 
			`website_gallery_attachment`.`gallery_idx`=`website_gallery`.`idx` AND 
			`website_gallery`.`langs`='".strip($_GET['lang'])."' AND 
			`website_gallery`.`status`!=1 
			");
			if(!mysql_num_rows($select_gallery))
			{
				//gallery max idx
				$maxcc = mysql_query("SELECT MAX( idx ) AS mm FROM website_gallery_attachment");
				if(mysql_num_rows($maxcc)){ $roMaxcc = mysql_fetch_array($maxcc); }else{ $roMaxcc["mm"]=0; }
				$select_languages = select_languages(); 
				foreach($select_languages["language"] as $language){
					$select = mysql_query("SELECT * FROM `website_catalogs_items` WHERE 
					`idx`='".(int)$_GET['item']."' AND 
					`catalog_id`='".(int)$_GET['edit']."' AND 
					`langs`='".strip($language)."' ");
					$geo = mysql_fetch_array($select);
					$admin_id = $_SESSION['admin_id'];
					$grand_id = implode(",",grand_admins());
					if(!in_array($admin_id,grand_admins())){
						$access_admins = $grand_id.",".$admin_id;
					}else{
						$access_admins = $grand_id;
					}
					$insert_gallery = mysql_query("INSERT INTO `website_gallery` SET `idx`='".(int)($roMaxcc['mm']+1)."', `date`='".time()."', `name`='".$geo['namelname']."', `langs`='".strip($language)."', `access_admins`='".strip($access_admins)."' ");
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
																				`type`='catalog' 
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
			`website_gallery_attachment`.`type`='catalog' AND 
			`website_gallery_attachment`.`gallery_idx`=`website_gallery`.`idx` AND 
			`website_gallery`.`langs`='".strip($_GET['lang'])."' AND 
			`website_gallery`.`status`!=1
			");
			$web_gal_att = mysql_fetch_array($select_website_gallery_attachment);
			
			$select_position = mysql_query("SELECT MAX(position) AS maxPosx FROM `website_gallery_photos` WHERE `gallery_id`='".(int)$web_gal_att['gallery_idx']."' AND `langs`='".mysql_real_escape_string($_GET['lang'])."' AND status!=1 ");
			$posit = mysql_fetch_array($select_position);
			
			$select_languages = select_languages();
			foreach($select_languages["language"] as $language){
				$select = mysql_query("SELECT * FROM `website_catalogs_items` WHERE 
				`idx`='".(int)$_GET['item']."' AND 
				`catalog_id`='".(int)$_GET['edit']."' AND 
				`langs`='".strip($language)."' ");
				$geo = mysql_fetch_array($select);
				$admin_id = $_SESSION['admin_id'];
				$grand_id = implode(",",grand_admins());
				if(!in_array($admin_id,grand_admins())){
					$access_admins = $grand_id.",".$admin_id;
				}else{
					$access_admins = $grand_id;
				}
				$insert_photo = mysql_query("INSERT INTO `website_gallery_photos` SET `idx`='".(int)($photo_row_idx['mm']+1)."', `gallery_id`='".(int)$web_gal_att['gallery_idx']."', `date`='".time()."', `photo`='".mysql_real_escape_string($newName)."', `title`='".mysql_real_escape_string($geo['namelname'])."', `langs`='".strip($language)."', `position`='".(int)($posit['maxPosx']+1)."', `access_admins`='".strip($access_admins)."' ");
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
		$select = mysql_query("
		SELECT 
		`website_catalogs_items`.*, 
		`website_catalogs_attachment`.`connect_id` AS cid 
		FROM 
		`website_catalogs_items`, `website_catalogs_attachment` 
		WHERE 
		`website_catalogs_attachment`.`catalog_id`='".(int)$_GET['edit']."' AND 
		`website_catalogs_attachment`.`langs`='".strip($select_languages["language"][$y-1])."' AND 
		`website_catalogs_attachment`.`catalog_id`=`website_catalogs_items`.`catalog_id` AND 
		`website_catalogs_items`.`langs`='".strip($select_languages["language"][$y-1])."' AND 
		`website_catalogs_items`.`idx`='".(int)$_GET['item']."' AND 
		`website_catalogs_items`.`status`!=1 
		");
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
				<label for="p_date"><i><?=l("date")?></i></label>
				<input type="text" name="post[<?=$select_languages["language"][$y-1]?>][p_date]" class="datepicker" id="date_<?=$rows["id"]?>" value="<?=(isset($rows['p_date'])) ? date("d/m/Y",$rows['p_date']) : date("d/m/Y");?>" />
				<div class="checker_none datex" onclick="$('.m_date').fadeIn('slow');">
						<div class="msg m_date"><?=l("filldate")?> !</div>
				</div>
			</div><div class="clearer"></div>

			<div class="boxes">
				<label for="title"><i><?=l("title")?></i> <font color="#f00">*</font></label>
				<input type="text" name="post[<?=$select_languages["language"][$y-1]?>][p_title]" class="title" id="title" value="<?=(isset($rows['p_title'])) ? $rows['p_title'] : "";?>" />
				<div class="checker_none namelname" onclick="$('.mtitle').fadeIn('slow');">
						<div class="msg mtitle"><?=l("filltitle")?> !</div>
				</div>
			</div><div class="clearer"></div>


			<div class="boxes">
				<label for="type"><i><?=l("type")?></i> <font color="#f00">*</font></label>
				<select name="post[<?=$select_languages["language"][$y-1]?>][p_type]">
					<option value="public" <?=(isset($rows['p_type']) && $rows['p_type']=="public") ? 'selected="selected"' : '';?>><?=l("public")?></option>
					<option value="commercial" <?=(isset($rows['p_type']) && $rows['p_type']=="commercial") ? 'selected="selected"' : '';?>><?=l("commercial")?></option>
					<option value="housing" <?=(isset($rows['p_type']) && $rows['p_type']=="housing") ? 'selected="selected"' : '';?>><?=l("housing")?></option>
					<option value="competition" <?=(isset($rows['p_type']) && $rows['p_type']=="competition") ? 'selected="selected"' : '';?>><?=l("competition")?></option>
					<option value="interior" <?=(isset($rows['p_type']) && $rows['p_type']=="interior") ? 'selected="selected"' : '';?>><?=l("interior")?></option>
					<option value="realized" <?=(isset($rows['p_type']) && $rows['p_type']=="realized") ? 'selected="selected"' : '';?>><?=l("realized")?></option>
				</select>
				<div class="checker_none typex" onclick="$('.mtype').fadeIn('slow');">
						<div class="msg mtype"><?=l("filltype")?> !</div>
				</div>
			</div><div class="clearer"></div>

			
			<div class="boxes">
				<label for="client"><i><?=l("client")?></i> <font color="#f00">*</font></label>
				<input type="text" name="post[<?=$select_languages["language"][$y-1]?>][p_client]" class="client" id="client" value="<?=(isset($rows['p_client'])) ? $rows['p_client'] : "";?>" />
				<div class="checker_none client" onclick="$('.mclient').fadeIn('slow');">
						<div class="msg mclient"><?=l("fillclient")?> !</div>
				</div>
			</div><div class="clearer"></div>

			<div class="boxes">
				<label for="location"><i><?=l("location")?></i> <font color="#f00">*</font></label>
				<input type="text" name="post[<?=$select_languages["language"][$y-1]?>][p_location]" class="location" id="location" value="<?=(isset($rows['p_location'])) ? $rows['p_location'] : "";?>" />
				<div class="checker_none location" onclick="$('.mlocation').fadeIn('slow');">
						<div class="msg mlocation"><?=l("filllocation")?> !</div>
				</div>
			</div><div class="clearer"></div>

			<div class="boxes">
				<label for="buildingsize"><i><?=l("buildingsize")?></i> <font color="#f00">*</font></label>
				<input type="text" name="post[<?=$select_languages["language"][$y-1]?>][p_buildingsize]" class="buildingsize" id="buildingsize" value="<?=(isset($rows['p_buildingsize'])) ? $rows['p_buildingsize'] : "";?>" />
				<div class="checker_none buildingsize" onclick="$('.mbuildingsize').fadeIn('slow');">
						<div class="msg mbuildingsize"><?=l("fillbuildingsize")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="budget"><i><?=l("budget")?></i> <font color="#f00">*</font></label>
				<input type="text" name="post[<?=$select_languages["language"][$y-1]?>][p_budget]" class="budget" id="budget" value="<?=(isset($rows['p_budget'])) ? $rows['p_budget'] : "";?>" />
				<div class="checker_none budget" onclick="$('.mbudget').fadeIn('slow');">
						<div class="msg mbudget"><?=l("fillbudget")?> !</div>
				</div>
			</div><div class="clearer"></div>

			<div class="boxes">
				<label for="programe"><i><?=l("programe")?></i> <font color="#f00">*</font></label>
				<input type="text" name="post[<?=$select_languages["language"][$y-1]?>][p_programe]" class="programe" id="programe" value="<?=(isset($rows['p_programe'])) ? $rows['p_programe'] : "";?>" />
				<div class="checker_none programe" onclick="$('.mprograme').fadeIn('slow');">
						<div class="msg mprograme"><?=l("fillprograme")?> !</div>
				</div>
			</div><div class="clearer"></div>

			<div class="boxes">
				<label for="status"><i><?=l("status")?></i> <font color="#f00">*</font></label>
				<input type="text" name="post[<?=$select_languages["language"][$y-1]?>][p_status]" class="status" id="status" value="<?=(isset($rows['p_status'])) ? $rows['p_status'] : "";?>" />
				<div class="checker_none status" onclick="$('.mstatus').fadeIn('slow');">
						<div class="msg mstatus"><?=l("fillstatus")?> !</div>
				</div>
			</div><div class="clearer"></div>

			<div class="boxes">
				<label for="credits"><i><?=l("credits")?></i> <font color="#f00">*</font></label>
				<input type="text" name="post[<?=$select_languages["language"][$y-1]?>][p_credits]" class="credits" id="credits" value="<?=(isset($rows['p_credit'])) ? $rows['p_credit'] : "";?>" />
				<div class="checker_none credits" onclick="$('.mcredits').fadeIn('slow');">
						<div class="msg mcredits"><?=l("fillcredits")?> !</div>
				</div>
			</div><div class="clearer"></div>

			<div class="boxes">
				<label for="competitionphrase"><i><?=l("competitionphrase")?></i> <font color="#f00">*</font></label><div class="clearer"></div>
				<textarea name="post[<?=$select_languages["language"][$y-1]?>][p_competitionphrase]" class="competitionphrase" id="competitionphrase"><?=(isset($rows['p_competitionphrase'])) ? $rows['p_competitionphrase'] : "";?></textarea>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="adviser"><i><?=l("adviser")?></i> <font color="#f00">*</font></label>
				<input type="text" name="post[<?=$select_languages["language"][$y-1]?>][p_adviser]" class="adviser" id="adviser" value="<?=(isset($rows['p_advisors'])) ? $rows['p_advisors'] : "";?>" />
				<div class="checker_none adviser" onclick="$('.madviser').fadeIn('slow');">
						<div class="msg madviser"><?=l("filladviser")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="phone"><i><?=l("photo")?></i></label>
				<a href="javascript:void(0)" onclick="openPop('fileuploda.php?lang=<?=$_GET['lang']?>&weblang=<?=$select_languages["language"][$y-1]?>')"><?=l("addphoto")?></a> / 
				<a href="<?=get_gallery_idx("catalog",$_GET['item'])?>"><?=l("photo")?></a>				
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label><i><?=l("files")?></i></label>
				<a href="javascript:void(0)" onclick="openPop('fileAttach.php?lang=<?=$_GET['lang']?>&weblang=<?=$select_languages["language"][$y-1]?>')"><?=l("fileAttach")?></a> /
				<a href="javascript:void(0)" onclick="openPop('showAttachs.php?lang=<?=$_GET['lang']?>&weblang=<?=$select_languages["language"][$y-1]?>&page_type=catalog&page_idx=<?=(int)$rows['idx']?>')"><?=l("showfiles")?></a>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<?php $_SESSION["token"]=randomPassword(16); ?>
				<a href="javascript:void(0)" onclick="openPop('contentRight.php?lang=<?=$_GET['lang']?>&idx=<?=$_GET["item"]?>&t=website_catalogs_items&weblang=<?=$_GET["lang"]?>&token=<?=$_SESSION["token"]?>')"><?=l("contentupdateright")?></a>
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


<?php 
endif;
?>