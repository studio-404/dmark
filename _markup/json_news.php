<?php 
error_reporting(0);

$limit = (isset($_GET["limit"])) ? (int)$_GET["limit"] : 10;

$datax = array();
for($x=0;$x<=$limit;$x++){
	$datax["t_".$x]["urlx"] = "project_view.html"; 
	$datax["t_".$x]["imgx"] = "assets/img/news.png"; 
	$datax["t_".$x]["titlex"] = "Title ".$x;
	$datax["t_".$x]["datex"] = "30.01.2015";
	$datax["t_".$x]["textx"] = "uas sint ut sit. Ex has omnis ancillae, eros comprehensam nec eu, eu est singulis mandamus dissentiunt. Noster salutatus ne ius, eum posse lorem propriae no, rebum euripidis disputationi qui eu. Mea hinc purto dolor ex. His perpetua definiebas id, per ea qualisque dissentiunt.
					<br /><br />
					Vis fugit graecis ne, ut usu posse choro, salutatus forensibus constituam vis at. Cu liber veniam accusata pri, cu viris putant sed. Per no verear volumus recteque. Has solet quaestio efficiendi id, dolor fastidii propriae his ei, qui tota saperet scaevola ne. Mea te dicit placerat verterem, erroribus sententiae ne eum.";
}

header('Content-Type: application/json');
echo json_encode($datax);
?>