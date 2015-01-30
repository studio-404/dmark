<ul class="main_actions">
	<li><div class="icon-add"></div><a href="<?=$_GET['lang']?>/add/navigation"><?=l("add")?></a></li>
</ul>
<div class="clearer"></div>
<table class="table">
<tr>
<th width="30">&nbsp;</th>
<th title="<?=l("id")?>"><?=cut_text(l("id"),4)?></th>
<th title="<?=l("step")?>"><?=cut_text(l("step"),4)?></th>
<th title="<?=l("position")?>"><?=cut_text(l("position"),4)?></th>
<th><?=cut_text(l("title"),40)?></th>
<th><?=cut_text(l("gotourl"),35)?></th>
<th title="<?=l("pagetype")?>"><?=cut_text(l("pagetype"),8)?></th>
<th width="100"><?=cut_text(l("action"),40)?></th>				
</tr>			
<?php
$fecth_admins = mysql_query($p[0]);
$x=1;
while($rows = mysql_fetch_array($fecth_admins)){
$ap = check_if_permition("website_menu",false,$rows['idx']);
?>
<tr>
<td>
	<?php 
	if($p[2] > 1) {
		if($x!=$p[2]) : 
		?>
		<div class="plus" onclick="moveAction('plus','<?=$rows['idx']?>','<?=$rows['position']?>','<?=$rows['menu_type']?>')"></div>
		<?php 
		endif;
		if($x!=1) :
		?>
		<div class="minus" onclick="moveAction('minus','<?=$rows['idx']?>','<?=$rows['position']?>','<?=$rows['menu_type']?>')"></div>
		<?php 
		endif;
	}
	?>
</td>
<td><?=$rows["idx"]?></td>
<td><?=$rows['menu_type']?></td>
<td><?=$rows['position']?></td>
<td><?=cut_text($rows['title'],80)?></td>
<td title="<?=$rows['url']?>"><?=cut_text($rows['url'],40)?></td>
<td><?=$rows['type']?></td>
<td>
	<div class="icon-add" title="<?=l("addSubmenu")?>"><a href="javascript:void(0)" onclick="sendPost(<?=$rows["idx"]?>)"></a></div>
	<div class="icon-url" title="<?=l("url")?>"><a href="<?=MAIN_DIR.$rows['url']?>" target="_blank"></a></div>
	<?php 
		$vis = (!$rows["show"]) ? "opacity: 1; filter: alpha(opacity=100);" : "opacity: 0.4; filter: alpha(opacity=40);";
		$command = (!$rows["show"]) ? "in" : "vi";
	?>
	<div class="icon-view" title="<?=l("visibility")?>" style="<?=$vis?>"><a href="javascript:void(0)" onclick="openPop('change_vis.php?edit=<?=$rows['idx']?>&command=<?=$command?>&lang=<?=$_GET['lang']?>')"></a></div>
	<div class="icon-edit" title="<?=l("edit")?>"><a href="<?=$_GET['lang']?>/edit/navigation/<?=$rows['idx']?>"></a></div>
	<?php 
	if($rows['idx']!=1 && $ap) :
	?>
	<div class="icon-delete" title="<?=l("delete")?>"><a href="javascript:void(0)" onclick="delete_request('<?=$rows['idx']?>','<?=l("delete_elem")?>,<?=l("delete")?>,<?=l("close")?>')"></a></div>
	<?php
	endif;
	?>
</td>
</tr>
<?php 
	$x++;
	echo select_sub_menus($rows['idx']);
?>
<?php
}
?>
</table>
<div class="clearer"></div>
<ul class="main_actions">
	<li><div class="icon-add"></div><a href="<?=$_GET['lang']?>/add/navigation"><?=l("add")?></a></li>
</ul>
<div class="clearer"></div>
<?=$p[1]?>
<div class="clearer"></div><br />