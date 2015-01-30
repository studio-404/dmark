<?php
$msg="";
if(isset($_POST['question'],$_POST['answers']))
{	
	if(!empty($_POST['question']) && !empty($_POST['answers']))
	{	
		insert_action("polls","add","0");
		$question = $_POST["question"]; 
		$answers = $_POST["answers"]; 
		
		$select = mysql_query("SELECT MAX(idx) AS maxi FROM `website_poll` WHERE `status`!=1 ");
		$getMax = mysql_fetch_array($select);
		$Max = $getMax['maxi']+1;
			$select_languages = select_languages(); 
			$c = count($_POST['answers']) / count($select_languages["language"]);
			foreach($select_languages["language"] as $language){
				/*
				** insert question
				*/
				$admin_id = $_SESSION['admin_id'];
				$grand_id = implode(",",grand_admins());
				if(!in_array($admin_id,grand_admins())){
					$access_admins = $grand_id.",".$admin_id;
				}else{
					$access_admins = $grand_id;
				}
				$insert = mysql_query("INSERT INTO `website_poll` SET 
					`idx`='".$Max."',  
					`date`='".time()."',  
					`type`='q',  
					`title`='".strip($_POST['question'])."',  
					`langs`='".strip($language)."', 
					`access_admins`='".strip($access_admins)."'
				");	
				/*
				** insert answers
				*/
					
					if(is_array($_POST['answers'])) : 
					$z=$Max+1;
					foreach($_POST['answers'] as $answer){
						if(empty($answer)){ continue; }
						if($z==$c){ $z=1; }
						$insert_answers = mysql_query("
							INSERT INTO `website_poll` SET 
							`idx`='".(int)$z."', 
							`date`='".time()."', 
							`cat_id`='".(int)$Max."', 
							`type`='a', 
							`title`='".strip($answer)."', 
							`langs`='".strip($language)."'
						");
						$z++;
					}
					endif;
			}		
			
			
			if(!$insert)
			{
				$msg = l("erroroccurred");
				$theBoxColore = "red";
			}
			else
			{
				_refresh_404("/".ADMIN_FOLDER."/".$_GET["lang"]."/edit/polls/".$Max);
				exit();
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
?>
<form action="" method="post" enctype="multipart/form-data">
	<?php
	if($msg) :
	?>
	<div class="boxes">
		<div class="error_msg <?=$theBoxColore?>"><i><?=$msg?> !</i></div>
	</div>
	<?php 
	endif;
	?>
	
	<div class="boxes">
		<label for="question"><i><?=l("question")?></i> <font color="#f00">*</font></label>
		<input type="text" name="question" class="question" id="question" value="<?=(isset($_POST['question'])) ? $_POST['question'] : "";?>" />
	</div><div class="clearer"></div>
	
	<div class="boxes">
		<label for="answers"><i><?=l("answers")?></i></label>
		<input type="text" name="answers[]" class="answers" value="" />
	</div><div class="clearer"></div>
	
	<div class="boxes" id="whattocopy">
		<label for="answers"><i><?=l("answers")?></i></label>
		<input type="text" name="answers[]" class="answers" value="" />
	</div><div class="clearer"></div>
	<div id="here"></div><div class="clearer"></div>
	<div class="boxes">
		<a href="javascript:void(0)" onclick="copyAnswer()"><?=l("moreanswers")?></a>
	</div><div class="clearer"></div>
	
	<div class="boxes">				
		<input type="submit" class="submit" id="submit" value="<?=l("add")?>" />
	</div><div class="clearer"></div><br />
			
</form>