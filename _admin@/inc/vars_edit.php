<?php
$msg = "";
if(isset($_POST["post"]))
{
	$r = 1;
	//insert action
	insert_action("vars","edit",$_GET["edit"]);
	foreach($_POST["post"] as $key => $value){ 
		if($value["text"]){
			$update = mysql_query("UPDATE `plain_text` SET `text`='".mysql_real_escape_string($value["text"])."' WHERE `idx`='".(int)$_GET["edit"]."' AND `langs`='".mysql_real_escape_string($key)."' ");
			if($r==1){ //clear language cache
				$path = "cache/*";
				claerFolder($path);
				$r=2;
			}
		}else{
			$msg = l("requiredfields");
			$theBoxColore = "red";
		}
		l("add",$key);
		
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
	
<form action="" method="post">
	<?php 
	if($count){		
		$y = 1;
		foreach($select_languages["name"] as $name){
		$select = mysql_query("SELECT `variable`,`text` FROM `plain_text` WHERE `idx`='".(int)$_GET['edit']."' AND `status`!=1 AND `langs`='".mysql_real_escape_string($select_languages["language"][$y-1])."' ");
		$rows = mysql_fetch_array($select);		
	?>
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
			<div class="boxes">
				<label for="variable"><i><?=l("variable")?></i> <font color="#f00">*</font></label>
				<input type="text" name="post[<?=$select_languages["language"][$y-1]?>][variable]" readonly="true" class="variable" id="variable" value="<?=(isset($rows['variable'])) ? $rows['variable'] : "";?>" />
				<div class="checker_none variable" onclick="$('.m_variable').fadeIn('slow');">
						<div class="msg m_variable"><?=l("fillvariable")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="text"><i><?=l("text")?></i> <font color="#f00">*</font></label>
				<input type="text" name="post[<?=$select_languages["language"][$y-1]?>][text]" class="text" id="text" value="<?=(isset($rows['text'])) ? $rows['text'] : "";?>" />
				<div class="checker_none text" onclick="$('.m_text').fadeIn('slow');">
						<div class="msg m_text"><?=l("filltext")?> !</div>
				</div>
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