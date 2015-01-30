<?php
if ((!isset($_SESSION['is_logged'])) || ($_SESSION['is_logged']=FALSE)) header("location: index.html");
?>