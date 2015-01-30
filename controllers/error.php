<?php

class error extends controller {

    function __construct() {
        parent::__construct();
        require 'modules/error_module.php';
        $module = new error_module;
        $this->view->main_navigation = $module->main_navigation;
        
        //output       
        $this->view->render("error/index");
    }

}
