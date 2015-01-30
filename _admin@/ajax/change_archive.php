<?php 
@require('../../config.php');
@require("../../_constants.php");
@require('../functions/functions.php');
?>
<div class="question">
	<div class="close" onclick="closeIt()"></div>
	<?=l("whouldyouarchive").htmlentities(" ?")?>
	</div>
	<div class="answer">
		<form action="" method="post">			
			<div class="boxes">
				<input type="hidden" name="archive_idx" value="<?=$_GET['edit']?>">
				<input type="hidden" name="archive_command" value="<?=$_GET['command']?>">
				<input type="submit" class="submit" id="submit" value="<?=l("yes")?>" />
				<div class="closex" onclick="location.reload()"><?=l("close")?></div>
			</div>
		</form><br />
</div>