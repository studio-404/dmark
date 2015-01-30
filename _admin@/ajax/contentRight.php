<?php 
session_start();
@require('../../config.php');
@require("../../_constants.php");
@require('../functions/functions.php');
if(isset($_GET["id"])){ $id=$_GET["id"]; }
if(isset($_GET["idx"])){ $idx=$_GET["idx"]; }
if(empty($_GET["id"]) && empty($_GET["idx"])){ exit(); }
?>
<div class="question">
	<div class="close" onclick="closeIt()"></div>
	<?=l("contentupdateright")?>
	</div>
	<div class="answer">
		<form action="" method="post">			
			<div class="boxes">
				<input type="hidden" name="s" value="1" />
				<?php echo rights($_GET["t"],$id,$idx); ?><br />
			</div>
		</form><br />
</div>