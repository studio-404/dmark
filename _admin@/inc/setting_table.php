<?php
$msg="";
if(isset($_POST['namex'],$_POST['email'],$_POST['phone']))
{
	if( !empty($_POST['namex']) && !empty($_POST['phone']) && !empty($_POST['email']))
	{	
		//insert action
		insert_action("setting","edit",$_SESSION['admin_id']);
	
		$namex = $_POST["namex"];
		$email = $_POST["email"];
		$phone = $_POST["phone"];
		$update = mysql_query("UPDATE `panel_admins` SET `name`='".strip($namex)."',  
													`phone`='".strip($phone)."',  
													`email`='".strip($email)."' 
													WHERE 
													`id`='".(int)$_SESSION['admin_id']."'
													");
		if(!$update)
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
if(isset($_POST['old_password'],$_POST['new_password'],$_POST['comfirm_password'])){
	if(!empty($_POST['old_password']) && !empty($_POST['old_password']) && !empty($_POST['old_password'])){
		$chack_pass = mysql_query("SELECT pass FROM `panel_admins` WHERE `status`!=1 AND `pass`='".md5($_POST['old_password'])."' AND `id`='".(int)$_SESSION['admin_id']."' ");
		if(mysql_num_rows($chack_pass)){
			if($_POST['new_password']==$_POST['comfirm_password']){
				$update_pass = mysql_query("UPDATE `panel_admins` SET `pass`='".md5($_POST['new_password'])."' WHERE `id`='".(int)$_SESSION['admin_id']."' ");
				if($update_pass){
					$msg=l("done");
					$theBoxColore = "orange";
				}else{
					$msg = l("erroroccurred");
					$theBoxColore = "red";
				}
			}else{
				$msg = l("erroroccurred");
				$theBoxColore = "red";
			}
		}else{
			$msg = l("erroroccurred");
			$theBoxColore = "red";
		}
	}else{
		$msg = l("requiredfields");
		$theBoxColore = "red";
	}
}
$select_admin = mysql_query("SELECT * FROM `panel_admins` WHERE `id`='".(int)$_SESSION['admin_id']."' ");
$rows_admin = mysql_fetch_array($select_admin);
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
		
			<div class="clearer"></div>
			<div class="boxes">
				<label for="namex"><i><?=l("namelname")?></i> <font color="#f00">*</font></label>
				<input type="text" name="namex" class="namex" id="namex" value="<?=(isset($rows_admin['name'])) ? $rows_admin['name'] : "";?>" />
				<div class="checker_none username" onclick="$('.m_namex').fadeIn('slow');">
						<div class="msg m_namex"><?=l("fillnamelname")?> !</div>
				</div>
			</div><div class="clearer"></div>
			<div class="boxes">
				<label for="phone"><i><?=l("phone")?></i> <font color="#f00">*</font></label>
				<input type="text" name="phone" class="phone" id="phone" value="<?=(isset($rows_admin['phone'])) ? $rows_admin['phone'] : "";?>" />
				<div class="checker_none phone" onclick="$('.m_phone').fadeIn('slow');">
						<div class="msg m_phone"><?=l("fillmobile")?> !</div>
				</div>
			</div>
			<div class="clearer"></div>
			
			<div class="boxes">
				<label for="email"><i><?=l("email")?></i> <font color="#f00">*</font></label>
				<input type="text" name="email" class="email" id="email" value="<?=(isset($rows_admin['email'])) ? $rows_admin['email'] : "";?>" />
				<div class="checker_none email" onclick="$('.m_email').fadeIn('slow');">
						<div class="msg m_email"><?=l("fillemail")?> !</div>
				</div>
			</div>
			<div class="clearer"></div>
			
			<div class="boxes">
				<label for="phone"><i><?=l("username")?></i> <font color="#f00">*</font></label>
				<input type="text" name="username" class="username" id="username" value="<?=(isset($rows_admin['user'])) ? $rows_admin['user'] : "";?>" readonly="readonly" />
				<div class="checker_none username" onclick="$('.m_username').fadeIn('slow');">
						<div class="msg m_username"><?=l("fillusername")?> !</div>
				</div>
			</div>
			<div class="clearer"></div>
			
			<div class="boxes">
				<label for="phone"><i><?=l("password")?></i> <font color="#f00">*</font></label>
				<a href="javascript:void(0)" onclick="openPop('change_password.php?lang=<?=$_GET['lang']?>')"><?=l("change_password")?></a>
			</div>
			<div class="clearer"></div>
			
			<div class="boxes">				
				<input type="submit" class="submit" id="submit" value="<?=l("edit")?>" />
			</div>
			<div class="clearer"></div><br />
		</form>