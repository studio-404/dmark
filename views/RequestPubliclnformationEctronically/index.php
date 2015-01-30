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
					<?=str_replace("%main%",$main,$this->breadCraps)?>
					</div><div class="clearer"></div>				
					<h2><?=html_entity_decode($this->text_title)?></h2>
					<div class="text">
						<form action="" method="post" id="RequestPubliclnformationEctronically">
						<label for="namelname"><?=$namelname?>: <font color="red">*</font></label>
						<input type="text" name="namelname" id="namelname" value="" /><div class="clearer"></div>
						<label for="personalNumber"><?=$personalNumber?>: <font color="red">*</font></label>
						<input type="text" name="personalNumber" id="personalNumber" value="" /><div class="clearer"></div>
						<label for="phonenumber"><?=$phonenumber?>: <font color="red">*</font></label>
						<input type="text" name="phonenumber" id="phonenumber" value="" /><div class="clearer"></div>
						<label for="email"><?=$email?>: <font color="red">*</font></label>
						<input type="text" name="email" id="email" value="" /><div class="clearer"></div>
						<label for="message"><?=$message?>: <font color="red">*</font></label>
						<textarea name="message" id="message"></textarea><div class="clearer"></div>
						<?php
						$_SESSION['encoded'] = rand(10000,99999);
						?>
						<input type="text" name="picture" value="" class="email" autocomplete="off" placeholder="<?=$fillsymbolsofPhoto?>" title="<?=$fillsymbolsofPhoto?>" style="margin:10px 0 0 0;" /><div class="clearer"></div>
						<img src="_plugins/cropimg/capcha.php" width="65" height="25" style="margin:10px 0 0 0; padding:0;"  />
						<div class="clearer"></div>
						<input type="submit" value="<?=$send?>" />
						</form>
					</div>
					<div class="clearer"></div>
					
				</aside>
				<?php if($this->banners_show){ ?>
				<aside class="text-right">
					<h3 class="hidden"><?=$banners?></h3>		
					<?=$this->banners?>
				</aside>
				<?php } ?>
			</div><div class="clearer"></div>
		</section><div class="clearer"></div>
	</main>
<div class="clearer"></div>
<?php
@require 'views/parts/footer.php';
?>