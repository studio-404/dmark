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
      legend:{
        verticalAlign: "center",
        horizontalAlign: "left",
        fontSize: 16,
        fontFamily: "Helvetica"        
      },
      theme: "theme2",
      data: [
      {        
       type: "pie",       
       indexLabelFontFamily: "Garamond",       
       indexLabelFontSize: 12,
       startAngle:-20, 
       dataPoints: [
		<?php
		if(isset($_POST["name"]) && isset($_POST["val"]) ){			
			$count = count($_POST["name"]);
			for($x=0;$x<=$count;$x++)
			{
				if(!empty($_POST["name"][$x]) && !empty($_POST["val"][$x]))
				{
					if($count==($x+1)){ $m = ''; }else{ $m=','; }
					?>
					{ y: <?=(int)$_POST["val"][$x]?>, label: "<?=$_POST["name"][$x]?>" }<?=$m?>
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
  <body>
    <div id="chartContainer" style="height: 300px; width: 100%;">
    </div>
  </body>

</html>
