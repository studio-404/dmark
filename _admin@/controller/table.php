<?php
$actual_link = $_SERVER['REQUEST_URI'];
if(isset($_GET['pn'])){ $ax = "/pn/".$_GET['pn'];}else{ $ax=''; }
if(isset($_GET['gallery_id'])){ $ax2 = "/".$_GET['gallery_id'];
	if(isset($_GET['pn'])){ $ax2 .= "/pn/".$_GET['pn']; }
}else{ $ax2=''; } 

$path = $_GET['lang']."/table/".$_GET['show']."/pn/"; 
if($actual_link=="/".ADMIN_FOLDER."/".$_GET['lang']."/table/system_admin".$ax){	
	if(isset($_POST['delete'])){
		$delete = explode(",",$_POST['delete']);
		if(count($delete) > 1){
				$update_admin_remove = mysql_query("UPDATE `panel_admins` SET `status`=1 WHERE `id` IN (".mysql_real_escape_string(str_replace("undefined","0",$_POST['delete'])).") AND `permition`!=1 ");
		}else{
			$update_admin_remove = mysql_query("UPDATE `panel_admins` SET `status`=1 WHERE `id`='".(int)$_POST['delete']."' AND `permition`!=1 ");
		}
		//insert action
		insert_action("users","delete",$_POST['delete']);
	}
	$p = pagination("SELECT * FROM `panel_admins` WHERE `status`!=1 ORDER BY `id` DESC",$path,20);
}else if($actual_link=="/".ADMIN_FOLDER."/".$_GET['lang']."/table/systemipaddresses".$ax){
	if(isset($_POST['delete'])){
		$delete = explode(",",$_POST['delete']);
		if(count($delete) > 1){
			$update_admin_remove = mysql_query("UPDATE `system_ips` SET `status`=1 WHERE `id` IN (".mysql_real_escape_string(str_replace("undefined","0",$_POST['delete'])).") ");
		}else{
			$update_admin_remove = mysql_query("UPDATE system_ips SET status=1 WHERE id='".(int)$_POST['delete']."' ");
		}
		//insert action
		insert_action("ip","delete",$_POST['delete']);
	}
	$p = pagination("SELECT * FROM system_ips WHERE status!=1 ORDER BY id DESC",$path,20);
}else if($actual_link=="/".ADMIN_FOLDER."/".$_GET['lang']."/table/systemlogs".$ax){
	if(isset($_POST['delete'])){
	$delete = explode(",",$_POST['delete']);
		if(count($delete) > 1){
			$update_admin_remove = mysql_query("UPDATE `system_logs` SET status=1 WHERE id IN (".mysql_real_escape_string(str_replace("undefined","0",$_POST['delete'])).") ");
		}else{
			$update_admin_remove = mysql_query("UPDATE `system_logs` SET status=1 WHERE id='".(int)$_POST['delete']."' ");
		}
		//insert action
		insert_action("logs","delete",$_POST['delete']);
	}
	$p = pagination("SELECT * FROM system_logs WHERE status!=1 ORDER BY id DESC",$path,20);
}else if($actual_link=="/".ADMIN_FOLDER."/".$_GET['lang']."/table/navigation".$ax){
	if(isset($_POST['delete'])){
		$sel = mysql_query("SELECT type,menu_type,cat_id,position FROM website_menu WHERE idx=".(int)$_POST['delete']." AND langs='ka' ORDER BY position ASC ");
		$ro = mysql_fetch_array($sel);
		$menu_type = $ro['menu_type'];
		$position = $ro['position'];
		$rocat_id = $ro['cat_id'];
		$typex = $ro['type'];
		$ccc = mysql_query("SELECT `id` FROM `website_menu` WHERE `cat_id`=".(int)$_POST['delete']." AND `status`!=1 ");
		if(!mysql_num_rows($ccc))
		{// if navigation not has sub category
			if($typex=="news"){
				$delete_news = mysql_query("UPDATE `website_news`,`website_news_attachment` SET `website_news`.`status`=1 WHERE `website_news_attachment`.`connect_id`='".(int)$_GET['delete']."' AND `website_news_attachment`.`news_idx`=`website_news`.`idx`  ");
			}else if($typex=="catalog"){
				$delete_catalog = mysql_query("UPDATE `website_catalogs`,`website_catalogs_attachment` SET `website_catalogs`.`status`=1 WHERE `website_catalogs_attachment`.`connect_id`='".(int)$_GET['delete']."' AND `website_catalogs_attachment`.`catalog_id`=`website_catalogs`.`idx` ");
			}else if($typex=="gallery"){
				$delete_catalog = mysql_query("UPDATE `website_gallery`,`website_gallery_attachment` SET `website_gallery`.`status`=1 WHERE `website_gallery_attachment`.`connect_id`='".(int)$_GET['delete']."' AND `website_gallery_attachment`.`gallery_idx`=`website_gallery`.`idx` ");
			}
			$update_admin_remove = mysql_query("UPDATE website_menu SET status=1 WHERE idx=".(int)$_POST['delete']." AND cat_id='".(int)$rocat_id."' ");
			$update_positions = mysql_query("UPDATE `website_menu` SET `position`=`position`-1 WHERE `position`>'".(int)$position."' AND `menu_type`='".(int)$menu_type."' AND cat_id='".(int)$rocat_id."' ");
			//insert action
			insert_action("navigation","delete",$_POST['delete']);
		}else{
			// echo "Yes =====================";
		}
	}
	if(isset($_POST["archive_idx"],$_POST["archive_command"])){
		$in = ($_POST["archive_command"]=="in") ? 1 : 0;
		$update_visibility = mysql_query("UPDATE `website_menu` SET `show`='".(int)$in."' WHERE `idx`='".(int)$_POST["archive_idx"]."' ");
	}
	$p = pagination("SELECT `id`,`idx`,`url`,`title`,`text`,`menu_type`,`cat_id`,`type`,`position`,`show` FROM `website_menu` WHERE `status`!=1 AND `menu_type`=1 AND `visibility`!=1 AND `langs`='".$_GET['lang']."' ORDER BY `position` ASC",$path,100);
}else if($actual_link=="/".ADMIN_FOLDER."/".$_GET['lang']."/table/gallery".$ax){
	if(isset($_POST['delete'])){
		$delete = explode(",",$_POST['delete']);
		if(count($delete) > 1){
			$update_admin_remove = mysql_query("UPDATE website_gallery SET status=1 WHERE idx IN (".$_POST['delete'].") ");
		}else{
			$update_admin_remove = mysql_query("UPDATE website_gallery SET status=1 WHERE idx ='".(int)$_POST['delete']."' ");
		}
		insert_action("gallery","delete gallery",$_POST['delete']);
	}
	if(isset($_POST["whereto"],$_POST["search"])){ 
		$s = ''; 
		if($_POST["whereto"]=='idx'){ $s = " AND `website_gallery`.`idx`='".(int)$_POST["search"]."' "; }
		else{ $s = " AND `website_gallery`.`name` LIKE '%".mysql_real_escape_string($_POST["search"])."%' ";  }
	}
	$sql = "
	SELECT 
	`website_gallery`.`id` AS w_id, 
	`website_gallery`.`idx` AS w_idx, 
	`website_gallery`.`date` AS w_date, 
	`website_gallery`.`name` AS w_name, 
	`website_gallery_attachment`.`idx` AS wga_idx, 
	`website_gallery_attachment`.`type` AS wga_type
	FROM 
	`website_gallery`, `website_gallery_attachment` 
	WHERE 
	`website_gallery`.`langs` = '".strip($_GET['lang'])."' AND 
	`website_gallery`.`status` != 1 AND 
	`website_gallery`.`idx`= `website_gallery_attachment`.`gallery_idx` AND 
	`website_gallery_attachment`.`langs` = '".strip($_GET['lang'])."' $s
	ORDER BY `website_gallery_attachment`.`id` DESC 
	";
	$p = pagination($sql,$path,10);
}else if($actual_link=="/".ADMIN_FOLDER."/".$_GET['lang']."/table/text".$ax){
	if(isset($_POST["whereto"],$_POST["search"])){ 
		$s = ''; 
		if($_POST["whereto"]=='text'){ $s = " AND `title` LIKE '%".mysql_real_escape_string($_POST["search"])."%' "; }
		else{ $s = " AND `url` LIKE '%".mysql_real_escape_string($_POST["search"])."%' ";  }
	}
	$p = pagination("SELECT `title`,`url`,`idx` FROM `website_menu` WHERE `status`!=1 AND `type`='text' AND `idx`<>1 AND `langs`='".strip($_GET['lang'])."' $s ORDER BY `title` ASC",$path,20);
}else if($actual_link=="/".ADMIN_FOLDER."/".$_GET['lang']."/table/photo".$ax || $actual_link=="/".ADMIN_FOLDER."/".$_GET['lang']."/table/photo".$ax2){
	$actual_link = $_SERVER['REQUEST_URI'];
	$path = $_GET['lang']."/table/photo/".$_GET['gallery_id']."/pn/";
	$sql = "SELECT 
	`website_gallery_photos`.`id` AS wgp_id, 
	`website_gallery_photos`.`idx` AS wgp_idx, 
	`website_gallery_photos`.`photo` AS wgp_photo, 
	`website_gallery_photos`.`position` AS wgp_position 
	FROM `website_gallery`, `website_gallery_photos`
	WHERE 
	`website_gallery`.`idx`='".(int)$_GET['gallery_id']."' AND 
	`website_gallery`.`langs`='".strip($_GET['lang'])."' AND 
	`website_gallery`.`status`!=1 AND 
	`website_gallery`.`idx`=`website_gallery_photos`.`gallery_id` AND 
	`website_gallery_photos`.`langs`='".strip($_GET['lang'])."' AND 
	`website_gallery_photos`.`status`!='1' 
	ORDER BY `website_gallery_photos`.`position` ASC
	";
	$p = pagination($sql,$path,10);
}else if($actual_link=="/".ADMIN_FOLDER."/".$_GET['lang']."/table/news".$ax){
	if(isset($_POST['delete'])){
		$delete = explode(",",$_POST['delete']);
		if(count($delete) > 1){
			$update_admin_remove = mysql_query("UPDATE `website_news` SET status=1 WHERE idx IN (".$_POST['delete'].") ");
		}else{
			$update_admin_remove = mysql_query("UPDATE `website_news` SET status=1 WHERE idx ='".(int)$_POST['delete']."' ");
		}
		insert_action("news","delete news",$_POST['delete']);
	}
	$sql = "
	SELECT 
	`website_news`.`id` AS n_id, 
	`website_news`.`date` AS n_date, 
	`website_news`.`news_category` AS n_category, 
	`website_news_attachment`.`idx` AS wna_idx 
	FROM 
	`website_menu`, `website_news_attachment`, `website_news`
	WHERE 
	`website_menu`.`status`!=1 AND  
	`website_menu`.`langs`= '".strip($_GET['lang'])."' AND 
	`website_news_attachment`.`connect_id`=`website_menu`.`idx` AND 
	`website_news_attachment`.`langs` = '".strip($_GET['lang'])."' AND 
	`website_news_attachment`.`news_idx` = `website_news`.`idx` AND 
	`website_news`.`langs` = '".strip($_GET['lang'])."' AND 
	`website_news`.`status` != 1 ORDER BY `website_news_attachment`.`id` DESC
	";
	$p = pagination($sql,$path,20);
}else if($actual_link=="/".ADMIN_FOLDER."/".$_GET['lang']."/table/newsItem".$ax || $actual_link=="/".ADMIN_FOLDER."/".$_GET['lang']."/table/newsItem".$ax2){
	$actual_link = $_SERVER['REQUEST_URI'];
	$path = $_GET['lang']."/table/newsItem/".$_GET['gallery_id']."/pn/";
	
	if(isset($_POST['delete'])){
		$delete = explode(",",$_POST['delete']);
		if(count($delete) > 1){
			$update_admin_remove = mysql_query("UPDATE `website_news_items` SET status=1 WHERE idx IN (".$_POST['delete'].") ");
		}else{
			$update_admin_remove = mysql_query("UPDATE `website_news_items` SET status=1 WHERE idx ='".(int)$_POST['delete']."' ");
		}
		insert_action("news","delete news item",$_POST['delete']);
	}
	if(isset($_POST["whereto"],$_POST["search"])){ 
		$s = ''; 
		if($_POST["whereto"]=='idx'){ $s = " AND `website_news_items`.`idx`='".(int)$_POST["search"]."' "; }
		else{ $s = " AND `website_news_items`.`title` LIKE '%".mysql_real_escape_string($_POST["search"])."%' ";  }
	}
	$sql = "SELECT 
	`website_news_items`.`id` AS wni_id, 
	`website_news_items`.`idx` AS wni_idx, 
	`website_news_items`.`date` AS wni_date, 
	`website_news_items`.`title` AS wni_title 
	FROM `website_news_items`
	WHERE 
	`website_news_items`.`news_idx`='".(int)$_GET['gallery_id']."' AND 
	`website_news_items`.`langs`='".strip($_GET['lang'])."' AND 
	`website_news_items`.`status`!='1' $s
	ORDER BY `website_news_items`.`date` DESC
	";
	$p = pagination($sql,$path,20);
}else if($actual_link=="/".ADMIN_FOLDER."/".$_GET['lang']."/table/catalogs".$ax){
	if(isset($_POST['delete'])){
		$delete = explode(",",$_POST['delete']);
		if(count($delete) > 1){
			$update_admin_remove = mysql_query("UPDATE `website_catalogs` SET status=1 WHERE idx IN (".$_POST['delete'].") ");
		}else{
			$update_admin_remove = mysql_query("UPDATE `website_catalogs` SET status=1 WHERE idx ='".(int)$_POST['delete']."' ");
		}
		insert_action("catalog","delete catalog",$_POST['delete']);
	}
	$sql = "
	SELECT 
	`website_catalogs`.`id` AS n_id, 
	`website_catalogs`.`date` AS n_date, 
	`website_catalogs`.`category` AS n_category, 
	`website_catalogs_attachment`.`idx` AS wna_idx 
	FROM 
	`website_menu`,`website_catalogs_attachment`, `website_catalogs` 
	WHERE 
	`website_menu`.`type`='catalog' AND 
	`website_menu`.`langs` = '".strip($_GET['lang'])."' AND 
	`website_menu`.`status`!=1 AND 
	`website_catalogs_attachment`.`connect_id`=`website_menu`.`idx` AND 
	`website_catalogs_attachment`.`langs` = '".strip($_GET['lang'])."' AND 
	`website_catalogs_attachment`.`catalog_id` = `website_catalogs`.`idx` AND 
	`website_catalogs`.`langs` = '".strip($_GET['lang'])."' AND 
	`website_catalogs`.`status` != 1 ORDER BY `website_catalogs_attachment`.`id` DESC
	";
	$p = pagination($sql,$path,20);
}else if($actual_link=="/".ADMIN_FOLDER."/".$_GET['lang']."/table/categoryItem".$ax || $actual_link=="/".ADMIN_FOLDER."/".$_GET['lang']."/table/categoryItem".$ax2){
	$actual_link = $_SERVER['REQUEST_URI'];	
	$path = $_GET['lang']."/table/categoryItem/".$_GET['gallery_id']."/pn/";
	
	if(isset($_POST['delete'])){
		$delete = explode(",",$_POST['delete']);
		if(count($delete) > 1){
			$update_admin_remove = mysql_query("UPDATE `website_catalogs_items` SET status=1 WHERE idx IN (".$_POST['delete'].") ");
		}else{
			$update_admin_remove = mysql_query("UPDATE `website_catalogs_items` SET status=1 WHERE idx ='".(int)$_POST['delete']."' ");
		}
		insert_action("catalog","delete catalog item",$_POST['delete']);
	}
	
	if(isset($_POST["whereto"],$_POST["search"])){ 
		$s = ''; 
		if($_POST["whereto"]=='idx'){ $s = " AND `website_catalogs_items`.`idx`='".(int)$_POST["search"]."' "; }
		else{ $s = " AND `website_catalogs_items`.`namelname` LIKE '%".mysql_real_escape_string($_POST["search"])."%' ";  }
	}
	$sql = "SELECT 
	`website_catalogs_items`.`id` AS wni_id, 
	`website_catalogs_items`.`idx` AS wni_idx, 
	`website_catalogs_items`.`startjob` AS wni_startjob, 
	`website_catalogs_items`.`p_title` AS wni_title, 
	`website_catalogs_items`.`p_client` AS wni_client, 
	`website_catalogs_items`.`p_type` AS wni_type, 
	`website_catalogs_items`.`namelname` AS wni_namelname 
	FROM `website_catalogs_items`
	WHERE 
	`website_catalogs_items`.`catalog_id`='".(int)$_GET['gallery_id']."' AND 
	`website_catalogs_items`.`langs`='".strip($_GET['lang'])."' AND 
	`website_catalogs_items`.`status`!='1' $s
	ORDER BY `website_catalogs_items`.`idx` DESC
	";
	$p = pagination($sql,$path,20);
}else if($actual_link=="/".ADMIN_FOLDER."/".$_GET['lang']."/table/invisiable".$ax){
	
	if(isset($_POST['delete'])){
		$delete = explode(",",$_POST['delete']);
		if(count($delete) > 1){
			$update_admin_remove = mysql_query("UPDATE `website_menu` SET status=1 WHERE idx IN (".$_POST['delete'].") ");
		}else{
			$update_admin_remove = mysql_query("UPDATE `website_menu` SET status=1 WHERE idx ='".(int)$_POST['delete']."' ");
		}
		insert_action("invisiable","delete",$_POST['delete']);
	}
	if(isset($_POST["whereto"],$_POST["search"])){ 
		$s = ''; 
		if($_POST["whereto"]=='url'){ $s = " AND `url` LIKE '%".mysql_real_escape_string($_POST["search"])."%' "; }
		else{ $s = " AND `title` LIKE '%".mysql_real_escape_string($_POST["search"])."%' ";  }
	}
	$p = pagination("SELECT `title`,`url`,`idx`,`type` FROM `website_menu` WHERE `status`!=1 AND `visibility`=1 AND `langs`='".strip($_GET['lang'])."' AND `type`!='public' $s ORDER BY `title` ASC",$path,10);
}else if($actual_link=="/".ADMIN_FOLDER."/".$_GET['lang']."/table/youtubeChannels".$ax){
	$path = $_GET['lang']."/table/youtubeChannels/".$_GET['gallery_id']."/pn/";
	if(isset($_POST['delete'])){
		$delete = explode(",",$_POST['delete']);
		if(count($delete) > 1){
			$update_admin_remove = mysql_query("UPDATE `website_youtube` SET status=1 WHERE id IN (".$_POST['delete'].") ");
		}else{
			$update_admin_remove = mysql_query("UPDATE `website_youtube` SET status=1 WHERE id='".(int)$_POST['delete']."' ");
		}
		insert_action("youtube","delete channel",$_POST['delete']);
	}
	$p = pagination("SELECT `id`,`channel_name`,`channel_link`,`email` FROM `website_youtube` WHERE `status`!=1 ORDER BY `id` DESC",$path,20);
}else if($actual_link=="/".ADMIN_FOLDER."/".$_GET['lang']."/table/youtubeVideos".$ax){
	$path = $_GET['lang']."/table/youtubeVideos/".$_GET['gallery_id']."pn/";
	if(isset($_POST['delete'])){
		$delete = explode(",",$_POST['delete']);
		if(count($delete) > 1){
			$update_admin_remove = mysql_query("UPDATE `website_youtube_videos` SET status=1 WHERE id IN (".$_POST['delete'].") ");
		}else{
			$update_admin_remove = mysql_query("UPDATE `website_youtube_videos` SET status=1 WHERE id='".(int)$_POST['delete']."' ");
		}
		insert_action("youtube","delete videos",$_POST['delete']);
	}
	$p = pagination("SELECT `id`,`title`,`category`,`video_link`,`channel_id`,`upload_status` FROM `website_youtube_videos` WHERE `status`!=1 ORDER BY `id` DESC",$path,20);
}else if($actual_link=="/".ADMIN_FOLDER."/".$_GET['lang']."/table/banners".$ax){
	if(isset($_POST['delete']))
	{
		$sel = mysql_query("SELECT `position` FROM `website_banners` WHERE `idx`=".(int)$_POST['delete']." ");
		$ro = mysql_fetch_array($sel);
		$position = $ro['position'];
		$update_positions = mysql_query("UPDATE `website_banners` SET `position`=`position`-1 WHERE `position`>'".(int)$position."' ");
		$update_admin_remove = mysql_query("UPDATE `website_banners` SET `status`=1 WHERE `idx`=".(int)$_POST['delete']." ");
		insert_action("banners","delete",$_POST['delete']);
	}
	
	$p = pagination("SELECT `id`,`idx`,`date`,`title`,`banner_type`,`url`,`position` FROM `website_banners` WHERE `status`!=1 AND `langs`='".strip($_GET["lang"])."' ORDER BY position ASC",$path,100);
}else if($actual_link=="/".ADMIN_FOLDER."/".$_GET['lang']."/table/languages".$ax){
	if(isset($_POST['delete']))
	{
		$sel = mysql_query("SELECT `shortname` FROM `website_languages` WHERE id=".(int)$_POST['delete']." AND `shortname`!='".mysql_real_escape_string(MAIN_LANGUAGE)."' ");
		if(mysql_num_rows($sel))
		{
			$ro = mysql_fetch_array($sel);
			delete_language_items("contactus",$ro["shortname"]);
			delete_language_items("plain_text",$ro["shortname"]);
			delete_language_items("website_catalogs",$ro["shortname"]);
			delete_language_items("website_catalogs_attachment",$ro["shortname"]);
			delete_language_items("website_catalogs_items",$ro["shortname"]);
			delete_language_items("website_gallery",$ro["shortname"]);
			delete_language_items("website_gallery_attachment",$ro["shortname"]);
			delete_language_items("website_gallery_photos",$ro["shortname"]);
			delete_language_items("website_menu",$ro["shortname"]);
			delete_language_items("website_news",$ro["shortname"]);
			delete_language_items("website_news_attachment",$ro["shortname"]);
			delete_language_items("website_news_items",$ro["shortname"]);
			delete_language_items("website_slider",$ro["shortname"]);
			delete_language_items("website_charts",$ro["shortname"]);
			delete_language_items("website_charts_items",$ro["shortname"]);
			delete_language_items("website_banners",$ro["shortname"]);
			delete_language_items("website_poll",$ro["shortname"]);
			delete_language_items("website_poll_answers",$ro["shortname"]);
			
			$delete = mysql_query("DELETE FROM `website_languages` WHERE `id`='".(int)$_POST["delete"]."' AND `shortname`!='".mysql_real_escape_string(MAIN_LANGUAGE)."' ");
			//insert action
			insert_action("language","delete",$_POST["delete"]);
			$select_languages = select_languages();
			foreach($select_languages["language"] as $language){
				l("add",$language);
			}
		}
	}
	if(isset($_POST['visibility_id'],$_POST['visibility_command'])){
		$v = ($_POST['visibility_command']=="in") ? 1 : 0;
		$update = mysql_query("UPDATE `website_languages` SET `visibility`='".(int)$v."' WHERE `id`='".(int)$_POST['visibility_id']."' ");
		insert_action("language","visibility change",$_POST['visibility_id']);
	}
	
	$p = pagination("SELECT `id`,`outname`,`shortname`,`img`,`visibility`,`status` FROM `website_languages` WHERE `status`!=1",$path,100);
}else if($actual_link=="/".ADMIN_FOLDER."/".$_GET['lang']."/table/vars".$ax){
	if(isset($_POST['delete'])){
		$delete = explode(",",$_POST['delete']);
		if(count($delete) > 1){
			$update_admin_remove = mysql_query("UPDATE `plain_text` SET status=1 WHERE idx IN (".mysql_real_escape_string(str_replace("undefined","0",$_POST['delete'])).") ");
		}else{
			$update_admin_remove = mysql_query("UPDATE `plain_text` SET status=1 WHERE idx='".(int)$_POST['delete']."' ");
		}
		//insert action
		insert_action("vars","delete",$_POST['delete']);
		$select_languages = select_languages();
		$path = "cache/*";
		claerFolder($path);
		foreach($select_languages["language"] as $langs){
			l("add",$langs);
		}
	}
	if(isset($_POST["where"],$_POST["search_val"]) && !empty($_POST["where"]) && !empty($_POST["search_val"]) && strlen($_POST["search_val"]) > 3 ){
		$where = ($_POST["where"]=="variable") ? 'variable' : 'text';
		$p = pagination("SELECT `idx`,`variable`,`text` FROM `plain_text` WHERE `".strip($where)."` LIKE '%".strip($_POST["search_val"])."%' AND `status`!=1 AND langs='".strip($_GET['lang'])."' ORDER BY idx DESC",$path,100);
	}else{
		$p = pagination("SELECT `idx`,`variable`,`text` FROM `plain_text` WHERE `status`!=1 AND langs='".strip($_GET['lang'])."' ORDER BY idx DESC",$path,20);
	}
}else if($actual_link=="/".ADMIN_FOLDER."/".$_GET['lang']."/table/polls".$ax){
	if(isset($_POST['delete']))
	{
		$remove = mysql_query("UPDATE `website_poll` SET `status`=1 WHERE `type`='q' AND idx=".(int)$_POST['delete']." ");
		insert_action("polls","delete",$_POST['delete']);
	}
	$p = pagination("SELECT `idx`,`title` FROM `website_poll` WHERE `type`='q' AND `langs`='".strip($_GET['lang'])."' AND `status`!=1 ORDER BY idx DESC",$path,20);
}else if($actual_link=="/".ADMIN_FOLDER."/".$_GET['lang']."/table/backup".$ax){
	if(isset($_POST['delete']))
	{
		$remove = mysql_query("UPDATE `website_backup` SET `status`=1 WHERE `id`=".(int)$_POST['delete']." ");
		$select_file = mysql_query("SELECT `type`, `filename` FROM `website_backup` WHERE `id`=".(int)$_POST['delete']." ");
		$rfile = mysql_fetch_array($select_file);
		$xfile = "_backup/".$rfile['type']."/".$rfile['filename'];
		if($remove){ unlink($xfile); }
		insert_action("backup","delete",$_POST['delete']);
	}
	$p = pagination("SELECT `id`,`title`,`type`,`filename`,`croned` FROM `website_backup` WHERE `status`!=1 ORDER BY id DESC",$path,20);
}else if($actual_link=="/".ADMIN_FOLDER."/".$_GET['lang']."/table/actions".$ax){
	if(isset($_POST['date']))
	{
		$date = explode("/",$_POST['date']);
		$d = $date[2]."-".$date[1]."-".$date[0];		
		$d = (int)strtotime($d);
		$start = $d - 43200; // start day
		$end = $d + 43200; // end day
		
		$s = 'AND `date` > "'.$start.'" AND `date` < "'.$end.'" ';
	}else{ $s=''; }
	$p = pagination("SELECT `id`,`date`,`type`,`admin_id`,`ip` FROM `website_actions` WHERE `status`!=1 $s ORDER BY id DESC",$path,20);
}else if($actual_link=="/".ADMIN_FOLDER."/".$_GET['lang']."/table/charts".$ax){
	$path = $_GET['lang']."/table/charts/".$_GET['gallery_id']."/pn/";
	if(isset($_POST['delete'])){
		if(count($delete) > 1){
			$update_admin_remove = mysql_query("UPDATE `website_charts` SET `status`=1 WHERE `idx` IN (".$_POST['delete'].") ");
		}else{
			$update_admin_remove = mysql_query("UPDATE `website_charts` SET `status`=1 WHERE `idx`='".(int)$_POST['delete']."' ");
		}
		insert_action("charts","delete",$_POST['delete']);
		$sel = mysql_query("SELECT `chart_file` FROM `website_charts` WHERE `idx` IN (".$_POST['delete'].") ");
		while($un = mysql_fetch_array($sel)){
			@unlink(ROOT."_charts/".$un["chart_file"]);
		}
	}
	$p = pagination("SELECT `idx`,`chart_title`,`create_status`,`chart_file` FROM `website_charts` WHERE `status`!=1 AND `langs`='".strip($_GET["lang"])."' ORDER BY `idx` DESC",$path,20);
}else if($actual_link=="/".ADMIN_FOLDER."/".$_GET['lang']."/table/public".$ax){
	if(isset($_POST['delete'])){
		$delete = explode(",",$_POST['delete']);
		if(count($delete) > 1){
			$update_admin_remove = mysql_query("UPDATE `website_public` SET status=1 WHERE idx IN (".$_POST['delete'].") ");
		}else{
			$update_admin_remove = mysql_query("UPDATE `website_public` SET status=1 WHERE idx ='".(int)$_POST['delete']."' ");
		}
		insert_action("public","delete public",$_POST['delete']);
	}
	if(isset($_POST["whereto"],$_POST["search"])){ 
		$s = ''; 
		if($_POST["whereto"]=='idx'){ $s = " AND `website_public`.`idx`='".(int)$_POST["search"]."' "; }
		else{ $s = " AND `website_public`.`name` LIKE '%".mysql_real_escape_string($_POST["search"])."%' ";  }
	}
	$sql = "
	SELECT 
	`website_public`.`id` AS n_id, 
	`website_public`.`idx` AS n_idx, 
	`website_public`.`date` AS n_date, 
	`website_public`.`name` AS n_name, 
	`website_public_attachment`.`idx` AS wna_idx, 
	`website_menu`.`idx` AS wm_idx, 
	`website_menu`.`title` AS wm_title, 
	`website_menu`.`url` AS wm_url
	FROM 
	`website_menu`,`website_public_attachment`, `website_public` 
	WHERE 
	`website_menu`.`type`='public' AND 
	`website_menu`.`langs` = '".strip($_GET['lang'])."' AND 
	`website_menu`.`status`!=1 AND 
	`website_public_attachment`.`connect_id`=`website_menu`.`idx` AND 
	`website_public_attachment`.`langs` = '".strip($_GET['lang'])."' AND 
	`website_public_attachment`.`public_id` = `website_public`.`idx` AND 
	`website_public`.`langs` = '".strip($_GET['lang'])."' AND 
	`website_public`.`status` != 1 $s ORDER BY `website_public_attachment`.`id` DESC
	";
	$p = pagination($sql,$path,20);
}else if($actual_link=="/".ADMIN_FOLDER."/".$_GET['lang']."/table/publicFiles".$ax || $actual_link=="/".ADMIN_FOLDER."/".$_GET['lang']."/table/publicFiles".$ax2){
	$actual_link = $_SERVER['REQUEST_URI'];	
	$path = $_GET['lang']."/table/publicFiles/".$_GET['gallery_id']."/pn/";
	
	if(isset($_POST['delete'])){
		$delete = explode(",",$_POST['delete']);
		if(count($delete) > 1){
			$update_admin_remove = mysql_query("UPDATE `website_public_files` SET status=1 WHERE idx IN (".$_POST['delete'].") ");
		}else{
			$update_admin_remove = mysql_query("UPDATE `website_public_files` SET status=1 WHERE idx ='".(int)$_POST['delete']."' ");
		}
		insert_action("public","delete public item",$_POST['delete']);
	}
	
	if(isset($_POST["archive_idx"])){
		$in = ($_POST["archive_command"]=="archived") ? 1 : 2;
		$update_visibility = mysql_query("UPDATE `website_public_files` SET `archive`='".(int)$in."' WHERE `idx`='".(int)$_POST["archive_idx"]."' ");
	}
	
	if(isset($_POST["whereto"],$_POST["search"])){ 
		$s = ''; 
		if($_POST["whereto"]=='idx'){ $s = " AND `idx`='".(int)$_POST["search"]."' "; }
		else{ $s = " AND `name` LIKE '%".mysql_real_escape_string($_POST["search"])."%' ";  }
	}
	
	$sql = "SELECT 
	`id`, `idx`, `date`, `name`, `file_name`, `archive`
	FROM `website_public_files`
	WHERE 
	`public_id`='".(int)$_GET['gallery_id']."' AND 
	`langs`='".strip($_GET['lang'])."' AND 
	`status`!='1' $s 
	ORDER BY `date` DESC 
	";
	$p = pagination($sql,$path,20);
}else if($actual_link=="/".ADMIN_FOLDER."/".$_GET['lang']."/table/socialnetworks".$ax){
	$path = $_GET['lang']."/table/socialnetworks/pn/";
	$p = pagination("SELECT `id`,`name`,`var`,`url`,`access_admins` FROM `website_social` ORDER BY `id` DESC",$path,20);
}

?>