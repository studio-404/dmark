<?php 
@require('../../config.php');
@require("../../_constants.php");
@require('../functions/functions.php');
?>
<div class="question">
<div class="close" onclick="closeIt()"></div>
<?=l("moveToSlide")?>
</div>
<div class="answer">
	<form action="" method="post">			
		<div class="boxes">
			<input type="hidden" name="moveToSlide" value="<?=$_GET['idx']?>">
			<input type="submit" class="submit" id="submit" value="<?=l("add")?>" />
			<div class="closex" onclick="location.reload()"><?=l("close")?></div>
		</div>
	</form><br />
</div>