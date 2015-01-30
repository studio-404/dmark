<?php
$msg="";
if(isset($_POST['type'],$_POST['meta_title'],$_POST['gotourl'],$_POST['title']))
{
	if(!empty($_POST['meta_title']) && !empty($_POST['gotourl']) && !empty($_POST['title']))
	{	
		// insert action
		insert_action("navigation","add","0");
		$step = $_POST["step"];
		$type = $_POST["type"];
		$meta_title = $_POST["meta_title"];
		$meta_desc = $_POST["meta_desc"];
		$keywords = $_POST["keywords"];
		$gotourl = $_POST["gotourl"];
		$title = $_POST["title"];
		$text = strip_tags($_POST["text"],"<iframe><i><b><p><span><strong><table><tbody><tr><td><th><em><stroke><ul><ol><li><img><a><map><area>");
		$visibility = $_POST["visibility"];
		if(preg_match('/^[a-zA-Z\d]+$/',$gotourl) || preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $gotourl) || $gotourl=="0")
		{
			$selectMax = mysql_query("SELECT MAX(idx) AS midx FROM `website_menu` WHERE `langs`='".mysql_real_escape_string($_GET['lang'])."' ");
			$rMax = mysql_fetch_array($selectMax);
			$max_idx = ($rMax['midx']+1);
			
			if($step){
				$selectStep = mysql_query("SELECT idx,menu_type FROM website_menu WHERE idx='".(int)$step."' AND langs='".mysql_real_escape_string($_GET['lang'])."' ");
				$sTep = mysql_fetch_array($selectStep);
				$new_menu_type = ($sTep['menu_type']+1);
				$new_idx = ($sTep['idx']+1);
				$old_idx = $sTep['idx'];
			}else{
				$new_menu_type = 1;
				$new_idx=0;
				$old_idx = 0;
			}
			
			$admin_id = $_SESSION['admin_id'];
			$grand_id = implode(",",grand_admins());
			if(!in_array($admin_id,grand_admins())){
				$access_admins = $grand_id.",".$admin_id;
			}else{
				$access_admins = $grand_id;
			}
			
			if($type=="news")
			{//news type
				$n_max = mysql_query("SELECT MAX(idx) AS mx FROM `website_news` WHERE `status`!=1 ");
				$n_rows = mysql_fetch_array($n_max);
				$select_languages = select_languages(); 
				foreach($select_languages["language"] as $language)
				{
					$news_insert1 = mysql_query("INSERT INTO `website_news` SET 
																`idx`='".($n_rows['mx']+1)."', 
																`date`='".time()."', 
																`news_category`='".mysql_real_escape_string($title)."', 
																`langs`='".strip($language)."'
																");
					$news_item1 = mysql_query("INSERT INTO website_news_attachment SET 
																		`idx`='".(int)($n_rows['mx']+1)."', 
																		`connect_id`='".(int)$max_idx."', 
																		`news_idx`='".(int)($n_rows['mx']+1)."', 
																		`langs`='".strip($language)."'
																		");
				}
			}else if($type=="catalog")
			{//catalog type
				$c_max = mysql_query("SELECT MAX(idx) AS mx FROM `website_catalogs` WHERE `status`!=1 ");
				$c_rows = mysql_fetch_array($c_max);
				
				$select_languages = select_languages(); 
				foreach($select_languages["language"] as $language)
				{
					$catalog_insert1 = mysql_query("INSERT INTO `website_catalogs` SET 
																	`idx`='".($c_rows['mx']+1)."', 
																	`date`='".time()."', 
																	`category`='".strip($title)."', 
																	`langs`='".strip($language)."'
																	");																			
					$catalog_item1 = mysql_query("INSERT INTO `website_catalogs_attachment` SET 
																		`idx`='".(int)($c_rows['mx']+1)."', 
																		`connect_id`='".(int)$max_idx."', 
																		`catalog_id`='".(int)($c_rows['mx']+1)."', 
																		`langs`='".strip($language)."'
																		");
				}
			}else if($type=="public")
			{//public type
				$c_max = mysql_query("SELECT MAX(idx) AS mx FROM `website_public` WHERE `status`!=1 ");
				$c_rows = mysql_fetch_array($c_max);
				
				$select_languages = select_languages(); 
				foreach($select_languages["language"] as $language){
					$catalog_insert1 = mysql_query("INSERT INTO `website_public` SET 
																	`idx`='".($c_rows['mx']+1)."', 
																	`date`='".time()."', 
																	`name`='".strip($title)."', 
																	`langs`='".strip($language)."', 
																	`access_admins`='".strip($access_admins)."' 
																	");																			
					$catalog_item1 = mysql_query("INSERT INTO `website_public_attachment` SET 
																		`idx`='".(int)($c_rows['mx']+1)."', 
																		`connect_id`='".(int)$max_idx."', 
																		`public_id`='".(int)($c_rows['mx']+1)."', 
																		`langs`='".strip($language)."'
																		");
				}
			}
			
			if($type=="plugin"){
				$plugin_path = "../views/".$_POST["gotourl"];
				$plugin_file = "../views/".$_POST["gotourl"]."/index.php";
				$plugin_data = 'Plugin created, website developer could change this text...';
				if(mkdir($plugin_path, 0755))
				_create_file_404($plugin_file,$plugin_data);
			}
			
			
			$selectMaxPos = mysql_query("SELECT MAX(position) AS maxPossition FROM website_menu WHERE menu_type='".(int)$new_menu_type."' AND cat_id='".(int)$old_idx."' AND `status`!=1 AND `visibility`!=1 ");
			$rowsMaxPos = mysql_fetch_array($selectMaxPos);
			$maxPossition = ($rowsMaxPos['maxPossition']+1);

			$text = strip_tags($text,"<iframe><i><b><p><span><strong><table><tbody><tr><td><th><em><stroke><ul><ol><li><img><a><map><area>");	
			$meta_title = strip_tags($meta_title);	
			$meta_desc = strip_tags($meta_desc);	
			$title = strip_tags($title);	
			
			$select_languages = select_languages(); 
			foreach($select_languages["language"] as $language){	
				if(!preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $gotourl)){
					$gotourl1 = $language."/".$gotourl;					
				}else if($gotourl=="0"){
					$gotourl1 = 'javascript:void(0)';
				}else{
					$gotourl1 = $gotourl;
				}
				
				
				$insert = mysql_query("INSERT INTO `website_menu` SET 	
														`date`='".time()."',  
														`idx`='".(int)$max_idx."',  
														`cat_id`='".(int)$old_idx."',  
														`meta_title`='".strip($meta_title)."',  
														`meta_desc`='".strip($meta_desc)."',  
														`meta_keywords`='".strip($keywords)."',  
														`title`='".strip($title)."',  
														`text`='".strip($text)."',
														`url`='".strip($gotourl1)."',
														`menu_type`='".(int)$new_menu_type."',
														`type`='".strip($type)."', 
														`langs`='".strip($language)."', 
														`position`='".(int)$maxPossition."', 
														`visibility`='".(int)$visibility."', 
														`access_admins`='".strip($access_admins)."'
														");
			}
	
			if(mysql_error())
			{
				$msg = l("erroroccurred");
				$theBoxColore = "red";
			}
			else
			{
				if($type=="text"){
					_refresh_404("/".ADMIN_FOLDER."/".$_GET["lang"]."/edit/text/".$max_idx);
				}else if($type=="public"){
					_refresh_404("/".ADMIN_FOLDER."/".$_GET["lang"]."/table/public");
				}else{
					_refresh_404("/".ADMIN_FOLDER."/".$_GET["lang"]."/edit/navigation/".$max_idx);
				}
				exit();
				$msg = l("done");
				$theBoxColore = "orange";
			}
		}
		else
		{
			$msg = l("error_url");
			$theBoxColore = "red";
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
				<label for="step"><i><?=l("step")?></i></label>
				<?=menu_hierarchy()?>
			</div><div class="clearer"></div>
			<div class="boxes">
				<label for="type"><i><?=l("pagetype")?></i> <font color="#f00">*</font></label>
				<select name="type" id="pageTypeForChange">					
					<option value=""><?=l("choose")?></option>
					<option value="text" selected="selected"><?=l("text")?></option>
					<option value="public"><?=l("publicInfo")?></option>
					<option value="catalog"><?=l("catalog")?></option>
					<option value="news"><?=l("news")?></option>
					<option value="gallery"><?=l("gallery")?></option>
					<option value="plugin"><?=l("otherplugins")?></option>
				</select>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="visibility"><i><?=l("visibility")?></i> <font color="#f00">*</font></label>
				<select name="visibility" onchange="changeToText(this.value,'<?=$_GET['lang']?>')">
					<option value="0" slected="selected"><?=l("visible")?></option>
					<option value="1"><?=l("invisible")?></option>
				</select>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="meta_title"><i><?=l("meta_title")?></i> <font color="#f00">*</font></label>
				<input type="text" name="meta_title" class="meta_title" id="meta_title" value="<?=(isset($_POST['meta_title'])) ? $_POST['meta_title'] : "";?>" />
				<div class="checker_none meta_title" onclick="$('.m_meta_title').fadeIn('slow');">
						<div class="msg m_meta_title"><?=l("fillmeta_title")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="meta_desc"><i><?=l("meta_desc")?></i> <font color="#f00">*</font></label>
				<input type="text" name="meta_desc" class="meta_desc" id="meta_desc" value="<?=(isset($_POST['meta_desc'])) ? $_POST['meta_desc'] : "";?>" />
				<div class="checker_none meta_desc" onclick="$('.m_meta_desc').fadeIn('slow');">
						<div class="msg m_meta_desc"><?=l("fillmeta_desc")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="keywords"><i><?=l("keywords")?></i></label>
				<input type="text" name="keywords" class="keywords" id="keywords" value="<?=(isset($_POST['keywords'])) ? $_POST['meta_desc'] : "";?>" />
				<div class="checker_none keywords" onclick="$('.m_keywords').fadeIn('slow');">
					<div class="msg m_keywords"><?=l("fillkeywords")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="gotourl"><i><?=l("gotourl")?></i> <font color="#f00">*</font></label>
				<input type="text" name="gotourl" class="gotourl" id="gotourl" value="<?=(isset($_POST['gotourl'])) ? $_POST['gotourl'] : "";?>"  />
				<div class="checker_none gotourl" onclick="$('.m_gotourl').fadeIn('slow');">
						<div class="msg m_gotourl"><?=l("fillgotourl")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="title"><i><?=l("title")?></i> <font color="#f00">*</font></label>
				<input type="text" name="title" class="title" id="title" value="<?=(isset($_POST['title'])) ? $_POST['title'] : "";?>" />
				<div class="checker_none title" onclick="$('.m_title').fadeIn('slow');">
						<div class="msg m_title"><?=l("filltitle")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="text"><i><?=l("text")?></i></label><div class="clearer"></div>
				<textarea name="text" class="text" id="text"><?=(isset($_POST['text'])) ? $_POST['text'] : "";?></textarea>
			</div>
			<div class="clearer"></div>
				
			<div class="boxes">				
				<input type="submit" class="submit" id="submit" value="<?=l("add")?>" />
				<input type="reset" class="reset" id="reset" value="<?=l("clear")?>" />	
			</div>
			<div class="clearer"></div><br />
		</form>