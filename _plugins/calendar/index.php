<?php
error_reporting(0);
$date = time();
$day = date('d'); 
$month = date('m');
$year = date('Y');
$Cday = date('d');
$Cmonth = date('m');
$Cyear = date('Y');

if(isset($_GET[month])){ $month=$_GET[month]; }
if(isset($_GET[year])){ $year=$_GET[year]; }

$first_day = mktime(0,0,0,$month,1,$year);

$title = date('F',$first_day);

if($_GET['lang']=="ka")
{
switch($title)
{
	case "January":
	$title = "იანვარი";
	break;
	case "February":
	$title = "თებერვალი";
	break;
	case "March":
	$title = "მარტი";
	break;
	case "April":
	$title = "აპრილი";
	break;
	case "May":
	$title = "მაისი";
	break;
	case "June":
	$title = "ივნისი";
	break;
	case "July":
	$title = "ივლისი";
	break;
	case "August":
	$title = "აგვისტო";
	break;
	case "September":
	$title = "სექტემბერი";
	break;
	case "October":
	$title = "ოქტომბერი";
	break;
	case "November":
	$title = "ნოემბერი";
	break;
	case "December":
	$title = "დეკემბერი";
	break;
}
}


if($_GET['lang']=="ru")
{
switch($title)
{
	case "January":
	$title = "январь";
	break;
	case "February":
	$title = "февраль";
	break;
	case "March":
	$title = "март";
	break;
	case "April":
	$title = "апрель";
	break;
	case "May":
	$title = "май";
	break;
	case "June":
	$title = "июнь";
	break;
	case "July":
	$title = "июль";
	break;
	case "August":
	$title = "август";
	break;
	case "September":
	$title = "сентябрь";
	break;
	case "October":
	$title = "октябрь";
	break;
	case "November":
	$title = "ноябрь";
	break;
	case "December":
	$title = "декабрь";
	break;
}
}

$day_of_week = date('D',$first_day);

switch($day_of_week)
{
	case "Sun": $blank=0; break;
	case "Mon": $blank=1; break;
	case "Tue": $blank=2; break;
	case "Wed": $blank=3; break;
	case "Thu": $blank=4; break;
	case "Fri": $blank=5; break;
	case "Sat": $blank=6; break;
	default: exit;
}

$days_in_month = cal_days_in_month(0,$month,$year);
?>
<style type="text/css" scoped>
table{ margin:0px 0px 10px 0px; padding:3px; border:0;  width:280px; height:180px; font-size:13px; font-family:'bpg_glaho_arial';  float:right; color:#0030b8; }
table tr td{ border:none; text-align:center; padding-top:5px; padding-bottom:5px }
#title-calendar{ position:relative; text-align:center;}
#title-calendar a{ text-decoration:underline !important; width:18px; height:18px; float:left; margin-left:5px;}
#title-calendar a:last-child{ float:right; }
#title-calendar a:hover{ text-decoration:none;}
#title-calendar .nextx{ float:right; margin:0 5px 0 0;}
.day_numbers:hover{ background:#0030b8; color:#fff }
table tr td a{ color:#0030b8; text-decoration:underline !important;}
.weekday{ width:25px; }
</style>
<table border="1">
<tr>
	<td colspan="7" id="title-calendar">
	<?php echo $title." ".$year; ?>
	<?php
	if($month!=1){ $yy_month=$month-1; $yy_year=$year; }else{ $yy_month=12; $yy_year=$year-1; }
	?>
		<a href="javascript:void(0)" onclick="hashx('?month=<?=$yy_month?>&amp;year=<?=$yy_year?>&amp;lang=<?=$_GET[lang]?>')"><?=htmlentities("<<")?></a>
	<?php
	if($month!=12){ $xx_month=$month+1; $xx_year=$year; }else{ $xx_month=1; $xx_year=$year+1; }
	?>
		<a href="javascript:void(0)" onclick="hashx('?month=<?=$xx_month?>&amp;year=<?=$xx_year?>&amp;lang=<?=$_GET[lang]?>')" class="nextx"><?=htmlentities(">>")?></a>
	</td>
</tr>
<?php
if($_GET["lang"]=="ka")
{
?>
<tr>
	<td class="weekday">კვ</td>
	<td class="weekday">ორ</td>
	<td class="weekday">სა</td>
	<td class="weekday">ოთ</td>
	<td class="weekday">ხუ</td>
	<td class="weekday">პა</td>
	<td class="weekday">შა</td>
</tr>
<?php
}
else if($_GET['lang']=="ru")
{
?>
<tr>
	<td class="weekday">вос</td>
	<td class="weekday">пон</td>
	<td class="weekday">вто</td>
	<td class="weekday">сре</td>
	<td class="weekday">чет</td>
	<td class="weekday">пят</td>
	<td class="weekday">суб</td>
</tr>
<?php
}
else{
?>
<tr>
	<td class="weekday">Su</td>
	<td class="weekday">Mo</td>
	<td class="weekday">Tu</td>
	<td class="weekday">We</td>
	<td class="weekday">Th</td>
	<td class="weekday">Fr</td>
	<td class="weekday">Sa</td>
</tr>
<?php
}
?>


<?php
$day_count = 1;

echo "<tr>";

while($blank > 0)
{
	echo "<td></td>";
	$blank = $blank-1;
	$day_count++;
}

$day_num = 1;

while($day_num <= $days_in_month)
{
	$d = $month."/".$day_num."/".$year;
	$to_time = strtotime($d);
	include("../../rd_config.php");
	$select_all_news=mysql_query("SELECT `id`,`news_idx` FROM `website_news_items` WHERE `status`!=1 AND `date`='".(int)$to_time."' AND `langs`='".mysql_real_escape_string($_GET[lang])."' AND FROM_UNIXTIME(`website_news_items`.`date`, '%Y/%m/%d') >= '2014/07/22'   ");
	if($select_all_news){
	$nu = mysql_num_rows($select_all_news);
	$nu_rows = mysql_fetch_array($select_all_news);
	
	$nu_select = mysql_query("
	SELECT 
	`website_menu`.`url` AS w_url
	FROM 
	`website_menu`, `website_news_attachment`
	WHERE 
	`website_news_attachment`.`idx`='".(int)$nu_rows['news_idx']."' AND 
	`website_news_attachment`.`langs`='ka' AND 
	`website_news_attachment`.`connect_id`=`website_menu`.`idx` AND 
	`website_menu`.`langs`='ka' AND 
	`website_menu`.`status`!=1 
	");
	$nu_select_rows = mysql_fetch_array($nu_select);
	$nu_explode = explode("ka/",$nu_select_rows['w_url']);
	}
	else
	{
	$nu=0;
	}
	if($day_num==$day&&$month==$Cmonth&&$year==$Cyear)
	{
		if($nu>0 && $nu_explode[1]){ echo "<td style='color:#fff; background:#0030b8'><a href='".$_GET[lang]."/".$nu_explode[1]."/date/".$day_num."/".$month."/".$year."' style='color:white'>".$day_num."</a></td>"; }
		else{	echo "<td style='color:#fff; background:#0030b8'>".$day_num."</td>"; }
	}
	else
	{
		if($nu>0 && $nu_explode[1]){ echo "<td style=''><a href='".$_GET[lang]."/".$nu_explode[1]."/date/".$day_num."/".$month."/".$year."'>".$day_num."</a></td>"; }
		else{	echo "<td class='day_numbers'>".$day_num."</td>"; }
	}
	$day_num++;
	$day_count++;
	
	if($day_count>7)
	{
		echo "</tr><tr>";
		$day_count=1;
	}
}

while($day_count>1 && $day_count<=7)
{
	echo "<td></td>";
	$day_count++;
}
?>
</tr>
</table>