<!DOCTYPE HTML>
<html>
<head>  
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <script type="text/javascript" charset="utf-8">
  window.onload = function () {
    var chart = new CanvasJS.Chart("chartContainer",
    {
      title:{
        text: "Analitics"
      },
      legend:{
        verticalAlign: "center",
        horizontalAlign: "left",
        fontSize: 10,
        fontFamily: "Helvetica"        
      },
      theme: "theme2",
      data: [
      {        
       type: "pie",       
       indexLabelFontFamily: "Garamond",       
       indexLabelFontSize: 10,
       startAngle:-20,      
       showInLegend: true,
       toolTipContent:"{label}",
       dataPoints: [
	   <?php
	   /*function persent($amount)
	   {
			$total = $_GET['p1']+$_GET['p2']+$_GET['p3']+$_GET['p4']+$_GET['p5'];
			$persent = (100 / $total) * $amount;
			return $persent;
	   }*/
	   ?>
       {  y: <?=$_GET['p1']?>, legendText:"Page views", label: "Page views: <?=$_GET['p1']?>" },
	   {  y: <?=$_GET['p5']?>, legendText:"Unique views", label: "Unique views: <?=$_GET['p5']?>" },
       {  y: <?=$_GET['p2']?>, legendText:"Visits", label: "Visits: <?=$_GET['p2']?>" }, 
       {  y: <?=$_GET['p3']?>, legendText:"Users", label: "Users: <?=$_GET['p3']?>" },
       {  y: <?=$_GET['p4']?>, legendText:"Session", label: "Session: <?=$_GET['p4']?>" },
       ]
     }
     ]
   });
    chart.render();
  }
  </script>
  <script type="text/javascript" src="canvasjs.min.js"></script>
  <body>
    <div id="chartContainer" style="height:300px; width: 100%;">
    </div>
  </body>

</html>
