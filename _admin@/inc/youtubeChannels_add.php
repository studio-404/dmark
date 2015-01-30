<?php
$msg="";
if(isset($_POST['channel_name'],$_POST['key'],$_POST['email'],$_POST['apppassword'],$_POST['channel_link']))
{
	if( !empty($_POST['channel_name']) && !empty($_POST['channel_link']) && !empty($_POST['key']) && !empty($_POST['email']) && !empty($_POST['apppassword']) )
	{	
			insert_action("youtube","add channel","0");
			$channel_name = $_POST["channel_name"];
			$key = $_POST["key"];
			$email = $_POST["email"];
			$apppassword = $_POST["apppassword"];
			$channel_link = $_POST["channel_link"];
			$admin_id = $_SESSION['admin_id'];
			$grand_id = implode(",",grand_admins());
			if(!in_array($admin_id,grand_admins())){
				$access_admins = $grand_id.",".$admin_id;
			}else{
				$access_admins = $grand_id;
			}
			$insert = mysql_query("INSERT INTO `website_youtube` SET 
													`channel_name`='".strip($channel_name)."',  
													`channel_link`='".strip($channel_link)."',  
													`key`='".strip($key)."',  
													`email`='".strip($email)."',  
													`app_password`='".strip($apppassword)."',
													`access_admins`='".strip($access_admins)."'
													");
			$mysql_insert_id = mysql_insert_id();			
			if(!$insert)
			{
				$msg = l("erroroccurred");
				$theBoxColore = "red";
			}
			else
			{
				_refresh_404("/".ADMIN_FOLDER."/".$_GET["lang"]."/edit/youtubeChannels/".$mysql_insert_id);
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
				<label for="channel_name"><i><?=l("channelname")?></i> <font color="#f00">*</font></label>
				<input type="text" name="channel_name" class="channel_name" id="channel_name" value="<?=(isset($_POST['channel_name'])) ? $_POST['channel_name'] : "";?>" />
				<div class="checker_none channel_name" onclick="$('.m_channel_name').fadeIn('slow');">
						<div class="msg m_channel_name"><?=l("fillchannel_name")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="channel_link"><i><?=l("channel_link")?></i> <font color="#f00">*</font></label>
				<input type="text" name="channel_link" class="channel_link" id="channel_link" value="<?=(isset($_POST['channel_link'])) ? $_POST['channel_link'] : "";?>" />
				<div class="checker_none channel_link" onclick="$('.m_channel_link').fadeIn('slow');">
						<div class="msg m_channel_link"><?=l("fillchannel_link")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="key"><i><?=l("key")?></i> <font color="#f00">*</font></label>
				<input type="text" name="key" class="key" id="key" value="<?=(isset($_POST['key'])) ? $_POST['key'] : "";?>" />
				<div class="checker_none key" onclick="$('.m_key').fadeIn('slow');">
						<div class="msg m_key"><?=l("fillkey")?> !</div>
				</div>
			</div>
			<div class="clearer"></div>
			
			<div class="boxes">
				<label for="email"><i><?=l("email")?></i> <font color="#f00">*</font></label>
				<input type="text" name="email" class="email" id="email" value="<?=(isset($_POST['email'])) ? $_POST['email'] : "";?>" />
				<div class="checker_none email" onclick="$('.m_email').fadeIn('slow');">
						<div class="msg m_email"><?=l("fillemail")?> !</div>
				</div>
			</div>
			<div class="clearer"></div>
			
			<div class="boxes">
				<label for="apppassword"><i><?=l("apppassword")?></i> <font color="#f00">*</font></label>
				<input type="text" name="apppassword" class="apppassword" id="apppassword" />
				<div class="checker_none apppassword" onclick="$('.m_apppassword').fadeIn('slow');">
						<div class="msg m_apppassword"><?=l("fillapppassword")?> !</div>
				</div>
			</div>
			<div class="clearer"></div>
					
			<div class="boxes">				
				<input type="submit" class="submit" id="submit" value="<?=l("add")?>" />
				<input type="reset" class="reset" id="reset" value="<?=l("clear")?>" />	
			</div>
			<div class="clearer"></div><br />
		</form>