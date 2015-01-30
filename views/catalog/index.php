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
					<?php 
					if(!isset($_GET['news_titile'])){
						echo '<h2>'.$this->text_title.'</h2>';
						echo str_replace("%readmore%",$readmore,$this->catalog_);
					}else{
						$cImage = count($this->mainPicture["image"]);
						if($cImage > 0){
							for($x=0;$x<=$cImage;$x++){
								if($this->mainPicture["image"][$x]) :
								$first_photo = ($x==0) ? '' : ' hidden';
								echo '<a href="image/gallery/'.$this->mainPicture["image"][$x].'" class="gallery'.$first_photo.'" title="'.$this->mainPicture["title"][$x].'"><img src="crop.php?img=image/gallery/'.$this->mainPicture["image"][$x].'&width=350&height=225" width="350" height="225" alt="'.$this->mainPicture["title"][$x].'" class="popup" align="left" title="'.$this->mainPicture["title"][$x].'" /><div class="countImage">'.$cImage.'</div></a>';
								endif;
							}
						}
						echo '<h2>'.($this->catalog_page_item['wni_namelname']).'</h2>';
						echo '<div class="text">';
						?>
						<?php	if($this->catalog_page_item['wni_shortbio']) :?>
						<i><b><font color="#333"><?=$shortbio?>:</font></b></i><br /> <?=stripslashes($this->catalog_page_item['wni_shortbio'])?> <br />
						<?php endif; ?>
						<?php	if($this->catalog_page_item['wni_startjob']) :?>
						<i><b><font color="#333"><?=$startjob?>:</font></b></i><br /> <?=date("d/m/Y",$this->catalog_page_item['wni_startjob'])?> <br />
						<?php endif; ?>
						<?php	if($this->catalog_page_item['wni_profesion']) :?>
						<i><b><font color="#333"><?=$profesion?>:</font></b></i><br /> <?=stripslashes($this->catalog_page_item['wni_profesion'])?> <br />
						<?php endif; ?>
						<?php	if($this->catalog_page_item['wni_dob']) :?>
						<i><b><font color="#333"><?=$dob?>:</font></b></i><br /> <?=date("d/m/Y",$this->catalog_page_item['wni_dob'])?> <br />
						<?php endif; ?>
						<?php	if($this->catalog_page_item['wni_bornplace']) :?>
						<i><b><font color="#333"><?=$bornplace?>:</font></b></i><br /> <?=stripslashes($this->catalog_page_item['wni_bornplace'])?> <br />
						<?php endif; ?>
						<?php	if($this->catalog_page_item['wni_livingplace']) :?>
						<i><b><font color="#333"><?=$livingplace?>:</font></b></i><br /> <?=stripslashes($this->catalog_page_item['wni_livingplace'])?> <br />
						<?php endif; ?>
						<?php	if($this->catalog_page_item['wni_phonenumber']) :?>
						<i><b><font color="#333"><?=$phonenumber?>:</font></b></i><br /> <?=stripslashes($this->catalog_page_item['wni_phonenumber'])?> <br />
						<?php endif; ?>
						<?php	if($this->catalog_page_item['wni_email']) :?>
						<i><b><font color="#333"><?=$email?>:</font></b></i><br /> <?=stripslashes($this->catalog_page_item['wni_email'])?> <br />
						<?php endif; ?>
						<?php	if($this->catalog_page_item['wni_education']) :?>
						<i><b><font color="#333"><?=$education?>:</font></b></i><br /> <?=stripslashes($this->catalog_page_item['wni_education'])?> <br />
						<?php endif; ?>
						<?php	if($this->catalog_page_item['wni_workExperience']) :?>
						<i><b><font color="#333"><?=$workExperience?>:</font></b></i><br /> <?=stripslashes($this->catalog_page_item['wni_workExperience'])?> <br />
						<?php endif; ?>
						<?php	if($this->catalog_page_item['wni_treinings']) :?>
						<i><b><font color="#333"><?=$treinings?>:</font></b></i><br /> <?=stripslashes($this->catalog_page_item['wni_treinings'])?> <br />
						<?php endif; ?>
						<?php	if($this->catalog_page_item['wni_certificate']) :?>
						<i><b><font color="#333"><?=$certificate?>:</font></b></i><br /> <?=stripslashes($this->catalog_page_item['wni_certificate'])?> <br />
						<?php endif; ?>
						<?php	if($this->catalog_page_item['wni_languages']) :?>
						<i><b><font color="#333"><?=$languages?>:</font></b></i><br /> <?=stripslashes($this->catalog_page_item['wni_languages'])?> <br />
						<?php endif; ?>
						<?php
						echo '<div class="clear"></div>';
						echo $this->attachs;
						echo '<div class="clear"></div>';
						?>
						<div class="clearer"></div>
						<div class="socials">
							<div class="print" onclick="window.print()"><div class="print-icon"></div><?=$print?></div>
							<div class="facebook_likee_share">
								<div class="fb-like" data-href="<?=CURRENT_URL?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>
							</div>
						</div>
						<?php
						echo '</div>';
					}
					?>					
				</aside>
				<?php if($this->banners_show){ ?>
				<aside class="text-right">
					<h3 class="hidden"><?=$banners?></h3>		
					<?=$this->banners?>
				</aside>
				<?php } ?>
				
				<!--<aside class="staticBanners">
					<div class="banner"><a href=""><img src="image/banners/static1.png" width="138" height="80" alt="პრობაციის ეროვნული სააგენტო" title="პრობაციის ეროვნული სააგენტო" /></a></div>
					<div class="banner"><a href=""><img src="image/banners/static2.png" width="138" height="80" alt="სასაწავლო ცენტრი" title="სასაწავლო ცენტრი" class="second" /></a></div>
					<div class="banner last"><a href=""><img src="image/banners/static3.png" width="138" height="80" alt="სასჯელ აღსრულების დეპარტამენტი" title="სასჯელ აღსრულების დეპარტამენტი" /></a></div>
				</aside>-->
			</div><div class="clearer"></div>
		</section><div class="clearer"></div>
	</main>
	<div class="clearer"></div>
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
</script>
<?php
@require 'views/parts/footer.php';
?>
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