<?php
@require("../../config.php");
@require("../../_constants.php");
@require("../functions/functions.php");
// update cron time
$update = mysql_query("UPDATE `website_croned` SET `date`='".time()."' WHERE `id`=1 AND `type`='newsletter' ");
/*
** select news letter
*/
$current_time = time();
$select = mysql_query("SELECT `email`, `langs` FROM `website_newsletter` WHERE `status`!=1 ");
if(mysql_num_rows($select)){
	while($rows = mysql_fetch_array($select)){
		// language
		$languages = mysql_query("SELECT `shortname` FROM `website_languages` WHERE `id`='".(int)$rows["langs"]."' ");
		if(!mysql_num_rows($languages)){ die("Language not exists");  }
		$rows_lang = mysql_fetch_array($languages);
		$langs = $rows_lang["shortname"];
		// news 
		$select_news = mysql_query("SELECT `idx`, `date`, `title`, `long_text` FROM `website_news_items` WHERE `langs`='".mysql_real_escape_string($langs)."' AND `emailed`!=1 AND `status`!=1 ORDER BY `date` ASC ");
		if(mysql_num_rows($select_news)){
			while($rows_news = mysql_fetch_array($select_news))
			{
				$title = $rows_news["title"];
				$long_text = $rows_news["long_text"];				
				$href = MAIN_DIR.$langs."/news/".urlencode($rows_news["idx"]."-".$title);
				
				$emailed = newsLetter(MAIN_EMAIL,$rows["email"],$title,$href,$rows_news["date"],$long_text);
				if($emailed){
					$update_news_item = mysql_query("UPDATE `website_news_items` SET `emailed`=1 ");
					echo "Sent ! <br />";
					
				}
			}
		}
	}
}

?>