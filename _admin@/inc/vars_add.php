<?php
$msg="";
if(isset($_POST['variable'],$_POST['text']))
{	
	if(!empty($_POST['variable']) && !empty($_POST['text']))
	{	
		//insert action
		insert_action("vars","add","0");
		$variable = $_POST["variable"]; 
		$text = $_POST["text"]; 
		if(!$msg){
			$selectMax = mysql_query("SELECT MAX(idx) AS max FROM `plain_text` WHERE `status`!=1");
			$rowsMax = (mysql_num_rows($selectMax)) ? mysql_fetch_array($selectMax) : "";
			$max = (int)$rowsMax["max"]+1;
			$select_languages = select_languages();

			foreach($select_languages["language"] as $langs){
				$insert = mysql_query("INSERT INTO `plain_text` SET 
					`idx`='".(int)$max."', 
					`langs`='".strip($langs)."', 
					`variable`='".strip($variable)."', 
					`text`='".strip($text)."', 
					`status`='0'
				");
				if(!$insert){ $msg = l("erroroccurred");	$theBoxColore = "red"; }
			}
			
			if(!$msg)
			{
				$path = "cache/*";
				claerFolder($path);
				foreach($select_languages["language"] as $langs){
					l("add",$langs);
				}
			}
			
		} 
		
		if($msg)
		{
			$msg = l("erroroccurred");
			$theBoxColore = "red";
		}
		else
		{		
			_refresh_404("/".ADMIN_FOLDER."/".$_GET["lang"]."/edit/vars/".$max);
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
		<label for="variable"><i><?=l("variable")?></i> <font color="#f00">*</font></label>
		<input type="text" name="variable" class="variable" id="variable" value="<?=(isset($_POST['variable'])) ? $_POST['variable'] : "";?>" />
		<div class="checker_none variable" onclick="$('.m_variable').fadeIn('slow');">
			<div class="msg m_variable"><?=l("fillvariable")?> !</div>
		</div>
	</div><div class="clearer"></div>
	
	<div class="boxes">
		<label for="text"><i><?=l("text")?></i> <font color="#f00">*</font></label>
		<input type="text" name="text" class="text" id="text" value="<?=(isset($_POST['text'])) ? $_POST['text'] : "";?>" />
		<div class="checker_none text" onclick="$('.m_text').fadeIn('slow');">
			<div class="msg m_text"><?=l("filltext")?> !</div>
		</div>
	</div><div class="clearer"></div>
			
	<div class="boxes">				
		<input type="submit" class="submit" id="submit" value="<?=l("add")?>" />
		<input type="reset" class="reset" id="reset" value="<?=l("clear")?>" />	
	</div><div class="clearer"></div><br />
			
</form>