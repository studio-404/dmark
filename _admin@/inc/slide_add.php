<?php
$msg="";
if(isset($_POST['title'],$_POST['text'],$_POST['gotourl']))
{
	if(!empty($_POST['title']) && !empty($_POST['text']))
	{	
			//insert action
			insert_action("slide","add","0");
			$title = $_POST["title"];
			$text = $_POST["text"];
			
			$target = $_POST["target"];
			$slideType = $_POST["slideType"];
			
			if($slideType){
				$gotourl = preg_replace("/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i","http://www.youtube.com/embed/$1",$_POST["gotourl"]);
			}else{
				$gotourl = $_POST["gotourl"];
			}
			
			$select = mysql_query("SELECT MAX(position) + 1 AS maxi FROM website_slider");
			$getMax = mysql_fetch_array($select);
			$Max = $getMax['maxi'];
			
			$idxM = mysql_query("SELECT MAX(idx) AS idxmaxi FROM website_slider");
			$idxMx = mysql_fetch_array($idxM);
			$idxmaxi = $idxMx['idxmaxi']+1;
			
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
				$newName = $newName.".".$extension;
			}
			if(!$msg){
			$select_languages = select_languages(); 
			foreach($select_languages["language"] as $language){
				$admin_id = $_SESSION['admin_id'];
				$grand_id = implode(",",grand_admins());
				if(!in_array($admin_id,grand_admins())){
					$access_admins = $grand_id.",".$admin_id;
				}else{
					$access_admins = $grand_id;
				}
				
				$insert = mysql_query("INSERT INTO `website_slider` SET
															`idx`='".(int)$idxmaxi."',  
															`date`='".time()."',  
															`title`='".strip($title)."',  
															`text`='".strip($text)."',  
															`gotourl`='".strip($gotourl)."',  
															`slidetype`='".strip($slideType)."',  
															`url_target`='".strip($target)."',  
															`image`='".strip($newName)."',  
															`langs`='".strip($language)."', 
															`position`=".(int)$Max.",
															`access_admins`='".strip($access_admins)."'
															"); 
			}
			
			
			}
			if(mysql_error())
			{
				$msg = l("erroroccurred");
				$theBoxColore = "red";
			}
			else
			{
				_refresh_404("/".ADMIN_FOLDER."/".$_GET["lang"]."/edit/slide/".$idxmaxi);
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
				<label for="title"><i><?=l("title")?></i> <font color="#f00">*</font></label>
				<input type="text" name="title" class="title" id="title" value="<?=(isset($_POST['title'])) ? $_POST['title'] : "";?>" />
				<div class="checker_none title" onclick="$('.m_title').fadeIn('slow');">
						<div class="msg m_title"><?=l("filltitle")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="text"><i><?=l("text")?></i> <font color="#f00">*</font></label>
				<input type="text" name="text" class="text" id="text" value="<?=(isset($_POST['text'])) ? $_POST['text'] : "";?>" />
				<div class="checker_none text" onclick="$('.m_text').fadeIn('slow');">
						<div class="msg m_text"><?=l("filltext")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="slideType"><i><?=l("slideType")?></i> <font color="#f00">*</font></label>
				<select name="slideType" id="slideType" onchange="changeSlideType(this.value)">
					<option value="0" selected="selected"><?=l("photo")?></option>
					<option value="1"><?=l("youtube_video")?></option>
				</select>
				<div class="checker_none target" onclick="$('.slty_target').fadeIn('slow');">
						<div class="msg slty_target"><?=l("fillslideType")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
					<label for="gotourl"><i><?=l("gotourl")?></i> <font color="#f00">*</font></label>
					<input type="text" name="gotourl" class="gotourl" id="gotourl" value="<?=(isset($_POST['gotourl'])) ? $_POST['gotourl'] : "";?>" />
					<div class="checker_none gotourl" onclick="$('.m_gotourl').fadeIn('slow');">
							<div class="msg m_gotourl"><?=l("fillgotourl")?> !</div>
					</div>
			</div><div class="clearer"></div>
			
			<div class="photoHide"> 				
				<div class="boxes">
					<label for="target"><i><?=l("target")?></i> <font color="#f00">*</font></label>
					<select name="target">
						<option value=""><?=l("choose")?></option>
						<option value="_self">_self</option>
						<option value="_blank">_blank</option>
					</select>
					<div class="checker_none target" onclick="$('.m_target').fadeIn('slow');">
							<div class="msg m_target"><?=l("filltarget")?> !</div>
					</div>
				</div><div class="clearer"></div>
				
				<div class="boxes">
					<label for="photo"><i><?=l("photo")?></i> <font color="#f00">*</font></label>
					<input type="file" name="photo" class="photo" id="photo" value="" />
				</div><div class="clearer"></div>
			</div>	
			
			
				
			<div class="boxes">				
				<input type="submit" class="submit" id="submit" value="<?=l("add")?>" />
				<input type="reset" class="reset" id="reset" value="<?=l("clear")?>" />	
			</div><div class="clearer"></div>
			
		</form>