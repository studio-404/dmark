<?php 

$lang_file = ADMIN_FOLDER."/cache/".$_GET['lang']."_l.php";
@require($lang_file); 
@require 'views/parts/header.php';
@require 'views/parts/navigation.php'; 
if(!isset($_GET["news_titile"])) : 
?>
<main class="error-404-eventMain">
	
	<div class="container error-404-newsContainer">			
	<?php 
		echo (str_replace(array("%readmore%","&nbsp;"),array($readmore," "),$this->news_));
	?>
	</div>
	<div class="clearer"></div><br />
</main>
<?php
endif;
@require("views/parts/footer.php");
?>