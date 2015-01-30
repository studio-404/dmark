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
	<li><div class="icon-add"></div><a href="<?=$_GET['lang']?>/add/publicFiles/<?=$_GET['gallery_id']?>"><?=l("add")?></a></li>
	<li><div class="icon-delete"></div><a href="javascript:void(0)"  class="deleteAll" onclick="remove_item('delete_newsItem.php?lang=<?=$_GET['lang']?>')"><?=l("delete")?></a></li>
</ul>
<div class="clearer"></div>
<table class="table">
<tr>
<th width="20"><input type="checkbox" name="sel" class="checkall" value="0" onclick="checkall()"></th>
<th><?=l("id")?></th>
<th><?=cut_text(l("date"),40)?></th>
<th><?=cut_text(l("name"),40)?></th>
<th><?=cut_text(l("status"),40)?></th>
<th width="100"><?=cut_text(l("action"),40)?></th>				
</tr>			
<?php
$fecth_admins = mysql_query($p[0]);
$x=1;
while($rows = mysql_fetch_array($fecth_admins)){
$ap = check_if_permition("website_public_files",false,$rows['idx']);
?>
<tr>
<td>
<?php if($ap) :?>
<input type="checkbox" name="sel[]" class="all" value="<?=$rows['idx']?>">
<?php endif; ?>
</td>
<td><?=$rows['idx']?></td>
<td><?=date("d/m/Y H:s",(int)$rows['date'])?></td>
<td><?=cut_text(stripslashes($rows['name']),40)?></td> 
<td><?=($rows['archive']==2) ? l("archived") : l("active")?></td>
<td>
	<div class="icon-url" title="<?=l("url")?>"><a href="<?=MAIN_DIR?>image/public_files/<?=$rows['file_name']?>" target="_blank"></a></div>
	<div class="icon-edit" title="<?=l("edit")?>"><a href="<?=$_GET['lang']?>/edit/<?=$_GET['show']?>/<?=$_GET['gallery_id']?>/<?=$rows['idx']?>"></a></div>
	<?php 
		$vis = ($rows["archive"]==2) ? "opacity: 1; filter: alpha(opacity=100);" : "opacity: 0.4; filter: alpha(opacity=40);";
		$command = ($rows["archive"]==2) ? "archived" : "noArchived";
	?>
	<div class="icon-archive" title="<?=l("archive")?>" style="<?=$vis?>"><a href="javascript:void(0)" onclick="openPop('change_archive.php?edit=<?=$rows['idx']?>&command=<?=$command?>&lang=<?=$_GET['lang']?>')"></a></div>
	<?php if($ap) :?>
	<div class="icon-delete" title="<?=l("delete")?>"><a href="javascript:void(0)" onclick="openPop('delete_newsItem.php?edit=<?=$rows['idx']?>&lang=<?=$_GET['lang']?>')"></a></div>
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
	<li><div class="icon-add"></div><a href="<?=$_GET['lang']?>/add/publicFiles/<?=$_GET['gallery_id']?>"><?=l("add")?></a></li>
	<li><div class="icon-delete"></div><a href="javascript:void(0)"  class="deleteAll" onclick="remove_item('delete_newsItem.php?lang=<?=$_GET['lang']?>')"><?=l("delete")?></a></li>
</ul>
<div class="clearer"></div>
<?=$p[1]?>
