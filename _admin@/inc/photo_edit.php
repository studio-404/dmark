<?php
$msg = "";
/*change permition*/
if(isset($_POST["s"])){ change_permition("website_gallery_photos",false,$_GET["edit"]); insert_action("gallery photo","change permition",$_GET["edit"]); }
/* check if have permition */
$admin_permition = check_if_permition("website_gallery_photos",false,$_GET["edit"]);
if(isset($_POST["post"]) && $admin_permition)
{
	if(isset($_POST["cover"][0]) || isset($_POST["cover"][1])){
		$cover = 1;
	}else{ $cover = 0; }
	insert_action("photo","edit",$_GET['edit']);
	// image upload
	foreach($_POST["post"] as $key => $value){ 
		$update = mysql_query("UPDATE `website_gallery_photos` SET 
								`title`='".strip($value["title"])."',  
								`description`='".strip($value["description"])."', 
								`cover`='".(int)$cover."' 
								WHERE 
								`idx`='".(int)$_GET['edit']."' AND 
								`langs`='".strip($key)."' 
								");
		$msg = l("done");
		$theBoxColore = "orange";	
	}
	
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
		$select = mysql_query("SELECT * FROM `website_gallery_photos` WHERE 
		`idx`='".(int)$_GET['edit']."' AND 
		`langs`='".strip($select_languages["language"][$y-1])."' AND 
		`status`!=1");
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
			<input type="hidden" name="l" value="<?=$select_languages["language"][$y-1]?>" />
			<div class="boxes">
				<div class="photo">
					<img src= "../crop.php?path=image/slide/&img=<?=MAIN_DIR?>/image/gallery/<?=$rows['photo']?>&amp;width=760&amp;height=250" width="760" height="250" />
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="title"><i><?=l("title")?></i> <font color="#f00">*</font></label>
				<input type="text" name="post[<?=$select_languages["language"][$y-1]?>][title]" class="title" value="<?=(isset($rows['title'])) ? $rows['title'] : "";?>" />
				<div class="checker_none title" onclick="$('.m_title').fadeIn('slow');">
						<div class="msg m_title"><?=l("filltitle")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="description"><i><?=l("text")?></i></label><br />
				<textarea name="post[<?=$select_languages["language"][$y-1]?>][description]" id="description_<?=$rows["id"]?>" class="description1"><?=(isset($rows['description'])) ? $rows['description'] : "";?></textarea>
			</div><div class="clearer"></div>


			<div class="boxes">
				<label for="cover-<?=y?>"><i><?=l("cover")?></i> <input type="checkbox" id="cover-<?=y?>" name="cover[<?=($y-1)?>]" class="cover" <?=(isset($rows['cover']) && $rows["cover"]==1) ? "checked='checked'" : "";?> value="1" /></label>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<?php $_SESSION["token"]=randomPassword(16); ?>
				<a href="javascript:void(0)" onclick="openPop('contentRight.php?lang=<?=$_GET['lang']?>&idx=<?=$_GET["edit"]?>&t=website_gallery_photos&weblang=<?=$_GET["lang"]?>&token=<?=$_SESSION["token"]?>')"><?=l("contentupdateright")?></a>
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