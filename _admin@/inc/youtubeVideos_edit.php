<?php
$msg="";
/*change permition*/
if(isset($_POST["s"])){ change_permition("website_youtube_videos",$_GET["edit"],false); insert_action("youtube video","change permition",$_GET["edit"]); }
/* check if have permition */
$admin_permition = check_if_permition("website_youtube_videos",$_GET["edit"],false);
if(isset($_POST['title'],$_POST['description'],$_POST['category'],$_POST['tags']) && $admin_permition)
{
	if( !empty($_POST['title']) && !empty($_POST['description']) && !empty($_POST['category']) && !empty($_POST['tags']))
	{	
			insert_action("youtube","edit video",$_GET['edit']);
			insert_action("youtube","edit channel",$_GET['edit']);
			$fillsymbols = $_POST["fillsymbols"];
			$title = $_POST["title"];
			$description = $_POST["description"];
			$category = $_POST["category"];
			$tags = $_POST["tags"];
	
			if($_SESSION['encoded'] == $fillsymbols)
			{
				$insert = mysql_query("UPDATE `website_youtube_videos` SET 
																			`title`='".mysql_real_escape_string($title)."',  
																			`description`='".mysql_real_escape_string($description)."',  
																			`category`='".mysql_real_escape_string($category)."',  
																			`tags`='".mysql_real_escape_string($tags)."', 
																			`upload_status`='updating' 
																			WHERE 
																			`id`='".(int)$_GET['edit']."' 
																			");
				if(!$insert)
				{
					$msg = l("erroroccurred");
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
				$msg = l("fillsymbolsright");
				$theBoxColore = "red";
			}
	}
	else
	{
		$msg = l("requiredfields");
		$theBoxColore = "red";
	}
}
$c = mysql_query("SELECT * FROM `website_youtube_videos` WHERE id='".(int)$_GET['edit']."' ");
$geo = mysql_fetch_array($c);
$channel_info = channel_info($geo['channel_id']);
?>
<form action="" method="post">
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
		<iframe width="790" height="444" src="//www.youtube.com/embed/<?=$geo['video_link']?>" frameborder="0" allowfullscreen></iframe>
	</div>
	<div class="clearer"></div>
	
	<div class="boxes">
		<label for="channel"><i><?=l("channel")?></i> <font color="#f00">*</font></label>
		<select name="channel" class="channel" id="channel" disabled="disabled ">
			<option value="<?=$channel_info["channel_name"]?>"><?=$channel_info["channel_name"]?></option> 
		</select>
		<div class="checker_none key" onclick="$('.m_category').fadeIn('slow');">
				<div class="msg m_category"><?=l("chooseChannel")?> !</div>
		</div>
	</div>
	<div class="clearer"></div>
	
	<div class="boxes">
		<label for="title"><i><?=l("title")?></i> <font color="#f00">*</font></label>
		<input type="text" name="title" class="title" id="title" value="<?=(isset($geo['title'])) ? $geo['title'] : "";?>" />
		<div class="checker_none title" onclick="$('.m_title').fadeIn('slow');">
				<div class="msg m_title"><?=l("filltitle")?> !</div>
		</div>
	</div><div class="clearer"></div>
	
	<div class="boxes">
		<label for="description"><i><?=l("desc")?></i> <font color="#f00">*</font></label><div class="clearer"></div>
		<textarea name="description" id="description" class="description"><?=$geo['description']?></textarea>
	</div><div class="clearer"></div>
	
	<div class="boxes">
		<label for="key"><i><?=l("category")?></i> <font color="#f00">*</font></label>
		<select name="category" class="category" id="category">  
			<option value=""><?=l("choose")?></option>    
			<option value="Film &amp; Animation" <?=($geo['category']=="Film &amp; Animation") ? 'selected="selected"' : ''?>><?=l("filmAnimation")?></option>
			<option value="Autos" <?=($geo['category']=="Autos") ? 'selected="selected"' : ''?>><?=l("auto")?></option>
			<option value="Music" <?=($geo['category']=="Music") ? 'selected="selected"' : ''?>><?=l("music")?></option>
			<option value="Animals" <?=($geo['category']=="Animals") ? 'selected="selected"' : ''?>><?=l("animal")?></option>
			<option value="Sports" <?=($geo['category']=="Sports") ? 'selected="selected"' : ''?>><?=l("sport")?></option>
			<option value="Travel" <?=($geo['category']=="Travel") ? 'selected="selected"' : ''?>><?=l("travel")?></option>
			<option value="Games" <?=($geo['category']=="Games") ? 'selected="selected"' : ''?>><?=l("games")?></option>
			<option value="Comedy" <?=($geo['category']=="Comedy") ? 'selected="selected"' : ''?>><?=l("comedy")?></option>
			<option value="Entertainment" <?=($geo['category']=="Entertainment") ? 'selected="selected"' : ''?>><?=l("entertaiment")?></option>
			<option value="News" <?=($geo['category']=="News") ? 'selected="selected"' : ''?>><?=l("news")?></option>
			<option value="Education" <?=($geo['category']=="Education") ? 'selected="selected"' : ''?>><?=l("education")?></option>
			<option value="Tech" <?=($geo['category']=="Tech") ? 'selected="selected"' : ''?>><?=l("technic")?></option>
			<option value="Movies" <?=($geo['category']=="Movies") ? 'selected="selected"' : ''?>><?=l("movie")?></option>	
		</select>
		<div class="checker_none key" onclick="$('.m_category').fadeIn('slow');">
				<div class="msg m_category"><?=l("fillcategory")?> !</div>
		</div>
	</div>
	<div class="clearer"></div>
	
	<div class="boxes">
		<label for="tags"><i><?=l("tags")?></i> <font color="#f00">*</font></label>
		<input type="text" name="tags" class="tags" id="tags" value="<?=(isset($geo['tags'])) ? $geo['tags'] : "";?>" />
		<div class="checker_none tags" onclick="$('.m_tags').fadeIn('slow');">
				<div class="msg m_tags"><?=l("filletags")?> !</div>
		</div>
	</div>
	<div class="clearer"></div>

	<div class="boxes">
		<?php $_SESSION["token"]=randomPassword(16); ?>
		<a href="javascript:void(0)" onclick="openPop('contentRight.php?lang=<?=$_GET['lang']?>&id=<?=$_GET["edit"]?>&t=website_youtube_videos&weblang=<?=$_GET["lang"]?>&token=<?=$_SESSION["token"]?>')"><?=l("contentupdateright")?></a>
	</div><div class="clearer"></div>
	
	<div class="boxes">				
		<input type="submit" class="submit" id="submit" value="<?=l("edit")?>" />
	</div>
	<div class="clearer"></div><br />
		</form>