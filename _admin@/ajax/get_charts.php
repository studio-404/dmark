<?php 
@require('../../config.php');
@require("../../_constants.php");
@require('../functions/functions.php');
?>
<div class="question">
	<div class="close" onclick="closeIt()"></div>
	<?=l("get_chart")?> 
</div>
<div class="answer">
	<form action="javascript:void(0)" id="y" name="y" method="post">
		<div class="boxes">
			<?php
			$start = explode("http://",MAIN_DIR);
			?>
			<textarea name="c" id="c"><?=htmlentities('<iframe width="100%" height="400" class="my_chart" src="http://www.'.$start[1].'_charts/'.$_GET['chart_file'].'" frameborder="0" allowfullscreen></iframe>')?></textarea>
			<div style="clear:both"></div>
			<input type="submit" value="<?=l("select")?>" onclick="$('#c').select();" />
		</div>
	</form>	<br />
</div>