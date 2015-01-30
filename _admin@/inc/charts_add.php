<?php
$msg="";
if(isset($_POST['title'],$_POST['chart'],$_POST['label_name'],$_POST['label_value']))
{	
	if(!empty($_POST['title']) && !empty($_POST['chart']))
	{	
		insert_action("chart","add","0");
		$title = $_POST["title"]; 
		$chart_post = $_POST["chart"]; 

			$chart = mysql_query("SELECT MAX(idx) AS maxi FROM `website_charts` ");
			$getMax = mysql_fetch_array($chart);
			$chartMax = $getMax['maxi']+1;
			
			$chart_item = mysql_query("SELECT MAX(idx) AS maxi FROM `website_charts_items` ");
			$getMaxItem = mysql_fetch_array($chart_item);
			$chartMaxItem = $getMaxItem['maxi']+1;
			
			$chart_item2 = mysql_query("SELECT MAX(idx) AS maxi FROM `website_charts_items2` ");
			$getMaxItem2 = mysql_fetch_array($chart_item2);
			$chartMaxItem2 = $getMaxItem2['maxi']+1;
			
			
			if(!$msg){
				$select_languages = select_languages(); 
				foreach($select_languages["language"] as $language){
					$file_name = time().'_'.$language.'.html';
					$admin_id = $_SESSION['admin_id'];
					$grand_id = implode(",",grand_admins());
					if(!in_array($admin_id,grand_admins())){
						$access_admins = $grand_id.",".$admin_id;
					}else{
						$access_admins = $grand_id;
					}
					
					$insert = mysql_query("INSERT INTO `website_charts` SET 
						`idx`='".(int)$chartMax."',  
						`date`='".time()."',  
						`chart_title`='".strip($title)."',  
						`chart_name`='".strip($chart_post)."',  
						`chart_file`='".strip($file_name)."', 
						`create_status`='inprogress', 
						`langs`='".strip($language)."', 
						`access_admins`='".strip($access_admins)."'
					");
					for($x=0;$x<=count($_POST["label_name"]);$x++){
						$label_name = $_POST["label_name"];
						$label_value = $_POST["label_value"];
						$name_num = count($_POST["label_name"]);
						if(!empty($label_name[$x]) && !empty($label_value[$x]))
						{
							if($chart_post=="mobile_phone_sub"){
								$labelN = $label_name[$x];
								$exp = explode(";",$label_value[$x]);
								$val_num = count($exp);
								foreach($exp as $ex)
								{
									$e = explode(":",$ex);
									$y = $e[0];
									$v = $e[1];
									$insert2 = mysql_query("INSERT INTO `website_charts_items2` SET 
									`idx`='".(int)$chartMaxItem2."',  
									`chart_idx`='".(int)$chartMax."',  
									`name`='".strip($labelN)."',  
									`year`='".strip($y)."',  
									`value`='".strip($v)."',  
									`num`='".(int)$name_num."',  
									`val_num`='".(int)($val_num-1)."',
									`langs`='".strip($language)."' 
									");
								}
							}else{
								if($chart_post=="earthquakes_monthly" || $chart_post=="valueOverYear"){ 
									$date = str_replace('/', '-', $label_name[$x]);
									$label_name[$x] = strtotime($date);
								}
								$insert2 = mysql_query("INSERT INTO `website_charts_items` SET 
									`idx`='".(int)$chartMaxItem."',  
									`chart_idx`='".(int)$chartMax."',  
									`label_name`='".strip($label_name[$x])."',  
									`label_value`='".strip($label_value[$x])."',  
									`langs`='".strip($language)."' 
								");
							}
						}
					}
				}
			} 
			
			if(!$insert)
			{
				$msg = l("erroroccurred");
				$theBoxColore = "red";
			}
			else
			{
				_refresh_404("/".ADMIN_FOLDER."/".$_GET["lang"]."/edit/charts/".$chartMax);
				exit();
				$msg = l("done");
				$theBoxColore = "orange";	
			}
	}
	else
	{
		$msg = l("requiredfields");
		$theBoxColore = "red";
	}
}
?>
<form action="" method="post" enctype="multipart/form-data">
	<?php
	if($msg) :
	?>
	<div class="boxes">
		<div class="error_msg <?=$theBoxColore?>"><i><?=$msg?> !</i></div>
	</div>
	<?php 
	endif;
	?>
	
	<div class="boxes">
		<label for="title"><i><?=l("title")?></i> <font color="#f00">*</font></label>
		<input type="text" name="title" class="title" id="title" value="" />
		<div class="checker_none title" onclick="$('.m_title').fadeIn('slow');">
			<div class="msg m_title"><?=l("filltitle")?> !</div>
		</div>
	</div><div class="clearer"></div>
	
	<div class="boxes">
		<label for="chart"><i><?=l("chart")?></i> <font color="#f00">*</font></label>
		<select name="chart" id="chart" onchange="chart_n(this.value)">
			<option value=""><?=l("choose")?></option>
			<option value="oil_reserves">Oil reserves</option> <!-- name, value -->
			<option value="spend_time">Spend time</option> <!-- name, value -->
			<option value="earthquakes_monthly"><?=l("name")?> {month} Format:(dd/mm/YYYY)</option>
			<option value="valueOverYear"><?=l("name")?> {Year} Format:(dd/mm/YYYY)</option>
			<option value="country_wise">Country wise</option>
			<option value="marketShare">Market share</option>
			<option value="mobile_phone_sub">mobile phone sub { 2012:500; 2013:450 }</option>
		</select>
	</div><div class="clearer"></div>
	
	<div class="boxes" id="chart_img"></div>
	
	<div class="boxes">
		<label for="file" onclick="moroChartanswers()"><i><?=l("add")?></i> <div class="icon-add"></div></label>
	</div><div class="clearer"></div>
	
	<div class="boxes" id="f1">
		<label for="label_name"><i><?=l("name")?></i> <font color="#f00">*</font></label>
		<input type="text" name="label_name[]" class="label_name" value="" />
	</div><div class="clearer"></div>
	
	<div class="boxes" id="f2">
		<label for="label_value"><i><?=l("quentity")?></i> <font color="#f00">*</font></label>
		<input type="text" name="label_value[]" class="label_value" value="" />
	</div><div class="clearer"></div>	
	
	<div class="appaends">
	</div><div class="clearer"></div> 
		
	<div class="boxes">				
		<input type="submit" class="submit" id="submit" value="<?=l("add")?>" />
	</div><div class="clearer"></div><br />
			
</form>