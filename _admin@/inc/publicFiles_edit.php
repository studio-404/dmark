<?php
$msg = "";
/*change permition*/
if(isset($_POST["s"])){ change_permition("website_public_files",false,$_GET["item"]); insert_action("public files","change permition",$_GET["edit"]); }
/* check if have permition */
$admin_permition = check_if_permition("website_public_files",false,$_GET["item"]);
if(isset($_POST["post"]) && $admin_permition)
{
	$r = 1;
	//insert action
	insert_action("public files","edit",$_GET["edit"]);
	foreach($_POST["post"] as $key => $value){ 
		if($value["name"]){
			$ex = explode("/",$value["date"]);
			$dd = $ex[0]."-".$ex[1]."-".$ex[2];
			$date_ = strtotime($dd);	
			$update = mysql_query("UPDATE `website_public_files` SET `date`='".(int)$date_."', `name`='".strip($value["name"])."' WHERE `idx`='".(int)$_GET["item"]."' AND `langs`='".strip($key)."' ");
		}else{
			$msg = l("requiredfields");
			$theBoxColore = "red";
		}
		
		if(isset($_FILES["files_".$key]["name"]) && !empty($_FILES["files_".$key]["name"]))
		{
			// old unlink
			$un = mysql_query("SELECT `file_name` FROM `website_public_files` WHERE `idx`='".(int)$_GET["item"]."' AND `langs`='".strip($key)."' ");
			$u = mysql_fetch_array($un);
			@unlink("../image/public_files/".$u["file_name"]);
			
			$temp = explode(".", $_FILES["files_".$key]["name"]);
			$extension = strtolower(end($temp));
			$allowedExts = array("pdf","doc","docx");
			$maxSize = 2000000;
			$newName = "publicFiles_".$key."_".time();
			$uploaded = upload_file($allowedExts,"files_".$key,$maxSize,"../image/public_files/",$newName);
			$newName = $newName.".".$extension;
			if(!$uploaded){
				$msg = l("erroroccurred");
				$theBoxColore = "red";
			}
			$update = mysql_query("UPDATE `website_public_files` SET `file_name`='".strip($newName)."' WHERE `idx`='".(int)$_GET["item"]."' AND `langs`='".strip($key)."' ");
		}
	}
	$msg = l("done");
	$theBoxColore = "orange";
	if(mysql_error()){
		$msg = l("erroroccurred");
		$theBoxColore = "red";
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
		$select = mysql_query("SELECT * FROM `website_public_files` WHERE `idx`='".(int)$_GET['item']."' AND `status`!=1 AND `langs`='".strip($select_languages["language"][$y-1])."' ");
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
				<label for="date_<?=$select_languages["language"][$y-1]?>"><i><?=l("date")?></i> <font color="#f00">*</font></label>
				<input type="text" name="post[<?=$select_languages["language"][$y-1]?>][date]" class="datepicker" id="date_<?=$select_languages["language"][$y-1]?>" value="<?=(isset($rows['date'])) ? date("d/m/Y",$rows['date']) : date("d/m/Y");?>" />
				<div class="checker_none date" onclick="$('.m_date').fadeIn('slow');">
						<div class="msg m_date"><?=l("filldate")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="name"><i><?=l("name")?></i> <font color="#f00">*</font></label>
				<input type="text" name="post[<?=$select_languages["language"][$y-1]?>][name]" class="name" id="name" value="<?=(isset($rows['name'])) ? htmlspecialchars($rows['name']) : "";?>" />
				<div class="checker_none name" onclick="$('.m_name').fadeIn('slow');">
						<div class="msg m_name"><?=l("fillname")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="files_<?=$select_languages["language"][$y-1]?>"><i><?=l("files")?></i> (pdf,doc,docx) <font color="#f00">*</font></label>
				<input type="file" name="files_<?=$select_languages["language"][$y-1]?>" class="files" id="files_<?=$select_languages["language"][$y-1]?>" value="" />
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<a href="../image/public_files/<?=$rows["file_name"]?>" target="_blank"><?=$rows["file_name"]?></a>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<?php $_SESSION["token"]=randomPassword(16); ?>
				<a href="javascript:void(0)" onclick="openPop('contentRight.php?lang=<?=$_GET['lang']?>&idx=<?=$_GET["item"]?>&t=website_public_files&weblang=<?=$_GET["lang"]?>&token=<?=$_SESSION["token"]?>')"><?=l("contentupdateright")?></a>
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