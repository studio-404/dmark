<?php

class error_module extends module {

    function __construct() {
        parent::__construct();		
		$this->main_navigation = $this->main_nav_module();	
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

}

