<form action="" method="post" id="form_search">
<h1>
<div class="search">
	<select name="whereto" id="whereto">
		<option value=""><?=l("choose")?></option>
		<option value="idx" <?=($_POST["whereto"]=="idx") ? 'selected="selected"' : ''?>><?=l("id")?></option>
		<option value="text" <?=($_POST["whereto"]=="text") ? 'selected="selected"' : ''?>><?=l("text")?></option>
	</select>
	<input type="text" name="search" id="seach" class="search" value="<?=(isset($_POST["search"])) ? $_POST["search"] : ''?>" placeholder="<?=l("search")?>" />
	<div class="button" onclick="$('#form_search').submit()"></div>
</div>
</h1>
</form>
<div class="clearer"></div>
<ul class="main_actions">
	<li><div class="icon-add"></div><a href="<?=$_GET['lang']?>/add/gallery"><?=l("addgallery")?></a></li>
	<li><div class="icon-delete"></div><a href="javascript:void(0)"  class="deleteAll" onclick="deleteMultiple('<?=l("delete_elem")?>,<?=l("delete")?>,<?=l("close")?>')"><?=l("delete")?></a></li>
</ul>
<div class="clearer"></div>
<table class="table">
<tr>
<th width="20"><input type="checkbox" name="sel" class="checkall" value="0" onclick="checkall()"></th>
<th><?=cut_text(l("date"),40)?></th>
<th><?=cut_text(l("title"),40)?></th>
<th><?=l("type")?></th>
<th width="100"><?=cut_text(l("action"),40)?></th>				
</tr>			
<?php
$fecth_admins = mysql_query($p[0]);
$x=1;
while($rows = mysql_fetch_array($fecth_admins)){
$ap = check_if_permition("website_gallery",false,$rows['w_idx']);
?>
<tr>
<td>
<?php if($ap) : ?>
<input type="checkbox" name="sel[]" class="all" value="<?=$rows['wga_idx']?>">
<?php endif; ?>
</td>
<td><?=date("d/m/Y H:s",(int)$rows['w_date'])?></td>
<td><?=cut_text($rows['w_name'],40)?></td>
<td><?=$rows['wga_type']?></td>
<td>
	<div class="icon-add" title="<?=l("addphoto")?>"><a href="<?=$_GET['lang']?>/table/photo/<?=$rows['wga_idx']?>"></a></div>
	<div class="icon-edit" title="<?=l("edit")?>"><a href="<?=$_GET['lang']?>/edit/<?=$_GET['show']?>/<?=$rows['wga_idx']?>"></a></div>
	<?php if($ap) : ?>
	<div class="icon-delete" title="<?=l("delete")?>"><a href="javascript:void(0)" onclick="delete_request('<?=$rows['wga_idx']?>','<?=l("delete_elem")?>,<?=l("delete")?>,<?=l("close")?>')"></a></div>
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
	<li><div class="icon-add"></div><a href="<?=$_GET['lang']?>/add/gallery"><?=l("addgallery")?></a></li>
	<li><div class="icon-delete"></div><a href="javascript:void(0)"  class="deleteAll" onclick="deleteMultiple('<?=l("delete_elem")?>,<?=l("delete")?>,<?=l("close")?>')"><?=l("delete")?></a></li>
</ul>
<div class="clearer"></div>
<?=$p[1]?>
