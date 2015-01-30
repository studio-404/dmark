<?php
@include("_plugins/gapi/index.php");
?>
<form action="" method="post">
<div class="boxes">
	<label for="start"><i>Start date:</i> <font color="#f00">*</font></label>
	<input type="text" name="start" class="datepicker" id="start" value="<?=(isset($_POST['start'])) ? date("d/m/Y",strtotime($start)) : date("d/m/Y");?>" />
</div><div class="clearer"></div>

<div class="boxes">
	<label for="end"><i>End date:</i> <font color="#f00">*</font></label>
	<input type="text" name="end" class="datepicker" id="end" value="<?=(isset($_POST['end'])) ? date("d/m/Y",strtotime($end)) : date("d/m/Y");?>" />
</div><div class="clearer"></div>

<div class="boxes">				
	<input type="submit" class="submit" id="submit" value="Search" />
</div><div class="clearer"></div>
</form>
<iframe src="../../_plugins/canvas/analitics.php?p1=<?=(int)$pageViews?>&amp;p2=<?=(int)$visits?>&amp;p3=<?=(int)$users?>&amp;p4=<?=(int)$session?>&amp;p5=<?=(int)$unique_pageviews?>" width="100%" height="320" style="border:0"></iframe>
<iframe src="../../_plugins/canvas/browsers.php?cl=Chrome,Mozilla,Opera,Explorer&amp;gr=<?=$chrome?>,<?=$Mozilla?>,<?=$Opera?>,<?=$Explorer?>" width="100%" height="350"></iframe>
<br />
<table class="table">
	<tr>
		<th>Url</th>
		<th>Views</th>
	</tr>
	<?php
	$y = 1;
	$cu = count($urlx["pagePath"]);
	for($x=$cu; $x>=0; $x-- )
	{
		if($y>15){ break; }
		if($urlx["pagePath"][$x]=="" OR $urlx["pageViews"][$x]==""){ continue; }
		echo '<tr>';
		echo '<td><a href="'.$urlx["pagePath"][$x].'" target="_blank">'.$urlx["pagePath"][$x].'</a></td>';
		echo '<td>'.$urlx["pageViews"][$x].'</td>'; 
		echo '</tr>';
		$y++;
	}
	?>
	<tr>
		<td colspan="2">
			<b><a href="https://www.google.com/analytics/web/?hl=en#home/a52272173w84712741p87806577/" target="_blank">Go to google analitics</a></b>
		</td>
	</tr>
</table>