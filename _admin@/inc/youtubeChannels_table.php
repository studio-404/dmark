<ul class="main_actions">
	<li><div class="icon-add"></div><a href="<?=$_GET['lang']?>/add/youtubeChannels"><?=l("add")?></a></li>
	<li><div class="icon-delete"></div><a href="javascript:void(0)"  class="deleteAll" onclick="remove_item('delete_systemlogs.php?lang=<?=$_GET['lang']?>')"><?=l("delete")?></a></li>
</ul>
<div class="clearer"></div>
<table class="table">
<tr>
<th width="20"><input type="checkbox" name="sel" class="checkall" value="0" onclick="checkall()"></th>
<th width="35"><?=l("id")?></th>
<th><?=l("channelname")?></th>
<th><?=l("email")?></th>
<th width="100"><?=l("action")?></th>				
</tr>			
<?php
$fecth_admins = mysql_query($p[0]);
while($rows = mysql_fetch_array($fecth_admins)){
$ap = check_if_permition("website_youtube",$rows['id'],false);
?>
<tr>
<td>
<?php if($ap) : ?>
<input type="checkbox" name="sel[]" class="all" value="<?=$rows['id']?>">
<?php endif; ?>
</td>
<td><?=$rows['id']?></td>
<td><a href="<?=$rows['channel_link']?>" target="_blank"><?=$rows['channel_name']?></a></td>
<td><?=$rows['email']?></td>
<td>
	<div class="icon-edit" title="<?=l("edit")?>"><a href="<?=$_GET['lang']?>/edit/youtubeChannels/<?=$rows['id']?>"></a></div>
	<?php if($ap) : ?>
	<div class="icon-delete" title="<?=l("delete")?>"><a href="javascript:void(0)" onclick="openPop('delete_systemlogs.php?edit=<?=$rows['id']?>&lang=<?=$_GET['lang']?>')"></a></div>
	<?php endif; ?>
</td>
</tr>
<?php
}
?>
</table>
<div class="clearer"></div>
<ul class="main_actions">
	<li><div class="icon-add"></div><a href="<?=$_GET['lang']?>/add/youtubeChannels"><?=l("add")?></a></li>
	<li><div class="icon-delete"></div><a href="javascript:void(0)"  class="deleteAll" onclick="remove_item('delete_systemlogs.php?lang=<?=$_GET['lang']?>')"><?=l("delete")?></a></li>
</ul>
<div class="clearer"></div>
<?=$p[1]?>