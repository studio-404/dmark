<?php
$msg="";
if(isset($_POST['type']))
{	
	if(!empty($_POST['type']))
	{
		insert_action("backup","add","0");
		$type = $_POST["type"]; 
		$date = time(); 
		if(!$msg){
			$admin_id = $_SESSION['admin_id'];
			$grand_id = implode(",",grand_admins());
			if(!in_array($admin_id,grand_admins())){
				$access_admins = $grand_id.",".$admin_id;
			}else{
				$access_admins = $grand_id;
			}
			$insert = mysql_query("INSERT INTO `website_backup` SET 
				`date`='".$date."',  
				`title`='".(int)$date."',  
				`type`='".mysql_real_escape_string($type)."', 
				`access_admins`='".strip($access_admins)."'
			");
		} 
		
		if(!$insert)
		{
			$msg = l("erroroccurred");
			$theBoxColore = "red";
		}
		else
		{
			_refresh_404("/".ADMIN_FOLDER."/".$_GET["lang"]."/table/backup");
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
		<label for="type"><i><?=l("type")?></i> <font color="#f00">*</font></label>
		<select name="type" id="type">
			<option value=""><?=l("choose")?></option>
			<option value="full"><?=l("full")?></option>
			<option value="file"><?=l("files")?></option>
			<option value="database"><?=l("database")?></option>
		</select>
	</div><div class="clearer"></div>
	
	<div class="boxes">				
		<input type="submit" class="submit" id="submit" value="<?=l("makeBackup")?>" />
	</div><div class="clearer"></div><br />
			
</form>