<?php 
@require('../../config.php');
@require("../../_constants.php");
@require('../functions/functions.php');
?>
<div class="question">
	<div class="close" onclick="closeIt()"></div>
	<?=l("change_password")?>	
	</div>
	<div class="answer">
		<form action="" method="post">
			
			<div class="boxes">
				<label for="old_password"><i><?=l("old_password")?></i> <font color="#f00">*</font></label>
				<input type="text" name="old_password" class="old_password" id="old_password" value="" autocomplete="off" />
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="new_password"><i><?=l("new_password")?></i> <font color="#f00">*</font></label>
				<input type="text" name="new_password" class="new_password" id="new_password" value="" autocomplete="off" />
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="comfirm_password"><i><?=l("comfirm_password")?></i> <font color="#f00">*</font></label>
				<input type="text" name="comfirm_password" class="comfirm_password" id="comfirm_password" value="" autocomplete="off" />
			</div><div class="clearer"></div>
			
			<div class="boxes">				
				<input type="submit" class="submit" id="submit" value="<?=l("edit")?>" /><br />
			</div>
		</form>
</div>