<?php

class module {
 
    function __construct() {
        //database
        $url = filter_input(INPUT_GET, "url");
        $rtrim = rtrim($url, "/");
        $explode = explode("/", $rtrim);
    }
	
	public function get_slide_array()
	{
		$out = array();
		$select = mysql_query("SELECT `date`,`title`,`text`,`gotourl`,`slidetype`,`url_target`,`image` FROM `website_slider` WHERE `status`!=1 AND `langs`='".mysql_real_escape_string($_GET['lang'])."' ORDER BY `position` ASC ");
		while($rows = mysql_fetch_array($select))
		{
			$out['date'][] = $rows['date'];
			$out['title'][] = strip_tags($rows['title']);
			$out['text'][] = strip_tags($rows['text']);
			$out['gotourl'][] = str_replace(" ","-",$rows['gotourl']);
			$out['url_target'][] = $rows['url_target'];
			$out['slidetype'][] = $rows['slidetype'];
			$out['image'][] = $rows['image'];
		}
		return $out;
	} 
	
	public function main_navigation()
	{
		$sql = "SELECT idx,title,url FROM `website_menu` WHERE `menu_type`=1 AND `langs`='".mysql_real_escape_string($_GET['lang'])."' AND `visibility`!=1 AND `status`!=1 AND `show`!=1 ORDER BY `position` ASC";
		$query = mysql_query($sql);
		if(mysql_num_rows($query)){
			$out = $query;
		}else{
			$out = null;
		}
		return $out;
	}
	
	public function get_page_type($url)
	{
		$sql = "SELECT `type` FROM `website_menu` WHERE `status`!=1 AND `langs`='".mysql_real_escape_string($_GET['lang'])."' AND `url`='".mysql_real_escape_string($url)."' ";
		$query = mysql_query($sql);
		if(mysql_num_rows($query)){
			$rows = mysql_fetch_array($query);	
			$out = $rows['type'];
		}else{
			$out = '';
		}
		return $out;
	}
	
	public function contact_info()
	{
		$sql = "SELECT * FROM contactus WHERE langs='".mysql_real_escape_string($_GET['lang'])."' ";
		$query = mysql_query($sql);
		if(mysql_num_rows($query))
		{
			$rows = mysql_fetch_array($query);
		}else{
			$rows ="";
		}
		return $rows;
	}
	
	public function content($column)
	{	
		$current_url = $_GET['lang']."/".$_GET['url'];
		$sql = "SELECT `".$column."` FROM `website_menu` WHERE `status`!=1 AND `langs`='".mysql_real_escape_string($_GET['lang'])."' AND `url`='".mysql_real_escape_string($current_url)."' ";
		$query = mysql_query($sql);
		if(mysql_num_rows($query))
		{
			$rows = mysql_fetch_array($query);
			$out=$rows[$column];
		}else{
			$out = "";
		}
		return $out;
	}
	
	public function get_right_menu()
	{
        $explode = explode("/", URL);
		$search_url = $_GET['lang']."/".$explode[0];
		$sql = "SELECT idx FROM `website_menu` WHERE `url`='".mysql_real_escape_string($search_url)."' AND `langs`='".mysql_real_escape_string($_GET['lang'])."' AND `visibility`!=1 AND `show`!=1 AND `status`!=1 ORDER BY `position` ASC";
		$query = mysql_query($sql);
		if(mysql_num_rows($query)){
			$rows = mysql_fetch_array($query);
			
			$sql2 = "SELECT `idx`,`title`,`url` FROM `website_menu` WHERE `cat_id`='".(int)$rows['idx']."' AND `langs`='".mysql_real_escape_string($_GET['lang'])."' AND `visibility`!=1 AND `show`!=1 AND `status`!=1 ORDER BY `position` ASC";
			$query2 = mysql_query($sql2);
			if(mysql_num_rows($query2))
			{
				$out = $query2;
			}else{
				$out = false;
			}
		}else{
			$out = false;
		}
		return $out;
	}
	
		public function pagination($sql,$path,$itemsPerPage)
		{
			$out = array();
			$select = mysql_query($sql);
			$nr = mysql_num_rows($select);
			if($nr){  
				if(isset($_GET['pn'])){	
					$pn = preg_replace('#[^0-9]#i','',$_GET['pn']);
				}
				else{
					$pn = 1;
				}	
				$lastPage = ceil($nr / $itemsPerPage);
				if($pn < 1){
					$pn = 1;
				}
				else if($pn > $lastPage){
					$pn = $lastPage;	
				}	
				$centerPages = '';
				$sub1 = $pn-1; // 0
				$sub2 = $pn-2; // -1
				$add1 = $pn+1; // 2
				$add2 = $pn+2; // 3	
				if($pn==1){
					$centerPages .= '<li><a href="javascript:void(0)" class="active">'.$pn.'</a></li>';
					$centerPages .= '<li><a href="'.$path.$add1.'" class="bluBG">'.$add1.'</a></li>';
				}
				else if($pn == $lastPage){
					$centerPages .= '<li><a href="'.$path.$sub1.'" class="bluBG">'.$sub1.'</a></li>';
					$centerPages .= '<li><a href="javascript:void(0)" class="active">'.$pn.'</a></li>';
				}
				else if($pn > 2 && $pn < ($lastPage-1)){
					$centerPages .= '<li><a href="'.$path.$sub2.'" class="bluBG">'.$sub2.'</a></li>';
					$centerPages .= '<li><a href="'.$path.$sub1.'" class="bluBG">'.$sub1.'</a></li>';
					$centerPages .= '<li><a href="javascript:void(0)" class="active">'.$pn.'</a></li>';
					$centerPages .= '<li><a href="'.$path.$add1.'" class="bluBG">'.$add1.'</a></li>';
					$centerPages .= '<li><a href="'.$path.$add2.'" class="bluBG">'.$add2.'</a></li>';
				}
				else if($pn > 1 && $pn < $lastPage){
					$centerPages .= '<li><a href="'.$path.$sub1.'" class="bluBG">'.$sub1.'</a></li>';
					$centerPages .= '<li><a href="javascript:void(0)" class="active">'.$pn.'</a></li>';
					$centerPages .= '<li><a href="'.$path.$add1.'" class="bluBG">'.$add1.'</a></li>';
				}
				$limit = 'LIMIT '.($pn-1)*$itemsPerPage.','.$itemsPerPage;
				if($nr > 0)
				{
					$out[0] = $sql." $limit";
				}
				$paginationDisplay = '<ul class="pagination">';
				if($lastPage != 1){
					//$paginationDisplay1 = '<font id="texti">გვერდი: <strong>'.$pn.'</strong> სულ: '.$lastPage.' </font>';
				}
				if($pn != 1){
					$previous = $pn-1;
					$paginationDisplay .= '<li><a href="'.$path.'1" class="bluBG">'.htmlentities("<<").'</a></li>';
					$paginationDisplay .= '<li><a id="back" href="'.$path.$previous.'" class="bluBG">'.htmlentities("<").'</a></li>';
				}
				$paginationDisplay .= $centerPages;
				if($pn != $lastPage){
					$nextPage = $pn+1;
					$paginationDisplay .= '<li><a id="next" href="'.$path.$nextPage.'" class="bluBG">'.htmlentities(">").'</a></li>';
					$paginationDisplay .= '<li><a href="'.$path.$lastPage.'" class="bluBG">'.htmlentities(">>").'</a></li>';
				}
				$outputList = $paginationDisplay."</ul>";
				if($nr <= $itemsPerPage)
				{
					$outputList = "";
				}
				$n=1;
				$out[1]=$outputList;
				$out[2]=$nr;
			}
			return $out;
		}
	
	public function news_page()
	{
		$explode = explode("/", URL);
		$search_url = $_GET['lang']."/".$explode[0];
		if(isset($_GET['day'],$_GET['month'],$_GET['year'])){
			$totime = $_GET['month']."/".$_GET['day']."/".$_GET["year"];
			$to_date = ' AND `website_news_items`.`date`= "'.(int)strtotime($totime).'" ';
		}else{ $to_date=''; }
		$sql = "
		SELECT 
		`website_news_items`.`idx` AS wni_idx, 
		`website_news_items`.`date` AS wni_date, 
		`website_news_items`.`news_idx` AS wni_news_idx, 
		`website_news_items`.`title` AS wni_title, 
		`website_news_items`.`short_text` AS wni_short_text, 
		`website_news_items`.`long_text` AS wni_long_text, 
		`website_news_items`.`httplink` AS wni_httplink 
		FROM 
		`website_menu`,`website_news_attachment`,`website_news`,`website_news_items`
		WHERE 
		`website_menu`.`url`='".mysql_real_escape_string($search_url)."' AND 
		`website_menu`.`langs`='".mysql_real_escape_string($_GET['lang'])."' AND 
		`website_menu`.`idx`=`website_news_attachment`.`connect_id` AND 
		`website_news_attachment`.`langs`='".mysql_real_escape_string($_GET['lang'])."' AND 
		`website_news_attachment`.`news_idx`=`website_news`.`idx` AND 
		`website_news`.`langs`='".mysql_real_escape_string($_GET['lang'])."' AND 
		`website_news`.`status`!=1 AND 
		`website_news`.`idx`=`website_news_items`.`news_idx` AND 
		`website_news_items`.`langs`='".mysql_real_escape_string($_GET['lang'])."' AND 
		`website_news_items`.`status`!=1 ".$to_date." AND 
		FROM_UNIXTIME(`website_news_items`.`date`, '%Y/%m/%d') >= '2014/07/22' 
		ORDER BY `website_news_items`.`date` DESC
		";
		$query = mysql_query($sql);
		if(mysql_num_rows($query)){
			$path = $_GET['lang']."/".$_GET['url']."/pn/";
			$out = $this->pagination($sql,$path,3);
		}else{
			$out='';
		}
		return $out;
	}
	
	public function news_page_item()
	{
		$explode = explode("/", URL);
		$search_url = $_GET['lang']."/".$explode[0];
		$news_titile = explode("-",$_GET['news_titile']);
		$sql = "
		SELECT 
		`website_news_items`.`idx` AS wni_idx, 
		`website_news_items`.`date` AS wni_date, 
		`website_news_items`.`title` AS wni_title, 
		`website_news_items`.`long_text` AS wni_long_text
		FROM 
		`website_menu`,`website_news_attachment`,`website_news`,`website_news_items`
		WHERE 
		`website_menu`.`url`='".mysql_real_escape_string($search_url)."' AND 
		`website_menu`.`langs`='".mysql_real_escape_string($_GET['lang'])."' AND 
		`website_menu`.`idx`=`website_news_attachment`.`connect_id` AND 
		`website_news_attachment`.`langs`='".mysql_real_escape_string($_GET['lang'])."' AND 
		`website_news_attachment`.`news_idx`=`website_news`.`idx` AND 
		`website_news`.`langs`='".mysql_real_escape_string($_GET['lang'])."' AND 
		`website_news`.`status`!=1 AND 
		`website_news`.`idx`=`website_news_items`.`news_idx` AND 
		`website_news_items`.`idx`='".(int)$news_titile[0]."' AND 
		`website_news_items`.`langs`='".mysql_real_escape_string($_GET['lang'])."' AND 
		`website_news_items`.`status`!=1 
		";
		$query = mysql_query($sql);
		if(mysql_num_rows($query)){
			$rows = mysql_fetch_array($query);
			$out = $rows;
		}else{
			$out="";
		}
		return $out;
	}
	
	
	public function catalog_page_item()
	{
		$explode = explode("/", URL);
		$search_url = $_GET['lang']."/".$explode[0];
		$news_titile = explode("-",$_GET['news_titile']);
		$sql = "
		SELECT 
		`website_catalogs_items`.`idx` AS wni_idx, 
		`website_catalogs_items`.`startjob` AS wni_startjob, 
		`website_catalogs_items`.`catalog_id` AS wni_catalog_id, 
		`website_catalogs_items`.`namelname` AS wni_namelname, 
		`website_catalogs_items`.`profesion` AS wni_profesion, 
		`website_catalogs_items`.`dob` AS wni_dob, 
		`website_catalogs_items`.`bornplace` AS wni_bornplace, 
		`website_catalogs_items`.`livingplace` AS wni_livingplace, 
		`website_catalogs_items`.`phonenumber` AS wni_phonenumber, 
		`website_catalogs_items`.`email` AS wni_email, 
		`website_catalogs_items`.`shortbio` AS wni_shortbio, 
		`website_catalogs_items`.`workExperience` AS wni_workExperience, 
		`website_catalogs_items`.`education` AS wni_education, 
		`website_catalogs_items`.`treinings` AS wni_treinings, 
		`website_catalogs_items`.`certificate` AS wni_certificate, 
		`website_catalogs_items`.`languages` AS wni_languages 
		FROM 
		`website_menu`,`website_catalogs_attachment`,`website_catalogs`,`website_catalogs_items`
		WHERE 
		`website_menu`.`url`='".mysql_real_escape_string($search_url)."' AND 
		`website_menu`.`langs`='".mysql_real_escape_string($_GET['lang'])."' AND 
		`website_menu`.`idx`=`website_catalogs_attachment`.`connect_id` AND 
		`website_catalogs_attachment`.`langs`='".mysql_real_escape_string($_GET['lang'])."' AND 
		`website_catalogs_attachment`.`catalog_id`=`website_catalogs`.`idx` AND 
		`website_catalogs`.`langs`='".mysql_real_escape_string($_GET['lang'])."' AND 
		`website_catalogs`.`status`!=1 AND 
		`website_catalogs`.`idx`=`website_catalogs_items`.`catalog_id` AND 
		`website_catalogs_items`.`idx`='".(int)$news_titile[0]."' AND 
		`website_catalogs_items`.`langs`='".mysql_real_escape_string($_GET['lang'])."' AND 
		`website_catalogs_items`.`status`!=1 
		";
		$query = mysql_query($sql);
		if(mysql_num_rows($query)){
			$rows = mysql_fetch_array($query);
			$out = $rows;
		}else{
			$out="";
		}
		return $out;
	}
	
	
	public function gallery_page()
	{
		$explode = explode("/", URL);
		$search_url = $_GET['lang']."/".$explode[0];
		if($explode[0]=="photoGallery"){ $type = "all"; }
		else if($explode[0]=="common"){ $type = "text"; }
		else if($explode[0]=="catalogGallery"){ $type = "catalog"; }
		if($type=="all")
		{
			$sql = "SELECT 
			`website_gallery`.`name` AS wg_name,
			`website_gallery`.`idx` AS wg_idx 
			FROM 
			`website_gallery_attachment`, `website_gallery`
			WHERE 
			`website_gallery_attachment`.`langs`='".mysql_real_escape_string($_GET['lang'])."' AND 
			`website_gallery_attachment`.`gallery_idx`=`website_gallery`.`idx` AND 
			`website_gallery_attachment`.`type`='gallery' AND 
			`website_gallery`.`langs`='".mysql_real_escape_string($_GET['lang'])."' AND 		
			`website_gallery`.`status` != 1 
			ORDER BY `website_gallery`.`date` DESC
			";
		}
		else
		{
			$sql = "SELECT 
			`website_gallery`.`name` AS wg_name,
			`website_gallery`.`idx` AS wg_idx 
			FROM 
			`website_gallery_attachment`, `website_gallery`
			WHERE 
			`website_gallery_attachment`.`langs`='".mysql_real_escape_string($_GET['lang'])."' AND 
			`website_gallery_attachment`.`gallery_idx`=`website_gallery`.`idx` AND 
			`website_gallery_attachment`.`type`='".mysql_real_escape_string($type)."' AND 
			`website_gallery`.`langs`='".mysql_real_escape_string($_GET['lang'])."' AND 		
			`website_gallery`.`status` != 1 
			ORDER BY `website_gallery`.`date` DESC
			";
		}
		$out = array();		
		$path = $_GET['lang']."/".$_GET['url']."/pn/";
		$ss = $this->pagination($sql,$path,10);
		$query = mysql_query($ss[0]);
		while($rows = mysql_fetch_array($query))
		{
			$out["url"][] = $search_url."/".$rows['wg_idx'];
			$out["name"][] = $rows['wg_name'];
			$out["wg_idx"][] = $rows['wg_idx'];
			$select = mysql_query("SELECT `photo` FROM `website_gallery_photos` WHERE `gallery_id`='".(int)$rows['wg_idx']."' AND `langs`='".mysql_real_escape_string($_GET['lang'])."' AND `status`!=1 ORDER BY `position` ASC ");
			$out["nums"][] = mysql_num_rows($select);
			if(mysql_num_rows($select)){
				$photo = mysql_fetch_array($select);
				$out["photo"][] = $photo['photo'];
			}else{
				$out["photo"][] = "";
			}
		}
		$out["pagination"] = $ss[1];
		return $out;
	}
	
	public function get_gallery_p($gallery_idx)
	{
		$sql = "
		SELECT 
		`website_gallery_photos`.`photo` AS wgp_photo, 
		`website_gallery_photos`.`title` AS wgp_title, 
		`website_gallery_photos`.`description` AS wgp_description 
		FROM 
		`website_gallery_attachment`, `website_gallery`, `website_gallery_photos` 
		WHERE 
		`website_gallery_attachment`.`gallery_idx`='".(int)$gallery_idx."' AND 
		`website_gallery_attachment`.`langs`='".mysql_real_escape_string($_GET['lang'])."' AND 
		`website_gallery_attachment`.`gallery_idx`=`website_gallery`.`idx` AND 
		`website_gallery`.`langs`='".mysql_real_escape_string($_GET['lang'])."' AND 
		`website_gallery`.`status` != 1 AND 
		`website_gallery`.`idx` = `website_gallery_photos`.`gallery_id` AND 
		`website_gallery_photos`.`langs`='".mysql_real_escape_string($_GET['lang'])."' AND 
		`website_gallery_photos`.`status` != 1 
		ORDER BY `website_gallery_photos`.`position` ASC
		";
		return $sql;
	}
	
	public function get_gallery_photos()
	{
		$sql = "
		SELECT 
		`website_gallery`.`idx` AS wg_idx, 
		`website_gallery_photos`.`photo` AS wgp_photo, 
		`website_gallery_photos`.`title` AS wgp_title, 
		`website_gallery_photos`.`description` AS wgp_description 
		FROM 
		`website_gallery_attachment`, `website_gallery`, `website_gallery_photos` 
		WHERE 
		`website_gallery_attachment`.`gallery_idx`='".(int)$_GET['news_titile']."' AND 
		`website_gallery_attachment`.`langs`='".mysql_real_escape_string($_GET['lang'])."' AND 
		`website_gallery_attachment`.`gallery_idx`=`website_gallery`.`idx` AND 
		`website_gallery`.`langs`='".mysql_real_escape_string($_GET['lang'])."' AND 
		`website_gallery`.`status` != 1 AND 
		`website_gallery`.`idx` = `website_gallery_photos`.`gallery_id` AND 
		`website_gallery_photos`.`gallery_id` = '".(int)$_GET['news_titile']."' AND 
		`website_gallery_photos`.`langs`='".mysql_real_escape_string($_GET['lang'])."' AND 
		`website_gallery_photos`.`status` != 1 
		ORDER BY `website_gallery_photos`.`position` ASC
		";
		return $sql;
	}
	
	public function main_picture($type, $cover = 1)
	{
		$explode = explode("/", URL);
		$search_url = $_GET['lang']."/".$explode[0];
		if($type=="text"){
			$sql = "
			SELECT 
			`website_gallery_photos`.`photo` AS wgp_photo, 
			`website_gallery_photos`.`title` AS wgp_title, 
			`website_gallery_photos`.`description` AS wgp_description, 
			`website_gallery`.`idx` AS wg_idx, 
			`website_menu`.`url` AS wm_url 
			FROM 
			`website_menu`, `website_gallery_attachment`, `website_gallery`, `website_gallery_photos` 
			WHERE 
			`website_menu`.`url`='".mysql_real_escape_string($search_url)."' AND 
			`website_menu`.`idx`= `website_gallery_attachment`.`connect_id` AND 
			`website_menu`.`langs`= '".mysql_real_escape_string($_GET['lang'])."' AND 
			`website_gallery_attachment`.`type`='text' AND 
			`website_gallery_attachment`.`langs`= '".mysql_real_escape_string($_GET['lang'])."' AND 
			`website_gallery_attachment`.`gallery_idx`=`website_gallery`.`idx` AND 			
			`website_gallery`.`langs`='".mysql_real_escape_string($_GET['lang'])."' AND 
			`website_gallery`.`status`!=1 AND 
			`website_gallery`.`idx`=`website_gallery_photos`.`gallery_id` AND 	
			`website_gallery_photos`.`langs`='".mysql_real_escape_string($_GET['lang'])."' AND 
			`website_gallery_photos`.`status` != 1 
			ORDER BY `website_gallery_photos`.`position` ASC
			";
		}else if($type=="news")
		{
			$news_title = explode("-",$_GET['news_titile']);
			$sql = "
			SELECT 
			CONCAT(`website_gallery_photos`.`photo`) AS wgp_photo, 
			`website_gallery_photos`.`cover` AS wg_cover, 
			`website_gallery`.`idx` AS wg_idx,
			`website_gallery_photos`.`title` AS wgp_title 
			FROM 
			`website_gallery_attachment`, `website_gallery`, `website_gallery_photos` 
			WHERE 
			`website_gallery_attachment`.`connect_id`='".(int)$news_title[0]."' AND 
			`website_gallery_attachment`.`type`='news' AND 
			`website_gallery_attachment`.`langs`= '".mysql_real_escape_string($_GET['lang'])."' AND 
			`website_gallery_attachment`.`gallery_idx`=`website_gallery`.`idx` AND 
			`website_gallery`.`idx`=`website_gallery_photos`.`gallery_id` AND 
			`website_gallery`.`langs`='".mysql_real_escape_string($_GET['lang'])."' AND 
			`website_gallery`.`status`!=1 AND 
			`website_gallery_photos`.`langs`='".mysql_real_escape_string($_GET['lang'])."' AND 
			`website_gallery_photos`.`status` != 1 
			ORDER BY `website_gallery_photos`.`position` ASC
			";

		}else if($type=="catalog")
		{
			$news_title = explode("-",$_GET['news_titile']);
			$sql = "
			SELECT 
			CONCAT(`website_gallery_photos`.`photo`) AS wgp_photo, 
			`website_gallery_photos`.`cover` AS wg_cover, 
			`website_gallery_photos`.`title` AS wgp_title, 
			`website_gallery`.`idx` AS wg_idx
			FROM 
			`website_gallery_attachment`, `website_gallery`, `website_gallery_photos` 
			WHERE 
			`website_gallery_attachment`.`connect_id`='".(int)$news_title[0]."' AND 
			`website_gallery_attachment`.`type`='catalog' AND 
			`website_gallery_attachment`.`langs`= '".mysql_real_escape_string($_GET['lang'])."' AND 
			`website_gallery_attachment`.`gallery_idx`=`website_gallery`.`idx` AND 
			`website_gallery`.`idx`=`website_gallery_photos`.`gallery_id` AND 
			`website_gallery`.`langs`='".mysql_real_escape_string($_GET['lang'])."' AND 
			`website_gallery`.`status`!=1 AND 
			`website_gallery_photos`.`langs`='".mysql_real_escape_string($_GET['lang'])."' AND 
			`website_gallery_photos`.`status` != 1 
			ORDER BY `website_gallery_photos`.`position` ASC
			";

		}
		return $sql;
	}
	
	public function get_attachs($type="text")
	{
		$explode = explode("/", URL);
		$search_url = $_GET['lang']."/".$explode[0];
		if(!$type){
			$sql = "
			SELECT 
			`website_menu`.`idx` AS wm_idx, 
			`website_menu`.`type` AS wm_type,  
			`website_files`.`outname` AS wf_outname,  
			`website_files`.`filename` AS wf_filename,  
			`website_files`.`filetype` AS wf_filetype, 
			`website_files`.`position` AS wf_fileposition 
			FROM
			`website_menu`, `website_files`
			WHERE 
			`website_menu`.`url`='".mysql_real_escape_string($search_url)."' AND 
			`website_menu`.`langs`= '".mysql_real_escape_string($_GET['lang'])."' AND 
			`website_menu`.`idx`=`website_files`.`page_idx` AND 
			`website_menu`.`type`=`website_files`.`page_type` AND 
			`website_menu`.`status`!=1 AND 
			`website_files`.`langs`= '".mysql_real_escape_string($_GET['lang'])."' AND 
			`website_files`.`status` != 1 
			ORDER BY `website_files`.`position` ASC 
			";
		}else if($type=="news"){
			$news_titile = explode("-",$_GET["news_titile"]);
			$sql = "
			SELECT 
			`website_files`.`outname` AS wf_outname,  
			`website_files`.`filename` AS wf_filename,  
			`website_files`.`filetype` AS wf_filetype,  
			`website_files`.`position` AS wf_fileposition 
			FROM
			`website_news_items`, `website_files`
			WHERE 
			`website_news_items`.`idx`='".(int)$news_titile[0]."' AND 
			`website_news_items`.`langs`= '".mysql_real_escape_string($_GET['lang'])."' AND 
			`website_files`.`page_idx`=`website_news_items`.`idx` AND 
			`website_files`.`page_type`='news' AND 
			`website_files`.`langs`= '".mysql_real_escape_string($_GET['lang'])."' AND 
			`website_files`.`status` != 1 
			ORDER BY `website_files`.`position` ASC 
			";
		}else if($type=="catalog"){
			$news_titile = explode("-",$_GET["news_titile"]);
			$sql = "
			SELECT 
			`website_files`.`outname` AS wf_outname,  
			`website_files`.`filename` AS wf_filename,  
			`website_files`.`filetype` AS wf_filetype, 
			`website_files`.`position` AS wf_fileposition  
			FROM
			`website_catalogs_items`, `website_files`
			WHERE 
			`website_catalogs_items`.`idx`='".(int)$news_titile[0]."' AND 
			`website_catalogs_items`.`langs`= '".mysql_real_escape_string($_GET['lang'])."' AND 
			`website_files`.`page_idx`=`website_catalogs_items`.`idx` AND 
			`website_files`.`page_type`='catalog' AND 
			`website_files`.`langs`= '".mysql_real_escape_string($_GET['lang'])."' AND 
			`website_files`.`status` != 1 
			ORDER BY `website_files`.`position` ASC 
			";
		}
		return $sql;
	}
	
	public function catalog_page()
	{//under constructor
		$explode = explode("/", URL);
		$search_url = $_GET['lang']."/".$explode[0];		
		$sql = "
		SELECT 
		`website_catalogs_items`.`idx` AS wni_idx, 
		`website_catalogs_items`.`namelname` AS wni_namelname, 
		`website_catalogs_items`.`profesion` AS wni_profesion, 
		`website_catalogs_items`.`education` AS wni_education, 
		`website_catalogs_items`.`shortbio` AS wni_shortbio, 
		`website_catalogs_items`.`workExperience` AS wni_workExperience
		FROM 
		`website_menu`,`website_catalogs_attachment`,`website_catalogs`,`website_catalogs_items`
		WHERE 
		`website_menu`.`url`='".mysql_real_escape_string($search_url)."' AND 
		`website_menu`.`langs`='".mysql_real_escape_string($_GET['lang'])."' AND 
		`website_menu`.`idx`=`website_catalogs_attachment`.`connect_id` AND 
		`website_catalogs_attachment`.`langs`='".mysql_real_escape_string($_GET['lang'])."' AND 
		`website_catalogs_attachment`.`catalog_id`=`website_catalogs`.`idx` AND 
		`website_catalogs`.`langs`='".mysql_real_escape_string($_GET['lang'])."' AND 
		`website_catalogs`.`status`!=1 AND 
		`website_catalogs`.`idx`=`website_catalogs_items`.`catalog_id` AND 
		`website_catalogs_items`.`langs`='".mysql_real_escape_string($_GET['lang'])."' AND 
		`website_catalogs_items`.`status`!=1 
		ORDER BY `website_catalogs_items`.`id` DESC
		";
		$path = $_GET['lang']."/".$_GET['url']."/pn/";
		$out = $this->pagination($sql,$path,10);
		return $out;
	}
	
	public function sitemap($x=0){
		$select = mysql_query("SELECT `idx`,`title`,`url` FROM `website_menu` WHERE `cat_id`='".(int)$x."' AND `langs`='".mysql_real_escape_string($_GET['lang'])."' AND `visibility`=0 AND `status`=0 ORDER BY `position` ASC ");
		if(mysql_num_rows($select))
		{
			$out = '<ul class="level_'.$x.'">';
			while($rows = mysql_fetch_array($select))
			{
				$out .= '<li><a href="'.$rows['url'].'">'.$rows['title'].'</a>';
				$out .= $this->sitemap($rows['idx']);
				$out .= '</li>';
			}
			$out .= '</ul>';
		}
		return $out;
	}
	
	public function schools()
	{
		$select = mysql_query("SELECT `meta_title`, `meta_desc`,`url` FROM `website_menu` WHERE `cat_id`=65 AND `langs`='".mysql_real_escape_string($_GET['lang'])."' AND `status`!=1 ");
		$class_array = array("librery","cafe","church");
		$image_array = array("bussinessSchool.png","medicalschool.png","itschool.png");
		$out = "";
		if(mysql_num_rows($select))
		{
			$x=0;
			$y=6;
			$url = filter_input(INPUT_GET, "url");
			$rtrim = rtrim($url, "/");
			$explode = explode("/", $rtrim);
			$active_url = $_GET['lang']."/".$explode[0];
			while($rows = mysql_fetch_array($select))
			{
				$active = ($active_url == $rows['url']) ? ' active' : '';
				$out .= '<div class="'.$class_array[$x].$active.'">';
				$out .= '<a href="'.$rows['url'].'">';
				$out .= '<img src="crop.php?img=image/homepage/'.$image_array[$x].'&width=328&height=319" width="328" height="319" alt="" />';
				$out .= '<div class="text">';
				$out .= '<h1>'.strtoupper($rows['meta_title']).'</h1>';
				$out .= '<font>'.$rows['meta_desc'].'</font>';
				$out .= '</div>';
				$out .= '<div class="number">'.$y.'</div></a></div>';					
				$x++;
				$y++;
			}
		}
		return $out;
	}
	
	public function banners($left=false)
	{
		$select = mysql_query("SELECT * FROM `website_banners` WHERE `status`!=1 AND `langs`='".$_GET["lang"]."' ORDER BY position ASC");
		$out = '';
		$nums = mysql_num_rows($select);
		if($nums)
		{
			$x=1;
			$y=1;
			$w = 1;
			$trueX = 1;
			while($rows = mysql_fetch_array($select))
			{
				if(!$left)
				{
					if($x==2){ $class = ' second'; }else{ $class=''; $x=1; }
					$out .= '<div class="banner'.$class.'">';			 
					$file = 'image/banners/'.$rows['img_name'];
					if(!file_exists($file)){ continue; }	
					if($rows["banner_type"]=="img"){
						$out .= '<img src="'.$file.'" width="65" height="40" alt="'.html_entity_decode($rows['title']).'" title="'.html_entity_decode($rows['title']).'" class="banner_image" /><a href="'.$rows['url'].'">'.html_entity_decode($rows['title']).'</a>';
					}else{
						$out .= '<a href="'.$rows['url'].'" target="_blank">
									<object height="250" width="110"><param name="movie" value="'.$file.'">
									<embed src="'.$file.'" height="110" width="250"></embed>
									</object>
								</a>';
					}
					$out .= '</div>';				
					if($y==2 && $trueX!=$nums){ $out .= '<div class="hr"></div>'; $y=1; }else{ $y=2; }
					$x++;
				}else{
					if($w==2){ $ccx=' second'; $w=1; }else{ $ccx=""; $w=2; }
					$out .= '<div class="banner'.$ccx.'">';	
					if($rows["banner_type"]=="img"){
						$file = 'image/banners/'.$rows['img_name'];
						if(!file_exists($file)){ continue; }	
						$out .= '<img src="'.$file.'" width="65" height="40" alt="'.html_entity_decode($rows['title']).'" title="'.html_entity_decode($rows['title']).'" class="banner_image" />';
						$out .= '<a href="'.$rows['url'].'">'.html_entity_decode($rows['title']).'</a>';
						$out .= '<div class="clearer"></div>';
					}
					$out .= '</div>';
				}
				$trueX++;
			}
		}		
		return $out;
	}
	
	public function _create_file_404($file,$data) {
		if(!file_exists($file))
		{
			$f=fopen($file, "wb");
			fwrite($f, $data);
			fclose($f);
		}	
	}
	
	public function show_languages()
	{
		$select = mysql_query("SELECT `outname`,`shortname`,`img`,`showname` FROM `website_languages` WHERE `status`!=1 AND `visibility`!=1 ");
		$out = "";
		if(mysql_num_rows($select) > 1){// minimum 2 language
			$out = '<ul class="choose">';			
			$ex = explode("/",$_SERVER[REQUEST_URI]);
			$count = count($ex);
			while($rows = mysql_fetch_array($select))
			{	
					if($rows["shortname"]==$_GET["lang"]){ continue; }
					$link = "/".$rows["shortname"]; 
					for($x=2;$x<=$count;$x++){
						$link .= "/".$ex[$x];
					}
					//$active = ($_GET["lang"]==$rows["shortname"]) ? 'class="active"' : "";
					$out .= '<li><a href="'.rtrim($link,"/").'">'.strtoupper($rows["showname"]).'</a></li>';
			}
			$out .= '</ul>';
		}
		return $out;
	}

	public function chooseLang()
	{
		$select = mysql_query("SELECT `id`,`outname` FROM `website_languages` WHERE `status`!=1 AND `visibility`!=1 ");
		//echo "SELECT `outname`,`shortname`,`img` FROM `website_languages` WHERE `status`!=1 AND `visibility`!=1 ";
		if(mysql_num_rows($select)){
			$out = $select;
		}else{
			$out = false;
		}
		return $out;
	}
	
	public function select_languages($visibility=false){
		$o = array();
		$vis = ($visibility) ? " AND visibility!=1" : "";
		$select = mysql_query("SELECT `shortname` AS language, `outname` AS name, `img` AS image FROM `website_languages` WHERE `status`!=1 $vis");
		while($out = mysql_fetch_array($select))
		{
			$o["language"][] = $out["language"];
			$o["name"][] = $out["name"];
			$o["image"][] = $out["image"];
		}
		return $o;
	}
	
	public function studio404_count_poll($poll_idx,$answer_idx){
		$select_answers1 = mysql_query("SELECT COUNT(id) AS cc FROM `website_poll_answers` WHERE `poll_idx`='".(int)$poll_idx."' ");
		$out=0;
		if(mysql_num_rows($select_answers1)){
			$answer_all = mysql_fetch_array($select_answers1);
			$cc = $answer_all["cc"]; // all answers for this polls 200
			$select_answers2 = mysql_query("SELECT * FROM `website_poll_answers` WHERE `poll_idx`='".(int)$poll_idx."' AND `answer_idx`='".(int)$answer_idx."' ");
			$tt = mysql_num_rows($select_answers2); // answers only this 100
			if($tt!=0){
				$out = ($tt*100) / $cc;
			}else{
				$out = 0;
			}
		}
		return floor($out);
	}
	
	public function studio404_poll()
	{
		$out = '';
		
		if(isset($_GET["news_titile"])){ $e = explode("-",$_GET["news_titile"]); $e = ' `idx`="'.(int)$e[0].'" AND '; }else{ $e=""; }
		$select = mysql_query("SELECT * FROM `website_poll` WHERE $e `type`='q' AND `status`!=1 AND `langs`='".mysql_real_escape_string($_GET['lang'])."' ORDER BY rand() LIMIT 1");
		if(mysql_num_rows($select))
		{
			$rows = mysql_fetch_array($select);
			$select_a = mysql_query("SELECT * FROM `website_poll` WHERE `type`='a' AND `cat_id`='".(int)$rows["idx"]."' AND `status`!=1 AND `langs`='".mysql_real_escape_string($_GET['lang'])."' ORDER BY idx ASC ");
			$answer_nums = mysql_num_rows($select_a);
			$out .= '<div class="q">'.$rows["title"].'</div>';
			$out .= '<div class="xx">';
			while($rows_a = mysql_fetch_array($select_a)){ 
				$pro = $this->studio404_count_poll($rows["idx"],$rows_a["idx"]);
				$out .= '<div class="a" onclick="poll('.$rows["idx"].','.$rows_a["idx"].',\''.$_GET['lang'].'\')">';
				$out .= '<div class="background" style="width:'.$pro.'%"></div>'; 
				$out .= '<div class="span">'.$rows_a["title"].' '.$pro.'% </div>';
				$out .= '</div>'; 
				$pro = 0;
			}
			$out .= '</div>';
		}
		return $out;
	}
	
	public function studio404_allPolls()
	{
		$sql = "
		SELECT 
		`idx`,`title`
		FROM 
		`website_poll`
		WHERE 
		`type`='q' AND 
		`status`!=1 AND 
		`langs`='".mysql_real_escape_string($_GET['lang'])."' ORDER BY idx DESC";
		$path = $_GET['lang']."/".$_GET['url']."/pn/";
		$out = $this->pagination($sql,$path,15);
		$turn[0] = $out[0];	
		$turn[1] = $out[1];	
		$turn[2] = $out[2];	
		return $turn;
	}
	
	public function userErrorHandler($errno, $errmsg, $filename, $linenum, $vars) 
	{
		$dt = date("Y-m-d H:i:s (T)");
		$errortype = array (
					E_ERROR              => 'Error',
					E_WARNING            => 'Warning',
					E_PARSE              => 'Parsing Error',
					E_NOTICE             => 'Notice',
					E_CORE_ERROR         => 'Core Error',
					E_CORE_WARNING       => 'Core Warning',
					E_COMPILE_ERROR      => 'Compile Error',
					E_COMPILE_WARNING    => 'Compile Warning',
					E_USER_ERROR         => 'User Error',
					E_USER_WARNING       => 'User Warning',
					E_USER_NOTICE        => 'User Notice',
					E_STRICT             => 'Runtime Notice',
					E_RECOVERABLE_ERROR  => 'Catchable Fatal Error'
					);
		// set of errors for which a var trace will be saved
		$user_errors = array(E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE);

		$err = "<errorentry>\n";
		$err .= "\t<datetime>" . $dt . "</datetime>\n";
		$err .= "\t<errornum>" . $errno . "</errornum>\n";
		$err .= "\t<errortype>" . $errortype[$errno] . "</errortype>\n";
		$err .= "\t<errormsg>" . $errmsg . "</errormsg>\n";
		$err .= "\t<scriptname>" . $filename . "</scriptname>\n";
		$err .= "\t<scriptlinenum>" . $linenum . "</scriptlinenum>\n";

		if (in_array($errno, $user_errors)) {
			$err .= "\t<vartrace>" . wddx_serialize_value($vars, "Variables") . "</vartrace>\n";
		}
		$err .= "</errorentry>\n\n";
		//error_log($err, 3, "/usr/local/php4/error.log");
		if ($errno == E_USER_ERROR) {
			$fp = fopen("lasterror.txt", "w");
			fwrite($fp, $err);
			echo "error";
			//mail("giorgigvazava87@gmail.com", "Critical User Error - ".MAIN_DIR, $err);
		}
	}
	
	public function distance($vect1, $vect2) 
	{
		if (!is_array($vect1) || !is_array($vect2)) {
			trigger_error("Incorrect parameters, arrays expected", E_USER_ERROR);
			return NULL;
		}
		if (count($vect1) != count($vect2)) {
			trigger_error("Vectors need to be of the same size", E_USER_ERROR);
			return NULL;
		}
		for ($i=0; $i<count($vect1); $i++) {
			$c1 = $vect1[$i]; $c2 = $vect2[$i];
			$d = 0.0;
			if (!is_numeric($c1)) {
				trigger_error("Coordinate $i in vector 1 is not a number, using zero", 
								E_USER_WARNING);
				$c1 = 0.0;
			}
			if (!is_numeric($c2)) {
				trigger_error("Coordinate $i in vector 2 is not a number, using zero", 
								E_USER_WARNING);
				$c2 = 0.0;
			}
			$d += $c2*$c2 - $c1*$c1;
		}
		return sqrt($d);
	}
	
	public function publicInformation()
	{
		$current_url = $_GET['lang']."/".$_GET['url'];
		$sql = "SELECT
		`website_public_files`.`date` AS wpf_date, 
		`website_public_files`.`name` AS wpf_name, 
		`website_public_files`.`file_name` AS wpf_file_name, 
		`website_public_files`.`archive` AS wpf_archive
		FROM 
		`website_menu`, `website_public_attachment`, `website_public`, `website_public_files` 
		WHERE 
		`website_menu`.`url`='".mysql_real_escape_string($current_url)."' AND 
		`website_menu`.`type`='public' AND 
		`website_menu`.`langs`='".mysql_real_escape_string($_GET['lang'])."' AND 
		`website_menu`.`status`!=1 AND 
		`website_menu`.`idx`=`website_public_attachment`.`connect_id` AND 
		`website_public_attachment`.`langs`='".mysql_real_escape_string($_GET['lang'])."' AND 
		`website_public_attachment`.`public_id`=`website_public`.`idx` AND 
		`website_public`.`langs`='".mysql_real_escape_string($_GET['lang'])."' AND 
		`website_public`.`status`!=1 AND 
		`website_public`.`idx`=`website_public_files`.`public_id` AND 
		`website_public_files`.`langs`='".mysql_real_escape_string($_GET['lang'])."' AND 
		`website_public_files`.`status`!=1 
		ORDER BY `website_public_files`.`date` DESC
		";
		return $sql;
	}
	
	public function public_archives()
	{
		if(isset($_GET["year"])){ $year= "/".$_GET["year"]; $year_get=$_GET["year"]; }else{ $year=""; $year_get=date("Y"); }
		if(isset($_GET["year"],$_POST["search_in_archive"])){
			if( !empty($_POST["search_in_archive"]))
			{
				$sx = ' AND `website_public_files`.`name` LIKE "%'.$_POST["search_in_archive"].'%"  ';
			}
		}
		$sql = '
		SELECT 
		`website_public`.`name` AS wp_name, 
		`website_public_files`.`date` AS wpf_date, 
		`website_public_files`.`name` AS wpf_name, 
		`website_public_files`.`file_name` AS wpf_file_name, 
		`website_public_files`.`archive` AS wpf_archive  
		FROM 
		`website_public`, `website_public_files` 
		WHERE 
		`website_public`.`status`!=1 AND 
		`website_public`.`langs`="'.mysql_real_escape_string($_GET["lang"]).'" AND 
		`website_public`.`idx`=`website_public_files`.`public_id` AND 
		`website_public_files`.`langs`="'.mysql_real_escape_string($_GET["lang"]).'" AND 
		`website_public_files`.`status`!=1 AND 
		FROM_UNIXTIME(`website_public_files`.`date`, "%Y") = '.$year_get.' '.$sx.' ORDER BY `website_public_files`.`date` DESC
		';
		$query = mysql_query($sql);
		if(mysql_num_rows($query)){
			$path = $_GET['lang']."/".$_GET["url"].$year."/pn/";
			$out = $this->pagination($sql,$path,20);
		}else{
			$out='';
		}
		return $out;
	}
	
	public function news_archives()
	{ 
		if(isset($_GET["year"])){ $year= "/".$_GET["year"]; $year_get=$_GET["year"]; }else{ $year=""; $year_get=2014; }
		if(isset($_GET["year"],$_POST["search_in_archive"])){
			if( !empty($_POST["search_in_archive"]))
			{
				$sx = ' AND `title` LIKE "%'.$_POST["search_in_archive"].'%"  ';
			}
		}
		$sql = '
		SELECT 
		*  
		FROM 
		`website_news_items` 
		WHERE 
		`status`!=1 AND 
		`langs`="'.mysql_real_escape_string($_GET["lang"]).'" AND 
		FROM_UNIXTIME(`date`, "%Y") = '.$year_get.' AND 
		FROM_UNIXTIME(`date`, "%Y/%m/%d") < "2014/07/22"  
		'.$sx.' ORDER BY `date` DESC
		';
		$query = mysql_query($sql);
		if(mysql_num_rows($query)){
			$path = $_GET['lang']."/".$_GET["url"].$year."/pn/";
			$out = $this->pagination($sql,$path,20);
		}else{
			$out='';
		}
		return $out;
	}
}