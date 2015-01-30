<?php
$msg="";
if(isset($_POST['namex'],$_POST['username'],$_POST['password']))
{
	if(!empty($_POST['namex']) && !empty($_POST['username']) && !empty($_POST['password']))
	{	
		//insert action
		insert_action("users","add","0");
		$rights = $_POST["rights"];
		$sub_rights = $_POST["sub_rights"];
		$namex = $_POST["namex"];
		$email = $_POST["email"];
		$phone = $_POST["phone"];
		$username = $_POST["username"];
		$password = $_POST["password"];
		$additional = $_POST["additional"]; 
		
		$check_admin_name_exists = mysql_query("SELECT `id` FROM `panel_admins` WHERE `name`='".strip($namex)."' AND `status`!=1 ");
		if(!mysql_num_rows($check_admin_name_exists)){
			$admin_id = $_SESSION['admin_id'];
			$grand_id = implode(",",grand_admins());
			if(!in_array($admin_id,grand_admins())){
				$access_admins = $grand_id.",".$admin_id;
			}else{
				$access_admins = $grand_id;
			}
			$insert = mysql_query("INSERT INTO `panel_admins` SET 
																`name`='".strip($namex)."',  
																`phone`='".strip($phone)."',  
																`email`='".strip($email)."',  
																`user`='".strip($username)."',  
																`pass`='".md5($password)."',  
																`aditional_info`='".strip($aditional_info)."', 
																`access_admins`='".strip($access_admins)."' 
																");
			$addSystemAdmin_id = mysql_insert_id();
		}
		if(!$insert)
		{
			$msg = l("erroroccurred");
			$theBoxColore = "red";
		}
		else
		{
			$m = ""; 
			$m .= "1,"; 
			foreach($rights as $rig){
			$m .= $rig.","; 
			}
			$m .= "34"; 
			
			$s = ""; 
			foreach($sub_rights as $su){
			$s .= $su.","; 
			}			
			$mysql_insert_id = mysql_insert_id();
			$insert21 = mysql_query("INSERT INTO `panel_admin_rights` SET `a_id`='".$mysql_insert_id."', `main`='".strip($m)."', `sub`='".strip($s)."', `langs`='ka' ");				
			$insert2 = mysql_query("INSERT INTO `panel_admin_rights` SET `a_id`='".$mysql_insert_id."', `main`='', `sub`='', `langs`='en'  ");				
			if(!$insert21 || !$insert2){
				$msg = l("erroroccurred");
				$theBoxColore = "red";
			}else{
				$msg = l("done");
				$theBoxColore = "orange";
			}
		}
		_refresh_404("/".ADMIN_FOLDER."/".$_GET["lang"]."/edit/system_admin/".$addSystemAdmin_id);
		exit();
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
				<label><b><i><?=l("rights")?></i></b> <font color="#f00">*</font></label>				
				<?=get_nav_for_rights()?>
			</div>
			<div class="clearer"></div>
			<div class="boxes">
				<label for="namex"><i><?=l("namelname")?></i> <font color="#f00">*</font></label>
				<input type="text" name="namex" class="namex" id="namex" value="<?=(isset($_POST['namex'])) ? $_POST['namex'] : "";?>" />
				<div class="checker_none username" onclick="$('.m_namex').fadeIn('slow');">
						<div class="msg m_namex"><?=l("fillnamelname")?> !</div>
				</div>
			</div><div class="clearer"></div>
			<div class="boxes">
				<label for="phone"><i><?=l("phone")?></i></label>
				<input type="text" name="phone" class="phone" id="phone" value="<?=(isset($_POST['phone'])) ? $_POST['phone'] : "";?>" />
				<div class="checker_none phone" onclick="$('.m_phone').fadeIn('slow');">
						<div class="msg m_phone"><?=l("fillmobile")?> !</div>
				</div>
			</div>
			<div class="clearer"></div>
			
			<div class="boxes">
				<label for="email"><i><?=l("email")?></i></label>
				<input type="text" name="email" class="email" id="email" value="<?=(isset($_POST['email'])) ? $_POST['email'] : "";?>" />
				<div class="checker_none email" onclick="$('.m_email').fadeIn('slow');">
						<div class="msg m_email"><?=l("fillemail")?> !</div>
				</div>
			</div>
			<div class="clearer"></div>
			
			<div class="boxes">
				<label for="phone"><i><?=l("username")?></i> <font color="#f00">*</font></label>
				<input type="text" name="username" class="username" id="username" value="<?=(isset($_POST['username'])) ? $_POST['username'] : "";?>" />
				<div class="checker_none username" onclick="$('.m_username').fadeIn('slow');">
						<div class="msg m_username"><?=l("fillusername")?> !</div>
				</div>
			</div>
			<div class="clearer"></div>
			
			<div class="boxes">
				<label for="password"><i><?=l("password")?></i> <font color="#f00">*</font></label>
				<input type="text" name="password" class="password" id="password" />
				<div class="checker_none password" onclick="$('.m_password').fadeIn('slow');">
						<div class="msg m_password"><?=l("fillpassword")?> !</div>
				</div>
			</div>
			<div class="clearer"></div>
			
			<div class="boxes">
				<label for="additional"><i><?=l("additional")?></i> </label><div class="clearer"></div>
				<textarea name="additional" class="additional" id="additional"><?=(isset($_POST['additional'])) ? $_POST['additional'] : "";?></textarea>
			</div>
			<div class="clearer"></div>
			
			<div class="boxes">				
				<input type="submit" class="submit" id="submit" value="<?=l("add")?>" />
				<input type="reset" class="reset" id="reset" value="<?=l("clear")?>" />	
			</div>
			<div class="clearer"></div><br />
		</form>