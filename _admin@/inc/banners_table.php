<ul class="main_actions">
	<li><div class="icon-add"></div><a href="<?=$_GET['lang']?>/add/banners"><?=l("add")?></a></li>
</ul>
<div class="clearer"></div>
<table class="table">
<tr>
<th width="30">&nbsp;</th>
<th title="<?=l("position")?>"><?=cut_text(l("position"),4)?></th>
<th><?=cut_text(l("title"),40)?></th>
<th><?=cut_text(l("gotourl"),35)?></th>
<th width="100"><?=cut_text(l("action"),40)?></th>				
</tr>			
<?php
$fecth_admins = mysql_query($p[0]);
$x=1;
while($rows = mysql_fetch_array($fecth_admins)){
$ap = check_if_permition("website_banners",false,$rows['idx']);
?>
<tr>
<td>
	<?php 
	if($p[2] > 1) {
		if($x!=$p[2]) : 
		?>
		<div class="plus" onclick="moveAction2('plus','<?=$rows['idx']?>','<?=$rows['position']?>')"></div>
		<?php 
		endif;
		if($x!=1) :
		?>
		<div class="minus" onclick="moveAction2('minus','<?=$rows['idx']?>','<?=$rows['position']?>')"></div>
		<?php 
		endif;
	}
	?>
</td>
<td><?=$rows['position']?></td>
<td><?=cut_text($rows['title'],80)?></td>
<td title="<?=$rows['url']?>"><?=cut_text($rows['url'],40)?></td>
<td>
	<div class="icon-edit" title="<?=l("edit")?>"><a href="<?=$_GET['lang']?>/edit/banners/<?=$rows['idx']?>"></a></div>
	<?php if($ap) : ?>
	<div class="icon-delete" title="<?=l("delete")?>"><a href="javascript:void(0)" onclick="openPop('delete_nav.php?edit=<?=$rows['idx']?>&lang=<?=$_GET['lang']?>')"></a></div>
	<?php endif; ?>
</td>
</tr>
<?php 
	$x++;
?>
<?php
}
?>
</table>
<div class="clearer"></div>
<ul class="main_actions">
	<li><div class="icon-add"></div><a href="<?=$_GET['lang']?>/add/banners"><?=l("add")?></a></li>
</ul>
<div class="clearer"></div>
<?=$p[1]?>
<div class="clearer"></div><br />