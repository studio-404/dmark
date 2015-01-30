<?php
function str_limit($string, $max_length) {
$full=$string;
if (mb_strlen($string, 'UTF-8') > $max_length){
$string = mb_substr($string, 0, $max_length, 'UTF-8');
$pos = mb_strrpos($string, ' ', false, 'UTF-8');
if($pos === false) {
return ''.mb_substr($string, 0, $max_length, 'UTF-8').'…';
}
return ''.mb_substr($string, 0, $pos, 'UTF-8').'…';
}else{
return $string;
}
}
$developerKey = 'AIzaSyDvqVhVoAPTqRMZ1I8gooXtgkdKnwRQyA8'; // API key:

$my_username = 'giorgigvazava87@gmail.com'; // EMAIL

$my_password = 'hklnzmixharthvmc'; // https://security.google.com/settings/security/apppasswords
?>