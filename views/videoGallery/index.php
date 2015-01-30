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
							<?php 
							$x=1;
							foreach($this->out_video_folders["video_link"] as $video)
							{
								$f = ($x==1) ? " first" : "";
								echo '<article class="gallery_folder'.$f.'">';
								echo '<div class="img">';
								echo '<a href="https://www.youtube.com/watch?v='.$video.'" class="gallery">';
								echo '<img src="http://img.youtube.com/vi/'.$video.'/0.jpg" width="328" height="220" alt="">';
								echo '<div class="playbutton"></div></a></div></article>';
								if($x==1){ $x=2; }else{ $x=1; }
							}
							echo $this->out_video_folders["pagination"];
							?>	
							
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
	$('main .content .center .text-left section').each(function() { // the containers for all your galleries
		$(this).magnificPopup({
			delegate: '.gallery', // child items selector, by clicking on it popup will open
			type: 'iframe',
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