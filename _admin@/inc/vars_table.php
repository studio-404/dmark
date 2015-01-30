<h1>
<div class="search">
	<form action="" method="post" id="target">
	<input type="hidden" name="where" id="where" value="" />
	<input type="hidden" name="search_val" id="search_val" value="" />
	</form>
	<select name="whereto" id="whereto">
		<option value=""><?=l("choose")?></option>
		<option value="variable" <?=($_POST["whereto"]=="variable") ? 'selected="selected"' : ''?>><?=l("variable")?></option>
		<option value="text" <?=($_POST["whereto"]=="text") ? 'selected="selected"' : ''?>><?=l("text")?></option>
	</select>
	<input type="text" name="search" id="seach" class="search" value="<?=(isset($_POST["search"])) ? $_POST["search"] : ''?>" placeholder="<?=l("search")?>" />
	<div class="button" onclick="search_vars()"></div>
</div>
</h1>
<div class="clearer"></div>
<ul class="main_actions">
	<li><div class="icon-add"></div><a href="<?=$_GET['lang']?>/add/vars"><?=l("add")?></a></li>
	<li><div class="icon-delete"></div><a href="javascript:void(0)"  class="deleteAll" onclick="deleteMultiple('<?=l("delete_elem")?>,<?=l("delete")?>,<?=l("close")?>')"><?=l("delete")?></a></li>
</ul>
<div class="clearer"></div>
<table class="table">
<tr>
<th width="20"><input type="checkbox" name="sel" class="checkall" value="0" onclick="checkall()"></th>
<th><?=l("id")?></th>
<th><?=l("variable")?></th>
<th><?=l("text")?></th>
<th width="100"><?=l("action")?></th>				
</tr>			
<?php
$fecth_admins = mysql_query($p[0]);
$x=1;
while($rows = mysql_fetch_array($fecth_admins)){
?>
<tr>
<td><input type="checkbox" name="sel[]" class="all" value="<?=$rows['idx']?>"></td>
<td><?=$rows['idx']?></td>
<td><?=$rows['variable']?></td>
<td><?=$rows['text']?></td>
<td>
	<div class="icon-edit" title="<?=l("edit")?>"><a href="<?=$_GET['lang']?>/edit/<?=$_GET['show']?>/<?=$rows['idx']?>"></a></div>
	<div class="icon-delete" title="<?=l("delete")?>"><a href="javascript:void(0)" onclick="delete_request('<?=$rows['idx']?>','<?=l("delete_elem")?>,<?=l("delete")?>,<?=l("close")?>')"></a></div>
</td>
</tr>
<?php 
	$x++;
}
?>
</table>
<div class="clearer"></div>
<ul class="main_actions">
	<li><div class="icon-add"></div><a href="<?=$_GET['lang']?>/add/vars"><?=l("add")?></a></li>
	<li><div class="icon-delete"></div><a href="javascript:void(0)"  class="deleteAll" onclick="deleteMultiple('<?=l("delete_elem")?>,<?=l("delete")?>,<?=l("close")?>')"><?=l("delete")?></a></li>
</ul>
<div class="clearer"></div>
<?=$p[1]?>
