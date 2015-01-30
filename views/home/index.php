<?php 
$lang_file = ADMIN_FOLDER."/cache/".$_GET['lang']."_l.php";
if(!file_exists($lang_file)){
	die("Language file does not exists !");
}
@require($lang_file); 
@require 'views/parts/header.php';
?>
<div class="preloader">
	<img src="<?=MAIN_DIR?>/public/img/loader.gif" alt="preloader" />
</div>

<div class="container error-404-container stop_load">
	
	<div class="row error-404-rowcenter">
		<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 error-404-textaligncenter">
			<img src="<?=MAIN_DIR?>/public/img/logo.png" class="error-404-logo" data-url="<?=MAIN_DIR?>/<?=$_GET["lang"]?>/projects" />
		</div>
		<div class="col-lg-8 col-md-8 error-404-hide992">
			<div class="error-404-text">
				<h1><?=ucfirst($hello)?> !</h1>
				<p><?=ucfirst($hellotext)?></p>
				<div class="clearer"></div>
				 <p class="error-404-prolinks">
				<a href="<?=MAIN_DIR?>/<?=$_GET["lang"]?>/projects">
					<?=ucfirst($projects)?> 
					<img src="<?=MAIN_DIR?>/public/img/arrow.png" alt="arrow" width="41" height="27" />
				</a>
				</p>  
			</div>
		</div>
		<div class="clearer"></div>
	</div>
	<div class="clearer"></div>

</div>
</body>
</html>