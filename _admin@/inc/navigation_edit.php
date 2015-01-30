<?php
$msg = "";
/*change permition*/
if(isset($_POST["s"])){ change_permition("website_menu",false,$_GET["edit"]); insert_action("navigation","change permition",$_GET["edit"]); }
/* check if have permition */
$admin_permition = check_if_permition("website_menu",false,$_GET["edit"]);
if(isset($_POST["post"]) && $admin_permition)
{
	// insert action
	insert_action("navigation","edti",$_GET['edit']);
	// image upload
	foreach($_POST["post"] as $key => $value){ 
		if(!empty($value["meta_title"]) && !empty($value["meta_desc"]) && !empty($value["title"])){	
			$update = mysql_query("UPDATE `website_menu` SET 
												`meta_title`='".strip($value["meta_title"])."',  
												`meta_desc`='".strip($value["meta_desc"])."',  
												`meta_keywords`='".strip($value["keywords"])."',  
												`title`='".strip($value["title"])."', 
												`text`='".addslashes($value["text"])."' 
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
		$select = mysql_query("SELECT `id`,`meta_title`,`meta_desc`,`meta_keywords`,`title`,`text`,`url`,`type` FROM `website_menu` WHERE `idx`='".(int)$_GET['edit']."' AND `status`!=1 AND `langs`='".mysql_real_escape_string($select_languages["language"][$y-1])."' ");
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
				<label for="meta_title<?=$y?>"><i><?=l("meta_title")?></i> <font color="#f00">*</font></label>
				<input type="text" name="post[<?=$select_languages["language"][$y-1]?>][meta_title]" class="meta_title" id="meta_title<?=$y?>" value="<?=(isset($rows['meta_title'])) ? stripslashes($rows['meta_title']) : "";?>" />
				<div class="checker_none meta_title" onclick="$('.m_meta_title').fadeIn('slow');">
						<div class="msg m_meta_title"><?=l("fillmeta_title")?> !</div>
				</div>
			</div><div class="clearer"></div>
		
			<div class="boxes">
				<label for="meta_desc<?=$y?>"><i><?=l("meta_desc")?></i> <font color="#f00">*</font></label>
				<input type="text" name="post[<?=$select_languages["language"][$y-1]?>][meta_desc]" class="meta_desc" id="meta_desc<?=$y?>" value="<?=(isset($rows['meta_desc'])) ? stripslashes($rows['meta_desc']) : "";?>" />
				<div class="checker_none meta_desc" onclick="$('.m_meta_desc').fadeIn('slow');">
						<div class="msg m_meta_desc"><?=l("fillmeta_desc")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="keywords<?=$y?>"><i><?=l("keywords")?></i></label>
				<input type="text" name="post[<?=$select_languages["language"][$y-1]?>][keywords]" class="keywords" id="keywords<?=$y?>" value="<?=(isset($rows['meta_keywords'])) ? stripslashes($rows['meta_keywords']) : "";?>" />
				<div class="checker_none keywords" onclick="$('.m_keywords').fadeIn('slow');">
					<div class="msg m_keywords"><?=l("fillkeywords")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="gotourl<?=$y?>"><i><?=l("gotourl")?></i> <font color="#f00">*</font></label>
				<input type="text" name="post[<?=$select_languages["language"][$y-1]?>][gotourl]" class="gotourl" id="gotourl<?=$y?>" value="<?=(isset($rows['url'])) ? $rows['url'] : "";?>" readonly="readonly" />
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="type<?=$y?>"><i><?=l("type")?></i> <font color="#f00">*</font></label>
				<input type="text" name="post[<?=$select_languages["language"][$y-1]?>][type]" class="type" id="type<?=$y?>" value="<?=(isset($rows['type'])) ? $rows['type'] : "";?>" readonly="readonly" />
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="title<?=$y?>"><i><?=l("title")?></i> <font color="#f00">*</font></label>
				<input type="text" name="post[<?=$select_languages["language"][$y-1]?>][title]" class="title" id="title<?=$y?>" value="<?=(isset($rows['title'])) ? stripslashes($rows['title']) : "";?>" />
				<div class="checker_none title" onclick="$('.m_title').fadeIn('slow');">
						<div class="msg m_title"><?=l("filltitle")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="text_ka_<?=$rows['id']?>"><i><?=l("text")?></i></label><div class="clearer"></div>
				<textarea name="post[<?=$select_languages["language"][$y-1]?>][text]" class="text_geo" id="text_ka_<?=$rows['id']?>"><?=(isset($rows['text'])) ? stripslashes($rows['text']) : "";?></textarea>
			</div>
			<div class="clearer"></div>
			
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