<?php
 
class bootstrap {

    function __construct() {
		
        $file = "controllers/render.php";
        if (file_exists($file)) {
            require_once $file;
        } else {
			$select_languages = select_languages();		
			if(!in_array($_GET['lang'], $select_languages["language"])){ $_GET['lang']=MAIN_LANGUAGE; }
            echo '<meta http-equiv="refresh" content="0;url='.MAIN_DIR.$_GET['lang'].'/error" />';
            return FALSE;
        }
        $controllers = new render;
		
    }

}
