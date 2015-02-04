<?php 
$lang_file = ADMIN_FOLDER."/cache/".$_GET['lang']."_l.php";
@require($lang_file); 
@require 'views/parts/header.php';
@require 'views/parts/navigation.php';
?>
<main class="error-404-contactMain">
	<div class="row">	
		
		<div class="col-lg-12 col-md-12 error-404-contactOwl">
			<ul class="bxslider">
				<?php
					echo $this->get_slide_array;
				?>
			</ul>
			<script type="text/javascript">
				$(".bxslider").bxSlider({
					auto : true, 
					speed : 3000, 
					pause: 7000, 
  					useCSS: false, 
  					controls : false, 
  					pager : false 
				});
			</script>

			<div class="clearer"></div>
		</div><div class="clearer"></div>

		<div class="col-lg-4 col-md-4 col-sm-12 error-404-contactCols">
			<h2><?=$sendquestion?>: </h2>
			<form action="javascript:sendEm();" method="post" accept-charset="utf-8" id="myform">
			<input type="hidden" name="lang" id="lang" value="<?=$_GET["lang"]?>" />
			<div class="msg orange" id="omsg"></div>
			<input type="text" name="namelname" id="namelname" value="" placeholder="<?=$name?>:" />
			<input type="text" name="email" id="email" value="" placeholder="<?=$email?>:" />
			<textarea name="text" id="text" placeholder="<?=$message?>:"></textarea>
			<input type="submit" name="submit" value="<?=$send?>" />
			</form>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-12 error-404-contactCols">
			<h2><?=$contactInformation?>: </h2>
			<p>
			<?=$coinfofor?>
			</p>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-12 error-404-contactCols">
			<h2><?=$getdirection?>: </h2>
			<div class="map-canvas" id="map-canvas"></div>
		</div>

	</div><div class="clearer"></div>
</main>
<?php
@require 'views/parts/footer.php';
?>
