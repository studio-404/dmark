<?php 
@require('../../config.php');
@require("../../_constants.php");
@require('../functions/functions.php');
?>
<div class="question">
	<div class="close" onclick="closeIt()"></div>
	<?=l("videoplayer")?> 
</div>
<div class="answer">
	<iframe width="390" height="219" src="//www.youtube.com/embed/<?=$_GET['video']?>" frameborder="0" allowfullscreen></iframe>
	<br />
</div>