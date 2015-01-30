<?php
$msg = "";
/*change permition*/
if(isset($_POST["s"])){ change_permition("website_menu",false,$_GET["edit"]); insert_action("website menu","change permition",$_GET["edit"]); $msg = l("done"); $theBoxColore = "orange"; }
/* check if have permition */
$admin_permition = check_if_permition("website_menu",false,$_GET["edit"]);
if(isset($_POST["post"]) && $admin_permition)
{
	insert_action("website menu","edit",$_GET['edit']);
	// image upload
	foreach($_POST["post"] as $key => $value){ 
		if(!empty($value["title"])){
			$update = mysql_query("UPDATE `website_menu` SET 
			`title`='".mysql_real_escape_string(strip($value["title"]))."' 
			WHERE 
			`idx`='".(int)$_GET['edit']."' AND 
			`langs`='".strip($key)."' 
			");
		}else{
			$msg = l("requiredfields");
			$theBoxColore = "red";
		}		
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
	
<form action="" method="post" enctype="multipart/form-data">
	<?php 
	if($count){		
		$y = 1;
		foreach($select_languages["name"] as $name){
		$select = mysql_query("SELECT `title` FROM `website_menu` WHERE `idx`='".(int)$_GET['edit']."' AND `status`!=1 AND `langs`='".strip($select_languages["language"][$y-1])."' ");
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
			<?php
			if(!$admin_permition){ 
				echo '<div class="boxes">';
				echo '<div class="error_msg red"><i>'.l("noRight").' !</i></div>';
				echo '</div>';
			}
			?>
			<div class="boxes">
				<label for="title"><i><?=l("title")?></i> <font color="#f00">*</font></label>
				<input type="text" name="post[<?=$select_languages["language"][$y-1]?>][title]" id="title" class="title" value="<?=(isset($rows['title'])) ? $rows['title'] : "";?>" />
				<div class="checker_none title" onclick="$('.m_name').fadeIn('slow');">
						<div class="msg m_name"><?=l("filltitle")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<?php $_SESSION["token"]=randomPassword(16); ?>
				<a href="javascript:void(0)" onclick="openPop('contentRight.php?lang=<?=$_GET['lang']?>&idx=<?=$_GET["edit"]?>&t=website_menu&weblang=<?=$_GET["lang"]?>&token=<?=$_SESSION["token"]?>')"><?=l("contentupdateright")?></a>
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