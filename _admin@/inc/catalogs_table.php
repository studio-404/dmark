<div class="clearer"></div>
<table class="table">
<tr>
<th><?=cut_text(l("date"),40)?></th>
<th><?=cut_text(l("catalog"),40)?></th>
<th width="100"><?=cut_text(l("action"),40)?></th>				
</tr>			
<?php
$fecth_admins = mysql_query($p[0]);
$x=1;
while($rows = mysql_fetch_array($fecth_admins)){
?>
<tr>
<td><?=date("d/m/Y H:s",(int)$rows['n_date'])?></td>
<td><?=cut_text($rows['n_category'],40)?></td>
<td>
	<div class="icon-add" title="<?=l("addphoto")?>"><a href="<?=$_GET['lang']?>/table/categoryItem/<?=$rows['wna_idx']?>"></a></div>
	<div class="icon-edit" title="<?=l("edit")?>"><a href="<?=$_GET['lang']?>/edit/<?=$_GET['show']?>/<?=$rows['wna_idx']?>"></a></div>
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
