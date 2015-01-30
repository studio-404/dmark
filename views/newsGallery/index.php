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
						<section class="gallery_folders">
							<h3 class="hidden"><?=$this->text_title?></h3>
							<?=$this->out_gallery_folders?>				
						</section>					
				</aside>
				<?php if($this->banners_show){ ?>
				<aside class="text-right">
					<h3 class="hidden"><?=$banners?></h3>		
					<?=$this->banners?>
				</aside>
				<?php } ?>
			</div><div class="clearer"></div>
		</section><div class="clearer"></div>
	</main><div class="clearer"></div>
<script type="text/javascript">
	$('main .content .center .text-left section article').each(function() { // the containers for all your galleries
		$(this).magnificPopup({
			delegate: '.gallery', // child items selector, by clicking on it popup will open
			type: 'image',
			gallery:{
			enabled:true
			}
		});
	}); 
</script>
<div class="clearer"></div>
<?php
@require 'views/parts/footer.php';
?>