<?php 
@require('../../config.php');
@require("../../_constants.php");
@require('../functions/functions.php');
$select = mysql_query("SELECT * FROM `website_actions` WHERE `id`='".(int)$_GET["edit"]."' ");
if(!mysql_num_rows($select)){ exit(); }
$rows = mysql_fetch_array($select);
?>
<div class="question">
	<div class="close" onclick="closeIt()"></div>
	<?=l("view_action")?>	
</div>
<div class="answer">
		<form action="" method="post" enctype="multipart/form-data">
			<div class="boxes">
				<label><b><?=l("ip")?></b>: <span><?=$rows["ip"]?></span></label>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label><b><?=l("admin")?></b>: <span><?=getadmin($rows["admin_id"],"name")?> (# <?=$rows["admin_id"]?>)</span></label>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label><b><?=l("date")?></b>: <span><?=date("d/m/Y H:i",$rows["date"])?></span></label>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label><b><?=l("type")?></b>: <span><?=$rows["type"]?></span></label>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label><b><?=l("action")?></b>: <span><?=$rows["action"]?></span></label>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label><b><?=l("id")?></b>: <span><?=$rows["actioned_idx"]?></span></label>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label><b><?=l("url")?></b>: <span><a href="<?=$rows["request_url"]?>"><?=$rows["request_url"]?></a></span></label>
			</div><div class="clearer"></div>
			
		</form>
</div>