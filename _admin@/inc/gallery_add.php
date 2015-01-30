<?php
$msg="";
if(isset($_POST['title']))
{
	if(!empty($_POST['title']) )
	{	
		insert_action("gallery","add gallery","0");
		$fillsymbols = $_POST["fillsymbols"];
		$title = $_POST["title"];
		$selectMax = mysql_query("SELECT MAX(idx) AS midx FROM website_gallery_attachment WHERE langs='".mysql_real_escape_string($_GET['lang'])."' ");
		$rMax = mysql_fetch_array($selectMax);
		$max_idx = ($rMax['midx']+1);
		
		$selectMaxG = mysql_query("SELECT MAX(idx) AS midx FROM website_gallery WHERE langs='".mysql_real_escape_string($_GET['lang'])."' ");
		$rMaxG = mysql_fetch_array($selectMaxG);
		$max_idxG = ($rMaxG['midx']+1);
	
		$title = strip_tags($title);	
		$select_languages = select_languages(); 
		foreach($select_languages["language"] as $language){
			$admin_id = $_SESSION['admin_id'];
			$grand_id = implode(",",grand_admins());
			if(!in_array($admin_id,grand_admins())){
				$access_admins = $grand_id.",".$admin_id;
			}else{
				$access_admins = $grand_id;
			}
			$insert = mysql_query("INSERT INTO `website_gallery` SET 	
												`idx`='".$max_idxG."',  
												`date`='".time()."',  
												`name`='".strip($title)."',  
												`langs`='".strip($language)."',
												`access_admins`='".strip($access_admins)."'
												");
		
		}
		$select_languages = select_languages(); 
		foreach($select_languages["language"] as $language){
			$insert2 = mysql_query("INSERT INTO `website_gallery_attachment` SET 	
													`idx`='".(int)$max_idx."',  
													`connect_id`='0',  
													`gallery_idx`='".(int)$max_idxG."',  
													`langs`='".strip($language)."', 
													`type`='gallery'
													");
		}
		
		
		if(!$insert || !$insert2)
		{
			$msg = l("erroroccurred");
			$theBoxColore = "red";
		}
		else
		{
			_refresh_404("/".ADMIN_FOLDER."/".$_GET["lang"]."/edit/gallery/".$max_idxG);
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
			<div class="boxes">
				<label for="title"><i><?=l("title")?></i> <font color="#f00">*</font></label>
				<input type="text" name="title" class="title" id="title" value="<?=(isset($_POST['title'])) ? $_POST['title'] : "";?>" />
				<div class="checker_none title" onclick="$('.m_title').fadeIn('slow');">
					<div class="msg m_title"><?=l("filltitle")?> !</div>
				</div>
			</div><div class="clearer"></div>
				
			<div class="boxes">				
				<input type="submit" class="submit" id="submit" value="<?=l("add")?>" />
			</div>
			<div class="clearer"></div><br />
		</form>