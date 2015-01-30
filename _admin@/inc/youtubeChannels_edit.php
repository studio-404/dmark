<?php
$msg="";
/*change permition*/
if(isset($_POST["s"])){ change_permition("website_youtube",$_GET["edit"],false); insert_action("youtube","change permition",$_GET["edit"]); }
/* check if have permition */
$admin_permition = check_if_permition("website_youtube",$_GET["edit"],false);
if(isset($_POST['channel_name'],$_POST['key'],$_POST['email'],$_POST['apppassword'],$_POST['channel_link']) && $admin_permition)
{
	if( !empty($_POST['channel_name']) && !empty($_POST['key']) && !empty($_POST['channel_link']) && !empty($_POST['email']) && !empty($_POST['apppassword']) )
	{	
			$channel_name = $_POST["channel_name"];
			$key = $_POST["key"];
			$email = $_POST["email"];
			$apppassword = $_POST["apppassword"];
			$channel_link = $_POST["channel_link"];
			$insert = mysql_query("UPDATE `website_youtube` SET 
																									`channel_name`='".mysql_real_escape_string($channel_name)."',  
																									`channel_link`='".mysql_real_escape_string($channel_link)."',  
																									`key`='".mysql_real_escape_string($key)."',  
																									`email`='".mysql_real_escape_string($email)."',  
																									`app_password`='".mysql_real_escape_string($apppassword)."' 
																									WHERE 
																									`id`='".(int)$_GET['edit']."'
																									");
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

$c = mysql_query("SELECT * FROM `website_youtube` WHERE `id`='".(int)$_GET['edit']."' ");
$geo = mysql_fetch_array($c);
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
			<?php
			if(!$admin_permition){ 
				echo '<div class="boxes">';
				echo '<div class="error_msg red"><i>'.l("noRight").' !</i></div>';
				echo '</div>';
			}
			?>
			<div class="boxes">
				<label for="channel_name"><i><?=l("channelname")?></i> <font color="#f00">*</font></label>
				<input type="text" name="channel_name" class="channel_name" id="channel_name" value="<?=(isset($geo['channel_name'])) ? $geo['channel_name'] : "";?>" />
				<div class="checker_none channel_name" onclick="$('.m_channel_name').fadeIn('slow');">
						<div class="msg m_channel_name"><?=l("fillchannel_name")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="channel_link"><i><?=l("channel_link")?></i> <font color="#f00">*</font></label>
				<input type="text" name="channel_link" class="channel_link" id="channel_link" value="<?=(isset($geo['channel_link'])) ? $geo['channel_link'] : "";?>" />
				<div class="checker_none channel_link" onclick="$('.m_channel_link').fadeIn('slow');">
						<div class="msg m_channel_link"><?=l("fillchannel_link")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="key"><i><?=l("key")?></i> <font color="#f00">*</font></label>
				<input type="text" name="key" class="key" id="key" value="<?=(isset($geo['key'])) ? $geo['key'] : "";?>" />
				<div class="checker_none key" onclick="$('.m_key').fadeIn('slow');">
						<div class="msg m_key"><?=l("fillkey")?> !</div>
				</div>
			</div>
			<div class="clearer"></div>
			
			<div class="boxes">
				<label for="email"><i><?=l("email")?></i> <font color="#f00">*</font></label>
				<input type="text" name="email" class="email" id="email" value="<?=(isset($geo['email'])) ? $geo['email'] : "";?>" />
				<div class="checker_none email" onclick="$('.m_email').fadeIn('slow');">
						<div class="msg m_email"><?=l("fillemail")?> !</div>
				</div>
			</div>
			<div class="clearer"></div>
			
			<div class="boxes">
				<label for="apppassword"><i><?=l("apppassword")?></i> <font color="#f00">*</font></label>
				<input type="text" name="apppassword" class="apppassword" id="apppassword" value="<?=$geo["app_password"]?>" />
				<div class="checker_none apppassword" onclick="$('.m_apppassword').fadeIn('slow');">
						<div class="msg m_apppassword"><?=l("fillapppassword")?> !</div>
				</div>
			</div>
			<div class="clearer"></div>
			
			<div class="boxes">
				<?php $_SESSION["token"]=randomPassword(16); ?>
				<a href="javascript:void(0)" onclick="openPop('contentRight.php?lang=<?=$_GET['lang']?>&id=<?=$_GET["edit"]?>&t=website_youtube&weblang=<?=$_GET["lang"]?>&token=<?=$_SESSION["token"]?>')"><?=l("contentupdateright")?></a>
			</div><div class="clearer"></div>	
				
			<div class="boxes">				
				<input type="submit" class="submit" id="submit" value="<?=l("edit")?>" />
			</div>
			<div class="clearer"></div><br />
		</form>