<?php 
if(isset($_POST['delete'])){
	$delete = explode(",",$_POST['delete']);
	if(count($delete) > 1){
		$update_admin_remove = mysql_query("UPDATE website_gallery_photos SET status=1 WHERE idx IN (".$_POST['delete'].") ");
	}else{
		$update_admin_remove = mysql_query("UPDATE website_gallery_photos SET status=1 WHERE idx='".(int)$_POST['delete']."' ");
	}
	insert_action("photo","delete",$_POST['delete']);
}
if(isset($_POST['action'],$_POST['idx'])){
	insert_action("photo","move",$_POST['idx']);
	$s = mysql_query("SELECT position FROM website_gallery_photos WHERE idx='".(int)$_POST['idx']."' ");
	$r = mysql_fetch_array($s);
	if($_POST['action']=="next" && $r['position']!=$p[2]){
		$update_pos = mysql_query("UPDATE website_gallery_photos SET position=0 WHERE position='".(int)($r['position']+1)."' ");
		$update_pos2 = mysql_query("UPDATE website_gallery_photos SET position=position+1 WHERE idx='".(int)$_POST['idx']."' ");
		$update_pos3 = mysql_query("UPDATE website_gallery_photos SET position='".(int)$r['position']."' WHERE position='0' ");
	}else if($_POST['action']=="prev" && $r['position']!=1){
		$update_pos = mysql_query("UPDATE website_gallery_photos SET position=0 WHERE position='".(int)($r['position']-1)."' ");
		$update_pos2 = mysql_query("UPDATE website_gallery_photos SET position=position-1 WHERE idx='".(int)$_POST['idx']."' ");
		$update_pos3 = mysql_query("UPDATE website_gallery_photos SET position='".(int)$r['position']."' WHERE position='0' ");
	}
}
?>
<form action="" method="post" id="move">
<input type="hidden" name="action" id="action" value="next" />
<input type="hidden" name="idx" id="idx" value="1" />
</form>
<ul class="main_actions">
	<li><div class="icon-add"></div><a href="<?=$_GET['lang']?>/add/photo/<?=$_GET['gallery_id']?>"><?=l("add")?></a></li>
</ul><div class="clearer"></div>

<div class="imageBoxs">
<?php
$fecth_admins = mysql_query($p[0]);
$x=0;
$m=1;
while($rows = mysql_fetch_array($fecth_admins)){
$ap = check_if_permition("website_gallery_photos",false,$rows['wgp_idx']); 
?>
	<div class="box">
		<img src="../crop.php?path=image/slide/&img=<?=MAIN_DIR?>/image/gallery/<?=$rows['wgp_photo']?>&amp;width=249&amp;height=178" width="249" height="178" alt="" />
		<div class="sub_actions">
			<div class="icon-arrow-left<?=($x==0) ? " op_60" : ""?>" title="<?=l("move")?>" <?=($x!=0) ? 'onclick="move(\'prev\',\''.$rows['wgp_idx'].'\')"' : ''?>></div>
			<div class="icon-arrow-right<?=(($x+1)==$p[2]) ? " op_60" :""?>" title="<?=l("move")?>" <?=(($x+1)!=$p[2]) ? 'onclick="move(\'next\',\''.$rows['wgp_idx'].'\')"' : ''?>></div>
			<div class="icon-edit" title="<?=l("edit")?>" onclick="location.href='<?=$_GET['lang']?>/edit/photo/<?=$rows['wgp_idx']?>'"></div>
			<?php if($ap) :?>
			<div class="icon-delete" title="<?=l("delete")?>" onclick="openPop('delete_gallery_photo.php?edit=<?=$rows['wgp_idx']?>&lang=<?=$_GET['lang']?>')"></div>
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
	<li><div class="icon-add"></div><a href="<?=$_GET['lang']?>/add/photo/<?=$_GET['gallery_id']?>"><?=l("add")?></a></li>
</ul>
<div class="clearer"></div>
<?=$p[1]?><div class="clearer"></div>
<div class="backLink">
<a href="<?=backspaceLink()?>"><?=htmlentities("< ").l("backspace")?></a>
</div>