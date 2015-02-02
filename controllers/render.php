<?php

class render extends controller {

    function __construct() {
	    parent::__construct();	
	    require 'modules/render_module.php';
        $module = new render_module;
		$this->view->studio404_poll = $module->studio404_poll;
        $this->view->msg = $module->msg;
        $this->view->main_navigation = $module->main_navigation;
        $this->view->main_navigation_mobile = $module->main_navigation_mobile;
        $this->view->main_navigation_bottom = $module->main_navigation_bottom;
        $this->view->get_slide_array = $module->get_slide;
        $this->view->show_languages = $module->show_languages; 
		$this->view->newsletter_msg = $this->post_newsletter();
        $this->view->text_idx = $module->text_idx;
        $this->view->text_title = $module->text_title;
        $this->view->text_text = $module->text_text;
        $this->view->contact_info = $module->contact_info;
        $this->view->right_menu = $module->right_menu();
        $this->view->right_menu_content = $module->right_menu(true);
		$this->view->schools = $module->schools();
		$this->view->breadCraps = $this->outCraps();
		$this->view->keywords = $this->keywords();
		$this->view->get_social_footer = $module->get_social(true);
		$this->view->get_social_right = $module->get_social(false);
		
		$this->view->adonmenu = $module->adonmenu(47);
		//$this->view->adonmenu2 = $module->adonmenu(26);
		$this->view->adonmenu3 = $module->adonmenu(2,false);
		$this->view->adonmenu4 = $module->adonmenu(5,false);
		$this->view->adonmenu5 = $module->adonmenu(43,false);
		 
	
		$url = filter_input(INPUT_GET, "url");
        $rtrim = rtrim($url, "/");
        $explode = explode("/", $rtrim);
		
		$current_url = $_GET['lang']."/".$_GET['url'];
		$pageType = $module->get_page_type($current_url);
        $this->view->get_page_type = $module->get_page_type($current_url);


		if($pageType=="text"){
			$this->view->mainPicture = $module->mainPicture("text");
			$this->view->javascripts = $this->js("text");
			$this->view->banners = $module->banners2;
			$this->view->attachs = $module->attachs();
			$this->view->banners_show = $this->check_sh("banners");
		}else if($pageType=="public"){
			$this->view->mainPicture = $module->mainPicture("text");
			$this->view->javascripts = $this->js("text");
			$this->view->banners = $module->banners2;
			$this->view->attachs = $module->attachs();
			$this->view->banners_show = $this->check_sh("banners");
			$this->view->publicInformation = $module->publicInformation;
		}else if($pageType=="news"){
			$this->view->mainPicture = $module->mainPicture("news");
			$this->view->banners = $module->banners2;
			$this->view->attachs = $module->attachs("news");
			$this->view->news_ = $module->get_page_news();
			$this->view->news_page_item = $module->news_page_item();
			$this->view->chooseLang = $module->chooseLang;
			$this->view->javascripts = $this->js("news");
			$this->view->calendar_show = $this->check_sh("calendar");
			$this->view->newsletter_show = $this->check_sh("newsletter");
		}else if($pageType=="catalog"){
			$this->view->mainPicture = $module->mainPicture("catalog");
			$this->view->catalog_ = $module->get_page_catalog();
			$this->view->catalog_page_item = $module->catalog_page_item();
			$this->view->banners = $module->banners2;
			$this->view->javascripts = $this->js("catalog");
			$this->view->attachs = $module->attachs("catalog");
			$this->view->banners_show = $this->check_sh("banners");
		}else if($pageType=="plugin"){
			$this->view->studio404_allPolls = $module->studio404_allPolls;
			$this->view->studio404_poll = $module->studio404_poll;
			$this->view->banners = $module->banners2;
			$this->view->javascripts = $this->js("plugin");
			$this->view->banners_show = $this->check_sh("banners");
		}


		
		if($_GET["url"]=="home"){ 
			$this->view->javascripts = $this->js("plugin"); 
			$this->view->banners = $module->banners;
			$this->view->slider_show = $this->check_sh("slide");
			$this->view->banners_show = $this->check_sh("banners");
			$this->view->poll_show = $this->check_sh("poll");
			$this->view->videoTeka = $this->videoTeka(6,10);
			$this->view->photoTeka = $this->photoTeka(30);
		}else if($_GET["url"]=="search" && isset($_GET["news_titile"]) && !empty($_GET["news_titile"])){
			$this->view->search_result = $this->studio404_search($_GET["news_titile"]);
		}else if($_GET["url"]=="contact"){
			$this->view->google_maps = $module->google_maps(); 
			if(isset($_POST["person"],$_POST["email"],$_POST["phone"],$_POST["subject"],$_POST["letter"])){
				$this->view->mailTo = $this->mailHtmlTo("Contact - ".MAIN_DIR,$_POST["person"],$_POST["email"],$_POST["phone"],$_POST["subject"],$_POST["letter"]);
			}
		}else if($_GET["url"]=="photoGallery"){
			$this->view->out_gallery_folders = $module->get_gallery_page();
			$this->view->get_gallery_photos = $module->photoes();
			$this->view->banners = $module->banners2;
			$this->view->javascripts = $this->js("gallery");
			$this->view->banners_show = $this->check_sh("banners");
		}else if($_GET["url"]=="common"){
			$this->view->out_gallery_folders = $module->get_gallery_page();
			$this->view->get_gallery_photos = $module->photoes();
			$this->view->banners = $module->banners2;
			$this->view->javascripts = $this->js("gallery");
			$this->view->banners_show = $this->check_sh("banners");
		}else if($_GET["url"]=="catalogGallery"){
			$this->view->out_gallery_folders = $module->get_gallery_page();
			$this->view->get_gallery_photos = $module->photoes();
			$this->view->banners = $module->banners2;
			$this->view->javascripts = $this->js("gallery");
			$this->view->banners_show = $this->check_sh("banners");
		}else if($_GET["url"]=="videoGallery"){
			$this->view->out_video_folders = $module->get_video_gallery();
			
			$this->view->banners = $module->banners2;
			$this->view->javascripts = $this->js("gallery");
			$this->view->banners_show = $this->check_sh("banners");
		}else if($_GET["url"]=="publicArchive"){
			$this->view->get_public_archives = $module->get_public_archives();
		}else if($_GET["url"]=="newsarchive"){
			$this->view->get_news_archives = $module->get_news_archives(); 
		}else if($_GET["url"]=="tenders")
		{
			$this->view->CreateTenderPage = $this->CreateTenderPage();
		}else if($_GET['url']=="projects"){
			$idx = (isset($_GET["news_titile"])) ? (int)$_GET["news_titile"] : 0;
			$this->view->projects = $module->projects($idx);
			if(isset($_GET["news_titile"])){
				$this->view->projectImgs = $module->getMainImageCatalog($idx,true);
			}
		}else if($_GET['url']=="team"){
			$idx = (isset($_GET["news_titile"])) ? (int)$_GET["news_titile"] : 0;
			$this->view->team = $module->team($idx);
			$this->view->teamLeftside = $module->teamLeftside();
			if(isset($_GET["news_titile"])){
				$this->view->projectImgs = $module->getMainImageCatalog($idx);
			}
		}
			
		if($explode[0]=="error"){ $pageType="error"; }
		else if($pageType=="plugin"){ 
			$pageType=$explode[0]; 
			$this->view->sitemap = $module->sitemap();
		}
        //output   
        $this->view->render($pageType."/index");
    }
	
	public function js($type)
	{
		$out = "<link href='".MAIN_DIR."/public/css/google.css' type='text/css' rel='stylesheet' />";
		if($type=="text"){
			$out .= '<link rel="stylesheet" href="public/scripts/gallery/dist/magnific-popup.css" type="text/css" />';
		}else if($type=="plugin")
		{
			if($_GET["url"]=="home"){
				$out .= '<script type="text/javascript" src="'.MAIN_DIR.'/public/js/jquery-1.11.2.min.js"></script>
				<!-- Latest compiled and minified CSS -->
				<link rel="stylesheet" href="'.MAIN_DIR.'/_plugins/bootstrap/css/bootstrap.min.css">
				<!-- Optional theme -->
				<link rel="stylesheet" href="'.MAIN_DIR.'/_plugins/bootstrap/css/bootstrap-theme.min.css">
				<link rel="stylesheet" type="text/css" href="'.MAIN_DIR.'/public/css/general.css" />
				<link rel="stylesheet" type="text/css" href="'.MAIN_DIR.'/public/css/'.$_GET["lang"].'.css" />
				<script type="text/javascript" src="'.MAIN_DIR.'/public/js/scripts.js"></script>
				<!-- Latest compiled and minified JavaScript -->
				<script src="'.MAIN_DIR.'/_plugins/bootstrap/js/bootstrap.min.js"></script>
				<!--[if lt IE 9]>
				<script src="'.MAIN_DIR.'/_plugins/bootstrap/js/html5shiv.min.js"></script>
				<script src="'.MAIN_DIR.'/_plugins/bootstrap/js/respond.min.js"></script>
				<![endif]-->
				<script type="text/javascript" src="'.MAIN_DIR.'/public/scripts/studio404_carusel.js"></script>';
			}else if($_GET["url"]=="projects" && !isset($_GET["news_titile"])){
				$out .= '<script type="text/javascript" src="'.MAIN_DIR.'/public/js/jquery-1.11.2.min.js"></script>
				<!-- Latest compiled and minified CSS -->
				<link rel="stylesheet" href="'.MAIN_DIR.'/_plugins/bootstrap/css/bootstrap.min.css">
				<!-- Optional theme -->
				<link rel="stylesheet" href="'.MAIN_DIR.'/_plugins/bootstrap/css/bootstrap-theme.min.css">

			    <link rel="stylesheet" type="text/css" href="'.MAIN_DIR.'/public/css/general.css" />
    			<link rel="stylesheet" type="text/css" href="'.MAIN_DIR.'/public/css/'.$_GET["lang"].'.css" />
    			<link rel="stylesheet" type="text/css" href="'.MAIN_DIR.'/_plugins/content-filter/css/style.css" />
				<!--filter Jquery START-->
				<script src="'.MAIN_DIR.'/_plugins/content-filter/js/modernizr.js"></script>
				<!--filter Jquery END-->
				<script type="text/javascript">
				// scroll loader
				$(window).scroll(function() {         
				if($(window).scrollTop() + $(window).height() == $(document).height()) 
				{
					loadProjects();
				}
				});
				</script>
				<script type="text/javascript" src="'.MAIN_DIR.'/public/js/scripts.js"></script>
				<!-- Latest compiled and minified JavaScript -->
				<script src="'.MAIN_DIR.'/_plugins/bootstrap/js/bootstrap.min.js"></script>
				<!--[if lt IE 9]>
				<script src="'.MAIN_DIR.'/_plugins/bootstrap/js/html5shiv.min.js"></script>
				<script src="'.MAIN_DIR.'/_plugins/bootstrap/js/respond.min.js"></script>
				<![endif]-->

				<!--filter Jquery START-->
				<script src="'.MAIN_DIR.'/_plugins/content-filter/js/jquery-2.1.1.js"></script>
				<script src="'.MAIN_DIR.'/_plugins/content-filter/js/jquery.mixitup.min.js"></script>
				<script src="'.MAIN_DIR.'/_plugins/content-filter/js/main.js"></script>
				<!--filter Jquery END-->
				<!--Blank and White START-->
				<script src="'.MAIN_DIR.'/_plugins/BlackAndWhite/src/jquery.BlackAndWhite.js"></script>
				<script type="text/javascript">
				$(window).load(function(){
					$("#gridx li a").css({"position":"relative", "display":"block"});
  					$("#gridx li a").BlackAndWhite({
        				hoverEffect : true, 
        				webworkerPath : false,
        				intensity:1,
        				speed: { 
            					fadeIn: 500, 
            					fadeOut: 1000 
        				}
    				});
				});
				</script>
				<!--Blank and White END-->
				';
			}else if(isset($_GET["url"]) && $_GET["url"]=="projects" && isset($_GET["news_titile"])){
				$out .= '<script type="text/javascript" src="'.MAIN_DIR.'/public/js/jquery-1.11.2.min.js"></script>
				<!-- Latest compiled and minified CSS -->
				<link rel="stylesheet" href="'.MAIN_DIR.'/_plugins/bootstrap/css/bootstrap.min.css">
				<!-- Optional theme -->
				<link rel="stylesheet" href="'.MAIN_DIR.'/_plugins/bootstrap/css/bootstrap-theme.min.css">
			    <link rel="stylesheet" type="text/css" href="'.MAIN_DIR.'/public/css/general.css" />
    			<link rel="stylesheet" type="text/css" href="'.MAIN_DIR.'/public/css/'.$_GET["lang"].'.css" />
    			<link rel="stylesheet" type="text/css" href="'.MAIN_DIR.'/_plugins/content-filter/css/style.css" />
				<script type="text/javascript" src="'.MAIN_DIR.'/public/js/scripts.js"></script>
				<!-- Latest compiled and minified JavaScript -->
				<script src="'.MAIN_DIR.'/_plugins/bootstrap/js/bootstrap.min.js"></script>
				<!--[if lt IE 9]>
				<script src="'.MAIN_DIR.'/_plugins/bootstrap/js/html5shiv.min.js"></script>
				<script src="'.MAIN_DIR.'/_plugins/bootstrap/js/respond.min.js"></script>
				<![endif]-->
				 <!--OWL Slider START-->
				<link rel="stylesheet" href="'.MAIN_DIR.'/_plugins/owl.carousel/owl-carousel/owl.carousel.css">	 
				<link rel="stylesheet" href="'.MAIN_DIR.'/_plugins/owl.carousel/owl-carousel/owl.theme.css">	 
				<script src="'.MAIN_DIR.'/_plugins/owl.carousel/owl-carousel/owl.carousel.js"></script>
			    <!--OWL Slider END-->
			    <script type="text/javascript">
				$(document).ready(function() {
						$("#owl-demo").owlCarousel({ 
								autoPlay : true, 
								autoHeight : true, 
								navigation : false, // Show next and prev buttons
								navigationText : ["<",">"], 
								//Lazy load
							    lazyLoad : false,
							    lazyFollow : true,
							    lazyEffect : false,
								paginationNumbers: true,
								slideSpeed : 1000,
								paginationSpeed : 400,
								singleItem:true
						});
				});
				</script>
				';
				
			}else if($_GET["url"]=="team"){
				$out .= '<script type="text/javascript" src="'.MAIN_DIR.'/public/js/jquery-1.11.2.min.js"></script>
				<!-- Latest compiled and minified CSS -->
				<link rel="stylesheet" href="'.MAIN_DIR.'/_plugins/bootstrap/css/bootstrap.min.css">
				<!-- Optional theme -->
				<link rel="stylesheet" href="'.MAIN_DIR.'/_plugins/bootstrap/css/bootstrap-theme.min.css">

			    <link rel="stylesheet" type="text/css" href="'.MAIN_DIR.'/public/css/general.css" />
    			<link rel="stylesheet" type="text/css" href="'.MAIN_DIR.'/public/css/'.$_GET["lang"].'.css" />
    			<link rel="stylesheet" type="text/css" href="'.MAIN_DIR.'/_plugins/content-filter/css/style.css" />
				
				<script type="text/javascript" src="'.MAIN_DIR.'/public/js/scripts.js"></script>
				<!-- Latest compiled and minified JavaScript -->
				<script src="'.MAIN_DIR.'/_plugins/bootstrap/js/bootstrap.min.js"></script>
				<!--[if lt IE 9]>
				<script src="'.MAIN_DIR.'/_plugins/bootstrap/js/html5shiv.min.js"></script>
				<script src="'.MAIN_DIR.'/_plugins/bootstrap/js/respond.min.js"></script>
				<![endif]-->
				<!--Blank and White START-->
				<script src="'.MAIN_DIR.'/_plugins/BlackAndWhite/src/jquery.BlackAndWhite.js"></script>
				<script type="text/javascript">
				$(window).load(function(){
					$(".error-team-item a").css({"position":"relative", "display":"block"});
  					$(".error-team-item a").BlackAndWhite({
        				hoverEffect : true, 
        				webworkerPath : false,
        				intensity:1,
        				speed: { 
            				fadeIn: 500, 
            				fadeOut: 1000 
        				}
    				});

					$(".studio-404-teamMember").css({"position":"relative", "display":"block"});
					$(".studio-404-teamMember").BlackAndWhite({
						hoverEffect : true, 
						webworkerPath : false,
						intensity:1,
						speed: { 
						fadeIn: 500, 
						fadeOut: 1000 
						}
					});
				});
				
				</script>
				<!--Blank and White END-->
				';
			}else if($_GET["url"]=="contact"){
				$out .= '<script type="text/javascript" src="'.MAIN_DIR.'/public/js/jquery-1.11.2.min.js"></script>
				<!-- Latest compiled and minified CSS -->
				<link rel="stylesheet" href="'.MAIN_DIR.'/_plugins/bootstrap/css/bootstrap.min.css">
				<!-- Optional theme -->
				<link rel="stylesheet" href="'.MAIN_DIR.'/_plugins/bootstrap/css/bootstrap-theme.min.css">

				<link rel="stylesheet" type="text/css" href="'.MAIN_DIR.'/public/css/general.css" />
				<link rel="stylesheet" type="text/css" href="'.MAIN_DIR.'/public/css/'.$_GET["lang"].'.css" />
				
				 <!--OWL Slider START-->
				<link rel="stylesheet" href="'.MAIN_DIR.'/_plugins/owl.carousel/owl-carousel/owl.carousel.css">	 
				<link rel="stylesheet" href="'.MAIN_DIR.'/_plugins/owl.carousel/owl-carousel/owl.theme.css">	 
				<script src="'.MAIN_DIR.'/_plugins/owl.carousel/owl-carousel/owl.carousel.js"></script>
			    <!--OWL Slider END-->
			    <script type="text/javascript">
				$(document).ready(function() {
						$("#owl-demo").owlCarousel({ 
								autoPlay : true, 
								autoHeight : true, 
								navigation : false, // Show next and prev buttons
								navigationText : ["<",">"], 
								//Lazy load
							    lazyLoad : false,
							    lazyFollow : true,
							    lazyEffect : false,
								paginationNumbers: true,
								slideSpeed : 1000,
								paginationSpeed : 400,
								singleItem:true
						});
				});
				</script>
				
				<!--LOAD MAP START-->
				<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
				<script type="text/javascript">
				function initialize() {
				var mapOptions = {
				zoom: 17,
				center: new google.maps.LatLng(41.7243112,44.7772948)
				}
				var map = new google.maps.Map(document.getElementById(\'map-canvas\'), mapOptions);
				setMarkers(map, beaches);
				}
				var beaches = [
				[\''.MAIN_DIR.'/'.$_GET["lang"].'/contact'.'\', 41.7243112,44.7772948]
				];

				function setMarkers(map, locations) {
				var image = {
				url: \'public/img/anchor-icon.png\',
				size: new google.maps.Size(29, 38),
				origin: new google.maps.Point(0,0),
				anchor: new google.maps.Point(40, 15)
				};
				var shape = {
				coord: [1, 1, 1, 20, 18, 20, 18 , 1],
				type: \'poly\'
				};
				for (var i = 0; i < locations.length; i++) {
				var beach = locations[i];
				var myLatLng = new google.maps.LatLng(beach[1], beach[2]);
				var marker = new google.maps.Marker({
				position: myLatLng,
				map: map,
				icon: image,
				shape: shape,
				title: beach[0],
				zIndex: beach[3]
				});
				}
				}

				google.maps.event.addDomListener(window, \'load\', initialize);
				</script>
				<!--LOAD MAP END-->
				<script type="text/javascript" src="'.MAIN_DIR.'/public/js/scripts.js"></script>
				<!-- Latest compiled and minified JavaScript -->
				<script src="'.MAIN_DIR.'/_plugins/bootstrap/js/bootstrap.min.js"></script>
				<!--[if lt IE 9]>
				<script src="'.MAIN_DIR.'/_plugins/bootstrap/js/html5shiv.min.js"></script>
				<script src="'.MAIN_DIR.'/_plugins/bootstrap/js/respond.min.js"></script>
				<![endif]-->';			
		}
		}else if($type=="news"){
				$out .= '<script type="text/javascript" src="'.MAIN_DIR.'/public/js/jquery-1.11.2.min.js"></script>
				<!-- Latest compiled and minified CSS -->
				<link rel="stylesheet" href="'.MAIN_DIR.'/_plugins/bootstrap/css/bootstrap.min.css">
				<!-- Optional theme -->
				<link rel="stylesheet" href="'.MAIN_DIR.'/_plugins/bootstrap/css/bootstrap-theme.min.css">

				<link rel="stylesheet" type="text/css" href="'.MAIN_DIR.'/public/css/general.css" />
				<link rel="stylesheet" type="text/css" href="'.MAIN_DIR.'/public/css/'.$_GET["lang"].'.css" />
				<script type="text/javascript">
				// scroll loader
				$(window).scroll(function() {         
				if($(window).scrollTop() + $(window).height() == $(document).height()) 
				{
					loadNews();
				}
				});
				</script>
				<script type="text/javascript" src="'.MAIN_DIR.'/public/js/scripts.js"></script>
				<!-- Latest compiled and minified JavaScript -->
				<script src="'.MAIN_DIR.'/_plugins/bootstrap/js/bootstrap.min.js"></script>
				<!--[if lt IE 9]>
				<script src="'.MAIN_DIR.'/_plugins/bootstrap/js/html5shiv.min.js"></script>
				<script src="'.MAIN_DIR.'/_plugins/bootstrap/js/respond.min.js"></script>
				<![endif]-->
				<!--Blank and White START-->
				<script src="'.MAIN_DIR.'/_plugins/BlackAndWhite/src/jquery.BlackAndWhite.js"></script>
				<script type="text/javascript">
				$(window).load(function(){
					$(".error-404-articleImg a").css({"position":"relative", "display":"block"});
  					$(".error-404-articleImg a").BlackAndWhite({
        				hoverEffect : true, 
        				webworkerPath : false,
        				intensity:1,
        				speed: { 
            				fadeIn: 500, 
            				fadeOut: 1000 
        				}
    				});
				});
				</script>
				<!--Blank and White END-->
				';			
		}else if($type=="catalog"){
			$out .= '<link rel="stylesheet" href="public/scripts/gallery/dist/magnific-popup.css" type="text/css" />';
		}else if($type=="gallery"){
			$out .= '<link rel="stylesheet" href="public/scripts/gallery/dist/magnific-popup.css" type="text/css" />';
		}
		return $out;
	}
	
	public function images($cat_id){
		$select = mysql_query("SELECT 		
		`website_gallery_attachment`.`connect_id`='".(int)$cat_id."' AND 
		`website_gallery_attachment`.`langs`='".mysql_real_escape_string($_GET["lang"])."' AND 
		`website_gallery_attachment`.`gallery_idx`=`website_gallery`.`idx` AND 
		`website_gallery`.`idx` = `website_gallery_photos`.`gallery_id`
		");
	}
	
	public function post_newsletter(){
		if(isset($_POST["email"],$_POST["subscribe"]) && !empty($_POST["email"])){
			if($_SESSION['count'] >= 3){
				if(empty($_POST["picture"])){ return false; }
				if($_POST["picture"]!=$_SESSION['encoded']){ return false; } 
			}
			if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
				return 2;
				exit();
			}
			if(isset($_POST["langs"]) && count($_POST["langs"]) >= 1){
				foreach($_POST["langs"] as $l)
				{
					if(!$l){ continue; }
					if($_POST["subscribe"]==1){ 
						$select = mysql_query("SELECT `id` FROM `website_newsletter` WHERE 
						`email`='".mysql_real_escape_string($_POST["email"])."' AND 
						`langs`='".mysql_real_escape_string($l)."' AND 
						`status`!=1
						");
						if(!mysql_num_rows($select)){
							$insert = mysql_query("INSERT INTO `website_newsletter` SET 
								`ip`='".$_SERVER["REMOTE_ADDR"]."', 
								`date`='".time()."', 
								`email`='".mysql_real_escape_string($_POST["email"])."', 
								`langs`='".mysql_real_escape_string($l)."' 
							"); 
							$msg = 1;
						}else{
							$msg = 2;
						}
					}else{
						$update = mysql_query("UPDATE `website_newsletter` SET `status`=1 WHERE 
						`email`='".mysql_real_escape_string($_POST["email"])."' AND 
						`langs`='".mysql_real_escape_string($l)."' 
						");
						$msg = 1;
					}
				}
			}
			else
			{
				if($_POST["subscribe"]==1){ 
					$select = mysql_query("SELECT `id` FROM `website_newsletter` WHERE 
					`email`='".mysql_real_escape_string($_POST["email"])."' AND `status`!=1
					");
					if(!mysql_num_rows($select)){
						$insert = mysql_query("INSERT INTO `website_newsletter` SET 
							`langs`=1, 
							`ip`='".$_SERVER["REMOTE_ADDR"]."', 
							`date`='".time()."', 
							`email`='".mysql_real_escape_string($_POST["email"])."'
						"); 
						$msg = 1;
					}else{
						$msg = 2;
					}
				}else{
					$update = mysql_query("UPDATE `website_newsletter` SET `status`=1 WHERE `email`='".mysql_real_escape_string($_POST["email"])."' ");
					$msg = 1;
				}
			}	
		}else{
			$msg = 2;
		}
		$_SESSION['count']++;
		return $msg;
	}
	
	
	public function check_email_address($email) 
	{
		if (!preg_match("/^[^@]{1,64}@[^@]{1,255}$/", $email)) {
			return false;
		}
		$email_array = explode("@", $email);
		$local_array = explode(".", $email_array[0]);
		for ($i = 0; $i < sizeof($local_array); $i++) {
			if (!preg_match("/^(([A-Za-z0-9!#$%&'*+\/=?^_`{|}~-][A-Za-z0-9!#$%&'*+\/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$/", $local_array[$i])) {
			return false;
			}
		}
		if (!preg_match("/^\[?[0-9\.]+\]?$/", $email_array[1])) {
			$domain_array = explode(".", $email_array[1]);
			if (sizeof($domain_array) < 2) {
				return false; 
			}
			for ($i = 0; $i < sizeof($domain_array); $i++) {
				if (!preg_match("/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$/", $domain_array[$i])) {
					return false;
				}
			}
		}
		return true;
	}
	
	public function mailHtmlTo($subject,$p_person,$p_email,$p_phone,$p_subject,$p_letter)
	{
		if($this->check_email_address($p_email)){
			$text = '<div style="width:116px; height:139px; margin:0 auto;"><img src="'.MAIN_DIR.'/public/img/logo.png" width="116" height="139" alt="logo" style="border:0;" /></div>';
			$text .= '<br /><hr style="width:100%; height:1px; background:#0030b8; margin:10px 0" />';
			$text .= '<h3>'.strip_tags($p_subject).'</h3>';
			$text .= '<b>Date</b>: '.date("d/m/Y H:s").'<br />';
			$text .= "<b>IP</b>: ".$_SERVER["REMOTE_ADDR"]."<br />";
			$text .= "<b>Name</b>: ".html_entity_decode($p_person)."<br />";
			$text .= "<b>Email</b>: ".html_entity_decode($p_email)."<br />";
			$text .= "<b>Phone</b>: ".html_entity_decode($p_phone)."<br />";
			$text .= html_entity_decode($p_letter)."<br />";
			$text .= '<p><a href="'.MAIN_DIR.'" style="color:#0030b8">'.$MAIN_DIR.'</a></p>';		
			$headers = "From: " . strip_tags($p_email) . "\r\n";
			$headers .= "Reply-To: ". strip_tags($p_email) . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
			$message = '<html><head><title>Cruise.ge</title></head><body style="background-image:url(\''.MAIN_DIR.'/public/img/pattern.jpg\'); padding:20px;">';
			$message .= wordwrap($text, 988, "\n");
			$message .= '</body></html>';
			$main_email = MAIN_EMAIL;
			$mail = mail($main_email, $subject, $message, $headers);
			if($mail){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	public function studio404_search($post)
	{
		$post = strip_tags($post);
		$sql = "
		(SELECT `id` AS page_id, `idx` AS page_idx, `title` AS page_title, `text` AS page_text, `url` AS page_url, `type` AS page_type FROM `website_menu` WHERE MATCH (`title`,`text`) AGAINST ('".mysql_real_escape_string($post)."') AND `langs`='".mysql_real_escape_string($_GET["lang"])."' AND `visibility`=0 AND `status`=0 AND `type`='text' )
		UNION
		(SELECT
		`website_news_items`.`id` AS page_id,
		`website_news_items`.`idx` AS page_idx,
		`website_news_items`.`title` AS page_title,
		`website_news_items`.`long_text` AS page_text, 
		`website_menu`.`url` AS page_url, 
		`website_menu`.`type` AS page_type 
		FROM 
		`website_menu`, `website_news_attachment`, `website_news`, `website_news_items` 
		WHERE 
		MATCH (`website_news_items`.`title`,`website_news_items`.`long_text`) AGAINST ('".mysql_real_escape_string($post)."') AND 
		`website_menu`.`type`='news' AND 
		`website_menu`.`langs`='".mysql_real_escape_string($_GET["lang"])."' AND 
		`website_menu`.`visibility`!=1 AND 
		`website_menu`.`status`!=1 AND 
		`website_menu`.`idx`=`website_news_attachment`.`connect_id` AND 
		`website_news_attachment`.`langs`='".mysql_real_escape_string($_GET["lang"])."' AND 
		`website_news_attachment`.`news_idx`=`website_news`.`idx` AND 
		`website_news`.`langs`='".mysql_real_escape_string($_GET["lang"])."' AND 
		`website_news`.`status`!=1 AND 
		`website_news`.`idx`=`website_news_items`.`news_idx` AND 
		`website_news_items`.`langs`='".mysql_real_escape_string($_GET["lang"])."' AND 
		`website_news_items`.`status`!=1
		)
		UNION
		(SELECT
		`website_catalogs_items`.`idx` AS page_idx,
		`website_catalogs_items`.`id` AS page_id,
		`website_catalogs_items`.`namelname` AS page_title, 
		`website_catalogs_items`.`shortbio` AS page_text, 
		`website_menu`.`url` AS page_url, 
		`website_menu`.`type` AS page_type 
		FROM 
		`website_menu`, `website_catalogs_attachment`, `website_catalogs`, `website_catalogs_items` 
		WHERE 
		MATCH (`website_catalogs_items`.`namelname`,`website_catalogs_items`.`shortbio`) AGAINST ('".mysql_real_escape_string($post)."') AND 
		`website_menu`.`type`='catalog' AND 
		`website_menu`.`langs`='".mysql_real_escape_string($_GET["lang"])."' AND 
		`website_menu`.`visibility`!=1 AND 
		`website_menu`.`status`!=1 AND 
		`website_menu`.`idx`=`website_catalogs_attachment`.`connect_id` AND 
		`website_catalogs_attachment`.`langs`='".mysql_real_escape_string($_GET["lang"])."' AND 
		`website_catalogs_attachment`.`catalog_id`=`website_catalogs`.`idx` AND 
		`website_catalogs`.`langs`='".mysql_real_escape_string($_GET["lang"])."' AND 
		`website_catalogs`.`status`!=1 AND 
		`website_catalogs`.`idx`=`website_catalogs_items`.`catalog_id` AND 
		`website_catalogs_items`.`langs`='".mysql_real_escape_string($_GET["lang"])."' AND 
		`website_catalogs_items`.`status`!=1
		)
		LIMIT 50
		";
		$query = mysql_query($sql);
		$out = '<ul>';
		if(mysql_num_rows($query)){
			while($rows = mysql_fetch_array($query))
			{
				if($rows["page_type"]=="text"){
					$path = $rows["page_url"];
				}else if($rows["page_type"]=="news"){
					$path = $rows["page_url"]."/".$rows["page_idx"]."-".$rows["page_title"];
				}else if($rows["page_type"]=="catalog"){
					$path = $rows["page_url"]."/".$rows["page_idx"]."-".$rows["page_title"];
				}
				$text = $this->cut_text(strip_tags(stripslashes($rows["page_text"])),250);
				$out .= '<li>';
				$out .= '<a href="'.$path.'">'.strip_tags(stripslashes($rows["page_title"])).'</a><br />';
				$out .= '<span>'.strip_tags(stripslashes($text)).'</span>';
				$out .= '</li>';
			}
		}else{
			$out .= '<li>';
			$out .= '%notFound%';
			$out .= '</li>';
		}
		$out .= '</ul>';
		return $out;
	}
	
	public function cut_text($text,$number,$dots=false)
	{
		if($dots){ $d=""; }else{ $d="..."; }
		$charset = 'UTF-8';
		$length = $number;
		$string = strip_tags(stripslashes($text));
		if(mb_strlen($string, $charset) > $length) {
		$string = mb_substr($string, 0, $length, $charset) . $d;
		}
		else
		{
			$string=$text;
		}
		return $string; 
	}
	
	public function breadCraps()
	{
		$url = mysql_real_escape_string($_GET["lang"])."/".mysql_real_escape_string($_GET["url"]);
		//echo $url;
		$select = mysql_query("SELECT `title`,`cat_id`,`menu_type`,`url`,`type` FROM `website_menu` WHERE `url`='".mysql_real_escape_string($url)."' AND `langs`='".mysql_real_escape_string($_GET["lang"])."' AND `status`!=1");
//		echo "SELECT `title`,`cat_id`,`menu_type`,`url` FROM `website_menu` WHERE `url`='".mysql_real_escape_string($url)."' AND `langs`='".mysql_real_escape_string($_GET["lang"])."' AND `status`!=1";
		if(mysql_num_rows($select)){
			$rows = mysql_fetch_array($select);
			
				$out .= '<a href="'.$rows["url"].'">'.$rows["title"].'</a>';
				$m = $rows["menu_type"];
				$c = $rows["cat_id"];
				if($m>=1){ 
					$out .= $this->subCraps($c);
				}
			
		}
		return $out;
	}

	public function subCraps($c_id){
		$select = mysql_query("SELECT `title`,`cat_id`,`menu_type`,`url`,'type' FROM `website_menu` WHERE `langs`='".mysql_real_escape_string($_GET["lang"])."' AND `idx`='".(int)$c_id."' AND `visibility`!=1 AND `status`!=1");
		if(mysql_num_rows($select)){
			$rows = mysql_fetch_array($select);
			
			$out .= '~<a href="'.$rows["url"].'">'.$rows["title"].'</a>';
			$m = $rows["menu_type"];
			$c = $rows["cat_id"];
			if($m>=1){
				$out .= $this->subCraps($c);
			}
		}
		return $out;
	}
	
	public function outCraps()
	{
		$out = '<a href="/">%main%</a>&nbsp;&nbsp;/&nbsp;&nbsp;';
		$ex = explode("~",$this->breadCraps()); // 3
		for($x=(count($ex)-1);$x>=0;$x--){
			$sep = ($x!=0) ? "&nbsp;&nbsp;/&nbsp;&nbsp;" : "";
			$out .= $ex[$x].$sep;
		}
		if($_GET['news_titile']&&$_GET["url"]!="search" && !isset($_GET["catalog"])){ 		
			$select_newstitle = mysql_query("SELECT `date`,`title` FROM `website_news_items` WHERE `idx`='".(int)$_GET['news_titile']."' AND  `langs`='".mysql_real_escape_string($_GET["lang"])."' ");
			if(mysql_num_rows($select_newstitle)){
				$rows_t = mysql_fetch_array($select_newstitle); 
				$outName = $rows_t["title"];
			}else{ $outName=''; }
			
			$current_url = $_GET['lang']."/".$_GET['url']."/".date("Y",$rows_t["date"])."/".date("m",$rows_t["date"])."/".$_GET["news_titile"];
			
			$out .= "&nbsp;&nbsp;/&nbsp;&nbsp;<a href='".$current_url."'>".html_entity_decode($outName)."</a>";
		}else if(isset($_GET["catalog"]))
		{
			$select_newstitle = mysql_query("SELECT `namelname` FROM `website_catalogs_items` WHERE `idx`='".(int)$_GET['news_titile']."' AND  `langs`='".mysql_real_escape_string($_GET["lang"])."' AND `status`!=1 ");
			if(mysql_num_rows($select_newstitle)){
				$rows_t = mysql_fetch_array($select_newstitle); 
				$outName = $rows_t["namelname"];
			}else{ $outName=''; }
			
			$current_url = $_GET['lang']."/".$_GET['url']."/".$_GET["news_titile"];
			
			$out .= "&nbsp;&nbsp;/&nbsp;&nbsp;<a href='".$current_url."'>".html_entity_decode($outName)."</a>";
		}else if($_GET["url"]=="search"){
			$current_url = $_GET['lang']."/".$_GET['url'];
			$out .= "<a href='".$current_url."'>%search%</a>";
		}
		return $out;
	}
	
	public function check_sh($column)
	{
		$select = mysql_query("SELECT `status` FROM `website_sh` WHERE `name`='".mysql_real_escape_string($column)."' ");
		if(mysql_num_rows($select)){
			$rows = mysql_fetch_array($select);
			if($rows["status"]){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	public function videoTeka($chanel_id, $limit){
		$select = mysql_query("SELECT `title`, `video_link` FROM `website_youtube_videos` WHERE `channel_id`='".(int)$chanel_id."' AND `upload_status`='uploaded' AND `status`!=1 ORDER BY `id` DESC LIMIT ".$limit);
		if(mysql_num_rows($select))
		{
		$out = '<ul>';
		while($rows = mysql_fetch_array($select))
		{
			$out .= '<li><a href="https://www.youtube.com/watch?v='.html_entity_decode($rows["video_link"]).'" class="gallery"><img src="http://img.youtube.com/vi/'.html_entity_decode($rows["video_link"]).'/0.jpg" width="95" height="75" alt="'.html_entity_decode($rows["title"]).'" title="'.html_entity_decode($rows["title"]).'" /><div class="pl_bt"></div></a></li>';
		}
		$out .= '</ul>';
		}
		return $out;
	}
	
	public function photoTeka($limit){
		$select = mysql_query("SELECT 
		`website_gallery_photos`.`title` AS gp_title, 
		`website_gallery_photos`.`photo` AS gp_photo
		FROM 
		`website_gallery`, `website_gallery_attachment`, `website_gallery_photos` 
		WHERE 
		`website_gallery`.`langs`='".mysql_real_escape_string($_GET["lang"])."' AND 
		`website_gallery`.`status`!=1 AND 
		`website_gallery`.`idx`=`website_gallery_attachment`.`gallery_idx` AND 
		`website_gallery_attachment`.`langs`='".mysql_real_escape_string($_GET["lang"])."' AND 
		`website_gallery_attachment`.`gallery_idx`= `website_gallery_photos`.`gallery_id` AND 
		`website_gallery_attachment`.`type` = 'gallery' AND 
		`website_gallery_photos`.`langs`= '".mysql_real_escape_string($_GET["lang"])."' AND 
		`website_gallery_photos`.`status`!= 1
		ORDER BY `website_gallery_photos`.`position` DESC LIMIT ".$limit);
		if(mysql_num_rows($select))
		{
		$out = '<ul>';
		while($rows = mysql_fetch_array($select))
		{
			$out .= '<li><a href="image/gallery/'.html_entity_decode($rows["gp_photo"]).'" class="gallery"><img src="crop.php?img=image/gallery/'.html_entity_decode($rows["gp_photo"]).'&width=95&height=75" width="95" height="75" alt="'.html_entity_decode($rows["gp_title"]).'" title="'.html_entity_decode($rows["gp_title"]).'" /></a></li>';
		}
		$out .= '</ul>';
		}
		return $out;
	}
	
	public function cUrlFunction($host_ip,$host,$get_url,$data,$referer){
	
		$curl = curl_init($host_ip);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array("Host: $host"));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);		
		curl_setopt($curl, CURLOPT_URL, $get_url);
		curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT'] );    
		curl_setopt($curl, CURLOPT_POST, 1); 
		curl_setopt($curl, CURLOPT_COOKIE,"SPA=jodomv7dghetj36kk2gpfnt9r1; SPALITE=sq9povmd9refqlvumu1m60hpe4");
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data); 
		curl_setopt($curl, CURLOPT_REFERER, $referer);
		$resp = curl_exec($curl);		
		curl_close($curl);		
		return $resp;
		
	}
	
	public function CreateTenderPage()
	{
		$create_file_name = '_temporaty/tenders.php';
		
		if(!file_exists($create_file_name))
		{
			ob_start();		
			@include('_plugins/simpleHtmlDom/simple_html_dom.php');
			$host_ip = ''; //212.58.116.79
			$host = 'tenders.procurement.gov.ge';
			$httpx = 'https://tenders.procurement.gov.ge/public/lib/controller.php?lang=ge';
			$referer = 'https://tenders.procurement.gov.ge/public/?lang=ge';			
			$http_build_query = "action=search_app&org_a=საქართველოს%20სასჯელაღსრულებისა%20და%20პრობაციის%20სამინისტრო&app_shems_id=39426&app_amount_from=0&app_amount_to=120&page=1";
			$cUrlFunction = $this->cUrlFunction($host_ip,$host, $httpx,$http_build_query,$referer);
			$http_build_query2 = "action=search_app&org_a=საქართველოს%20სასჯელაღსრულებისა%20და%20პრობაციის%20სამინისტრო&app_shems_id=39426&app_amount_from=0&app_amount_to=120&page=2";
			$cUrlFunction .= $this->cUrlFunction($host_ip,$host, $httpx,$http_build_query2,$referer);
			$http_build_query3 = "action=search_app&org_a=საქართველოს%20სასჯელაღსრულებისა%20და%20პრობაციის%20სამინისტრო&app_shems_id=39426&app_amount_from=0&app_amount_to=120&page=3";
			$cUrlFunction .= $this->cUrlFunction($host_ip,$host, $httpx,$http_build_query3,$referer);
			$html = str_get_html($cUrlFunction);
			$tender_data = array();
			foreach($html->find('tr') as $e){
			$app_id = str_replace("A","",$e->id);
			$tender_data["app_id"][] .=  $app_id;
			$test_http = "action=app_docs&app_id=".$app_id."&key=db435da479473acecaf970a1d05c54cd";
			$test_call_cUrl =  $this->cUrlFunction($host_ip,$host, $httpx,$test_http,$referer);
			$test_html = str_get_html($test_call_cUrl);
			foreach($test_html->find('.obsolete0 a') as $e){
				$tender_data["file"][] .=  $e->href;
			}
			}
			foreach($html->find('.color-2') as $e){
			$tender_data["color2"][] .=  $e->plaintext;
			}
			foreach($html->find('tr') as $e){
			$tender_data["info"][] .= preg_replace("/<img[^>]+\>/i", "", $e->innertext); 
			}

			$out = '<div class="tender_data">';
			$out .= '<ul>';
			for($x=0; $x<=count($tender_data["app_id"]); $x++)
			{
			if(!$tender_data["color2"][$x]){ continue; }						
			$out .= '<li>';
			$out .= '<a href="https://tenders.procurement.gov.ge/public/'.$tender_data["file"][$x].'" target="_blank"><strong>'.$tender_data["color2"][$x].'</strong></a>';
			$out .= strip_tags($tender_data["info"][$x],"<br><p>");
			$out .= '</li>';
			}	
			$out .= '</ul>';
			$out .= '</div>';	
			echo $out;
			$output = ob_get_contents();
			ob_end_clean();
			$fp = fopen($create_file_name, 'w');
			fwrite($fp, $output);
			fclose($fp);
			$get_page = file_get_contents($create_file_name);
		}else{
			$get_page = file_get_contents($create_file_name);
		}
		return $get_page;
	}
	
	public function keywords()
	{
		$keywords = "";		
		$current_url = $_GET['lang']."/".$_GET['url'];
		$sql = "SELECT `meta_keywords` FROM `website_menu` WHERE `status`!=1 AND `langs`='".mysql_real_escape_string($_GET['lang'])."' AND `url`='".mysql_real_escape_string($current_url)."' ";
		$query = mysql_query($sql);
		if(mysql_num_rows($query))
		{
			$rows = mysql_fetch_array($query);
			$keywords = $rows["meta_keywords"];
		}			
		if(!$keywords){ $keywords = "%websitemetatitle%"; }
		
		return $keywords;
	}
	
}
