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
					<div class="clearer"></div>
					<h2><?=$this->text_title?></h2>
					<div class="text">
					<?php
					echo $this->get_public_archives;
					?>
					<div class="clearer"></div>
					</div><div class="clearer"></div>
				</aside>	
				<aside class="text-right">
					<div class="h3"><?=$lastFiveYearArchive?></div><div class="claerer"></div>
					<div class="poll" style="padding:0">
						<form action="javascript:void(0)" method="post" class="form">
							<select id="year" style="margin-left:0px">
								<option value=""><?=$choose?></option>
								<?php
								$current = date("Y");
								$minus5 = $current - 4;
								for($x=$current; $x>=$minus5; $x--){
								?>
									<option value="<?=$x?>" <?=( (!isset($_GET["year"]) && $current==$x ) || (isset($_GET["year"]) && $x==$_GET["year"]) ) ? 'selected="selected"' : ''?>><?=$x?></option>
								<?php 
								}
								?>
							</select>
							<input type="text" name="search_in_archive" id="search_in_archive" class="email" value="<?=($_POST["search_in_archive"]) ? $_POST["search_in_archive"] : ''?>" placeholder="<?=$search_in_archive?>">
							<input type="submit" value="<?=$search?>" onclick="post_('<?=$_GET["lang"]?>')" />
						</form>
					</div>
					<div class="clearer"></div>
					<?php
					for($x=$current; $x>=$minus5; $x--){
					?>
						<div class="year<?=($_GET["year"]==$x || (!isset($_GET["year"]) && $x==date("Y")) ) ? ' active' : ''?>">
							<a href="<?=$_GET['lang']?>/<?=$_GET['url']?>/<?=$x?>">
								<div class="calendar-icon"></div><div class="span"><?php echo $x." ".$year; ?></div><div class="clearer"></div>
							</a>
						</div>
					<?php
					}
					?>
				</aside>		
			</div>
		</section>
	</main>
	<div class="clearer"></div>
<?php
@require 'views/parts/footer.php';
?>