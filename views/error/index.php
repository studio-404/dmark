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
				<aside class="text-left" style="width:958px; padding:50px 20px">				
					<h2><?=$error_msg?></h2>
					<div class="text">
					<?=$error_description?>
					</div>
					<div class="clearer"></div>
				</aside>			
				
			</div><div class="clearer"></div>
		</section><div class="clearer"></div>
	</main>
<div class="clearer"></div>
<?php
@require 'views/parts/footer.php';
?>