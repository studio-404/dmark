<?php 
session_start();
@require('../../config.php');
@require("../../_constants.php");
@require('../functions/functions.php');

if(isset($_GET['action'],$_GET['id'],$_GET['position'])){
	$select = mysql_query("SELECT `idx` FROM `website_banners` WHERE `idx`='".(int)$_GET['id']."' AND `position`='".(int)$_GET['position']."' "); 
	if(mysql_num_rows($select)){
		$ccc = mysql_fetch_array($select);
		if($_GET['action']=="plus"){
			$select_up = mysql_query("SELECT `idx` FROM `website_banners` WHERE `position`='".(int)($_GET['position']+1)."' ");
			if(mysql_num_rows($select_up)){		
				$update1 = mysql_query("UPDATE `website_banners` SET `position`=0 WHERE `idx`='".(int)$_GET['id']."' ");  // 0
				$update2 = mysql_query("UPDATE `website_banners` SET `position`='".(int)$_GET['position']."' WHERE `position`='".(int)($_GET['position']+1)."' "); // 4
				$update3 = mysql_query("UPDATE `website_banners` SET `position`='".(int)($_GET['position']+1)."' WHERE `position`='0' "); // 5
				echo 1;
			}
		}else if($_GET['action']=="minus"){
			$select_down = mysql_query("SELECT `idx` FROM `website_banners` WHERE `position`='".(int)($_GET['position']-1)."' ");
			if(mysql_num_rows($select_down)){			
				$update1 = mysql_query("UPDATE `website_banners` SET `position`=0 WHERE `idx`='".(int)$_GET['id']."' ");  // 0
				$update2 = mysql_query("UPDATE `website_banners` SET `position`='".(int)$_GET['position']."' WHERE `position`='".(int)($_GET['position']-1)."' "); // 3
				$update3 = mysql_query("UPDATE `website_banners` SET `position`='".(int)($_GET['position']-1)."' WHERE `position`='0' "); // 4
				echo 1;
			}
		}
	}
}
?>