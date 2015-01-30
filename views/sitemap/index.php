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
					<h2><?=$this->text_title?></h2>
					<div class="text">
					<?=$this->sitemap?>
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
		</section>
		<div class="clearer"></div>
	</main>
	<div class="clearer"></div>
<?php
@require 'views/parts/footer.php';
?>