<?php 
session_start();
@require('../../config.php');
@require("../../_constants.php");
@require('../functions/functions.php');
?>
<div class="question">
	<div class="close" onclick="closeIt()"></div>
	<?=l("showfiles")?>	
</div>
<div class="answer">
	<form action="javascript:;" method="post">
		<ul>
			<?php
			$select = mysql_query("SELECT id,outname,filename,filetype,position FROM website_files WHERE page_idx='".(int)$_GET['page_idx']."' AND page_type='".mysql_real_escape_string($_GET['page_type'])."' AND langs='".mysql_real_escape_string($_GET['weblang'])."' AND status!=1 ORDER BY position ASC ");
			while($rows = mysql_fetch_array($select)){
			?>
			<li id="f_<?=$rows['id']?>"><input type="text" value="<?=$rows['position']?>" data-id="<?=$rows['id']?>" class="file_attachs_" /> / <a href="<?php echo WEBSITE; ?>public/files/<?=strtolower($rows['filetype']).'/'.$rows['filename']?>" target="_blank"><?=$rows['outname']?></a> / <a href="javascript:void(0)" onclick="remove_file('<?=$rows['id']?>')">x</a></li>
			<?php
			}
			?>
		</ul>
		<div class="boxes">	<div class="clearer"></div>			
			<input type="submit" class="submit" id="submit" value="<?=l("edit")?>" />
		</div><div class="clearer"></div><br />
	</form>
</div>