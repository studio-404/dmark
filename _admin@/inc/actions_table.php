<?php
if($_POST["date"]){
$date = explode("/",$_POST['date']);
$d = $date[2]."-".$date[1]."-".$date[0];		
}
?>
<form action="" method="post">
<div class="boxes">
	<label for="date"><i><?=l("date")?>:</i> <font color="#f00">*</font></label>
	<input type="text" name="date" class="datepicker" value="<?=(isset($_POST['date'])) ? date("d/m/Y",strtotime($d)) : date("d/m/Y");?>" />
</div><div class="clearer"></div>
<div class="boxes">				
	<input type="submit" class="submit" id="submit" value="<?=l("search")?>" />
</div><div class="clearer"></div>
</form>
<div class="clearer"></div>
<table class="table">
<tr>
<th><?=cut_text(l("date"),35)?></th>
<th><?=cut_text(l("ip"),35)?></th>
<th><?=cut_text(l("admin"),35)?></th>
<th><?=cut_text(l("type"),35)?></th>
<th width="100"><?=cut_text(l("action"),40)?></th>		
</tr>			
<?php
$fecth_admins = mysql_query($p[0]);
$x=1;
while($rows = mysql_fetch_array($fecth_admins)){
?>
<tr>
<td><?=date("d/m/Y H:i",$rows['date'])?></td>
<td><?=$rows['ip']?></td>
<td><?=getadmin($rows['admin_id'],"name")?></td>
<td><?=$rows['type']?></td>
<td>
	<div class="icon-view" title="<?=l("view")?>"><a href="javascript:void(0)" onclick="openPop('view_action.php?edit=<?=$rows['id']?>&lang=<?=$_GET['lang']?>')"></a></div>
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
<div class="clearer"></div><br />