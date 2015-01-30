<ul class="main_actions">
	<li><div class="icon-add"></div><a href="<?=$_GET['lang']?>/add/polls"><?=l("add")?></a></li>
</ul>
<div class="clearer"></div>
<table class="table">
<tr>
<th><?=cut_text(l("question"),40)?></th>
<th width="100"><?=cut_text(l("action"),40)?></th>				
</tr>			
<?php
$fecth_admins = mysql_query($p[0]);
$x=1;
while($rows = mysql_fetch_array($fecth_admins)){
$ap = check_if_permition("website_poll",false,$rows['idx'],' AND `type`="q" ');
?>
<tr>
<td><?=cut_text($rows['title'],80)?></td>
<td>
	<div class="icon-edit" title="<?=l("edit")?>"><a href="<?=$_GET['lang']?>/edit/polls/<?=$rows['idx']?>"></a></div>
	<?php if($ap) : ?>
	<div class="icon-delete" title="<?=l("delete")?>"><a href="javascript:void(0)" onclick="openPop('delete_nav.php?edit=<?=$rows['idx']?>&lang=<?=$_GET['lang']?>')"></a></div>
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
	<li><div class="icon-add"></div><a href="<?=$_GET['lang']?>/add/polls"><?=l("add")?></a></li>
</ul>
<div class="clearer"></div>
<?=$p[1]?>
<div class="clearer"></div><br />