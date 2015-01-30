<?php
@include("../../_constants.php");
?>
<!DOCTYPE HTML>
<html>

<head>  
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?=$_POST["title"]?></title>
  <script type="text/javascript" charset="utf-8">
  window.onload = function () {
    var chart = new CanvasJS.Chart("chartContainer",
    {
      title:{
       text: "<?=$_POST["title"]?>"   
     },
      theme: "theme2",
     axisX: {
       valueFormatString: "YYYY",
	   interval:1, 
	   intervalType: "year" 
      },
      axisY:{
        valueFormatString: "#0"
      },
     data: [
     {        
      type: "line",
      showInLegend: true,
       legendText: "<?=$_POST["title"]?>",
      dataPoints: [        	  
		<?php
		if(isset($_POST["name"]) && isset($_POST["val"]) ){			
			$count = count($_POST["name"]);
			for($x=0;$x<=$count;$x++)
			{
				if(!empty($_POST["name"][$x]) && !empty($_POST["val"][$x]))
				{
					if($count==($x+1)){ $m = ''; }else{ $m=','; }
						$y = date("Y",$_POST["name"][$x]); 
						$d = date("d",$_POST["name"][$x]); 
						$mo = date("m",$_POST["name"][$x]); 
					?>
					{ x: new Date(<?=$y?>, <?=$mo?>, <?=$d?>), y: <?=(int)$_POST["val"][$x]?> }<?=$m?>
					<?php
				}
			}
		}
		?>	  
      ]
    }
    ]
  });

chart.render();
}
</script>
<script type="text/javascript" src="<?=MAIN_DIR?>_plugins/canvas/canvasjs.min.js"></script>
</head>
<body>
  <div id="chartContainer" style="height: 300px; width: 100%;">
  </div>
</body>
</html>
