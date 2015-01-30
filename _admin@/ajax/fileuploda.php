<?php 
@require('../../config.php');
@require("../../_constants.php");
@require('../functions/functions.php');
?>
<div class="question">
	<div class="close" onclick="closeIt()"></div>
	<?=l("addphoto")?>	
</div>
<div class="answer">
		<form action="" method="post" enctype="multipart/form-data">
			<input type="hidden" name="weblang" value="<?=$_GET['weblang']?>" />
			<div class="boxes">
				<label for="file" onclick="appx()"><i><?=l("files")?></i> <div class="icon-add"></div></label>
				<input type="file" name="photo_upload[]" class="file" />
			</div><div class="clearer"></div>
			
			<div class="boxes" id="files">
				<input type="file" name="photo_upload[]" class="file" />
			</div><div class="clearer"></div>
			
			<div class="appaends">
			</div><div class="clearer"></div>
			
			<div class="boxes">				
				<input type="submit" class="submit" id="submit" value="<?=l("add")?>" /><br />
			</div><div class="clearer"></div>
		</form>
</div>