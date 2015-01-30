<?php 
if(isset($_POST['delete'])){
	$delete = explode(",",$_POST['delete']);
	if(count($delete) > 1){
		$update_admin_remove = mysql_query("UPDATE website_slider SET status=1 WHERE idx IN (".mysql_real_escape_string(str_replace("undefined","0",$_POST['delete'])).") ");
	}else{
		$update_admin_remove = mysql_query("UPDATE website_slider SET status=1 WHERE idx='".(int)$_POST['delete']."' ");
	}
	// update positions
	$select_old_pos = mysql_query("SELECT `position` FROM `website_slider` WHERE idx='".(int)$_POST['delete']."' ");
	$old_pos_row = mysql_fetch_array($select_old_pos);
	$update_all_next_positions = mysql_query("UPDATE `website_slider` SET `position`=`position`-1 WHERE `position` >= '".(int)$old_pos_row["position"]."' ");
	
	//insert action
	insert_action("slide","delete",$_POST['delete']);
}
if(isset($_POST['action'],$_POST['idx'])){
	//insert action
	insert_action("slide","move",$_POST['idx']);
	$s = mysql_query("SELECT position FROM website_slider WHERE idx='".(int)$_POST['idx']."' ");
	$r = mysql_fetch_array($s);
	if($_POST['action']=="next" && $r['position']!=$p[2]){
		$update_pos = mysql_query("UPDATE website_slider SET position=0 WHERE position='".(int)($r['position']+1)."' ");
		$update_pos2 = mysql_query("UPDATE website_slider SET position=position+1 WHERE idx='".(int)$_POST['idx']."' ");
		$update_pos3 = mysql_query("UPDATE website_slider SET position='".(int)$r['position']."' WHERE position='0' ");
	}else if($_POST['action']=="prev" && $r['position']!=1){
		$update_pos = mysql_query("UPDATE website_slider SET position=0 WHERE position='".(int)($r['position']-1)."' ");
		$update_pos2 = mysql_query("UPDATE website_slider SET position=position-1 WHERE idx='".(int)$_POST['idx']."' ");
		$update_pos3 = mysql_query("UPDATE website_slider SET position='".(int)$r['position']."' WHERE position='0' ");
	}
}
?>
<form action="" method="post" id="move">
<input type="hidden" name="action" id="action" value="next" />
<input type="hidden" name="idx" id="idx" value="1" />
</form>
<ul class="main_actions">
	<li><div class="icon-add"></div><a href="<?=$_GET['lang']?>/add/slide"><?=l("add")?></a></li>
</ul><div class="clearer"></div>

<div class="imageBoxs">
<?php
$fecth_admins = mysql_query($p[0]);
$x=0;
$m=1;
while($rows = mysql_fetch_array($fecth_admins)){
$ap = check_if_permition("website_slider",false,$rows['idx']);
?>
	<div class="box<?php echo ($rows["slidetype"]) ? ' after-image-player' : ''; ?>">
		<?php
		if($rows["slidetype"])
		{
		?>
			<img src="<?=getYoutubeImageSrc($rows["gotourl"])?>" width="249" height="178" alt="" />
		<?php
		}
		else
		{
		?>
			<img src="../crop.php?path=image/slide/&img=<?=MAIN_DIR?>/image/slide/<?=$rows['image']?>&amp;width=249&amp;height=178" width="249" height="178" alt="" />
		<?php
		}
		?>
		<div class="sub_actions">
			<div class="icon-arrow-left<?=($x==0) ? " op_60" : ""?>" title="<?=l("move")?>" <?=($x!=0) ? 'onclick="move(\'prev\',\''.$rows['idx'].'\')"' : ''?>></div>
			<div class="icon-arrow-right<?=(($x+1)==$p[2]) ? " op_60" :""?>" title="<?=l("move")?>" <?=(($x+1)!=$p[2]) ? 'onclick="move(\'next\',\''.$rows['idx'].'\')"' : ''?>></div>
			<div class="icon-edit" title="<?=l("edit")?>" onclick="location.href='<?=$_GET['lang']?>/edit/slide/<?=$rows['idx']?>'"> </div>
			<?php if($ap) : ?>
			<div class="icon-delete <?=$rows['id']?>" title="<?=l("delete")?>" onclick="delete_request('<?=$rows['idx']?>','<?=l("delete_elem")?>,<?=l("delete")?>,<?=l("close")?>')"></div>
			<?php endif; ?>
		</div>
	</div>
<?php
	if(($m%3) == 0){ echo '<div class="clearer"></div>'; }
	$m++;
$x++;
}
?>
</div>

<div class="clearer"></div>
<ul class="main_actions">
	<li><div class="icon-add"></div><a href="<?=$_GET['lang']?>/add/slide"><?=l("add")?></a></li>
</ul>
<div class="clearer"></div>
<?=$p[1]?>