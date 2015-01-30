<?php
@require("../../config.php");
@require("../../_constants.php");
@require("../functions/functions.php");
$date = time();
// update cron time
$update = mysql_query("UPDATE `website_croned` SET `date`='".(int)$date."' WHERE `id`=5 AND `type`='backup' ");

if( !ini_get(‘safe_mode’) ){
set_time_limit(25);
}else{
set_time_limit(0);
}

//select backup for cron
$select_b = mysql_query("SELECT `id`,`type` FROM `website_backup` WHERE `croned`!=1 AND `status`!=1 ");
if(mysql_num_rows($select_b))
{
	while($rows_b = mysql_fetch_array($select_b))
	{
		// Source directory (can be an FTP address)
		if(!empty($rows_b["type"]) && $rows_b["type"]=="full"){	
			$src1 = ROOT."public/img";
			$src2 = ROOT."public/files";
			$src3 = ROOT."image";
			$dst1 = ROOT.ADMIN_FOLDER."/_backup/full/".$date;
			$dst2 = ROOT.ADMIN_FOLDER."/_backup/full/".$date;
			$dst3 = ROOT.ADMIN_FOLDER."/_backup/full/".$date;
			recurse_copy($src1,$dst1);
			recurse_copy($src2,$dst2);
			recurse_copy($src3,$dst3);
			$fnameDB = ROOT.ADMIN_FOLDER.'/_backup/full/'.$date.'/db-backup-'.time().'.sql';
			backup_tables($fnameDB);
			$realpath = ROOT.ADMIN_FOLDER."/_backup/full/".$date."/";
			$name = ROOT.ADMIN_FOLDER."/_backup/full/".$date.".zip";
			//zip directory
			zip($realpath,$name);
			// delete directories
			foreach(scandir($realpath) as $f){
				if($f != "." && $f!=".."){
					rmdir($realpath.$f);
				}
			}
			rmdir($realpath);
		}else if(!empty($rows_b["type"]) && $rows_b["type"]=="file"){
			$src1 = ROOT."public/img";
			$src2 = ROOT."public/files";
			$src3 = ROOT."image";
			$dst1 = ROOT.ADMIN_FOLDER."/_backup/files/".$date;
			$dst2 = ROOT.ADMIN_FOLDER."/_backup/files/".$date;
			$dst3 = ROOT.ADMIN_FOLDER."/_backup/files/".$date;
			recurse_copy($src1,$dst1);
			recurse_copy($src2,$dst2);
			recurse_copy($src3,$dst3);

			$realpath = ROOT.ADMIN_FOLDER."/_backup/files/".$date."/";
			$name = ROOT.ADMIN_FOLDER."/_backup/files/".$date.".zip";
			//zip directory
			zip($realpath,$name);
			// delete directories
			foreach(scandir($realpath) as $f){
				if($f != "." && $f!=".."){
					rmdir($realpath.$f);
				}
			}
			rmdir($realpath);
		}else if(!empty($rows_b["type"]) && $rows_b["type"]=="database"){	
			$dst1 = ROOT.ADMIN_FOLDER."/_backup/database/".$date;
			mkdir($dst1);
			$fnameDB = ROOT.ADMIN_FOLDER.'/_backup/database/'.$date.'/db-backup-'.time().'.sql';
			backup_tables($fnameDB);
			$realpath = ROOT.ADMIN_FOLDER."/_backup/database/".$date."/";
			$name = ROOT.ADMIN_FOLDER."/_backup/database/".$date.".zip";
			//zip directory
			zip($realpath,$name);
			// delete directories
			foreach(scandir($realpath) as $f){
				if($f != "." && $f!=".."){
					rmdir($realpath.$f);
				}
			}
			rmdir($realpath);
		}
		$update_b = mysql_query("UPDATE `website_backup` SET `croned`=1, `filename`='".mysql_real_escape_string($date.".zip")."' WHERE `id`='".(int)$rows_b["id"]."' ");
	}
}
?>