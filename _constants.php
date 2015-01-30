<?php

function url(){
  return sprintf(
    "%s://%s",
    isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
    $_SERVER['SERVER_NAME']
  );
} 

define("MAIN_DIR", url());
define("ROOT",$_SERVER["DOCUMENT_ROOT"]);
$url = filter_input(INPUT_GET, "url"); 
$rtrim = rtrim($url, "/"); 
define("URL",$rtrim);
define("ADMIN_FOLDER","_admin@"); 
define("MAIN_LANGUAGE","ka"); 
define("CURRENT_URL","http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"); 
// define("HOME","http://mcla.404.ge/mcla@/");
// define("ERROR_PAGE","http://mcla.404.ge/mcla@/ka/error");
define("WEBSITE_NAME_KA","სასჯელაღსრულებისა და პრობაციის სამინისტრო");
define("WEBSITE_NAME_EN","MINISTRY OF CORRECTIONS OF GEORGIA");
define("MAIN_EMAIL","info@moc.gov.ge");
define("TIMEZONE","Asia/Tbilisi");
?> 