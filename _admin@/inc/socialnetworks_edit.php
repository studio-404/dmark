<?php
$msg="";
/*change permition*/
if(isset($_POST["s"])){ change_permition("website_social",$_GET["edit"],false); insert_action("social_networks","change permition",$_GET["edit"]); }
/* check if have permition */
$admin_permition = check_if_permition("website_social",$_GET["edit"],false);
if(isset($_POST['socialname'],$_POST['imgclass'],$_POST['url']) && $admin_permition)
{
	if(!empty($_POST['socialname']) && !empty($_POST['imgclass']) && !empty($_POST['url']))
	{	
		//insert action
		insert_action("website_social","edit",$_GET["edit"]);
		$socialname = $_POST["socialname"];
		$imgclass = $_POST["imgclass"];
		$url = $_POST["url"];
	
		$update = mysql_query("UPDATE `website_social` SET 
															`name`='".strip($socialname)."',  
															`var`='".strip($imgclass)."',  
															`url`='".strip($url)."' 
															WHERE 
															`id`='".(int)$_GET['edit']."'
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
$select_admin = mysql_query("SELECT * FROM `website_social` WHERE `id`='".(int)$_GET['edit']."' ");
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
			<?php
			if(!$admin_permition){ 
				echo '<div class="boxes">';
				echo '<div class="error_msg red"><i>'.l("noRight").' !</i></div>';
				echo '</div>';
			}
			?>	
			<div class="boxes">
				<label for="phone"><i><?=l("name")?></i> <font color="#f00">*</font></label>
				<input type="text" name="socialname" class="socialname" id="socialname" value="<?=(isset($rows_admin['name'])) ? $rows_admin['name'] : "";?>"  />
				<div class="checker_none socialname" onclick="$('.m_socialname').fadeIn('slow');">
						<div class="msg m_socialname"><?=l("socialname")?> !</div>
				</div>
			</div>
			<div class="clearer"></div>
			
			<div class="boxes">
				<label for="phone"><i><?=l("imgclass")?></i> <font color="#f00">*</font></label>
				<input type="text" name="imgclass" class="imgclass" id="imgclass" value="<?=(isset($rows_admin['var'])) ? $rows_admin['var'] : "";?>"  />
				<div class="checker_none imgclass" onclick="$('.m_imgclass').fadeIn('slow');">
						<div class="msg m_imgclass"><?=l("fillimgclass")?> !</div>
				</div>
			</div>
			<div class="clearer"></div>
			
				<div class="boxes">
				<label for="phone"><i><?=l("url")?></i> <font color="#f00">*</font></label>
				<input type="text" name="url" class="url" id="url" value="<?=(isset($rows_admin['url'])) ? $rows_admin['url'] : "";?>"  />
				<div class="checker_none url" onclick="$('.m_url').fadeIn('slow');">
						<div class="msg m_url"><?=l("fillgotourl")?> !</div>
				</div>
			</div>
			<div class="clearer"></div>
			
			<div class="boxes">
				<?php $_SESSION["token"]=randomPassword(16); ?>
				<a href="javascript:void(0)" onclick="openPop('contentRight.php?lang=<?=$_GET['lang']?>&id=<?=$_GET["edit"]?>&t=website_social&weblang=<?=$_GET["lang"]?>&token=<?=$_SESSION["token"]?>')"><?=l("contentupdateright")?></a>
			</div><div class="clearer"></div>
			
			<div class="boxes">				
				<input type="submit" class="submit" id="submit" value="<?=l("edit")?>" />
			</div>
			<div class="clearer"></div><br />
		</form>