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
					</div><div class="clearer"></div>
					<?php
					$cImage = count($this->mainPicture["image"]);
					for($x=0;$x<=$cImage;$x++){
						if($this->mainPicture["image"][$x]) :
							$first_photo = ($x==0) ? '' : ' hidden';
					?>
						<a href="image/gallery/<?=$this->mainPicture["image"][$x]?>" class="gallery<?=$first_photo?>" title="<?=$this->mainPicture["title"][$x]?>"><img src="crop.php?img=image/gallery/<?=$this->mainPicture["image"][$x]?>&width=350&height=225" width="350" height="225" alt="<?=$this->mainPicture["title"][$x]?>" class="popup" align="left" /><b class="countImage"><?=$cImage?></b></a>
					<?php 
						endif;
					}
					?>						
					<h2><?=$this->text_title?></h2>
					<div class="text">
					<?=stripslashes($this->text_text)?>
					<?=$this->right_menu_content?>
					<?=$this->attachs?>					
					<div class="clearer"></div>
					<div class="socials">
						<div class="print" onclick="window.print()"><div class="print-icon"></div><?=$print?></div>
						<div class="facebook_likee_share">
							<div class="fb-like" data-href="<?=CURRENT_URL?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>
						</div>
					</div>
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
<script type="text/javascript">
$(".youtube_video").each(function( index ) {
	var t = $(this).text();
	var i_id = $(this).attr("id");
	jwplayer(i_id).setup({ 
	file: "https://www.youtube.com/watch?v="+t,
	image: "http://img.youtube.com/vi/"+t+"/0.jpg",
	height: 370, 
	width: 678 
	});
	$(i_id).css({"visibility":"hidden"});
});	
$(".server_video").each(function( index ) {
	var t = $(this).text();
	var i_id = $(this).attr("id");
	jwplayer(i_id).setup({ 
	file: "public/video/"+t+"/1.flv",
	image: "public/video/"+t+"/image1.jpg",
	height: 370, 
	width: 678 
	});
	$(i_id).css({"visibility":"hidden"});
});			
</script>
<script type="text/javascript">
	$('main .content .center .text-left').each(function() { // the containers for all your galleries
		$(this).magnificPopup({
			delegate: '.gallery', // child items selector, by clicking on it popup will open
			type: 'image',
			gallery:{
			enabled:true
			}
		});
	}); 
	
	$('main .content .center .text-left .pop').each(function() {
		$(this).magnificPopup({
			items: {
			src: $(this).attr("src")
			},
			type: 'image'
		});
	}); 
</script>
<?php
@require 'views/parts/footer.php';
?>