<ul class="main_actions">
	<li><div class="icon-add"></div><a href="<?=$_GET['lang']?>/add/systemipaddresses"><?=l("add")?></a></li>
	<li><div class="icon-delete"></div><a href="javascript:void(0)"  class="deleteAll" onclick="deleteMultiple('<?=l("delete_elem")?>,<?=l("delete")?>,<?=l("close")?>')"><?=l("delete")?></a></li>
</ul>
<div class="clearer"></div>
<table class="table">
<tr>
<th width="20">
<input type="checkbox" name="sel" class="checkall" value="0" onclick="checkall()">
</th>
<th width="35"><?=l("id")?></th>
<th><?=l("namelname")?></th>
<th><?=l("ip_address")?></th>
<th width="100"><?=l("action")?></th>				
</tr>			
<?php
$fecth_admins = mysql_query($p[0]);
while($rows = mysql_fetch_array($fecth_admins)){
$ap = check_if_permition("system_ips",$rows['id'],false);
?>
<tr>
<td>
	<?php  if($ap) : ?>
	<input type="checkbox" name="sel[]" class="all" value="<?=$rows['id']?>">
	<?php endif; ?>
</td>
<td><?=$rows['id']?></td>
<td><?=$rows['name']?></td>
<td><?=$rows['ip_address']?></td>
<td>
	<?php  if($ap) : ?>
	<div class="icon-edit" title="<?=l("edit")?>"><a href="<?=$_GET['lang']?>/edit/systemipaddresses/<?=$rows['id']?>"></a></div>
	<div class="icon-delete" title="<?=l("delete")?>"><a href="javascript:void(0)" onclick="delete_request('<?=$rows['id']?>','<?=l("delete_elem")?>,<?=l("delete")?>,<?=l("close")?>')"></a></div>
	<?php endif; ?>
</td>
</tr>
<?php
}
?>
</table>
<div class="clearer"></div>
<ul class="main_actions">
	<li><div class="icon-add"></div><a href="<?=$_GET['lang']?>/add/systemipaddresses"><?=l("add")?></a></li>
	<li><div class="icon-delete"></div><a href="javascript:void(0)"  class="deleteAll" onclick="deleteMultiple('<?=l("delete_elem")?>,<?=l("delete")?>,<?=l("close")?>')"><?=l("delete")?></a></li>
</ul>
<div class="clearer"></div>
<?=$p[1]?>
