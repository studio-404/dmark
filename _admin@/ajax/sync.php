<?php 
session_start();
@require('../../config.php');
@require("../../_constants.php");
@require('../functions/functions.php');
?>
<div class="question">
	<div class="close" onclick="closeIt()"></div>
	<?=l("sync")?> 
</div>
<div class="answer">
	<form action="" method="post">
		<div class="boxes">
			<label for="channel"><i><?=l("channel")?></i> <font color="#f00">*</font></label>
				<select name="channel" class="channel" id="channel">
					<option value=""><?=l("choose")?></option>    
					<?=get_channels_opt()?>
				</select>
			<div style="clear:both"></div>
		</div>
		<div class="boxes">
			<label for="from"><i><?=l("from")?></i> <font color="#f00">*</font></label>
			<input type="text" name="from" id="startpage" value="1" />
			<div style="clear:both"></div>
		</div>
		<div class="boxes">
			<label for="quentity"><i><?=l("quentity")?> (max value 50)</i> <font color="#f00">*</font></label>
			<input type="text" name="quentity" id="quentity" value="1" />
			<div style="clear:both"></div>
		</div>
		<div class="boxes">
		<input type="submit" value="<?=l("sync")?>" />
		</div>
	</form>	<br />
</div>