<?php
$c = mysql_query("SELECT * FROM `system_ips` WHERE id='".(int)$_GET['edit']."' ");
if(!mysql_num_rows($c)){ exit(); }
$msg="";
/*change permition*/
if(isset($_POST["s"])){ change_permition("system_ips",$_GET["edit"],false); insert_action("ip","change permition",$_GET["edit"]); }
/* check if have permition */
$admin_permition = check_if_permition("system_ips",$_GET["edit"],false);
if(isset($_POST['namex'],$_POST['ip']) && $admin_permition)
{
	if(!empty($_POST['namex']) && !empty($_POST['ip']))
	{	
			//insert action
			insert_action("ip","edit",$_GET['edit']);
			$namex = $_POST["namex"];
			$ip = $_POST["ip"];
			$update = mysql_query("UPDATE `system_ips` SET name='".mysql_real_escape_string($namex)."',  
																									ip_address='".mysql_real_escape_string($ip)."' 
																									WHERE 
																									id='".(int)$_GET['edit']."'
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
$c2 = mysql_query("SELECT * FROM `system_ips` WHERE id='".(int)$_GET['edit']."' ");
$rows_ip = mysql_fetch_array($c2);
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
				<label for="namex"><i><?=l("namelname")?></i> <font color="#f00">*</font></label>
				<input type="text" name="namex" class="namex" id="namex" value="<?=(isset($rows_ip['name'])) ? $rows_ip['name'] : "";?>" />
				<div class="checker_none username" onclick="$('.m_namex').fadeIn('slow');">
						<div class="msg m_namex"><?=l("fillnamelname")?> !</div>
				</div>
			</div><div class="clearer"></div>
			<div class="boxes">
				<label for="ip"><i><?=l("ip")?></i> <font color="#f00">*</font></label>
				<input type="text" name="ip" class="ip" id="ip" value="<?=(isset($rows_ip['ip_address'])) ? $rows_ip['ip_address'] : "";?>" />
				<div class="checker_none ip" onclick="$('.m_ip').fadeIn('slow');">
						<div class="msg m_ip"><?=l("fillip")?> !</div>
				</div>
			</div>
			<div class="clearer"></div>	

			<div class="boxes">
				<?php $_SESSION["token"]=randomPassword(16); ?>
				<a href="javascript:void(0)" onclick="openPop('contentRight.php?lang=<?=$_GET['lang']?>&id=<?=$_GET["edit"]?>&t=system_ips&weblang=<?=$_GET["lang"]?>&token=<?=$_SESSION["token"]?>')"><?=l("contentupdateright")?></a>
			</div><div class="clearer"></div>
			
			<div class="boxes">				
				<input type="submit" class="submit" id="submit" value="<?=l("edit")?>" />
			</div>
			<div class="clearer"></div><br />
		</form>