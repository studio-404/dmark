<?php
include("../_constants.php");
include("../rd_config.php");
include("../".ADMIN_FOLDER."/functions/functions.php");

if(isset($_GET["type"],$_GET["url"],$_GET["lang"]))
{
	if($_GET["type"]=="text")
	{
		$selectIdx = mysql_query("SELECT `idx` FROM `website_menu` WHERE `url`='".mysql_real_escape_string($_GET["lanh"]."/".$_GET["url"])."' AND `langs`='".mysql_real_escape_string($_GET["lang"])."' AND `status`!=1 ");
		if(mysql_num_rows($selectIdx)){
		$rows = mysql_fetch_array($selectIdx);
		$idx = $rows['idx'];
		$outPrintUrl = 'print.php?title='.l("websitemetatitle",$_GET["lang"]).'&langs='.$_GET["lang"].'&type='.$_GET["type"].'&idx='.$idx;
		}
	}
	echo $outPrintUrl;
}
?>