<?php
$lang_file = ADMIN_FOLDER."/cache/".$_GET['lang']."_l.php";
@require($lang_file); 
echo $_SESSION["hash_contact"];
?>