<?php
$msg = "";
/*change permition*/
if(isset($_POST["s"])){ change_permition("website_banners",false,$_GET["edit"]); insert_action("banner","change permition",$_GET["edit"]); }
/* check if have permition */
$admin_permition = check_if_permition("website_banners",false,$_GET["edit"]);
if(isset($_POST["post"]) && $admin_permition)
{
	$r = 1;
	//insert action
	insert_action("banners","edit",$_GET["edit"]);
	foreach($_POST["post"] as $key => $value){ 
		if($value["title"] && $value["url"]){
			$update = mysql_query("UPDATE `website_banners` SET `title`='".strip($value["title"])."', `url`='".strip($value["url"])."' WHERE `idx`='".(int)$_GET["edit"]."' AND `langs`='".strip($key)."' ");
		}else{
			$msg = l("requiredfields");
			$theBoxColore = "red";
		}
		
		if(isset($_FILES["banner_".$key]["name"]) && !empty($_FILES["banner_".$key]["name"]))
		{
			$temp = explode(".", $_FILES["banner_".$key]["name"]);
			$extension = strtolower(end($temp));
			$allowedExts = array("gif", "jpeg", "jpg", "png","swf");
			$maxSize = 2000000;
			$newName = "banner_".time();
			$uploaded = upload_file($allowedExts,"banner_".$key,$maxSize,"../image/banners/",$newName);
			if(!$uploaded){
				$msg = l("erroroccurred");
				$theBoxColore = "red";
			}
			$newName = $newName.".".$extension;
			$banner_type = ($extension=="swf") ? "flash" : "img";
			$update = mysql_query("UPDATE `website_banners` SET `img_name`='".strip($newName)."' WHERE `idx`='".(int)$_GET["edit"]."' AND `langs`='".strip($key)."' ");
			// old unlink
			//$un = mysql_query("SELECT `img_name` FROM `website_banners` WHERE `idx`='".(int)$_GET["edit"]."' AND `langs`='".strip($key)."' ");
			//$u = mysql_fetch_array($un);
			//@unlink("../image/banners/".$u["img_name"]);
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
		$select = mysql_query("SELECT * FROM `website_banners` WHERE `idx`='".(int)$_GET['edit']."' AND `status`!=1 AND `langs`='".strip($select_languages["language"][$y-1])."' ");
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
				<label for="title"><i><?=l("title")?></i> <font color="#f00">*</font></label>
				<input type="text" name="post[<?=$select_languages["language"][$y-1]?>][title]" class="title" value="<?=(isset($rows['title'])) ? $rows['title'] : "";?>" />
				<div class="checker_none title" onclick="$('.m_title').fadeIn('slow');">
					<div class="msg m_title"><?=l("filltitle")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="url"><i><?=l("url")?></i> <font color="#f00">*</font></label>
				<input type="text" name="post[<?=$select_languages["language"][$y-1]?>][url]" class="url" value="<?=(isset($rows['url'])) ? $rows['url'] : "";?>" />
				<div class="checker_none url" onclick="$('.m_url').fadeIn('slow');">
					<div class="msg m_url"><?=l("fillurl")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<img src="../image/banners/<?=$rows["img_name"]?>" width="250" height="110" />
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="banner"><i><?=l("banner")?></i> <font color="#f00">*</font></label>
				<input type="file" name="banner_<?=$select_languages["language"][$y-1]?>" class="banner" value="" />
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<?php $_SESSION["token"]=randomPassword(16); ?>
				<a href="javascript:void(0)" onclick="openPop('contentRight.php?lang=<?=$_GET['lang']?>&idx=<?=$_GET["edit"]?>&t=website_banners&weblang=<?=$_GET["lang"]?>&token=<?=$_SESSION["token"]?>')"><?=l("contentupdateright")?></a>
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