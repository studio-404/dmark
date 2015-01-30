<!DOCTYPE HTML>
<html>

<head>  
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script type="text/javascript" charset="utf-8">
	window.onload = function () {
		var chart = new CanvasJS.Chart("chartContainer", {

			title:{
				text:"Browsers"		
				},
			axisX:{
				interval: 1,
				gridThickness: 0,
				labelFontSize: 10,
				labelFontStyle: "normal",
				labelFontWeight: "normal",
				labelFontFamily: "Lucida Sans Unicode"

			},
			axisY2:{
				interlacedColor: "rgba(1,77,101,.2)",
				gridColor: "rgba(1,77,101,.1)"

			},

			data: [
			{     
				type: "bar",
                name: "companies",
				axisYType: "secondary",
				color: "#014D65",				
				dataPoints: [
				<?php
				$cl = explode(",",$_GET['cl']);
				$gr = explode(",",$_GET['gr']);
				$lastx = count($cl);
				for($i=0;$i<=count($cl)-1;$i++)
				{
					if($i==($lastx-1)){ $mz=""; }
					else{ $mz=","; }
				?>
				{ y:<?=$gr[$i]?>, label:"<?=$cl[$i]?>" }<?=$mz?>
				<?php
				}
				?>			
				]
			}
			
			]
		});

chart.render();
}
</script>
<script type="text/javascript" src="canvasjs.min.js"></script>
</head>
<body>
	<div id="chartContainer" style="height: 320px; width: 100%;">
	</div>
</body>
</html>
