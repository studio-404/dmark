<?php 
session_start();
@require('../../config.php');
@require("../../_constants.php");
@require('../functions/functions.php');


if(isset($_GET['action'],$_GET['idx'],$_GET['position'],$_GET['menu_type'])){
	$select = mysql_query("SELECT idx,cat_id FROM website_menu WHERE idx='".(int)$_GET['idx']."' AND position='".(int)$_GET['position']."' AND menu_type='".(int)$_GET['menu_type']."' AND langs='ka' "); 
	if(mysql_num_rows($select)){
		$ccc = mysql_fetch_array($select);
		if($_GET['action']=="plus"){
			$select_up = mysql_query("SELECT idx FROM website_menu WHERE position='".(int)($_GET['position']+1)."' AND menu_type='".(int)$_GET['menu_type']."' ");
			if(mysql_num_rows($select_up)){
				
				$update1 = mysql_query("UPDATE website_menu SET position=0 WHERE idx='".(int)$_GET['idx']."' AND menu_type='".(int)$_GET['menu_type']."' AND cat_id='".$ccc['cat_id']."' ");  // 0
				$update2 = mysql_query("UPDATE website_menu SET position='".(int)$_GET['position']."' WHERE position='".(int)($_GET['position']+1)."' AND menu_type='".(int)$_GET['menu_type']."' AND cat_id='".$ccc['cat_id']."' "); // 4
				$update3 = mysql_query("UPDATE website_menu SET position='".(int)($_GET['position']+1)."' WHERE position='0'  AND menu_type='".(int)$_GET['menu_type']."' AND cat_id='".$ccc['cat_id']."' "); // 5
				echo 1;
			}
		}else if($_GET['action']=="minus"){
			$select_down = mysql_query("SELECT idx FROM website_menu WHERE position='".(int)($_GET['position']-1)."' AND menu_type='".(int)$_GET['menu_type']."' ");
			if(mysql_num_rows($select_down)){
				$update1 = mysql_query("UPDATE website_menu SET position=0 WHERE idx='".(int)$_GET['idx']."' AND menu_type='".(int)$_GET['menu_type']."' AND cat_id='".$ccc['cat_id']."' ");  // 0
				$update2 = mysql_query("UPDATE website_menu SET position='".(int)$_GET['position']."' WHERE position='".(int)($_GET['position']-1)."' AND menu_type='".(int)$_GET['menu_type']."' AND cat_id='".$ccc['cat_id']."' "); // 3
				$update3 = mysql_query("UPDATE website_menu SET position='".(int)($_GET['position']-1)."' WHERE position='0' AND menu_type='".(int)$_GET['menu_type']."' AND cat_id='".$ccc['cat_id']."' "); // 4
				echo 1;
			}
		}
		//insert action
		insert_action("navigation","move",$_GET['idx']);
	}
}
?>