<header>
	<div class="container error-404-containerProject">		
		<a href="<?=$_GET["lang"]?>/home" class="llogo"></a>
		<?php
		$return_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$find = "/".$_GET["lang"]."/";
		$replace = ($_GET["lang"]=="ka") ? "/en/" : "/ka/"
		?>
		<a href="<?=str_replace($find,$replace,$return_url)?>" class="langs"><?=(isset($_GET["lang"]) && $_GET["lang"]=="en") ? "Ka" : "En"?></a>


		<div id="navigation">
			<div class="toggle">
				<div class="toggleline"></div>
				<div class="toggleline"></div>
				<div class="toggleline"></div>
			</div>

			<div class="menu">
				<?=$this->main_navigation_mobile?>
			</div>
		</div>

	</div>

</header>
<nav>
	<?=$this->main_navigation?>
</nav><div class="clearer"></div>