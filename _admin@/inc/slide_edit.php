<?php
unset($_SESSION["token"]);
$c = mysql_query("SELECT * FROM `website_slider` WHERE `idx`='".(int)$_GET['edit']."' ");
if(!mysql_num_rows($c)){ exit(); }
$geo = mysql_fetch_array($c);
$msg = "";
/*change permition*/
if(isset($_POST["s"])){ change_permition("website_slider",false,$_GET["edit"]); insert_action("slide","change permition",$_GET["edit"]); }
/* check if have permition */
$admin_permition = check_if_permition("website_slider",false,$_GET["edit"]);
if(isset($_POST["post"]) && $admin_permition)
{
	//insert action
	insert_action("slide","edit",$_GET['edit']);
	// image upload
	if(isset($_FILES["photo"]["name"]) && !empty($_FILES["photo"]["name"])){
		$temp = explode(".", $_FILES["photo"]["name"]);
		$extension = end($temp);
		$allowedExts = array("gif", "jpeg", "jpg", "png","GIF","JPEG","JPG","PNG");
		$maxSize = 2000000;
		$newName = "slide_".time();
		$uploaded = upload_file($allowedExts,"photo",$maxSize,"../image/slide/",$newName);
		if(!$uploaded){
			$msg = l("erroroccurred");
			$theBoxColore = "red";
		}
		$newName = "slide_".time().".".$extension;
		$remove = "../image/slide/".$geo['image'];
		unlink($remove);
	}else{
		$newName= $geo['image'];
	}
	$slidetype = $_POST['slidetype'];
	foreach($_POST["post"] as $key => $value){ 
		if(!empty($value["title"]) && !empty($value["text"]) ){

			if($slidetype){
				$gotourl = preg_replace("/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i","http://www.youtube.com/embed/$1",$value["gotourl"]);
			}else{
				$gotourl = $value["gotourl"];
			}
		
			$update = mysql_query("UPDATE `website_slider` SET 
												`title`='".mysql_real_escape_string($value["title"])."',  
												`text`='".mysql_real_escape_string($value["text"])."',  
												`gotourl`='".mysql_real_escape_string($gotourl)."', 
												`slidetype`='".(int)$slidetype."', 
												`url_target`='".mysql_real_escape_string($value["url_target"])."',  
												`image`='".mysql_real_escape_string($newName)."' 
												WHERE 
												`idx`='".(int)$_GET['edit']."' AND 
												`langs`='".mysql_real_escape_string($key)."'
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
		$select = mysql_query("SELECT `title`,`text`,`gotourl`,`slidetype`,`url_target`,`image` FROM `website_slider` WHERE `idx`='".(int)$_GET['edit']."' AND `status`!=1 AND `langs`='".mysql_real_escape_string($select_languages["language"][$y-1])."' ");
		$rows = mysql_fetch_array($select);
	
		if($rows["slidetype"]){
			echo '<input type="hidden" name="slidetype" value="1" />';
		}else{ echo '<input type="hidden" name="slidetype" value="0" />'; }
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
				<div class="photo">
					<?php
					if($rows["slidetype"])
					{
					?>
						<img src="<?=getYoutubeImageSrc($rows["gotourl"])?>" width="760" height="250" alt="" />
					<?php
					}
					else
					{
					?>
						<img src="../crop.php?path=image/slide/&img=<?=MAIN_DIR?>/image/slide/<?=$rows['image']?>&amp;width=760&amp;height=250" width="760" height="250" alt="" />
					<?php
					}
					?>
				</div>
			</div><div class="clearer"></div>
			<?php if($y==1 && !$rows["slidetype"]) : ?>
			<div class="boxes">
				<label for="photo"><i><?=l("photo")?></i> <font color="#f00">*</font></label>
				<input type="file" name="photo" class="photo" id="photo" />
			</div><div class="clearer"></div>
			<?php endif; ?>
			
			<div class="boxes">
				<label for="title"><i><?=l("title")?></i> <font color="#f00">*</font></label>
				<input type="text" name="post[<?=$select_languages["language"][$y-1]?>][title]" class="title" id="title" value="<?=(isset($rows['title'])) ? $rows['title'] : "";?>" />
				<div class="checker_none title" onclick="$('.m_title').fadeIn('slow');">
						<div class="msg m_title"><?=l("filltitle")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="text"><i><?=l("text")?></i> <font color="#f00">*</font></label>
				<input type="text" name="post[<?=$select_languages["language"][$y-1]?>][text]" class="text" id="text" value="<?=(isset($rows['text'])) ? $rows['text'] : "";?>" />
				<div class="checker_none text" onclick="$('.m_text').fadeIn('slow');">
						<div class="msg m_text"><?=l("filltext")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="gotourl"><i><?=l("gotourl")?></i> <font color="#f00">*</font></label>
				<input type="text" name="post[<?=$select_languages["language"][$y-1]?>][gotourl]" class="gotourl" id="gotourl" value="<?=(isset($rows['gotourl'])) ? $rows['gotourl'] : "";?>" />
				<div class="checker_none gotourl" onclick="$('.m_gotourl').fadeIn('slow');">
						<div class="msg m_gotourl"><?=l("fillgotourl")?> !</div>
				</div>
			</div><div class="clearer"></div>
	
			<?php
			if(!$rows["slidetype"]) :
			?>
			<div class="boxes">
				<label for="target"><i><?=l("target")?></i> <font color="#f00">*</font></label>
				<select name="post[<?=$select_languages["language"][$y-1]?>][url_target]">
					<option value=""><?=l("choose")?></option>
					<option value="_self" <?=($rows['url_target']=="_self") ? 'selected="selected"' : ''?>>_self</option>
					<option value="_blank" <?=($rows['url_target']=="_blank") ? 'selected="selected"' : ''?>>_blank</option>
				</select>
				<div class="checker_none target" onclick="$('.m_target').fadeIn('slow');">
						<div class="msg m_target"><?=l("filltarget")?> !</div>
				</div>
			</div><div class="clearer"></div>
			<?php endif; ?>
			<div class="boxes">
				<?php $_SESSION["token"]=randomPassword(16); ?>
				<a href="javascript:void(0)" onclick="openPop('contentRight.php?lang=<?=$_GET['lang']?>&idx=<?=$_GET["edit"]?>&t=website_slider&weblang=<?=$_GET["lang"]?>&token=<?=$_SESSION["token"]?>')"><?=l("contentupdateright")?></a>
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