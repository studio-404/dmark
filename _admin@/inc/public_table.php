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
<table class="table">
<tr>
<th><?=l("id")?></th>
<th><?=cut_text(l("date"),40)?></th>
<th><?=cut_text(l("name"),40)?></th>
<th width="100"><?=cut_text(l("action"),40)?></th>				
</tr>			
<?php
$fecth_admins = mysql_query($p[0]);
$x=1;
while($rows = mysql_fetch_array($fecth_admins)){
?>
<tr>
<td><?=$rows['n_idx']?></td>
<td><?=date("d/m/Y H:s",(int)$rows['n_date'])?></td>
<td title="<?=$rows['wm_title']?>"><?=cut_text($rows['wm_title'],70)?></td>
<td>
	<div class="icon-url" title="<?=l("url")?>"><a href="<?="/".$rows['wm_url']?>" target="_blank"></a></div>
	<div class="icon-add" title="<?=l("add")?>"><a href="<?=$_GET['lang']?>/table/publicFiles/<?=$rows['wna_idx']?>"></a></div>
	<div class="icon-edit" title="<?=l("edit")?>"><a href="<?=$_GET['lang']?>/edit/public/<?=$rows['wm_idx']?>"></a></div>
	<div class="icon-delete" title="<?=l("delete")?>"><a href="javascript:void(0)" onclick="openPop('delete_public.php?edit=<?=$rows['n_idx']?>&lang=<?=$_GET['lang']?>')"></a></div>
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
<?=$p[1]?>
