<?php
$msg = "";
/*change permition*/
if(isset($_POST["s"])){ change_permition("website_charts",false,$_GET["edit"]); insert_action("chart","change permition",$_GET["edit"]); }
/* check if have permition */
$admin_permition = check_if_permition("website_charts",false,$_GET["edit"]);
if(isset($_POST["post"]) && $admin_permition)
{
	insert_action("charts","edit",$_GET["edit"]);
	// charts
	$once = 1;
	
	$chart_item2 = mysql_query("SELECT MAX(idx) AS maxi FROM `website_charts_items2` ");
	$getMaxItem2 = mysql_fetch_array($chart_item2);
	$chartMaxItem2 = $getMaxItem2['maxi']+1;
	if($_POST["chart_name"]=="mobile_phone_sub"){
		$delete = mysql_query("DELETE FROM `website_charts_items2` WHERE `chart_idx`='".(int)$_GET["edit"]."' ");
	}
	foreach($_POST["post"] as $l => $value){ 
		if(!empty($l) && !empty($value)){
			$update_chart = mysql_query("UPDATE `website_charts` SET `chart_title`='".strip($value["title"])."', `create_status`='inprogress' WHERE `idx`='".(int)$_GET["edit"]."' AND `langs`='".strip($l)."' ");
			if($_POST["chart_name"]=="mobile_phone_sub"){
				for($x=0;$x<=count($value["name"]); $x++)
				{
					$name_num = count($value["name"]);
					$name = $value["name"][$x];
					$val = $value["value"][$x];
					$langs = $l;	
					$rr = explode(";",$val);
					$val_num = count($rr);
					foreach($rr as $r){
						$n = explode(":",$r);
						$y = $n[0];
						$v = $n[1];
						if(!empty($y) && !empty($v) && !empty($name)){
						$y = preg_replace('/\s\s+/', '', $y);
						$v = preg_replace('/\s\s+/', '', $v);
						$insert2 = mysql_query("INSERT INTO `website_charts_items2` SET 
									`idx`='".(int)$chartMaxItem2."',  
									`chart_idx`='".(int)$_GET["edit"]."',  
									`name`='".strip($name)."',  
									`year`='".strip($y)."',  
									`value`='".strip($v)."',  
									`num`='".(int)$name_num."',
									`val_num`='".(int)($val_num-1)."',
									`langs`='".strip($l)."' 
									");
						}
					}
				}
				/**
				$labelN = $value[$x];
				$exp = explode(";",$label_value[$x]);
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
					`langs`='".strip($language)."' 
					");
				} **/
			}
			
			foreach($value["label_name"] as $i => $v){
				if(!empty($i) && !empty($v)){
					if($_POST["chart_name"]!="mobile_phone_sub"){
						if($_POST["chart_name"]=="earthquakes_monthly" || $_POST["chart_name"]=="valueOverYear"){ 
									$date = str_replace('/', '-', $v);
									$v = strtotime($date);
								}
						$update_chart_item = mysql_query("UPDATE `website_charts_items` SET `label_name`='".strip($v)."', `label_value`='".strip($value["label_value"][$i])."' WHERE `id`='".(int)$i."' ");
					}
				}
			}
		}
	}
	$msg = l("done");
	$theBoxColore = "orange";
	if(mysql_error()){
		$msg = l("erroroccurred");
		$theBoxColore = "red";
	}
}
$select_languages = select_languages();
?>
<div class="cont">
	<?php
	$count = count($select_languages["name"]);
	$x = 1;
	if($count){
		echo '<ul>';
		foreach($select_languages["name"] as $name){
			echo '<li id="tab-'.$x.'" onclick="show(this, \'content-'.$x.'\');">'.$name.'</li>';
			$x++;
		}
		echo '</ul>';
	}
	?>
	
<form action="" method="post" enctype="multipart/form-data">
	<?php 
	if($count){		
		$y = 1;
		foreach($select_languages["name"] as $name){
		$select = mysql_query("SELECT 
		`idx`,`chart_title`,`chart_name`,`langs`
		FROM 
		`website_charts`
		WHERE 
		`idx`='".(int)$_GET['edit']."' AND 
		`langs` = '".strip($select_languages["language"][$y-1])."' AND 
		`status`!=1 ");
		$rows = mysql_fetch_array($select);
	?>
		<input type="hidden" name="chart_name" value="<?=$rows["chart_name"]?>" />
		<div id="content-<?=$y?>" class="content">
			<?php
			if($msg) :
			?>
				<div class="boxes">
				<div class="error_msg <?=$theBoxColore?>"><i><?=$msg?> !</i></div>
				</div>
			<?php 
			endif;
			?>
			<?php
			if(!$admin_permition){ 
				echo '<div class="boxes">';
				echo '<div class="error_msg red"><i>'.l("noRight").' !</i></div>';
				echo '</div>';
			}
			?>
			<div class="boxes">
			<label for="title"><i><?=l("title")?></i> <font color="#f00">*</font></label>
			<input type="text" name="post[<?=$select_languages["language"][$y-1]?>][title]" class="title" id="title" value="<?=(isset($rows['chart_title'])) ? $rows['chart_title'] : "";?>" />
			<div class="checker_none title" onclick="$('.m_title').fadeIn('slow');">
			<div class="msg m_title"><?=l("filltitle")?> !</div>
			</div>
			</div><div class="clearer"></div>
			<div class="boxes">
			<label for="chart"><i><?=l("chart")?></i> <font color="#f00">*</font></label>
			<select name="chart" id="chart" disabled="disabled">
			<option value=""><?=l("choose")?></option>
			<option value="oil_reserves" <?=($rows["chart_name"]=="oil_reserves") ? 'selected="selected"' : ''?>>Oil reserves</option> <!-- name, value -->
			<option value="spend_time" <?=($rows["chart_name"]=="spend_time") ? 'selected="selected"' : ''?>>Spend time</option> <!-- name, value -->
			<option value="earthquakes_monthly" <?=($rows["chart_name"]=="earthquakes_monthly") ? 'selected="selected"' : ''?>><?=l("name")?> Format:(dd/mm/YYYY)</option> <!-- name, value -->
			<option value="valueOverYear" <?=($rows["chart_name"]=="valueOverYear") ? 'selected="selected"' : ''?>><?=l("name")?> {Year} Format:(dd/mm/YYYY)</option>
			<option value="country_wise" <?=($rows["chart_name"]=="country_wise") ? 'selected="selected"' : ''?>>Country wise</option>
			<option value="marketShare" <?=($rows["chart_name"]=="marketShare") ? 'selected="selected"' : ''?>>Market share</option>
			<option value="mobile_phone_sub" <?=($rows["chart_name"]=="mobile_phone_sub") ? 'selected="selected"' : ''?>>mobile phone sub { 2012:500; 2013:450 }</option>
			</select>
			</div><div class="clearer"></div>
			<div class="boxes" id="chart_img"><img src="images/<?=$rows["chart_name"]?>.png" width="430" height="195" alt="" /></div><div class="clearer"></div>
			<?php
			$sub_items = mysql_query("SELECT `id`,`label_name`,`label_value` FROM `website_charts_items` WHERE `chart_idx`='".(int)$_GET["edit"]."' AND `langs`='".strip($select_languages["language"][$y-1])."' ORDER BY id ASC ");
			if(mysql_num_rows($sub_items)) {
				$c=1;
				while($item = mysql_fetch_array($sub_items)){
				?>
					<div class="boxes">
					<label for="label_name"><i><?=l("name")?></i> #<?=$c?> <font color="#f00">*</font></label>
					<?php
					if($rows["chart_name"]=="earthquakes_monthly" || $rows["chart_name"]=="valueOverYear"){ $item["label_name"]=date("d/m/Y",$item["label_name"]); }
					?>
					<input type="text" name="post[<?=$select_languages["language"][$y-1]?>][label_name][<?=$item["id"]?>]" class="label_name" value="<?=$item["label_name"]?>" />
					</div><div class="clearer"></div>

					<div class="boxes">
					<label for="label_value"><i><?=l("quentity")?></i> #<?=$c?> <font color="#f00">*</font></label>
					<input type="text" name="post[<?=$select_languages["language"][$y-1]?>][label_value][<?=$item["id"]?>]" class="label_value" value="<?=$item["label_value"]?>" />
					</div><div class="clearer"></div>	
				<?php
					$c++;
				}
			}else
			{
				$sub_items2 = mysql_query("SELECT `id`,`name`,`year`,`value` FROM `website_charts_items2` WHERE `chart_idx`='".(int)$_GET["edit"]."' AND `langs`='".strip($select_languages["language"][$y-1])."' ORDER BY `id` ASC ");
				if(mysql_num_rows($sub_items2))
				{
					$c=1;
					while($item = mysql_fetch_array($sub_items2))
					{
						$out[$select_languages["language"][$y-1]][$item["name"]][] = $item["year"].":".$item["value"]."; ";
					}
					foreach($out[$select_languages["language"][$y-1]] as $k => $o)
					{
						?>
						<div class="boxes">
						<label for="label_name"><i><?=l("name")?></i> #<?=$c?> <font color="#f00">*</font></label>
						<input type="text" name="post[<?=$select_languages["language"][$y-1]?>][name][<?=$item["id"]?>]" class="name" value="<?=$k?>" />
						</div><div class="clearer"></div>
						
						
						<div class="boxes">
						<label for="label_value"><i><?=l("quentity")?></i> #<?=$c?> <font color="#f00">*</font></label>
						<input type="text" name="post[<?=$select_languages["language"][$y-1]?>][value][<?=$item["id"]?>]" class="label_value" value="<?=implode(" ",$o)?>" />
						</div><div class="clearer"></div>	
						<?php
						$c++;
					}
				?>
				
				<?php
				}
			}
			?>
			
			<div class="boxes">
				<?php $_SESSION["token"]=randomPassword(16); ?>
				<a href="javascript:void(0)" onclick="openPop('contentRight.php?lang=<?=$_GET['lang']?>&idx=<?=$_GET["edit"]?>&t=website_charts&weblang=<?=$_GET["lang"]?>&token=<?=$_SESSION["token"]?>')"><?=l("contentupdateright")?></a>
			</div><div class="clearer"></div>
			
			<div class="boxes">				
				<input type="submit" class="submit" id="submit" value="<?=l("edit")?>" />
			</div><div class="clearer"></div><br />
		</div>
	<?php 
			$select = "";
			$rows = "";
			$y++;
		}
	}
	?>
	
</form>	
</div>
<div class="clearer"></div><br />