<?php
if(isset($_POST["post"]))
{
	$select = mysql_query("SELECT `name`,`status` FROM `website_sh`");
	while($rows = mysql_fetch_array($select))
	{
		if(isset($_POST["post"][$rows["name"]])){
			$update = mysql_query("UPDATE `website_sh` SET `status`=1 WHERE `name`='".mysql_real_escape_string($rows["name"])."' ");
		}else{
			$update = mysql_query("UPDATE `website_sh` SET `status`=0 WHERE `name`='".mysql_real_escape_string($rows["name"])."' ");
		}
	}
}
?>
<form action="" method="post" enctype="multipart/form-data">
	<div class="boxes">
		<label for="banners"><i><?=l("banners")?></i>:&nbsp;&nbsp;&nbsp;<input type="checkbox" name="post[banners]" id="banners" value="1" <?=check_sh("banners")?> /></label>
		<label for="poll"><i><?=l("poll")?></i>:&nbsp;&nbsp;&nbsp;<input type="checkbox" name="post[poll]" id="poll" value="1" <?=check_sh("poll")?> /></label>
		<label for="slide"><i><?=l("slide")?></i>:&nbsp;&nbsp;&nbsp;<input type="checkbox" name="post[slide]" id="slide" value="1" <?=check_sh("slide")?> /></label>
		<label for="calendar"><i><?=l("calendar")?></i>:&nbsp;&nbsp;&nbsp;<input type="checkbox" name="post[calendar]" id="calendar" value="1" <?=check_sh("calendar")?> /></label>
		<label for="newsletter"><i><?=l("newsletter")?></i>:&nbsp;&nbsp;&nbsp;<input type="checkbox" name="post[newsletter]" id="newsletter" value="1" <?=check_sh("newsletter")?> /></label>
	</div><div class="clearer"></div>
	
	<div class="boxes">				
		<input type="submit" class="submit" id="submit" value="<?=l("edit")?>" />
	</div><div class="clearer"></div><br />
</form>	
<div class="clearer"></div><br />