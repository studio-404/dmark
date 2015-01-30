<?php

class home_module extends module {

    function __construct() {
        parent::__construct();
        
        $this->msg = $this->out; 
		$this->main_navigation = $this->main_nav_module();
		$this->get_content = $this->get_content();
		$this->get_slide = $this->slides();
    }
	
	function main_nav_module(){
		$out = "";
		$main_navigation = parent::main_navigation();		
		if(mysql_num_rows($main_navigation)){
			$out = "<ul>";
			while($rows = mysql_fetch_array($main_navigation)){
				$url = explode("/",$_GET['url']);
				$getUrl = $_GET['lang']."/".$url[0];
				$active = ($rows['url']==$getUrl) ? 'class="active"' : '';
				$out .= '<li '.$active.'><a href="'.$rows['url'].'">'.strtoupper($rows['title']).'</a></li>';
			}
			$out .= "<ul>";
		}
		return $out;
	}
	
	public function get_content()
	{ 
		$out = ""; 
		$url = filter_input(INPUT_GET, "url"); 
        $rtrim = rtrim($url, "/"); 
        $explode = explode("/", $rtrim); 
		if($explode[0]=="home"){ 	
			$u = ROOT."/views/parts/home.php";
			$out = file_get_contents($u);
		} 
		return $out; 
	}
	
	function slides()
	{
		$slide_array = parent::get_slide_array();
		$out = "_plugins/nivo-slider/demo/demo.php?";
		$iframe='';
		if($_GET['lang']=="ka"){ $class='bpg_banner'; }else{ $class='denseregular'; }
		for($x=0;$x<count($slide_array['title']);$x++)
		{
			$iframe .= "img[]=".$slide_array['image'][$x]."&";
			$iframe .= "title[]=<h1 class='".$class."'>".strtoupper($slide_array['title'][$x])."</h1>".$slide_array['text'][$x]."&";
		}
		$iframe = urldecode($iframe);
		$out = $out.$iframe;
		return $out;
	}

}

