<form action="/_admin@/ka/table/vars" method="post" id="searchHello">
<input type="hidden" name="where" value="variable" />
<input type="hidden" name="search_val" value="hello" />
</form>
<table class="table">
<tbody>
<tr>
<th><?=l("data")?></th>
</tr>
<tr>
<td> 
	<b><i><?=l("name")?>:</i></b>&nbsp;&nbsp;&nbsp;<?=($_GET["lang"]=="ka") ? WEBSITE_NAME_KA : WEBSITE_NAME_EN?><br />
	<b><i><?=l("welcomePagex")?>:</i></b>&nbsp;&nbsp;&nbsp;<a href="javascript:$('#searchHello').submit()"><?=l("edit")?></a><br />
	<b><i><?=l("projects")?>:</i></b>&nbsp;&nbsp;&nbsp;<a href="/_admin@/<?=$_GET["lang"]?>/table/categoryItem/1"><?=l("edit")?></a><br />
	<b><i><?=l("teamCatalog")?>:</i></b>&nbsp;&nbsp;&nbsp;<a href="/_admin@/<?=$_GET["lang"]?>/table/categoryItem/3"><?=l("edit")?></a><br />
	<b><i><?=l("teamTextEdit")?>:</i></b>&nbsp;&nbsp;&nbsp;<a href="/_admin@/<?=$_GET["lang"]?>/edit/navigation/5"><?=l("edit")?></a><br />
	<b><i><?=l("event")?>:</i></b>&nbsp;&nbsp;&nbsp;<a href="/_admin@/<?=$_GET["lang"]?>/table/newsItem/1"><?=l("edit")?></a><br />
	<b><i><?=l("projectFilter")?>:</i></b>&nbsp;&nbsp;&nbsp;<a href="/_admin@/<?=$_GET["lang"]?>/table/categoryItem/4"><?=l("edit")?></a><br />
	<b><i><?=l("filemanager")?>:</i></b>&nbsp;&nbsp;&nbsp;<a href="/_admin@/<?=$_GET["lang"]?>/table/filemanager"><?=l("edit")?></a><br />
	<b><i><?=l("contactSlider")?>:</i></b>&nbsp;&nbsp;&nbsp;<a href="/_admin@/<?=$_GET["lang"]?>/slide"><?=l("edit")?></a><br />
</td>
</tr>
</tbody></table>
<!--
<iframe src="../../_plugins/canvas/prisoners.php?p1=2&amp;p2=3&amp;p3=10" width="100%" height="320" style="border:0"></iframe>
<br />
<iframe src="../../_plugins/canvas/countInClass.php?cl=????1,????2&amp;gr=15,30" width="100%" height="320"></iframe>
<br />
<iframe src="../../_plugins/canvas/monthMarks.php?m=5,10&amp;c=5,3" width="100%" height="320"></iframe>
</div>-->