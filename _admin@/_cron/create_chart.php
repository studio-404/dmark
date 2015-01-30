<?php
@require("../../config.php");
@require("../../_constants.php");
@require("../functions/functions.php");
// update cron time
$update = mysql_query("UPDATE `website_croned` SET `date`='".time()."' WHERE `id`=6 AND `type`='create_chart' ");
/*
** select news letter
*/
$select_chart = mysql_query("SELECT `id`,`idx`,`chart_title`,`chart_name`,`chart_file`,`langs` FROM `website_charts` WHERE `create_status`='inprogress' AND `status`!=1 ");
if(mysql_num_rows($select_chart))
{	
	while($charts = mysql_fetch_array($select_chart))
	{
		$id = $charts["id"];
		$idx = $charts["idx"];
		$chart_title = $charts["chart_title"];
		$chart_name = $charts["chart_name"];
		$chart_file = $charts["chart_file"];
		$langs = $charts["langs"];
		$path = 'title='.$chart_title.'&';
		
		if($chart_name=="mobile_phone_sub")
		{
			$select_items = mysql_query("SELECT `name`, `year`, `value`, `num` FROM `website_charts_items2` WHERE `chart_idx`='".(int)$idx."' AND `langs`='".mysql_real_escape_string($langs)."' ");
			if(mysql_num_rows($select_items))
			{
				while($item = mysql_fetch_array($select_items))
				{		
					$path .= "year[".$item["name"]."][]=".$item["year"]."&val[".$item["name"]."][]=".$item["value"]."&";
				}
				ob_start();			
				$url = MAIN_DIR."_plugins/canvas/".$chart_name.".php";
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $path);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$response = curl_exec($ch);
				curl_close($ch);
				echo $response;
				$data = ob_get_contents();
				ob_end_clean();
				$file = ROOT.'_charts/'.$chart_file;
				@unlink($file);
				_create_file_404($file,$data);
				$update_created = mysql_query("UPDATE `website_charts` SET `create_status`='created' WHERE `id`='".(int)$id."' ");
				$ch = "";
			}
		}
		else
		{
			$select_items = mysql_query("SELECT `label_name`, `label_value` FROM `website_charts_items` WHERE `chart_idx`='".(int)$idx."' AND `langs`='".mysql_real_escape_string($langs)."' ");
			if(mysql_num_rows($select_items))
			{
				while($item = mysql_fetch_array($select_items))
				{
					$path .= 'name[]='.$item["label_name"]."&val[]=".$item["label_value"]."&";
				}
				ob_start();			
				$url = MAIN_DIR."_plugins/canvas/".$chart_name.".php";
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $path);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$response = curl_exec($ch);
				curl_close($ch);
				echo $response;
				$data = ob_get_contents();
				ob_end_clean();
				$file = ROOT.'_charts/'.$chart_file;
				@unlink($file);
				_create_file_404($file,$data);
				$update_created = mysql_query("UPDATE `website_charts` SET `create_status`='created' WHERE `id`='".(int)$id."' ");
				$ch = "";
			}
		}
	}
}
?>