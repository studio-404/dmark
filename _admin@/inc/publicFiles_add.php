<?php
$msg="";
if(isset($_POST['name'],$_POST['date']))
{	
	if(!empty($_POST['name']) && !empty($_POST['date']))
	{	
			insert_action("public","add public item","0");
			$ex = explode("/",$_POST['date']);
			$dd = $ex[1]."/".$ex[0]."/".$ex[2];
			$date = strtotime($dd); 			
			$name = $_POST["name"]; 

			$select = mysql_query("SELECT MAX(idx) AS maxi FROM `website_public_files` WHERE `status`!=1 ");
			$getMax = mysql_fetch_array($select);
			$Max = $getMax['maxi']+1;
			
			if(!$msg){
				$admin_id = $_SESSION['admin_id'];
				$grand_id = implode(",",grand_admins());
				if(!in_array($admin_id,grand_admins())){
					$access_admins = $grand_id.",".$admin_id;
				}else{
					$access_admins = $grand_id;
				}
				
				if(isset($_FILES["files"]["name"]) && !empty($_FILES["files"]["name"])){
						$temp = explode(".", $_FILES["files"]["name"]);
						$allowedExts = array("pdf","doc","docx","zip","rar","xls","xlsx","png","jpg","jpeg","gif");
						$maxSize = 2000000;
						$newName = "publicFiles_".MAIN_LANGUAGE."_".time();
						$uploaded = upload_file($allowedExts,"files",$maxSize,"../image/public_files/",$newName);
						$extension = strtolower(end($temp));
						if(!$uploaded){
							$msg = l("erroroccurred");
							$theBoxColore = "red";
						}
						$newName = $newName.".".$extension;
					}
				
				$select_languages = select_languages(); 
				foreach($select_languages["language"] as $language){ 
					$insert = mysql_query("INSERT INTO `website_public_files` SET
														`idx`='".(int)$Max."', 
														`public_id`='".(int)$_GET["addid"]."', 
														`date`='".(int)$date."', 
														`archive`=1, 
														`name`='".strip($name)."', 
														`langs`='".strip($language)."', 
														`access_admins`='".strip($access_admins)."' 
														");
				}
				$update = mysql_query("UPDATE `website_public_files` SET `file_name`='".mysql_real_escape_string($newName)."' WHERE `idx`='".(int)$Max."' AND `langs`='".mysql_real_escape_string(MAIN_LANGUAGE)."' ");
			} 
			
			if(!$insert || !$update)
			{
				$msg = l("erroroccurred");
				$theBoxColore = "red";
			}
			else
			{
				_refresh_404("/".ADMIN_FOLDER."/".$_GET["lang"]."/edit/publicFiles/".$_GET["addid"]."/".$Max);
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
				<label for="date"><i><?=l("date")?></i></label>
				<input type="text" name="date" class="datepicker" id="date" value="<?=(isset($_POST['date'])) ? date("d/m/Y",$_POST['date']) : date("d/m/Y");?>" />
				<div class="checker_none date" onclick="$('.m_date').fadeIn('slow');">
						<div class="msg m_date"><?=l("filldate")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="name"><i><?=l("name")?></i> <font color="#f00">*</font></label>
				<input type="text" name="name" class="name" id="name" value="<?=(isset($_POST['name'])) ? $_POST['name'] : "";?>" />
				<div class="checker_none name" onclick="$('.m_name').fadeIn('slow');">
						<div class="msg m_name"><?=l("fillname")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="files"><i><?=l("files")?></i> ( pdf,doc,docx,zip,rar,xls,xlsx,png,jpg,jpeg,gif ) <font color="#f00">*</font></label>
				<input type="file" name="files" class="files" id="files" value="" />
			</div><div class="clearer"></div>
			
			<div class="boxes">				
				<input type="submit" class="submit" id="submit" value="<?=l("add")?>" />
				<input type="reset" class="reset" id="reset" value="<?=l("clear")?>" />	
			</div><div class="clearer"></div><br />
			
		</form>