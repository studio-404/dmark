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
<th width="100"><?=l("action")?></th>				
</tr>			
<?php
$fecth_admins = mysql_query($p[0]);
$x=1;
while($rows = mysql_fetch_array($fecth_admins)){
?>
<tr>
<td><?=$rows['title']?></td>
<td><?=$rows['url']?></td>
<td>
	<div class="icon-edit" title="<?=l("edit")?>"><a href="<?=$_GET['lang']?>/edit/<?=$_GET['show']?>/<?=$rows['idx']?>"></a></div>
</td>
</tr>
<?php 
	$x++;
}
?>
</table>
<div class="clearer"></div>
<?=$p[1]?>
