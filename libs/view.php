<?php

class view {

    function __construct() {
       // echo "View @ ll";
    }
    
    public function render($name)
    {

		if(file_exists("views/".$name.".php")){
			require "views/".$name.".php";
		}else{
			$module = new module();
			$select_languages = $module->select_languages();		
			if(!in_array($_GET['lang'], $select_languages["language"])){ $_GET['lang']=MAIN_LANGUAGE; }
			echo '<meta http-equiv="refresh" content="0;url='.MAIN_DIR.$_GET['lang'].'/error" />';
            return FALSE;
		}
    }

}

