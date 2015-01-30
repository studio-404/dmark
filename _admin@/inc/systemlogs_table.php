<ul class="main_actions">
	<li><div class="icon-delete"></div><a href="javascript:void(0)"  class="deleteAll" onclick="deleteMultiple('<?=l("delete_elem")?>,<?=l("delete")?>,<?=l("close")?>')"><?=l("delete")?></a></li>
</ul>
<div class="clearer"></div>
<table class="table">
<tr>
<th width="20"><input type="checkbox" name="sel" class="checkall" value="0" onclick="checkall()"></th>
<th width="35"><?=l("id")?></th>
<th><?=l("date")?></th>
<th><?=l("username")?></th>
<th><?=l("os")?></th>
<th><?=l("browser")?></th>
<th><?=l("ip")?></th>
<th width="100"><?=l("action")?></th>				
</tr>			
<?php
$fecth_admins = mysql_query($p[0]);
while($rows = mysql_fetch_array($fecth_admins)){
?>
<tr>
<td><input type="checkbox" name="sel[]" class="all" value="<?=$rows['id']?>"></td>
<td><?=$rows['id']?></td>
<td><?=date("d/m/Y H:s",(int)$rows['date'])?></td>
<td><?=select_admin_by_id($rows['user_id'],"name")?></td>
<td><?=$rows['os']?></td>
<td><?=$rows['browser']?></td>
<td><?=$rows['ip']?></td>
<td>
	<div class="icon-delete" title="<?=l("delete")?>"><a href="javascript:void(0)" onclick="delete_request('<?=$rows['id']?>','<?=l("delete_elem")?>,<?=l("delete")?>,<?=l("close")?>')"></a></div>
</td>
</tr>
<?php
}
?>
</table>
<div class="clearer"></div>
<ul class="main_actions">
	<li><div class="icon-delete"></div><a href="javascript:void(0)"  class="deleteAll" onclick="deleteMultiple('<?=l("delete_elem")?>,<?=l("delete")?>,<?=l("close")?>')"><?=l("delete")?></a></li>
</ul>
<div class="clearer"></div>
<?=$p[1]?>