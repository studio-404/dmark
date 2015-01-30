<section class="slider">
	<h2 class="hidden"><?=$slide?></h2>
	<?php 
	//str_replace("%readmore%",$readmore,$this->get_slide_array)
	?>
	<div class="center">
	<!-- Insert to your webpage where you want to display the slider -->
	
    <div id="amazingslider-wrapper-1" style=" width:1000px; margin:0;">
        <div id="amazingslider-1" style="width:1000px;">
            <?php 
				echo str_replace("%readmore%",$readmore,$this->get_slide_array); 
				//echo utf8_encode($this->get_slide_array);
				//echo html_entity_decode($this->get_slide_array);
				
			?>
        </div>
    </div>
    <!-- End of body section HTML codes -->
	</div>
	</section>