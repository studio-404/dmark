<?php
if(isset($_POST["channel"],$_POST["from"],$_POST["quentity"])){
	insert_action("youtube","sync videos","0");
	syncYoutube($_POST["channel"],$_POST["from"],$_POST["quentity"]);
}
?>
<ul class="main_actions">
	<li><div class="icon-sync"></div><a href="javascript:void(0)" onclick="openPop('sync.php?lang=<?=$_GET['lang']?>')"><?=l("sync")?></a></li>
	<li><div class="icon-add"></div><a href="<?=$_GET['lang']?>/add/youtubeVideos"><?=l("add")?></a></li>
	<li><div class="icon-delete"></div><a href="javascript:void(0)"  class="deleteAll" onclick="remove_item('delete_systemlogs.php?lang=<?=$_GET['lang']?>')"><?=l("delete")?></a></li>
</ul>
<div class="clearer"></div>
<table class="table">
<tr>
	<th width="20"><input type="checkbox" name="sel" class="checkall" value="0" onclick="checkall()"></th>
	<th width="35"><?=l("id")?></th>
	<th><?=l("title")?></th>
	<th><?=l("category")?></th>
	<th><?=l("channel")?></th>
	<th><?=l("status")?></th>
	<th width="100"><?=l("action")?></th>
</tr>			
<?php
$fecth_admins = mysql_query($p[0]);

while($rows = mysql_fetch_array($fecth_admins)){
?>
<tr>
	<td><input type="checkbox" name="sel[]" class="all" value="<?=$rows['id']?>"></td>
	<td><?=$rows['id']?></td>
	<td><a href="javascript:void(0)" onclick="openPop('open_youtube.php?video=<?=$rows['video_link']?>&lang=<?=$_GET['lang']?>')"><?=$rows['title']?></a></td>
	<td><?=$rows['category']?></td>
	<td><?=get_channel_name($rows['channel_id'])?></td>
	<td><?=l($rows['upload_status'])?></td>
	<td>
		<div class="icon-url" title="<?=l("url")?>"><a href="javascript:void(0)" onclick="openPop('get_embed.php?video=<?=$rows['video_link']?>&lang=<?=$_GET['lang']?>&video_id=<?=$rows['id']?>')"></a></div>
		<div class="icon-edit" title="<?=l("edit")?>"><a href="<?=$_GET['lang']?>/edit/youtubeVideos/<?=$rows['id']?>"></a></div>
		<div class="icon-delete" title="<?=l("delete")?>"><a href="javascript:void(0)" onclick="openPop('delete_systemlogs.php?edit=<?=$rows['id']?>&lang=<?=$_GET['lang']?>')"></a></div>
	</td>
</tr>
<?php
}
?>
<tr>
	<td colspan="7">Count: <?php echo $p[2]; ?></td>
</tr>
</table>
<div class="clearer"></div>
<ul class="main_actions">
	<li><div class="icon-sync"></div><a href="javascript:void(0)" onclick="openPop('sync.php?lang=<?=$_GET['lang']?>')"><?=l("sync")?></a></li>
	<li><div class="icon-add"></div><a href="<?=$_GET['lang']?>/add/youtubeVideos"><?=l("add")?></a></li>
	<li><div class="icon-delete"></div><a href="javascript:void(0)"  class="deleteAll" onclick="remove_item('delete_systemlogs.php?lang=<?=$_GET['lang']?>')"><?=l("delete")?></a></li>
</ul>
<div class="clearer"></div>
<?=$p[1]?>