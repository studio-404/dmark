<?php
session_start();
require_once 'google-api-php-client/src/Google/Client.php';
require_once 'google-api-php-client/src/contrib/Google/Service/Plus.php';

$client = new Google_Client();
$client->setApplicationName('Hello Analytics API Sample');

// Visit https://console.developers.google.com/ to generate your
// client id, client secret, and to register your redirect uri.
$client->setClientId('5136283500-ebm66mac8bgo70snf797fis029l4ftaf.apps.googleusercontent.com');
$client->setClientSecret('RtNjommMR_spHUw5CqQfBr2o');
$client->setRedirectUri('http://akademqalaqiedu.ge/404@/HelloAnalyticsApi.php');
$client->setDeveloperKey('AIzaSyDFKVy4MPuT6LAM6DImBB9YR_MWG42T5fQ');
$client->setScopes(array('https://www.googleapis.com/auth/analytics.readonly'));

// Magic. Returns objects from the Analytics Service instead of associative arrays.
$client->setUseObjects(true);


if (isset($_GET['code'])) {
  $client->authenticate();
  $_SESSION['token'] = $client->getAccessToken();
  $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}

if (isset($_SESSION['token'])) {
  $client->setAccessToken($_SESSION['token']);
}

if (!$client->getAccessToken()) {
  $authUrl = $client->createAuthUrl();
  print "<a class='login' href='$authUrl'>Connect Me!</a>";

} else {
	// Create analytics service object. See next step below.
	$analytics = new apiAnalyticsService($client);
	runMainDemo($analytics);
}
?>