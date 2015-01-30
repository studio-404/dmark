<ul class="main_actions">
	<li><div class="icon-add"></div><a href="<?=$_GET['lang']?>/add/backup"><?=l("makeBackup")?></a></li>
</ul>
<div class="clearer"></div>
<table class="table">
<tr>
<th><?=cut_text(l("date"),35)?></th>
<th><?=cut_text(l("type"),35)?></th>
<th><?=cut_text(l("status"),35)?></th>
<th width="100"><?=cut_text(l("action"),40)?></th>		
</tr>			
<?php
$fecth_admins = mysql_query($p[0]);
$x=1;
while($rows = mysql_fetch_array($fecth_admins)){
if($rows['filename']){
	$file = "_backup/".$rows['type']."/".$rows['filename'];
	$outname = date("d-m-Y H:i",$rows['filename']);
}else{
	$outname = cut_text($rows['title'],80);
}
if(!file_exists($file)){ $file = 'javascript:void(0)'; $target=''; }
else{ $target='target="_blank"'; }
$ap = check_if_permition("website_backup",$rows['id'],false);
?>
<tr>
<td><a href="<?=$file?>" <?=$target?>><?=$outname?></a></td>
<td><?=cut_text($rows['type'],40)?></td>
<td><?=(!$rows['croned']) ? l("proccess") : l("backuped")?></td>
<td>
	<?php if($ap) : ?>
	<div class="icon-delete" title="<?=l("delete")?>"><a href="javascript:void(0)" onclick="openPop('delete_nav.php?edit=<?=$rows['id']?>&lang=<?=$_GET['lang']?>')"></a></div>
	<?php endif;?>
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
	<li><div class="icon-add"></div><a href="<?=$_GET['lang']?>/add/backup"><?=l("makeBackup")?></a></li>
</ul>
<div class="clearer"></div>
<?=$p[1]?>
<div class="clearer"></div><br />