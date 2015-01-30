<?php
$msg = "";
$select_c_attachment = mysql_query("SELECT `connect_id` FROM `website_catalogs_attachment` WHERE `catalog_id`='".(int)$_GET["edit"]."' AND `langs`='".strip(MAIN_LANGUAGE)."' ");
$rows_c = mysql_fetch_array($select_c_attachment);
/*change permition*/
if(isset($_POST["s"])){ change_permition("website_menu",false,$rows_c["connect_id"]); insert_action("navigation","change permition",$rows_c["connect_id"]); }
/* check if have permition */
$admin_permition = check_if_permition("website_menu",false,$rows_c["connect_id"]);
if(isset($_POST["post"]) && $admin_permition)
{
	insert_action("catalog","edit catalog",$_GET["edit"]);
	// image upload
	foreach($_POST["post"] as $key => $value){ 
		if(!empty($value["category"])){
			$update = mysql_query("UPDATE `website_catalogs` SET 
			`category`='".strip($value["category"])."' 
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
		$select = mysql_query("SELECT 
		`website_catalogs`.`category` AS w_name
		FROM 
		`website_catalogs_attachment`,`website_catalogs` 
		WHERE 
		`website_catalogs_attachment`.`idx`='".(int)$_GET['edit']."' AND 
		`website_catalogs_attachment`.`langs`='en' AND 
		`website_catalogs_attachment`.`catalog_id`=`website_catalogs`.`idx` AND 
		`website_catalogs`.`status` != 1 AND 
		`website_catalogs`.`langs` = '".strip($select_languages["language"][$y-1])."' ");
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
				<label for="title"><i><?=l("newsCategory")?></i> <font color="#f00">*</font></label>
				<input type="text" name="post[<?=$select_languages["language"][$y-1]?>][category]" class="title" id="title" value="<?=(isset($rows['w_name'])) ? $rows['w_name'] : "";?>" />
				<div class="checker_none title" onclick="$('.m_title').fadeIn('slow');">
						<div class="msg m_title"><?=l("filltitle")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<?php $_SESSION["token"]=randomPassword(16); ?>
				<a href="javascript:void(0)" onclick="openPop('contentRight.php?lang=<?=$_GET['lang']?>&idx=<?=$rows_c["connect_id"]?>&t=website_menu&weblang=<?=$_GET["lang"]?>&token=<?=$_SESSION["token"]?>')"><?=l("contentupdateright")?></a>
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