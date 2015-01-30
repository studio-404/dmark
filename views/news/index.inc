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
						<?=str_replace("%main%",$main,$this->breadCraps).""?>
					</div>
					<div class="clearer"></div>
					<?php 
					if(!isset($_GET['news_titile'])){
						echo '<h2>'.$this->text_title.'</h2>';
						echo (str_replace("%readmore%",$readmore,$this->news_));
					}else{
						$cImage = count($this->mainPicture["image"]);
						if($cImage > 0){
							for($x=0;$x<=$cImage;$x++){
								if($this->mainPicture["image"][$x]) :
								$first_photo = ($x==0) ? '' : ' hidden';
								echo '<a href="image/gallery/'.$this->mainPicture["image"][$x].'" class="gallery'.$first_photo.'" title="'.$this->mainPicture["title"][$x].'"><img src="crop.php?img=image/gallery/'.$this->mainPicture["image"][$x].'&amp;width=350&amp;height=225" width="350" height="225" alt="'.$this->mainPicture["title"][$x].'" class="popup" align="left" /><b class="countImage">'.$cImage.'</b></a>';
								endif;
							}
						}
						echo '<h2>'.($this->news_page_item['wni_title']).'</h2>';
						echo '<div class="text">';
						echo '<em>'.$date.': '.date("d/m/Y",$this->news_page_item['wni_date']).'</em><br />';
						echo stripslashes(html_entity_decode(str_replace("&nbsp;"," ",$this->news_page_item['wni_long_text'])));
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
				<?php if($this->newsletter_show || $this->calendar_show){ ?>
				<aside class="text-right">
					<?php if($this->calendar_show) : ?>
					<form>
						<input type="hidden" id="lang_c" value="<?=$_GET["lang"]?>" />
						<select id="month">
							<option value=""><?=$month?></option>
							<?php
							$month_array = array($ianvari,$tebervali,$marti,$aprili,$maisi,$ivnisi,$ivlisi,$agvisto,$seqtemberi,$oqtomberi,$noemberi,$dekemberi);
							for($x=1;$x<=12;$x++){
							echo '<option value="'.$x.'">'.$month_array[$x-1].'</option>';
							}
							?>
						</select>
						<select id="year">
							<option value=""><?=$year?></option>
							<?php
							for($y=date("Y");$y>=(date("Y")-50);$y--){
							echo '<option value="'.$y.'">'.$y.'</option>';
							}
							?>
						</select>
					</form>
					<?php
					$monthx = (isset($_GET["month"])) ? $_GET["month"] : date("m");
					$yearx = (isset($_GET["year"])) ? $_GET["year"] : date("Y");
					$get_calendar = MAIN_DIR . "/_plugins/calendar/index.php?month=".$monthx."&year=".$yearx."&lang=".$_GET["lang"];
					if(@file_get_contents($get_calendar)){
					echo '<div id="mCalendar">';
					echo @file_get_contents($get_calendar);
					echo '</div>';
					}
					endif;
					if($this->newsletter_show) :
					@require("views/parts/newsletter.php");
					endif;
					?>
				</aside>			
				<?php } ?>
			</div><div class="clearer"></div>
		</section><div class="clearer"></div>
	</main>
	<div class="clearer"></div>
<script type="text/javascript">
	$('main .content .center .text-left').each(function() { 
		$(this).magnificPopup({
			delegate: '.gallery', 
			type: 'image',
			gallery:{
			enabled:true
			}
		});
	}); 
</script>
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
<?php
@require 'views/parts/footer.php';
?>