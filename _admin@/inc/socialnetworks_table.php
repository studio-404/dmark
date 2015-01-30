<div class="clearer"></div>
<table class="table">
<tr>
<th><?=l("socials")?></th>
<th width="100"><?=l("action")?></th>
</tr>			
<?php
$fecth_admins = mysql_query($p[0]);
$x=1;
while($rows = mysql_fetch_array($fecth_admins)){
$ap = check_if_permition("website_social",$rows['id'],false);
?>
<tr>
<td><?=$rows['name']?></td>
<td>
	<?php
	if($ap) :	
	?>
	<div class="icon-edit" title="<?=l("edit")?>"><a href="<?=$_GET['lang']?>/edit/socialnetworks/<?=$rows['id']?>"></a></div>
	<?php
	endif;
	?>
</td>
</tr>
<?php 
	$x++;
}
?>
</table>
<div class="clearer"></div>
<?=$p[1]?>