<ul class="main_actions">
	<li><div class="icon-add"></div><a href="<?=$_GET['lang']?>/add/charts"><?=l("add")?></a></li>
	<li><div class="icon-delete"></div><a href="javascript:void(0)"  class="deleteAll" onclick="remove_item('delete_systemlogs.php?lang=<?=$_GET['lang']?>')"><?=l("delete")?></a></li>
</ul>
<div class="clearer"></div>
<table class="table">
<tr>
	<th width="20"><input type="checkbox" name="sel" class="checkall" value="0" onclick="checkall()"></th>
	<th width="35"><?=l("id")?></th>
	<th><?=l("title")?></th>
	<th><?=l("status")?></th>
	<th width="100"><?=l("action")?></th>
</tr>			
<?php
$fecth_admins = mysql_query($p[0]);
while($rows = mysql_fetch_array($fecth_admins)){
$ap = check_if_permition("website_charts",false,$rows['idx']);
?>
<tr>
	<td>
		<?php if($ap) :?>
		<input type="checkbox" name="sel[]" class="all" value="<?=$rows['idx']?>">
		<?php endif; ?>
	</td>
	<td><?=$rows['idx']?></td>
	<td><?=$rows['chart_title']?></td>
	<td><?=l($rows['create_status'])?></td>
	<td>
		<div class="icon-view" title="<?=l("view")?>"><a href="<?=MAIN_DIR?>_charts/<?=$rows['chart_file']?>" target="_blank"></a></div>
		<div class="icon-url" title="<?=l("url")?>"><a href="javascript:void(0)" onclick="openPop('get_charts.php?chart_file=<?=$rows['chart_file']?>&lang=<?=$_GET['lang']?>')"></a></div>
		<div class="icon-edit" title="<?=l("edit")?>"><a href="<?=$_GET['lang']?>/edit/charts/<?=$rows['idx']?>"></a></div>
		<?php if($ap) :?>
		<div class="icon-delete" title="<?=l("delete")?>"><a href="javascript:void(0)" onclick="openPop('delete_systemlogs.php?edit=<?=$rows['idx']?>&lang=<?=$_GET['lang']?>')"></a></div>
		<?php endif; ?>
	</td>
</tr>
<?php
}
?>
<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td><a hrfe="javascript:void(0)">
	chart created: <?=croned("create_chart")?>
	</a></td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
</table>
<div class="clearer"></div>
<ul class="main_actions">
	<li><div class="icon-add"></div><a href="<?=$_GET['lang']?>/add/charts"><?=l("add")?></a></li>
	<li><div class="icon-delete"></div><a href="javascript:void(0)"  class="deleteAll" onclick="remove_item('delete_systemlogs.php?lang=<?=$_GET['lang']?>')"><?=l("delete")?></a></li>
</ul>
<div class="clearer"></div>
<?=$p[1]?>