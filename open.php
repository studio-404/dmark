<?php
session_start();
// we will do our own error handling
error_reporting(0);
// include mysql database & constants
require '_constants.php'; 
require 'rd_config.php';
//set time zone
date_default_timezone_set(TIMEZONE);
// auto loader
require 'libs/bootstrap.php';
require 'libs/controller.php';
require 'libs/module.php';
require 'libs/view.php';
// caching
//$cach = new controller();
//$cach->caching_headers(__FILE__, filemtime(__FILE__));

// bootstrap
$bootstrap = new bootstrap();
?>