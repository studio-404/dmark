<ul class="main_actions">
	<li><div class="icon-add"></div><a href="<?=$_GET['lang']?>/add/languages"><?=l("add")?></a></li>
</ul>
<div class="clearer"></div>
<table class="table">
<tr>
<th><?=l("language")?></th>
<th><?=l("vars")?></th>
<th width="100"><?=l("action")?></th>
</tr>			
<?php
$fecth_admins = mysql_query($p[0]);
$x=1;
while($rows = mysql_fetch_array($fecth_admins)){
$ap = check_if_permition("website_languages",$rows['id'],false);
?>
<tr>
<td><?=$rows['outname']?></td>
<td><?=$rows['shortname']?></td>
<td>
	<?php 
		$vis = (!$rows["visibility"]) ? "opacity: 1; filter: alpha(opacity=100);" : "opacity: 0.4; filter: alpha(opacity=40);";
		$command = (!$rows["visibility"]) ? "in" : "vi";
	?>
	<?php if($ap && $rows['shortname']!=MAIN_LANGUAGE) : ?>
	<div class="icon-view" title="<?=l("visibility")?>" style="<?=$vis?>"><a href="javascript:void(0)" onclick="openPop('change_vis.php?edit=<?=$rows['id']?>&command=<?=$command?>&lang=<?=$_GET['lang']?>')"></a></div>
	<div class="icon-delete" title="<?=l("delete")?>"><a href="javascript:void(0)" onclick="delete_request('<?=$rows['id']?>','<?=l("delete_elem")?>,<?=l("delete")?>,<?=l("close")?>')"></a></div>
	<?php endif; ?>
</td>
</tr>
<?php 
	$x++;
}
?>
</table>
<div class="clearer"></div>
<ul class="main_actions">
	<li><div class="icon-add"></div><a href="<?=$_GET['lang']?>/add/languages"><?=l("add")?></a></li>
</ul>
<div class="clearer"></div>
<?=$p[1]?>