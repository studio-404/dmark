<?php 
$lang_file = ADMIN_FOLDER."/cache/".$_GET['lang']."_l.php";
@require($lang_file); 
@require 'views/parts/header.php';
@require 'views/parts/navigation.php'; 
?>
<?php
if(!isset($_GET["news_titile"])) :
?>
<main class="error-404-teamMain">
	<div class="row">
		<div class="col-lg-2 col-md-2 error-projViewLeft">
			<h1 class="error-404-teamTitle"><?=$aboutus?></h1>
			<div class="error-404-projViewText">
			<?=html_entity_decode(stripslashes(str_replace("&nbsp;"," ",$this->teamLeftside)))?>
			</div><div class="clearer"></div><br>
		</div>
		<div class="col-lg-10 col-md-10">
			<div class="row">
				<?=$this->team?>
			</div>
		</div>
	</div><div class="clearer"></div>
</main>
<?php
endif;

if(isset($_GET["news_titile"])) : 
	// echo "<pre>";
	// print_r();
	// echo "</pre>";
	$team = $this->team;
?>
<main>
	<div class="row">
		<div class="col-lg-2 col-md-2 col-sm-12">
			<div class="error-404-backlink"><a href="<?=MAIN_DIR?>/<?=$_GET["lang"]?>/team"><?=ucfirst($back_page)?></a></div>
			<div class="studio-404-teamMember">
				<img src="crop.php?path=image/slide/&amp;img=http://dmark.ge/image/gallery/<?=$this->projectImgs?>&amp;width=200&amp;height=190" width="100%" alt="Vladimer abramidze" class="error-teammember-image" />
			</div>
		</div>
		<div class="col-lg-10 col-md-10 col-sm-12 error-404-teamView">
			<h1><?=html_entity_decode(stripslashes(str_replace("&nbsp;"," ",$team["namelname"])))?></h1>
			<h2><?=html_entity_decode(stripslashes(str_replace("&nbsp;"," ",$team["profesion"])))?></h2>
			<?php
			if(!empty($team["dob"])) :
			?>
			<strong><?=ucfirst($dob)?>: </strong> <span><?=date("d.m.Y",$team["dob"])?></span><br />
			<?php
			endif;
			?>
			<?php
			if(!empty($team["bornplace"])) :
			?>
			<strong><?=ucfirst($bornplace)?>: </strong> <span><?=html_entity_decode(stripslashes(str_replace("&nbsp;"," ",$team["bornplace"])))?></span><br />
			<?php
			endif;
			?>
			<?php
			if(!empty($team["email"])) :
			?>
			<strong><?=ucfirst($email)?>: </strong> <span><?=html_entity_decode($team["email"])?></span><br />
			<?php
			endif;
			?>
			<?php
			if(!empty($team["education"])) :
			?>
			<strong><?=ucfirst($education)?>: </strong> <span><?=html_entity_decode(stripslashes(str_replace("&nbsp;"," ",$team["education"])))?></span><br />
			<?php
			endif;
			?>
			<?php
			if(!empty($team["livingplace"])) :
			?>
			<strong><?=ucfirst($livingplace)?>: </strong> <span><?=html_entity_decode(stripslashes(str_replace("&nbsp;"," ",$team["livingplace"])))?></span><br />
			<?php
			endif;
			?>
			<?php
			if(!empty($team["phonenumber"])) :
			?>
			<strong><?=ucfirst($phonenumber)?>: </strong> <span><?=html_entity_decode(stripslashes(str_replace("&nbsp;"," ",$team["phonenumber"])))?></span><br />
			<?php
			endif;
			?>
			<?php
			if(!empty($team["shortbio"])) :
			?>
			<strong><?=ucfirst($shortbio)?>: </strong> <span><?=html_entity_decode(stripslashes(str_replace("&nbsp;"," ",$team["shortbio"])))?></span><br />
			<?php
			endif;
			?>
			<?php
			if(!empty($team["workExperience"])) :
			?>
			<strong><?=ucfirst($workExperience)?>: </strong> <span><?=html_entity_decode(stripslashes(str_replace("&nbsp;"," ",$team["workExperience"])))?></span><br />
			<?php
			endif;
			?>
			<?php
			if(!empty($team["treinings"])) :
			?>
			<strong><?=ucfirst($treinings)?>: </strong> <span><?=html_entity_decode(stripslashes(str_replace("&nbsp;"," ",$team["treinings"])))?></span><br />
			<?php
			endif;
			?>
			<?php
			if(!empty($team["certificate"])) :
			?>
			<strong><?=ucfirst($certificate)?>: </strong> <span><?=html_entity_decode(stripslashes(str_replace("&nbsp;"," ",$team["certificate"])))?></span><br />
			<?php
			endif;
			?>
			<?php
			if(!empty($team["languages"])) :
			?>
			<strong><?=ucfirst($languages)?>: </strong> <span><?=html_entity_decode(stripslashes(str_replace("&nbsp;"," ",$team["languages"])))?></span><br />
			<?php
			endif;
			?>

			<br />
			<!-- <h2><b>Work experiance</b></h2>
			<p>1995-1997 Working as a Architect in Tbilisi Georgia (NAMEOFTHECOMPANY) </p>
			<p>1998-current Lead project manager (DMARK)</p>
			<br />
			<h2><b>Contends</b></h2>
			<p>1995-1997 Working as a Architect in Tbilisi Georgia (NAMEOFTHECOMPANY) </p>
			<p>1998-current Lead project manager (DMARK)</p>
			<p>1998-current Lead project manager (DMARK) jaskhdka s</p>
			<p>1998-current Lead project manager (DMARK) askjdasd</p>
			<p>1998-current Lead project manager (DMARK) askd jaskjd akjsd asd</p>
			<p>1998-current Lead project manager (DMARK)as kasjd laksd lasjld aslkd</p> -->

			<br />
		</div><div class="clearer"></div>
	</div><div class="clearer"></div>
</main>
<?php
endif;
@require 'views/parts/footer.php';
?>