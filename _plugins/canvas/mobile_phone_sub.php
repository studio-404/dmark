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
			zoomEnabled: false,
			title:{
				text: "<?=$_POST["title"]?>"
			},
                        theme: "theme2",
                        toolTip:{
                                shared: true
                        },
			legend:{
				verticalAlign: "bottom",
				horizontalAlign: "center",
				fontSize: 15,
				fontFamily: "Lucida Sans Unicode"

			},
			data: 
			[
				<?php
				$count = count($_POST["year"]);
				for($x=1; $x<=$count;$x++){
					$key = key($_POST["year"]);
					$count_elems = count($_POST["year"][$key]);
				?>
						{   
							type: "line",
							lineThickness:3, 
							axisYType:"secondary", 
							showInLegend: true, 	      
							name: "<?=$key?>", 
							dataPoints: 
							[
								<?php
								$saveYear=array();
								for($u=($count_elems-1); $u>=0; $u--)
								{
									if(in_array($_POST["year"][$key][$u],$saveYear)){ continue; }
								?>
									{ x: new Date(<?=$_POST["year"][$key][$u]?>, 0), y: <?=$_POST["val"][$key][$u]?> }<?=($u>0) ? "," : ""?>
									<?php
									$saveYear[] = $_POST["year"][$key][$u];
								}
								?>
							]
						}<?=($count!=$x) ? "," : ""?>
				<?php
					next($_POST["year"]);
				}
				?>
			],
          legend: {
            cursor:"pointer",
            itemclick : function(e) {
              if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
              e.dataSeries.visible = false;
              }
              else {
                e.dataSeries.visible = true;
              }
              chart.render();
            }
          }
        });

chart.render();
}
</script>
  <script type="text/javascript" src="<?=MAIN_DIR?>_plugins/canvas/canvasjs.min.js"></script>
<body>
	<div id="chartContainer" style="height: 300px; width: 100%;">
	</div>
</body>
</html>
