<?php
$msg="";
if(isset($_POST['namex'],$_POST['ip']))
{
	if(!empty($_POST['namex']) && !empty($_POST['ip']))
	{	
			//insert action
			insert_action("ip","add","0");
			$namex = $_POST["namex"];
			$ip = $_POST["ip"];
			$admin_id = $_SESSION['admin_id'];
			$grand_id = implode(",",grand_admins());
			if(!in_array($admin_id,grand_admins())){
				$access_admins = $grand_id.",".$admin_id;
			}else{
				$access_admins = $grand_id;
			}
			
			$insert = mysql_query("INSERT INTO `system_ips` SET `name`='".strip($namex)."',  
																`ip_address`='".strip($ip)."', 
																`access_admins`='".strip($access_admins)."'
																");
			$mysql_insert_id = mysql_insert_id();
			_refresh_404("/".ADMIN_FOLDER."/".$_GET["lang"]."/edit/systemipaddresses/".$mysql_insert_id);
			exit();
			if(!$insert)
			{
				$msg = l("erroroccurred");
				$theBoxColore = "red";
			}
			else
			{				
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
<form action="" method="post">
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
				<label for="namex"><i><?=l("namelname")?></i> <font color="#f00">*</font></label>
				<input type="text" name="namex" class="namex" id="namex" value="<?=(isset($_POST['namex'])) ? $_POST['namex'] : "";?>" />
				<div class="checker_none username" onclick="$('.m_namex').fadeIn('slow');">
						<div class="msg m_namex"><?=l("fillnamelname")?> !</div>
				</div>
			</div><div class="clearer"></div>
			<div class="boxes">
				<label for="ip"><i><?=l("ip")?></i> <font color="#f00">*</font></label>
				<input type="text" name="ip" class="ip" id="ip" value="<?=(isset($_POST['ip'])) ? $_POST['ip'] : "";?>" />
				<div class="checker_none ip" onclick="$('.m_ip').fadeIn('slow');">
						<div class="msg m_ip"><?=l("fillip")?> !</div>
				</div>
			</div>
			<div class="clearer"></div>				
			<div class="boxes">				
				<input type="submit" class="submit" id="submit" value="<?=l("add")?>" />
				<input type="reset" class="reset" id="reset" value="<?=l("clear")?>" />	
			</div>
			<div class="clearer"></div><br />
		</form>