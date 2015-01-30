<?php
$msg="";
if(isset($_POST['channel'],$_POST['title'],$_POST['description'],$_POST['category'],$_POST['tags']))
{
	if(!empty($_POST['channel']) && !empty($_POST['title']) && !empty($_POST['description']) && !empty($_POST['category']) && !empty($_POST['tags']) )
	{
		insert_action("youtube","add video","0");
		$channel_info = channel_info($_POST['channel']); //select channel info
		$fillsymbols = $_POST["fillsymbols"];
		$channel = $_POST["channel"];
		$title = $_POST["title"];
		$email = $_POST["email"];
		$description = $_POST["description"];
		$category = $_POST["category"];
		$tags = $_POST["tags"];	

		/** UPLOAD SCRIPT */
		$allowedExts = array("MOV","MPEG4","MP4","AVI","WMV","MPEGPS","FLV","3GPP","WebM");	
		$temp = explode(".", $_FILES["video_file"]["name"]);
		$extension = end($temp);
		if ($_FILES["video_file"]["size"] < 20725760 && in_array(strtoupper($extension), $allowedExts)) {
		  if (!$_FILES["video_file"]["error"]) {	
			$api_video = $_FILES["video_file"]["tmp_name"];
			$api_video_name = time().".".$extension;
			$move_file = move_uploaded_file($api_video, "_plugins/youtube/file/".$api_video_name);
		  }else{
			$msg = l("erroroccurred")." 1";
			$theBoxColore = "red";
		  }
		}else{
			$msg = l("erroroccurred")." 2";
			$theBoxColore = "red";
		}
		
		$explode_tags = explode(",",$tags); 
		if(count($explode_tags) > 1)
		{
			$videoName = youTube($channel_info["key"], $channel_info["email"], $channel_info["app_password"], $api_video_name, $title, $description, $category, $tags, 0);
			/** UPLOAD SCRIPT */		
			$admin_id = $_SESSION['admin_id'];
			$grand_id = implode(",",grand_admins());
			if(!in_array($admin_id,grand_admins())){
				$access_admins = $grand_id.",".$admin_id;
			}else{
				$access_admins = $grand_id;
			}
			$insert = mysql_query("INSERT INTO `website_youtube_videos` SET 
													`channel_id`='".(int)$channel."',  
													`title`='".strip($title)."',  
													`description`='".strip($description)."',  
													`category`='".strip($category)."',  
													`private`='0',  
													`tags`='".strip($tags)."',  
													`video_file`='".strip($api_video_name)."', 
													`upload_status`='inprogress', 
													`access_admins`='".strip($access_admins)."'
													");
			$mysql_insert_id = mysql_insert_id();
			if(!$insert)
			{
				$msg = l("erroroccurred")." 3";
				$theBoxColore = "red";
			}
			else
			{
				_refresh_404("/".ADMIN_FOLDER."/".$_GET["lang"]."/edit/youtubeVideos/".$mysql_insert_id);
				exit();
				$msg = l("done");
				$theBoxColore = "orange";
			}
		}else{
			$msg = l("erroroccurred")." 4";
			$theBoxColore = "red";
		}
	}
	else
	{
		$msg = l("requiredfields")." 6";
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
				<label for="channel"><i><?=l("channel")?></i> <font color="#f00">*</font></label>
				<select name="channel" class="channel" id="channel">
					<option value=""><?=l("choose")?></option>    
					<?=get_channels_opt()?>
				</select>
				<div class="checker_none key" onclick="$('.m_category').fadeIn('slow');">
						<div class="msg m_category"><?=l("chooseChannel")?> !</div>
				</div>
			</div>
			<div class="clearer"></div>
			
			<div class="boxes">
				<label for="title"><i><?=l("title")?></i> <font color="#f00">*</font></label>
				<input type="text" name="title" class="title" id="title" value="<?=(isset($_POST['title'])) ? $_POST['title'] : "";?>" />
				<div class="checker_none title" onclick="$('.m_title').fadeIn('slow');">
						<div class="msg m_title"><?=l("filltitle")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="description"><i><?=l("desc")?></i> <font color="#f00">*</font></label><div class="clearer"></div>
				<textarea name="description" id="description" class="description"></textarea>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="key"><i><?=l("category")?></i> <font color="#f00">*</font></label>
				<select name="category" class="category" id="category">
					<option value=""><?=l("choose")?></option>    
					<option value="Film &amp; Animation"><?=l("filmAnimation")?></option>
					<option value="Autos"><?=l("auto")?></option>
					<option value="Music"><?=l("music")?></option>
					<option value="Animals"><?=l("animal")?></option>
					<option value="Sports"><?=l("sport")?></option>
					<option value="Travel"><?=l("travel")?></option>
					<option value="Games"><?=l("games")?></option>
					<option value="Comedy"><?=l("comedy")?></option>
					<option value="Entertainment"><?=l("entertaiment")?></option>
					<option value="News"><?=l("news")?></option>
					<option value="Education"><?=l("education")?></option>
					<option value="Tech"><?=l("technic")?></option>
					<option value="Movies"><?=l("movie")?></option>
				</select>
				<div class="checker_none key" onclick="$('.m_category').fadeIn('slow');">
						<div class="msg m_category"><?=l("fillcategory")?> !</div>
				</div>
			</div>
			<div class="clearer"></div>
			
			<div class="boxes">
				<label for="tags"><i><?=l("tags")?></i> <font color="#f00">*</font></label>
				<input type="text" name="tags" class="tags" id="tags" value="<?=(isset($_POST['tags'])) ? $_POST['tags'] : "";?>" />
				<div class="checker_none tags" onclick="$('.m_tags').fadeIn('slow');">
						<div class="msg m_tags"><?=l("filletags")?> !</div>
				</div>
			</div>
			<div class="clearer"></div>
			
			<div class="boxes">
				<label for="video_file"><i><?=l("video_file")?></i> <font color="#f00">*</font></label>
				<input type="file" name="video_file" class="video_file" id="video_file" />
			</div>
			<div class="clearer"></div>
				
			<div class="boxes">				
				<input type="submit" class="submit" id="submit" value="<?=l("add")?>" />
				<input type="reset" class="reset" id="reset" value="<?=l("clear")?>" />	
			</div>
			<div class="clearer"></div><br />
		</form>