<ul class="main_actions">
	<li><div class="icon-add"></div><a href="<?=$_GET['lang']?>/add/system_admin"><?=l("add")?></a></li>
	<li><div class="icon-delete"></div><a href="javascript:void(0)"  class="deleteAll" onclick="deleteMultiple('<?=l("delete_elem")?>,<?=l("delete")?>,<?=l("close")?>')"><?=l("delete")?></a></li>
</ul>
<div class="clearer"></div>
<table class="table">
<tr>
<th width="20"><input type="checkbox" name="gg" class="checkall" value="0" onclick="checkall()"></th>
<th width="35"><?=l("id")?></th>
<th><?=l("namelname")?></th>
<th><?=l("phone")?></th>
<th><?=l("email")?></th>
<th width="100"><?=l("action")?></th>				
</tr>			
<?php
$fecth_admins = mysql_query($p[0]);
while($rows = mysql_fetch_array($fecth_admins)){
$ap = check_if_permition("panel_admins",$rows['id'],false);
?>
<tr>
<td>
<?php if(!$rows["permition"] && $ap) : ?>
<input type="checkbox" name="sel[]" class="all" value="<?=$rows['id']?>">
<?php endif; ?>
</td>
<td><?=$rows['id']?></td>
<td><?=$rows['name']?></td>
<td><?=$rows['phone']?></td>
<td><?=$rows['email']?></td>
<td>
	<div class="icon-edit" title="<?=l("edit")?>"><a href="<?=$_GET['lang']?>/edit/system_admin/<?=$rows['id']?>"></a></div>
	<?php if(!$rows["permition"] && $ap) : ?>
	<!-- openPop('delete_admin.php?edit=<?=$rows['id']?>&lang=<?=$_GET['lang']?>') -->
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
	<li><div class="icon-add"></div><a href="<?=$_GET['lang']?>/add/system_admin"><?=l("add")?></a></li>
	<li><div class="icon-delete"></div><a href="javascript:void(0)"  class="deleteAll" onclick="deleteMultiple('<?=l("delete_elem")?>,<?=l("delete")?>,<?=l("close")?>')"><?=l("delete")?></a></li>
</ul>
<div class="clearer"></div>
<?=$p[1]?>
