<?php

class render_module extends module {

    function __construct() {
        parent::__construct();
		$url = filter_input(INPUT_GET, "url");
        $rtrim = rtrim($url, "/");
        $explode = explode("/", $rtrim);
		
		
		if($explode[0]=="contact")
		{//conact page
			$this->contact_info = parent::contact_info();
			$this->get_slide = $this->slides(); 
		}
		
        $this->msg = $this->out; 
		$this->main_navigation = $this->main_nav_module();
		$this->main_navigation_bottom = $this->main_nav_module(false);
		$this->main_navigation_mobile = $this->main_nav_module(false,true);
		$this->schools = parent::schools(); 		
		$this->text_idx = parent::content("idx");
		$this->text_title = parent::content("title");
		$this->text_text = parent::content("text");
		$this->banners = parent::banners();
		$this->banners2 = parent::banners(true);
		$this->studio404_poll = parent::studio404_poll();
		$this->chooseLang = parent::chooseLang();
		$this->studio404_allPolls = parent::studio404_allPolls();
		$this->show_languages = parent::show_languages();
		$this->publicInformation = parent::publicInformation();
		
		$this->news_page_item = parent::news_page_item();
		$this->catalog_page_item = parent::catalog_page_item();
		
    }
	
	function main_nav_module($sub_=true,$langEl=false){
		$out = "";
		$main_navigation = parent::main_navigation();
		if($main_navigation){  
			if(mysql_num_rows($main_navigation)){
				$out = "<ul>";
				while($rows = mysql_fetch_array($main_navigation)){
					$url = explode("/",$_GET['url']);
					$getUrl = $_GET['lang']."/".$url[0];
					$active = ($rows['url']==$getUrl) ? 'class="active"' : '';
					if($rows['url']==$_GET["lang"]."/home"){ continue; }
					$out .= '<li '.$active.'><a href="'.$rows['url'].'">'.ucfirst($rows['title']).'</a>';
					if($sub_) :
						$sub_sql = "SELECT `idx`,`title`,`url` FROM `website_menu` WHERE `menu_type`=2 AND `langs`='".mysql_real_escape_string($_GET['lang'])."' AND `visibility`!=1 AND `status`!=1 AND `show`!=1 AND `cat_id`='".(int)$rows['idx']."' ORDER BY `position` ASC";
						$select_sub = mysql_query($sub_sql);
						if(mysql_num_rows($select_sub)){
							$out .= "<ul class='sub'>";
							while($sub_rows = mysql_fetch_array($select_sub)){
								$out .= '<li><a href="'.$sub_rows['url'].'">'.ucfirst($sub_rows['title']).'</a>';								
								/*$sub_sql2 = "SELECT `idx`,`title`,`url` FROM `website_menu` WHERE `menu_type`=3 AND `langs`='".mysql_real_escape_string($_GET['lang'])."' AND `visibility`!=1 AND `status`!=1 AND `cat_id`='".(int)$sub_rows['idx']."' AND `show`!=1 ORDER BY `position` ASC";
								$select_sub2 = mysql_query($sub_sql2);
								if(mysql_num_rows($select_sub2)){
									$out .= "<ul class='subsub'>";
									while($sub_rows2 = mysql_fetch_array($select_sub2)){
										$out .= '<li><a href="'.$sub_rows2['url'].'">'.ucfirst($sub_rows2['title']).'</a>';									
										$sub_sql3 = "SELECT idx,title,url FROM `website_menu` WHERE menu_type=4 AND langs='".mysql_real_escape_string($_GET['lang'])."' AND visibility!=1 AND status!=1 AND cat_id='".(int)$sub_rows2['idx']."' ORDER BY position ASC";
										$select_sub3 = mysql_query($sub_sql3);
										if(mysql_num_rows($select_sub3)){
											$out .= "<ul class='subsubsub'>";
											while($sub_rows3 = mysql_fetch_array($select_sub3)){
												$out .= '<li><a href="'.$sub_rows3['url'].'">'.ucfirst($sub_rows3['title']).'</a></li>';
												$out .= "</li>";	
											}
											$out .= "</ul>";
											
										}									
									}
									$out .= "</ul>";
									$out .= "</li>";
								}		*/						
							}
							$out .= "</ul>";
							$out .= "</li>";
						}
					endif;
					$out .= '</li>';
				}

			$return_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$find = "/".$_GET["lang"]."/";
			$replace = ($_GET["lang"]=="ka") ? "/en/" : "/ka/"; 
			$l = str_replace($find,$replace,$return_url);
			$n = (isset($_GET["lang"]) && $_GET["lang"]=="en") ? "Georgian" : "English";
			if($langEl) :
			$out .= '<li class="lastLangElement"><a href="'.$l.'">'.$n.'</a>';
			endif;
			$out .= "</ul>";
			}
		}else{
			$out = "";
		}
		return $out;
	}
	
	function slides()
	{
		$slide_array = parent::get_slide_array();	
		$iframe = '';
		for($x=0;$x<count($slide_array['title']);$x++)
		{
			$iframe .= '<img src="crop.php?path=image/slide/&amp;img='.MAIN_DIR.'/image/slide/'.$slide_array['image'][$x].'&amp;width=1292&amp;height=475" width="100%" alt="" />';
		} 		
		$out = $iframe;
		return $out;
	}
	
	public function cut_text($text,$number,$dots=false)
	{
		if($dots){ $d=""; }else{ $d="..."; }
		$charset = 'UTF-8';
		$length = $number;
		$string = $text;
		if(mb_strlen($string, $charset) > $length) {
		$string = mb_substr($string, 0, $length, $charset) . $d;
		}
		else
		{
			$string=$text;
		}
		return $string; 
	}
	
	public function google_maps()
	{
		$out = '<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>';
		$out .= '<script src="public/scripts/google_map.js" type="text/javascript"></script>';
		return $out;
	}
	
	public function simple_gallery()
	{
		$out = '<script src="public/scripts/jqueryui-widget.min.js" type="text/javascript"></script>';
		$out .= '<script src="public/scripts/simple-gallery.min.js" type="text/javascript"></script>';
		return $out;
	}
	
	public function right_menu($ul = false)
	{
		$out="";
		$parent = parent::get_right_menu();
		if($parent)
		{
			if($ul){
				$out .= '<div class="inside_links">'; 
				while($rows = mysql_fetch_array($parent))
				{
					$out .= '<div class="link_box"><a href="'.$rows['url'].'">'.$rows['title'].'</a></div>';
				}
				$out .= '</div>';
			}else{
				$out .= '<ul>'; 
				while($rows = mysql_fetch_array($parent))
				{
					$out .= '<li><a href="'.$rows['url'].'">'.$rows['title'].'</a></li>';
				}
				$out .= '</ul>';
			}
		}else{
			$out ="";
		}		
		return $out;
	}
	
	public function get_page_news()
	{
		$news_ = parent::news_page();
		$query = mysql_query($news_[0]);
		$out = "";		
		if($news_[0]) :
			while($rows = mysql_fetch_array($query))
			{
				$select_gallery = mysql_query("SELECT 
				`website_gallery_photos`.`photo` AS picture 
				FROM 
				`website_gallery_attachment`, `website_gallery`, `website_gallery_photos` 
				WHERE 
				`website_gallery_attachment`.`connect_id`='".$rows["wni_idx"]."' AND 
				`website_gallery_attachment`.`langs`='".mysql_real_escape_string($_GET["lang"])."' AND 
				`website_gallery_attachment`.`type`='news' AND 
				`website_gallery_attachment`.`gallery_idx`=`website_gallery`.`idx` AND 
				`website_gallery`.`langs`!='".mysql_real_escape_string($_GET["lang"])."' AND 
				`website_gallery`.`status`!=1 AND 
				`website_gallery_photos`.`gallery_id`=`website_gallery`.`idx` AND 
				`website_gallery_photos`.`langs`='".mysql_real_escape_string($_GET["lang"])."' AND  
				`website_gallery_photos`.`status`!=1 
				ORDER BY `website_gallery_photos`.`position` ASC LIMIT 1
				");
				
				if(mysql_num_rows($select_gallery)){
					$rows_gallery = mysql_fetch_array($select_gallery);
					$image = $rows_gallery["picture"];
				}else{ $image=""; }
				//$path = $_GET['lang']."/".$_GET['url']."/".$rows['wni_idx']."-".urldecode(str_replace(array(' ','"','#'),"-",$rows['wni_title']));
				//$path = $_GET['lang']."/".$_GET['url']."/".date("Y",$rows['wni_date'])."/".date("m",$rows['wni_date'])."/".$rows['wni_idx'];
				$path = $rows["wni_httplink"]; 
				$out .= '<article class="row error-404-article">';
				$out .= '<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 error-404-articleImg">';
				$out .= '<a href="'.$path.'">';
				$out .= '<img src="crop.php?img=image/gallery/'.$image.'&amp;width=430&amp;height=300" width="100%" alt="" />';
				$out .= '</a>';
				$out .= '</div>';
				$out .= '<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 error-404-newsText">';
				$out .= '<h2><a href="'.$path.'">'.($rows['wni_title']).'</a> <span>'.date("d.m.Y",$rows['wni_date']).'</span></h2>';
				$out .= '<p>';
				$out .= html_entity_decode(str_replace("&nbsp;"," ",stripslashes($rows['wni_short_text'])));
				$out .= '</p>';
				$out .= '</div>';
				$out .= '</article>';
			}
		endif;
		//$out .= $news_[1];
		return $out;
	}
	
	public function get_page_catalog()
	{
		$news_ = parent::catalog_page();
		$query = mysql_query($news_[0]);
		$out = "";		
		if($news_[0]) :
			while($rows = mysql_fetch_array($query))
			{
				$path = $_GET['lang']."/".$_GET['url']."/".$rows['wni_idx']."-".urldecode(str_replace(array(' ','"','#'),"-",$rows['wni_namelname']));
				$out .= '<article class="news">';
				$out .= '<div class="img"><img src="'.$this->get_cover_image($rows['wni_idx'],"catalog").'" width="180" height="139" alt=""></div>';
				$out .= '<header>';
				$out .= '<h3><a href="'.$path.'">'.$rows['wni_namelname'].'</a></h3>';
				$out .= '</header>';
				$out .= '<div class="ntext">';
				$out .= stripslashes($rows['wni_shortbio']);
				$out .= '<br><a href="'.$path.'" class="readmore">%readmore%</a>';
				$out .= '</div><div class="clearer"></div>';				
				$out .= '</article>';
			}
		endif;
		$out .= $news_[1];
		return $out;
	}
	
	public function get_cover_image($idx,$type){
		$out="";
		$select = mysql_query("
		SELECT 
		`website_gallery_photos`.`photo` AS cover_photo
		FROM 
		`website_gallery_attachment`, `website_gallery`, `website_gallery_photos` 
		WHERE 
		`website_gallery_attachment`.`connect_id`='".(int)$idx."' AND 
		`website_gallery_attachment`.`langs`='".mysql_real_escape_string($_GET['lang'])."' AND 
		`website_gallery_attachment`.`type`='".mysql_real_escape_string($type)."' AND 
		`website_gallery_attachment`.`gallery_idx`=`website_gallery`.`idx` AND 
		`website_gallery`.`langs`='".mysql_real_escape_string($_GET['lang'])."' AND 
		`website_gallery`.`status`!=1 AND 
		`website_gallery`.`idx`=`website_gallery_photos`.`gallery_id` AND 
		`website_gallery_photos`.`langs`='".mysql_real_escape_string($_GET['lang'])."' AND 
		`website_gallery_photos`.`status`!=1 
		ORDER BY `website_gallery_photos`.`position` ASC LIMIT 1
		");
		if(mysql_num_rows($select)){
			$rows = mysql_fetch_array($select);
			$out .= 'crop.php?img=image/gallery/'.$rows['cover_photo'].'&width=180&height=139';
		}
		return $out;
	}
	
	public function get_gallery_page(){
		$array = parent::gallery_page();
		$out="";
		$y = 1;
		for($x=0;$x<count($array['name']);$x++){
			if(!$array['photo'][$x]){ continue; }
			if($y==1){ $first = ' first'; }
			if($y==2){ $y=0; $clear = '<div class="clearer"></div>'; $first=''; $clear=''; }
			
			$out .= '<article class="gallery_folder'.$first.'">';			
			$out .= '<div class="img"><a href="image/gallery/'.$array['photo'][$x].'" class="gallery">';
			$out .= '<img src="crop.php?img=image/gallery/'.$array['photo'][$x].'&width=328&height=220" width="328" height="220" alt="" />';
			$out .= '</a></div>';			
			$get_gallery_photos2 = parent::get_gallery_p($array['wg_idx'][$x]);
			$query2 = mysql_query($get_gallery_photos2);
			$imgCount = mysql_num_rows($query2);
			if($imgCount){
				while($rows2 = mysql_fetch_array($query2))
				{
					$array_replace = array('"','#',"'");
					if($rows2['wgp_photo']==$array['photo'][$x]){ continue; }
					$out .= '<div class="img hidden"><a href="image/gallery/'.$rows2['wgp_photo'].'" class="gallery" title="'.str_replace($array_replace,"", $rows2['wgp_title']).'"><img src="crop.php?img=image/gallery/'.$rows2['wgp_photo'].'&width=328&height=220" width="328" height="220" alt="'.str_replace($array_replace,"", $rows2['wgp_title']).'" /></a></div>';
				}
			}
			$out .= '<header>
						<h3>['.$imgCount.'] '.$array['name'][$x].'</h3>
					</header>';
			$out .= '</article>';
			$out .= $clear;
			$y++;
		}
		$out .= $array['pagination'];
		return $out;
	}
	
	public function photoes()
	{
		$get_gallery_photos = parent::get_gallery_photos();
		$query = mysql_query($get_gallery_photos);
		$out = "";
		$x=1;
		while($rows = mysql_fetch_array($query))
		{
			$array_replace = array('"','#',"'");
			if($x==1){ $first_box = ' first'; }else{ $first_box=""; }
			if($x==2){ $x=1; }
			$out .= '<article class="gallery_folder'.$first_box.'">';
			$out .= '<img src="crop.php?img=image/gallery/'.$rows['wgp_photo'].'&width=600&height=470" alt="" title="'.str_replace($array_replace,"", $rows['wgp_title']).'"  />';
			$out .= '</div>';
			$x++;
		}
		return $out;
	}
	
	public function mainPicture($type)
	{
		$main_picture = parent::main_picture($type);
		$query = mysql_query($main_picture);
		$nums = mysql_num_rows($query);
		$out["image"] = '';
		$out['gallery_idx']='';
		$out['title']='';
		$out['description']='';
		$out['nums']=$nums;
		$out['url']="";
		
		if($nums){
			while($rows=mysql_fetch_array($query))
			{
				$out["image"][] = $rows['wgp_photo'];
				$out['gallery_idx'][] = $rows['wg_idx'];
				$out['title'][] = $rows['wgp_title'];
				$out['description'][] = $rows['wgp_description'];
				$out['url'][] = $rows['wm_url'];				
			}
		}
		return $out;
	}
	
	public function attachs($type=false)
	{
		$get_attachs = parent::get_attachs($type);
		$query = mysql_query($get_attachs);
		
		$return_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		
		if(mysql_num_rows($query)){
			$out = '<ul class="attachs">';
			while($rows = mysql_fetch_array($query))
			{
				if(strtolower($rows['wf_filetype'])=="pdf"){
					$out .= '<li><a href="/public/files/pdf/'.$rows['wf_filename'].'" target="_blank"><div class="ext">'.strtoupper($rows['wf_filetype']).'</div> <div class="name">'.$rows['wf_outname'].'</div></a></li>';
				}
				else{
					$out .= '<li><a href="_plugins/download/index.php?download_file='.$rows['wf_filename'].'&ext='.strtolower($rows['wf_filetype']).'&returnurl='.$return_url.'"><div class="ext">'.strtoupper($rows['wf_filetype']).'</div> <div class="name">'.$rows['wf_outname'].'</div></a></li>';
				}
			}
			$out .= '</ul>';
		}
		return $out;
	}
	
	public function adonmenu($cat_id = 0, $oddeven = true)
	{
		$out["odd"] = "";
		$out["even"] = "";
		$x = 1;
		$select = mysql_query("SELECT `title`,`url` FROM `website_menu` WHERE `cat_id`='".(int)$cat_id."' AND `langs`='".mysql_real_escape_string($_GET["lang"])."' AND `visibility`!=1 AND `show`!=1 AND `status`!=1 ORDER BY position ASC ");
		if(mysql_num_rows($select)){
			$out["odd"] .= "<ul>";
			$out["even"] .= "<ul>";
			$out["all2"] .= "<ul>";
			while($rows = mysql_fetch_array($select)){
				if($oddeven){
					/*if($x==1){
						$out["odd"] .= '<li><a href="'.$rows["url"].'">'.$rows["title"].'</a></li>'; 
						$x=2;
					}else{
						$out["even"] .= '<li><a href="'.$rows["url"].'">'.$rows["title"].'</a></li>'; 
						$x=1;
					}*/
					$out["all2"] .= '<li><a href="'.$rows["url"].'">'.$rows["title"].'</a></li>'; 
				}else{
					$out["all"] .= '<li class="li"><a href="'.$rows["url"].'">'.$rows["title"].'</a></li>'; 
				}
			}
			$out["odd"] .= "</ul>";
			$out["even"] .= "</ul>";
			$out["all2"] .= "</ul>";
		}
		return $out;
	}

	public function get_video_gallery()
	{
		$sql = "SELECT 
		`video_link`
		FROM 
		`website_youtube_videos`
		WHERE 
		`upload_status`='uploaded' AND 
		`status` != 1 
		ORDER BY `id` DESC
		";
		$out = array();		
		$path = $_GET['lang']."/".$_GET['url']."/pn/";
		$ss = $this->pagination($sql,$path,10);
		$query = mysql_query($ss[0]);
		while($rows = mysql_fetch_array($query))
		{
			$out["video_link"][] = $rows['video_link'];
		}
		$out["pagination"] = $ss[1];
		return $out;
	}
	
	
	public function get_public_archives()
	{
		$public_archives = parent::public_archives();
		$query = mysql_query($public_archives[0]);
		$out = "";
		if(mysql_num_rows($query)) :
			$out = "<ul>";
			$count = 1;
			while($rows = mysql_fetch_array($query))
			{
				if($rows["wpf_file_name"]){ $download = MAIN_DIR.'_plugins/download/public_files.php?download_file='.$rows["wpf_file_name"]; }
				else{ $download="javascript:alert('Sorry, not avaliable !')"; }
				if($rows["wpf_archive"]==2){ $color='style="color:#b80000"'; }else{ $color=''; }
				$out .= '<li><a href="'.$download.'" '.$color.'>'.$rows["wpf_name"].'</a> ( '.date("d/m/Y",$rows["wpf_date"]).' )</li>';
				$count++;
			}
			$out .= '</ul><div class="clearer"></div><br />';
		endif;	
		$out .= $public_archives[1];
		return $out;
	}
	
	public function get_news_archives(){
		$news_archives = parent::news_archives();
		$query = mysql_query($news_archives[0]);
		$out = "";		
		if($news_archives[0]) :
			while($rows = mysql_fetch_array($query))
			{
				$select_gallery = mysql_query("SELECT 
				`website_gallery_photos`.`photo` AS picture 
				FROM 
				`website_gallery_attachment`, `website_gallery`, `website_gallery_photos` 
				WHERE 
				`website_gallery_attachment`.`connect_id`='".$rows["idx"]."' AND 
				`website_gallery_attachment`.`langs`='".mysql_real_escape_string($_GET["lang"])."' AND 
				`website_gallery_attachment`.`type`='news' AND 
				`website_gallery_attachment`.`gallery_idx`=`website_gallery`.`idx` AND 
				`website_gallery`.`langs`!='".mysql_real_escape_string($_GET["lang"])."' AND 
				`website_gallery`.`status`!=1 AND 
				`website_gallery_photos`.`gallery_id`=`website_gallery`.`idx` AND 
				`website_gallery_photos`.`langs`='".mysql_real_escape_string($_GET["lang"])."' AND  
				`website_gallery_photos`.`status`!=1 
				ORDER BY `website_gallery_photos`.`position` ASC LIMIT 1
				");
				
				if(mysql_num_rows($select_gallery)){
					$rows_gallery = mysql_fetch_array($select_gallery);
					$image = $rows_gallery["picture"];
				}else{ $image=""; }
				$path = $_GET['lang']."/news/".date("Y",$rows['date'])."/".date("m",$rows['date'])."/".$rows['idx'];
				$out .= '<article class="news">';
				$out .= '<div class="img">';
				if($image){
					$out .= '<img src="crop.php?img=image/gallery/'.$image.'&amp;width=180&amp;height=139" width="180" height="139" alt="" />';
				}else{
					$out .= '<img src="public/img/noimage.png" width="180" height="139" alt="No image" />';
				}
				$out .= '</div>';
				$out .= '<header>';
				$out .= '<h3><a href="'.$path.'">'.$rows['title'].'</a></h3>';
				$out .= '<p>'.date("d/m/Y",$rows['date']).'</p>';
				$out .= '</header>';
				$out .= '<div class="ntext">';
				$out .= strip_tags($rows['short_text']).'<br /><a href="'.$path.'" class="readmore">%readmore%</a>';
				$out .= '</div><div class="clearer"></div>';
				$out .= '</article>';
			}
		endif;
		$out .= $news_archives[1];
		return $out;
	}
	
	public function get_social($footer = false)
	{
		$out = '<div class="social_networksx">';
		$query = mysql_query("SELECT `name`,`var`,`url` FROM `website_social`");
		if(mysql_num_rows($query))
		{
			$out .= '<ul>';
			while($rows = mysql_fetch_array($query))
			{
					if($rows["name"]=="facebook"){
						$v["facebook"] = $rows["url"];
						$v["facebook_var"] = $rows["name"];
					}else if($rows["name"]=="twitter"){
						$v["twitter"] = $rows["url"];
						$v["twitter_var"] = $rows["name"];
					}else if($rows["name"]=="myvideo"){
						$v["myvideo"] = $rows["url"];
						$v["myvideo_var"] = $rows["name"];
					}else if($rows["name"]=="youtube"){
						$v["youtube"] = $rows["url"];
						$v["youtube_var"] = $rows["name"];
					}else if($rows["name"]=="hotline"){
						$v["hotline"] = $rows["url"];
						$v["hotline_var"] = $rows["url"];
					}
			}
			$out .= '<li class="fbx"><a href="'.$v["facebook"].'" target="_blank">'.$v["facebook_var"].'</a></li>';
			$out .= '<li class="twx"><a href="'.$v["twitter"].'" target="_blank">'.$v["twitter_var"].'</a></li>';
			$out .= '<li class="mvx"><a href="'.$v["myvideo"].'" target="_blank">'.$v["myvideo_var"].'</a></li>';
			$out .= '<li class="ytx"><a href="'.$v["youtube"].'" target="_blank">'.$v["youtube_var"].'</a></li>';
			$out .= '<li class="hlx"><a href="'.$v["hotline"].'" target="_blank">'.$v["hotline_var"].'</a></li>';				
			$out .= '</ul>';
			
		}
		$out .= '</div>';
			
		return $out;
	}

	public function projects($idx = false){
		if(!$idx) :
		$select_projects = mysql_query("SELECT `idx`,`p_title`,`catalog_id`,`p_type`
										FROM 
										`website_catalogs_items`
										WHERE 
										`catalog_id`=1 AND 
										`langs`='".mysql_real_escape_string($_GET["lang"])."' AND 
										`status`!=1 ORDER BY `p_date` DESC LIMIT 10
										");
		$out = ''; 
		$ix = 1;
		while($rows = mysql_fetch_array($select_projects)){
			$out .= '<li class="col-lg-2 col-md-4 col-sm-4 col-xs-6 error-404-item mix '.$rows["p_type"].' check1 radio2 option3" title="'.addslashes(html_entity_decode($rows["p_title"])).'" aria-describedby="ui-id-'.$ix.'">';
			
			$image = $this->getMainImageCatalog($rows["idx"]); 
			$out .= '<a href="'.$_GET["lang"].'/'.$_GET["url"].'/'.$rows["idx"].'">';
			if($image) :
				$out .= '<img src="crop.php?path=image/slide/&amp;img=http://dmark.ge/image/gallery/'.$image.'&amp;width=200&amp;height=190" width="100%" alt="" />';
			endif;
			$cutText = $this->cut_text($rows["p_title"],20);
			$out .= '<p>'.$cutText.'</p>';
			$out .= '</a>';
			$out .= '</li>';
			$ix++;
		}
		endif;
		if($idx) : 
			$select_projects = mysql_query("SELECT *
										FROM 
										`website_catalogs_items`
										WHERE 
										`idx`='".(int)$idx."' AND 
										`catalog_id`=1 AND 
										`langs`='".mysql_real_escape_string($_GET["lang"])."' AND 
										`status`!=1 
										");
			$out = mysql_fetch_array($select_projects);
		endif;
		return $out; 
	}


	public function team($idx = false){
		if(!$idx) :
		$select_team = mysql_query("SELECT 
										`idx`,`startjob`,`namelname`,`profesion`,`client`,`dob`,`bornplace`,`livingplace`,`phonenumber`,`email`,`shortbio`,`workExperience`,`education`,`treinings`,`certificate`,`languages` 
										FROM 
										`website_catalogs_items`
										WHERE 
										`catalog_id`=3 AND 
										`langs`='".mysql_real_escape_string($_GET["lang"])."' AND 
										`status`!=1 
										");
		$out = ''; 
		while($rows = mysql_fetch_array($select_team)){
			$out .= '<div class="col-lg-2 col-md-2 col-sm-4 col-xs-6 error-team-item">';
			//$out .= '<a href="">';
			$image = $this->getMainImageCatalog($rows["idx"]); 
			$out .= '<a href="'.$_GET["lang"].'/'.$_GET["url"].'/'.$rows["idx"].'">';
			if($image) :
				$out .= '<img src="crop.php?path=image/slide/&amp;img=http://dmark.ge/image/gallery/'.$image.'&amp;width=200&amp;height=190" width="100%" alt="" />';
			endif;
			$out .= '<h4>'.$rows["namelname"].'</h4>';
			$out .= '<p>'.$rows["profesion"].'</p>';
			$out .= '</a></div>';
		}
		endif;
		if($idx) : 
			$select_team = mysql_query("SELECT *
										FROM 
										`website_catalogs_items`
										WHERE 
										`idx`='".(int)$idx."' AND 
										`catalog_id`=3 AND 
										`langs`='".mysql_real_escape_string($_GET["lang"])."' AND 
										`status`!=1 
										");
			$out = mysql_fetch_array($select_team);
		endif;
		return $out; 
	}

	public function teamLeftside(){
		$url = $_GET["lang"]."/team";
		$select_dmark_about = mysql_query("SELECT `text` FROM `website_menu` WHERE `url` LIKE '".mysql_real_escape_string($url)."' AND `status`!=1");
		$out = '';
		if(mysql_num_rows($select_dmark_about)){
			$rows = mysql_fetch_array($select_dmark_about);
			$out = $rows["text"];
		}
		return $out;
	}

	public function getMainImageCatalog($idx,$limit = false){
		$l = (!$limit) ? 'LIMIT 1' : '';
		$select = mysql_query("SELECT 
								`website_gallery_photos`.`photo` AS pho, 
								`website_gallery_photos`.`title` AS tit 
								FROM 
								`website_gallery_attachment`, 
								`website_gallery`, 
								`website_gallery_photos` 
								WHERE 
								`website_gallery_attachment`.`connect_id`='".(int)$idx."' AND 
								`website_gallery_attachment`.`type`='catalog' AND 
								`website_gallery_attachment`.`langs`='".mysql_real_escape_string($_GET["lang"])."' AND 
								`website_gallery_attachment`.`gallery_idx`=`website_gallery`.`idx` AND 
								`website_gallery`.`langs`='".mysql_real_escape_string($_GET["lang"])."' AND 
								`website_gallery`.`status`!=1 AND 
								`website_gallery`.`idx`=`website_gallery_photos`.`gallery_id` AND 
								`website_gallery_photos`.`langs`='".mysql_real_escape_string($_GET["lang"])."' AND 
								`website_gallery_photos`.`status`!=1 ORDER BY `website_gallery_photos`.`id` DESC $l
								");
		if(mysql_num_rows($select)){
			if(!$limit){
				$rows = mysql_fetch_array($select);
				return $rows["pho"];
			}else{
				$out = array();
				while($rows = mysql_fetch_array($select)){
					$out[] = $rows["pho"]; 
				}
				return $out;
			}
		}else{
			return false;
		}		
	}



	
	
}

