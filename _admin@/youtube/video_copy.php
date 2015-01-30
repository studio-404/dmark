<?php
require'auth.php';
require_once 'Zend/Loader.php';

Zend_Loader::loadClass('Zend_Gdata_YouTube');
Zend_Loader::loadClass('Zend_Gdata_ClientLogin');

$authenticationURL= 'https://www.google.com/accounts/ClientLogin';

$httpClient = Zend_Gdata_ClientLogin::getHttpClient(

              $username = $my_username,
              $password = $my_password,
              $service = 'youtube',
              $client = null,
              $source = 'MyYoutubeAPIApp', // a short string identifying your application
              $loginToken = null,
              $loginCaptcha = null,
              $authenticationURL);

$yt = new Zend_Gdata_YouTube($httpClient, "Null", "Null", $developerKey);


#######################################################################################################




/////// update video status
$myVideoEntry = new Zend_Gdata_YouTube_VideoEntry();
$myVideoEntry = $yt->getFullVideoEntry('JoOGBy94Zkk');
echo '<pre>';
print_r($myVideoEntry);
try {

	$yt->updateEntry($myVideoEntry, $putUrl, 'Zend_Gdata_YouTube_VideoEntry'); 
}

catch (Zend_Gdata_App_HttpException $httpException) { 

	echo $httpException->getRawResponseBody(); 
}

catch (Zend_Gdata_App_Exception $e) { 

	echo $e->getMessage(); 
}