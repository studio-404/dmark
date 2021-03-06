<!DOCTYPE HTML>
<html>

<head>  
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?=$_POST["title"]?></title>
	<script type="text/javascript" charset="utf-8">
	window.onload = function () {
		var chart = new CanvasJS.Chart("chartContainer",
		{
			title: {
				text: "Growth of Gangnam Style on YouTube"
			},
			axisX:{      
				valueFormatString: "DD-MMM" ,
				interval: 10,
				intervalType: "day",
				labelAngle: -50,
				labelFontColor: "rgb(0,75,141)",
				minimum: new Date(2012,06,10)
			},
			axisY: {
				title: "Views on YouTube",
				interlacedColor: "#F0FFFF",
				tickColor: "azure",
				titleFontColor: "rgb(0,75,141)",
				valueFormatString: "#M,,.",
				interval: 100000000
			},
			data: [
			{        
				indexLabelFontColor: "darkSlateGray",
				name: 'views',
				type: "area",
				color: "rgba(0,75,141,0.7)",
				markerSize:8,
				dataPoints: [
				{ x: new Date(2012, 06, 15), y: 0,  indexLabel: "Release", indexLabelOrientation: "vertical", indexLabelFontColor: "orangered", markerColor: "orangered"},       
				{ x: new Date(2012, 06, 18), y: 2000000 }, 
				{ x: new Date(2012, 06, 23), y: 6000000 }, 
				{ x: new Date(2012, 07, 1), y: 10000000, indexLabel:"10m"}, 
				{ x: new Date(2012, 07, 11), y: 21000000 }, 
				{ x: new Date(2012, 07, 23), y: 50000000 }, 
				{ x: new Date(2012, 07, 31), y: 75000000  }, 
				{ x: new Date(2012, 08, 04), y: 100000000, indexLabel:"100m" },
				{ x: new Date(2012, 08, 10), y: 125000000 },
				{ x: new Date(2012, 08, 13), y: 150000000},	
				{ x: new Date(2012, 08, 16), y: 175000000},	
				{ x: new Date(2012, 08, 18), y: 200000000, indexLabel:"200m"},	
				{ x: new Date(2012, 08, 21), y: 225000000},	
				{ x: new Date(2012, 08, 24), y: 250000000},	
				{ x: new Date(2012, 08, 26), y: 275000000},	
				{ x: new Date(2012, 08, 28), y: 302000000, indexLabel:"300m"}	
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
	<div id="chartContainer" style="height: 300px; width: 100%;">
	</div>
</body>
</html>
