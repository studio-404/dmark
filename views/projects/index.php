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
		<div class="selectedx menuSelected"><?=ucfirst($allworks)?></div>
	</div>		
	<div class="cd-tab-filter">
		<ul class="cd-filters">
			<li>
				<a class="selected filter" href="<?=CURRENT_URL?>#all" data-type="a"><?=ucfirst($allworks)?></a>
			</li>
			<?php
			$sfilter = mysql_query("SELECT `p_title`,`p_client` FROM `website_catalogs_items` WHERE `catalog_id`=4 AND `langs`='".mysql_real_escape_string($_GET["lang"])."' AND `status`!=1 ");
			while($srows = mysql_fetch_array($sfilter)){
				//echo '<option value="'.$srows["p_client"].'">'.$srows["p_title"].'</option>';
				echo '<li data-filter=".'.$srows["p_client"].'" class="filter">
				<a href="'.CURRENT_URL.'#'.$srows["p_client"].'" data-type="'.$srows["p_client"].'">'.$srows["p_title"].'</a></li>';
			}
			?>
		</ul> 
		<div class="closeable"></div>
		<div class="clearer"></div>
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
		<?php
		$cimage = count($this->projectImgs);
		$idImage = ($cimage<=1) ? "noCarusel" : "owl-demo";
		?>
			<div id="<?=$idImage?>" class="owl-theme error-404-owl studio-404-projectOwlSlider">
			<?php
			$x = 0;
			echo '<ul class="bxslider">';
			foreach($this->projectImgs as $image) : 
			?>
				<li class="item"><img src="crop.php?path=image/slide/&img=<?=MAIN_DIR?>/image/gallery/<?=$image?>&width=1065&height=755" width="100%" alt="<?=$projects["p_title"]?>"></li>
			<?php
			$x++;
			endforeach;
			echo "</ul>";
			?>
			</div>
			<script type="text/javascript">
				$(".bxslider").bxSlider({
					auto : true, 
					speed : 3000, 
					pause: 7000, 
  					useCSS: false, 
  					controls : false, 
  					pager : true 
				});
			</script>
			<div class="clearer"></div>
		</div>
	</div><div class="clearer"></div>
</main>


<script src="<?=MAIN_DIR?>/_plugins/readmore/readmore.js"></script>
<script>
    $('.error-404-projViewText').readmore({
      moreLink: '<a href="#"><?=$readmore?></a>',
      lessLink: '<a href="#"><?=$close?></a>',
      collapsedHeight: 450 
    });
</script>
<?php
endif;
@require("views/parts/footer.php");
?>