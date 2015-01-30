<?php 
session_start();
@require('../../config.php');
@require("../../_constants.php");
@require('../functions/functions.php');

$update = mysql_query("UPDATE website_files SET status=1 WHERE id='".(int)$_GET['id']."' ");
if($update){ echo "1"; }
?>