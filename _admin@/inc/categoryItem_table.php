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
	<li><div class="icon-add"></div><a href="<?=$_GET['lang']?>/add/categoryItem/<?=$_GET['gallery_id']?>"><?=l("addcatalog")?></a></li>
	<li><div class="icon-delete"></div><a href="javascript:void(0)"  class="deleteAll" onclick="remove_item('delete_newsItem.php?lang=<?=$_GET['lang']?>')"><?=l("delete")?></a></li>
</ul>
<div class="clearer"></div>
<?php
if($_GET["gallery_id"]==3) :
?>
<table class="table">
<tr>
<th width="20"><input type="checkbox" name="sel" class="checkall" value="0" onclick="checkall()"></th>
<th><?=cut_text(l("startjob"),40)?></th>
<th><?=cut_text(l("namelname"),40)?></th>
<th width="100"><?=cut_text(l("action"),40)?></th>				
</tr>			
<?php
$fecth_admins = mysql_query($p[0]);
$x=1;
while($rows = mysql_fetch_array($fecth_admins)){
$ap = check_if_permition("website_catalogs_items",false,$rows['wni_idx']);
?>
<tr>
<td>
<?php if($ap) :?>
<input type="checkbox" name="sel[]" class="all" value="<?=$rows['wni_idx']?>">
<?php endif; ?>
</td>
<td><?=date("d/m/Y H:s",(int)$rows['wni_startjob'])?></td>
<td><?=cut_text($rows['wni_namelname'],40)?></td>
<td>
	<div class="icon-edit" title="<?=l("edit")?>"><a href="<?=$_GET['lang']?>/edit/<?=$_GET['show']?>/<?=$_GET['gallery_id']?>/<?=$rows['wni_idx']?>"></a></div>
	<?php if($ap) :?>
	<div class="icon-delete" title="<?=l("delete")?>"><a href="javascript:void(0)" onclick="openPop('delete_newsItem.php?edit=<?=$rows['wni_idx']?>&lang=<?=$_GET['lang']?>')"></a></div>
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
<?php 
endif;

if($_GET["gallery_id"]==1) : 
?>
<table class="table">
<tr>
<th width="20"><input type="checkbox" name="sel" class="checkall" value="0" onclick="checkall()"></th>
<th><?=cut_text(l("title"),40)?></th>
<th><?=cut_text(l("type"),40)?></th>
<th width="100"><?=cut_text(l("action"),40)?></th>				
</tr>			
<?php
$fecth_admins = mysql_query($p[0]);
$x=1;
while($rows = mysql_fetch_array($fecth_admins)){
$ap = check_if_permition("website_catalogs_items",false,$rows['wni_idx']);
?>
<tr>
<td>
<?php if($ap) :?>
<input type="checkbox" name="sel[]" class="all" value="<?=$rows['wni_idx']?>">
<?php endif; ?>
</td>
<td><?=cut_text($rows['wni_title'],40)?></td>
<td><?=cut_text($rows['wni_type'],40)?></td>
<td>
	<div class="icon-edit" title="<?=l("edit")?>"><a href="<?=$_GET['lang']?>/edit/<?=$_GET['show']?>/<?=$_GET['gallery_id']?>/<?=$rows['wni_idx']?>"></a></div>
	<?php if($ap) :?>
	<div class="icon-delete" title="<?=l("delete")?>"><a href="javascript:void(0)" onclick="openPop('delete_newsItem.php?edit=<?=$rows['wni_idx']?>&lang=<?=$_GET['lang']?>')"></a></div>
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
<?php
endif;
?>
<div class="clearer"></div>
<ul class="main_actions">
	<li><div class="icon-add"></div><a href="<?=$_GET['lang']?>/add/categoryItem/<?=$_GET['gallery_id']?>"><?=l("addcatalog")?></a></li>
	<li><div class="icon-delete"></div><a href="javascript:void(0)"  class="deleteAll" onclick="remove_item('delete_newsItem.php?lang=<?=$_GET['lang']?>')"><?=l("delete")?></a></li>
</ul>
<div class="clearer"></div>
<?=$p[1]?>
