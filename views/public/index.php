<?php 
$lang_file = ADMIN_FOLDER."/cache/".$_GET['lang']."_l.php";
@require($lang_file); 
@require 'views/parts/header.php';
@require 'views/parts/top.php';
@require 'views/parts/navigation.php';
?>
<main>
		<section class="content">
			<h2 class="hidden">კონტენტი</h2>
			<div class="center">
				
				<aside class="text-left">
					<div class="path">
					<?=str_replace("%main%",$main,$this->breadCraps)?>
					</div>									
					<h2><?=html_entity_decode($this->text_title)?></h2>
					<div class="text">
					<table style="width: 100%;">
					<tbody>
					<tr>
						<td><strong><?=$filename?></strong></td>
						<td><strong><?=$updateDate?></strong></td>
					</tr>
					<?php 
						$sql = $this->publicInformation;
						$query_ = mysql_query($sql);
						if(mysql_num_rows($query_) > 0){  
							while($rows = mysql_fetch_array($query_))
							{
								if($rows["wpf_archive"]==2){
									$archive_["file_name"][] = $rows["wpf_file_name"];
									$archive_["name"][] = $rows["wpf_name"];
									$archive_["date"][] = $rows["wpf_date"];
									continue;
								}
								echo '<tr>';
								$ext = strtolower(end(explode(".",$rows["wpf_file_name"])));
								if($ext=="pdf"){
									echo '<td><a href="image/public_files/'.html_entity_decode($rows["wpf_file_name"]).'" target="_blank">'.stripslashes($rows["wpf_name"]).'</a></td>';
								}else{
									echo '<td><a href="'.MAIN_DIR.'_plugins/download/public_files.php?download_file='.html_entity_decode($rows["wpf_file_name"]).'" target="_blank">'.stripslashes($rows["wpf_name"]).'</a></td>';
								}
								echo '<td>'.date("d/m/Y",$rows["wpf_date"]).'</td>';
								echo '</tr>';
							}
						}else{
							echo '<tr>';
							echo '<td colspan="2">'.$noData.'</td>'; 
							echo '</tr>';
						}
						if(count($archive_["file_name"]) > 0){
							echo '<tr>';
							echo '<td colspan="2"><strong>'.$archivex.'</strong></td>'; 
							echo '</tr>';
							for($i = 1; $i <= count($archive_["file_name"]); $i++)
							{
								$x = $i-1;
								echo '<tr>';
								$ext = strtolower(end(explode(".",$archive_["file_name"][$x])));
								if($ext=="pdf"){
									echo '<td><a href="image/public_files/'.html_entity_decode($archive_["file_name"][$x]).'" target="_blank">'.html_entity_decode($archive_["name"][$x]).'</a></td>';
								}else{
									echo '<td><a href="'.MAIN_DIR.'_plugins/download/public_files.php?download_file='.html_entity_decode($archive_["file_name"][$x]).'" target="_blank">'.html_entity_decode($archive_["name"][$x]).'</a></td>';
								}
								echo '<td>'.date("d/m/Y",$archive_["date"][$x]).'</td>';
								echo '</tr>';
							}
						}
					?>
					</tbody>
					</table>					
					</div>
					<div class="clearer"></div>
				</aside>
				<?php if($this->banners_show){ ?>
				<aside class="text-right">
					<h3 class="hidden"><?=$banners?></h3>		
					<?=$this->banners?>
				</aside>
				<?php } ?>
			</div><div class="clearer"></div>
		</section><div class="clearer"></div>
	</main>
<div class="clearer"></div>
<?php
@require 'views/parts/footer.php';
?>