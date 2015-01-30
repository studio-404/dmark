<?php
error_reporting(0);
require '../config.php';
function insert($poll_idx,$answer_idx){
	$ip = $_SERVER['REMOTE_ADDR'];
	//check if exists
	$p = mysql_query("SELECT `id` FROM `website_poll` WHERE `idx`='".(int)$poll_idx."' AND `type`='q' AND `status`!=1 AND `langs`='".mysql_real_escape_string($_GET['lang'])."' ");
	if(mysql_num_rows($p)){
		$a = mysql_query("SELECT `id` FROM `website_poll` WHERE `idx`='".(int)$answer_idx."' AND `cat_id`='".(int)$poll_idx."' ");
		if(mysql_num_rows($a)){
			$delete = mysql_query("DELETE FROM `website_poll_answers` WHERE `ip_address`='".mysql_real_escape_string($ip)."' AND `poll_idx`='".(int)$poll_idx."' ");
			$query = mysql_query("INSERT INTO `website_poll_answers` SET `ip_address`='".mysql_real_escape_string($ip)."', `poll_idx`='".(int)$poll_idx."', `answer_idx`='".(int)$answer_idx."' ");
		}
	}
}
insert($_GET['poll_id'],$_GET["answer_id"]);
function studio404_count_poll($poll_idx,$answer_idx){
		$select_answers1 = mysql_query("SELECT COUNT(id) AS cc FROM `website_poll_answers` WHERE `poll_idx`='".(int)$poll_idx."' ");
		$out=0;
		if(mysql_num_rows($select_answers1)){
			$answer_all = mysql_fetch_array($select_answers1);
			$cc = $answer_all["cc"]; // all answers for this polls 200
			$select_answers2 = mysql_query("SELECT * FROM `website_poll_answers` WHERE `poll_idx`='".(int)$poll_idx."' AND `answer_idx`='".(int)$answer_idx."' ");
			$tt = mysql_num_rows($select_answers2); // answers only this 100
			if($tt!=0){
				$a = $cc/$tt;
				$out = 100/$a;
			}else{
				$out = 0;
			}
		}
		return floor($out);
	}

		$out = '';
		$select = mysql_query("SELECT * FROM `website_poll` WHERE `idx`='".(int)$_GET['poll_id']."' AND `type`='q' AND `status`!=1 AND `langs`='".mysql_real_escape_string($_GET['lang'])."' LIMIT 1 ");
		if(mysql_num_rows($select)){
			$rows = mysql_fetch_array($select);
			$select_a = mysql_query("SELECT * FROM `website_poll` WHERE `type`='a' AND `cat_id`='".(int)$rows["idx"]."' AND `status`!=1 AND `langs`='".mysql_real_escape_string($_GET['lang'])."' ORDER BY `idx` ASC ");
			$answer_nums = mysql_num_rows($select_a);
			$out .= '';
			if(mysql_num_rows($select_a)){
				while($rows_a = mysql_fetch_array($select_a)){ 
					$pro = studio404_count_poll($rows["idx"],$rows_a["idx"]);
					$out .= '<div class="a" onclick="poll('.$rows["idx"].','.$rows_a["idx"].',\''.$_GET['lang'].'\')">';
					$out .= '<div class="background" style="width:'.$pro.'%"></div>'; 
					$out .= '<div class="span">'.html_entity_decode($rows_a["title"]).' '.$pro.'% </div>';
					$out .= '</div>'; 
					$pro=0;
				}
			}
			$out .= '';
		}
		echo $out;
?>