<?php 
@require('../../config.php');
@require("../../_constants.php");
@require('../functions/functions.php');
?>
<div class="question">
	<div class="close" onclick="closeIt()"></div>
	<?=l("youtubeCode")?> 
</div>
<div class="answer">
	<form action="javascript:void(0)" id="y" name="y" method="post">
		<div class="boxes">
		<?php
		$embed = '<p id="video_'.$_GET["video_id"].'" class="youtube_video">'.$_GET['video'].'</p>';
		?>
		<textarea name="c" id="c" style="width:380px !important"><?=htmlentities($embed)?></textarea>
		<div style="clear:both"></div>
		<input type="submit" value="<?=l("select")?>" onclick="$('#c').select();" />
		</div>
	</form>	<br />
</div>