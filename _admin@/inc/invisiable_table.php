<form action="" method="post" id="form_search">
<h1>
<div class="search">
	<select name="whereto" id="whereto">
		<option value=""><?=l("choose")?></option>
		<option value="url" <?=($_POST["whereto"]=="url") ? 'selected="selected"' : ''?>><?=l("url")?></option>
		<option value="text" <?=($_POST["whereto"]=="text") ? 'selected="selected"' : ''?>><?=l("text")?></option>
	</select>
	<input type="text" name="search" id="seach" class="search" value="<?=(isset($_POST["search"])) ? $_POST["search"] : ''?>" placeholder="<?=l("search")?>" />
	<div class="button" onclick="$('#form_search').submit()"></div>
</div>
</h1>
</form>
<div class="clearer"></div>
<table class="table">
<tr>
<th><?=l("title")?></th>
<th><?=l("gotourl")?></th>
<th><?=l("type")?></th>
<th width="100"><?=l("action")?></th>				
</tr>			
<?php
$fecth_admins = mysql_query($p[0]);
$x=1;
while($rows = mysql_fetch_array($fecth_admins)){
$ap = check_if_permition("website_menu",false,$rows['idx']);
?>
<tr>
<td><?=$rows['title']?></td>
<td><?=$rows['url']?></td>
<td><?=$rows['type']?></td>
<td>
	<?php if($rows['type']!="plugin") : ?>
	<div class="icon-edit" title="<?=l("edit")?>"><a href="<?=$_GET['lang']?>/edit/text/<?=$rows['idx']?>"></a></div>
	<?php endif; if($ap) : ?>
	<div class="icon-delete" title="<?=l("delete")?>"><a href="javascript:void(0)" onclick="openPop('delete_invisible.php?edit=<?=$rows['idx']?>&lang=<?=$_GET['lang']?>')"></a></div>
	<?php endif; ?>
</td>
</tr>
<?php 
	$x++;
}
?>
</table>
<div class="clearer"></div>
<?=$p[1]?>