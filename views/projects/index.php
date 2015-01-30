<?php 
// echo "<pre>"; 
// print_r($_GET); 
// echo "</pre>"; 

$lang_file = ADMIN_FOLDER."/cache/".$_GET['lang']."_l.php";
@require($lang_file); 
@require 'views/parts/header.php';
@require 'views/parts/navigation.php'; 
if(!isset($_GET["news_titile"]) && !isset($_GET["catalog"])) : 
?>
<main>
	<div class="container error-404-projectContainer cd-main-content">
	<div class="filterx error-404-margintop20">
		<div class="selectedx menuSelected">All Works</div>
	</div>		
	<div class="cd-tab-filter">
		<ul class="cd-filters">
			<li>
				<a class="selected filter" href="<?=CURRENT_URL?>#all" data-type="a">All Works</a>
			</li>
			<li data-filter=".public" class="filter">
				<a href="<?=CURRENT_URL?>#public" data-type="public">Public</a></li>
			<li data-filter=".commercial" class="filter">
				<a href="<?=CURRENT_URL?>#commercial" data-type="commercial">Commercial</a>
			</li>
			<li data-filter=".housing" class="filter">
				<a href="<?=CURRENT_URL?>#housing" data-type="housing">Housing</a>
			</li>
			<li data-filter=".competition" class="filter">
				<a href="<?=CURRENT_URL?>#competition" data-type="competition">Competition</a>
			</li>
			<li data-filter=".interior" class="filter">
				<a href="<?=CURRENT_URL?>#interior" data-type="interior">Interior</a>
			</li>
			<li data-filter=".realized" class="filter">
				<a href="<?=CURRENT_URL?>#realized" data-type="realized">Realized</a>
			</li>
		</ul> <div class="clearer"></div>
	</div> 

	<div class="clearer"></div>
		<section class="cd-gallery">
			<ul class="row" id="gridx">
				<?php
				echo $this->projects;
				?>				
			</ul>
			<div class="cd-fail-message">No results found</div>
		</section> 

	</div>
</main>
<?php
endif;

if(isset($_GET["news_titile"]) && isset($_GET["catalog"])) : 
	$projects = $this->projects; 
	// echo "<pre>";
	// print_r($this->projectImgs); 
	// echo "</pre>";
?>
<main>
	<div class="row"> 
		<div class="col-lg-2 col-md-2 error-projViewLeft">
			<div class="error-404-backlink"><a href="<?=MAIN_DIR?>/<?=$_GET["lang"]?>/projects">Back</a></div>
			<h1><?=$projects["p_title"]?></h1>
			<em><?=$date?>: 2013</em>
			<div class="error-404-projViewText">
			<strong><?=$client?>:</strong> <span class="error-404-value"><?=$projects["p_client"]?></span> <br />
			<strong><?=$location?>:</strong> <span class="error-404-value"><?=$projects["p_location"]?></span> <br />
			<strong><?=$buildingsize?>:</strong> <span class="error-404-value"><?=$projects["p_buildingsize"]?></span> <br />
			<strong><?=$budget?>:</strong> <span class="error-404-value"><?=$projects["p_budget"]?></span> <br />
			<strong><?=$programe?>:</strong> <span class="error-404-value"><?=$projects["p_programe"]?></span> <br />
			<strong><?=$status?>:</strong> <span class="error-404-value"><?=$projects["p_status"]?></span>
			<hr />
			<strong><?=$credits?>:</strong> <span class="error-404-value"><?=$projects["p_credit"]?></span> <br />
			<strong><?=$competitionphrase?>:</strong> 
			<span class="error-404-value"><?=$projects["p_competitionphrase"]?></span><br />
			<strong><?=$adviser?>:</strong>  
			<span class="error-404-value"><?=$projects["p_advisors"]?></span>
			</div>
		</div>
		<div class="col-lg-10 col-md-10">

			<div id="owl-demo" class="owl-carousel owl-theme error-404-owl">
			<?php
			// echo "<pre>"; 
			// print_r($this->projectImgs);
			// echo "</pre>"; 
			$x = 0;
			foreach($this->projectImgs as $image) : 
			?>
				<div class="item"><img src="crop.php?path=image/slide/&img=<?=MAIN_DIR?>/image/gallery/<?=$image?>&width=1065&height=755" width="100%" alt="<?=$projects["p_title"]?>"></div>
			<?php
			$x++;
			endforeach;
			?>
			</div>
			<div class="clearer"></div>
		</div>
	</div><div class="clearer"></div>
</main>
<?php
endif;
@require("views/parts/footer.php");
?>