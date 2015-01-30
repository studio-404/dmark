<div class="poll">
	<div class="h3"><?=strtoupper($newsletter)?></div>
	<form action="" method="post" class="form">
		<?php if($_POST["email"]){ if($this->newsletter_msg==1){ echo '<div class="msg">'.$done.'</div>'; }else{ echo '<div class="msg">'.$erroroccurred.'</div>'; }	} ?>
		<input type="text" name="email" class="email" value="" placeholder="<?=$email?>" title="<?=$email?>" />
		<label for="sub"><?=strtoupper($subscribe)?>: <input type="radio" name="subscribe" id="sub" value="1" checked='checked' /></label>
		<label for="unsub"><?=strtoupper($unsubscribe)?>: <input type="radio" name="subscribe" id="unsub" value="2" /></label>
		<br />
		<?php
		if(mysql_num_rows($this->chooseLang)) :
		?>
			<?php
			$x = 1;
			while($fecth = mysql_fetch_array($this->chooseLang))
			{
				echo '<label for="this_'.$x.'">'.$fecth["outname"].' <input type="checkbox" name="langs[]" id="this_'.$x.'" value="'.$fecth["id"].'" /></label><br />';
				$x++;
			}
		endif;
		?>
		<?php
			if($_SESSION['count'] >= 3){
			$_SESSION['encoded'] = rand(10000,99999);
		?>
		<input type="text" name="picture" value="" class="email" autocomplete="off" placeholder="<?=$fillsymbolsofPhoto?>" title="<?=$fillsymbolsofPhoto?>" style="margin:10px 0 0 0;" />
		<img src="_plugins/cropimg/capcha.php" width="65" height="25" style="margin:10px 0 0 0; padding:0;"  />
		<?php } ?>
		<input type="submit" value="<?=strtoupper($subscribe)?>" />
	</form>
</div>