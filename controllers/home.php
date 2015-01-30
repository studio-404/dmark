<?php

class home extends controller {

    function __construct() {
        parent::__construct();
        require 'modules/home_module.php';

        $module = new home_module;
        $this->view->msg = $module->msg;
        $this->view->main_navigation = $module->main_navigation;
        $this->view->main_navigation_bottom = $module->main_navigation_bottom;
        $this->view->get_content = $module->get_content;
        $this->view->get_slide_array = $module->get_slide;
        
        //output       
        $this->view->render("home/index");
    }

}
