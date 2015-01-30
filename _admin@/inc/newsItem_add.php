<?php
$msg="";
if(isset($_POST['date'],$_POST['title'],$_POST['text'],$_POST['short_text']))
{	
	if(!empty($_POST['date']) && !empty($_POST['title']) && !empty($_POST['text']) && !empty($_POST['short_text']))
	{	
			insert_action("news","add news item","0");
			$ex = explode("/",$_POST['date']);
			$dd = $ex[0]."-".$ex[1]."-".$ex[2];
			$date = strtotime($dd); 
			$title = $_POST["title"]; 
			$text = $_POST["text"]; 
			$httplink = $_POST["httplink"]; 
			$short_text = $_POST["short_text"]; 
			$select = mysql_query("SELECT MAX(idx) AS maxi FROM `website_news_items` ");
			$getMax = mysql_fetch_array($select);
			$Max = $getMax['maxi']+1;
			
			if(!$msg){
				$select_languages = select_languages(); 
				foreach($select_languages["language"] as $language){
					$admin_id = $_SESSION['admin_id'];
					$grand_id = implode(",",grand_admins());
					if(!in_array($admin_id,grand_admins())){
						$access_admins = $grand_id.",".$admin_id;
					}else{
						$access_admins = $grand_id;
					}
					$insert = mysql_query("INSERT INTO `website_news_items` SET
														`idx`='".(int)$Max."',  
														`date`='".(int)$date."',  
														`news_idx`='".(int)$_GET['addid']."', 
														`title`='".strip($title)."',  
														`short_text`='".strip($short_text)."',  
														`long_text`='".strip($text)."',  
														`httplink`='".strip($httplink)."',  
														`langs`='".strip($language)."', 
														`access_admins`='".strip($access_admins)."'
														");
				}
			} 
					
			if(!$insert)
			{
				$msg = l("erroroccurred");
				$theBoxColore = "red";
			}
			else
			{	
				_refresh_404("/".ADMIN_FOLDER."/".$_GET["lang"]."/edit/newsItem/".$_GET["addid"]."/".$Max);
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
				<label for="date"><i><?=l("date")?></i> <font color="#f00">*</font></label>
				<input type="text" name="date" class="datepicker" id="date" value="<?=(isset($_POST['date'])) ? date("d/m/Y",$_POST['date']) : date("d/m/Y");?>" />
				<div class="checker_none datex" onclick="$('.m_date').fadeIn('slow');">
						<div class="msg m_date"><?=l("filldate")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="title"><i><?=l("title")?></i> <font color="#f00">*</font></label>
				<input type="text" name="title" class="title" id="title" value="<?=(isset($_POST['title'])) ? $_POST['title'] : "";?>" />
				<div class="checker_none title" onclick="$('.m_title').fadeIn('slow');">
						<div class="msg m_title"><?=l("filltitle")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="short_text"><i><?=l("short_text")?></i> <font color="#f00">*</font></label><div class="clearer"></div>
				<textarea name="short_text" class="short_text" id="short_text"><?=(isset($_POST['short_text'])) ? $_POST['short_text'] : "";?></textarea>
			</div>
			<div class="clearer"></div>
			
			<div class="boxes">
				<label for="text"><i><?=l("text")?></i> <font color="#f00">*</font></label><div class="clearer"></div>
				<textarea name="text" class="text" id="text"><?=(isset($_POST['text'])) ? $_POST['text'] : "";?></textarea>
			</div>
			<div class="clearer"></div>

			<div class="boxes">
				<label for="httplink"><i><?=l("url")?></i> <font color="#f00">*</font></label>
				<input type="text" name="httplink" class="httplink" id="httplink" value="<?=(isset($_POST['httplink'])) ? $_POST['httplink'] : "";?>" />
				<div class="checker_none httplink" onclick="$('.m_httplink').fadeIn('slow');">
						<div class="msg m_httplink"><?=l("fillurl")?> !</div>
				</div>
			</div><div class="clearer"></div>

			<div class="boxes">				
				<input type="submit" class="submit" id="submit" value="<?=l("add")?>" />
				<input type="reset" class="reset" id="reset" value="<?=l("clear")?>" />	
			</div><div class="clearer"></div><br />	
			
		</form>