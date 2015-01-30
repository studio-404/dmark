<?php
@require("../../config.php");
@require("../../_constants.php");
@require("../functions/functions.php");
$ct = time();
// update cron time
$update = mysql_query("UPDATE `website_croned` SET `date`='".$ct."' WHERE `id`=7 AND `type`='unblock_users' ");
/*
** select news letter
*/
$update = mysql_query("UPDATE `panel_admins` SET `blocked`=0 WHERE `blocked`=1 ");

?>