<?php
$msg = "";
/*change permition*/
if(isset($_POST["s"])){ change_permition("website_poll",false,$_GET["edit"]); insert_action("poll","change permition",$_GET["edit"]); }
/* check if have permition */
$admin_permition = check_if_permition("website_poll",false,$_GET["edit"],' AND `type`="q" ');
if(isset($_POST['question'],$_POST['answers']) && $admin_permition )
{	
	if(!empty($_POST['question']) && !empty($_POST['answers']))
	{		
		insert_action("polls","edit",$_GET["edit"]);
		// answer max idx 
		$select = mysql_query("SELECT MAX(idx) AS maxi FROM `website_poll` WHERE `status`!=1 ");
		$getMax = mysql_fetch_array($select);
		$Max = $getMax['maxi']+1;
		$clear = mysql_query("DELETE FROM `website_poll` WHERE cat_id='".(int)$_GET["edit"]."' "); // clear old ones
			$select_languages = select_languages(); 
			$x=0;
			foreach($select_languages["language"] as $language){
				/*
				** update question
				*/
				$insert = mysql_query("UPDATE `website_poll` SET  
					`title`='".strip($_POST['question'][$language])."' 
					WHERE 
					`idx`='".(int)$_GET["edit"]."' AND 
					`langs`='".strip($language)."' AND 
					`type`='q'
				");	
				/*
				** insert answers
				*/
					if(is_array($_POST['answers'][$language])) : 
					$c = 1;
					foreach($_POST['answers'][$language] as $answer){
						if(empty($answer)){ continue; }
						if($c==((count($_POST['answers'][$language]) / 2) - 1)){ $c=1; }
						$insert_answers = mysql_query("
							INSERT INTO `website_poll` SET 
							`idx`='".(int)$c."', 
							`cat_id`='".(int)$_GET["edit"]."', 
							`type`='a', 
							`title`='".strip($answer)."', 
							`langs`='".strip($language)."'
						");
						$c++;
					}$Max++;
					endif;
					$x++;
					
			}
			
			
			
			if(!$insert)
			{
				$msg = l("erroroccurred");
				$theBoxColore = "red";
			}
			else
			{										
				$msg = l("done");
				$theBoxColore = "orange";	
			}
	}
	else
	{
		$msg = l("requiredfields");
		$theBoxColore = "red";
	}
}
$select_languages = select_languages();
?>
<div class="cont">
	<?php
	$count = count($select_languages["name"]);
	$x = 1;
	if($count){
		echo '<ul>';
		foreach($select_languages["name"] as $name){
			echo '<li id="tab-'.$x.'" onclick="show(this, \'content-'.$x.'\');">'.$name.'</li>';
			$x++;
		}
		echo '</ul>';
	}
	?>
	
<form action="" method="post" enctype="multipart/form-data">
	<?php 
	if($count){		
		$y = 1;
		foreach($select_languages["name"] as $name){
		$select = mysql_query("SELECT `idx`,`title`,`type` FROM `website_poll` WHERE `type`='q' AND `idx`='".(int)$_GET['edit']."' AND `status`!=1 AND `langs`='".mysql_real_escape_string($select_languages["language"][$y-1])."' ");
	?>
		<div id="content-<?=$y?>" class="content">
			<?php
			if($msg) :
			?>
				<div class="boxes">
				<div class="error_msg <?=$theBoxColore?>"><i><?=$msg?> !</i></div>
				</div>
			<?php 
			endif;
			?>
			<?php
			if(!$admin_permition){ 
				echo '<div class="boxes">';
				echo '<div class="error_msg red"><i>'.l("noRight").' !</i></div>';
				echo '</div>';
			}
			?>
			<?php
			while($rows = mysql_fetch_array($select))
			{
			?>
				<div class="boxes">
				<label for="question"><i><?=l("question")?></i> <font color="#f00">*</font></label>
				<input type="text" name="question[<?=$select_languages["language"][$y-1]?>]" class="question" value="<?=(isset($rows['title'])) ? $rows['title'] : "";?>" />
				</div><div class="clearer"></div>
				<?php 
				$select_a = mysql_query("SELECT `title` FROM `website_poll` WHERE `type`='a' AND `cat_id`='".(int)$rows['idx']."' AND `status`!=1 AND `langs`='".strip($select_languages["language"][$y-1])."' ORDER BY idx ASC");  
				$a=1;
				$nums = mysql_num_rows($select_a) / 2;
				while($rows_a = mysql_fetch_array($select_a))
				{
					if($a==$nums){ $a=1; }
				?>
					<div class="boxes">
					<label for="answers"><i><?=l("answers")?> #<?=$a?></i></label>
					<input type="text" name="answers[<?=$select_languages["language"][$y-1]?>][]" class="answers" value="<?=(isset($rows_a['title'])) ? $rows_a['title'] : "";?>" />
					</div><div class="clearer"></div>
				<?php 
					$a++;
				} 
			}
			?>
			
			<div class="boxes">
				<?php $_SESSION["token"]=randomPassword(16); ?>
				<a href="javascript:void(0)" onclick="openPop('contentRight.php?lang=<?=$_GET['lang']?>&idx=<?=$_GET["edit"]?>&t=website_poll&weblang=<?=$_GET["lang"]?>&token=<?=$_SESSION["token"]?>')"><?=l("contentupdateright")?></a>
			</div><div class="clearer"></div>
			
			<div class="boxes">				
				<input type="submit" class="submit" id="submit" value="<?=l("edit")?>" />
			</div><div class="clearer"></div><br />
		</div>
	<?php 
			$select = "";
			$rows = "";
			$y++;
		}
	}
	?>
</form>	
</div>
<div class="clearer"></div><br />