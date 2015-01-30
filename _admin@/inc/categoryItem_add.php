<?php
$msg="";

if($_GET["addid"]==3) : 

if(isset($_POST['namelname'],$_POST['profesion']))
{	
	if(!empty($_POST['namelname']) && !empty($_POST['profesion']) && !empty($_POST["shortbio"]))
	{
			insert_action("catalog","add catalog item","0");
			$ex = explode("/",$_POST['startjob']);
			$dd = $ex[1]."/".$ex[0]."/".$ex[2];
			$startjob = strtotime($dd); 			
			$namelname = $_POST["namelname"]; 
			$profesion = $_POST["profesion"]; 
			$dob = $_POST["dob"]; 			
			$ex2 = explode("/",$_POST['dob']);
			$dd2 = $ex2[1]."/".$ex2[0]."/".$ex2[2];
			$dob = strtotime($dd2);			
			$bornplace = $_POST["bornplace"]; 
			$livingplace = $_POST["livingplace"]; 
			$phonenumber = $_POST["phonenumber"]; 
			$email = $_POST["email"]; 		
			$shortbio = $_POST["shortbio"]; 
			$workExperience = $_POST["workExperience"]; 
			$education = $_POST["education"]; 
			$treinings = $_POST["treinings"]; 
			$certificate = $_POST["certificate"]; 
			$languages = $_POST["languages"]; 

			$select = mysql_query("SELECT MAX(idx) AS maxi FROM `website_catalogs_items` ");
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
					$insert = mysql_query("INSERT INTO `website_catalogs_items` SET 
														`startjob`='".(int)$startjob."',  
														`idx`='".(int)$Max."',  
														`catalog_id`='".(int)$_GET['addid']."', 
														`namelname`='".strip($namelname)."',  
														`profesion`='".strip($profesion)."',  
														`dob`='".(int)$dob."',  
														`bornplace`='".strip($bornplace)."', 
														`livingplace`='".strip($livingplace)."',  
														`phonenumber`='".strip($phonenumber)."',  
														`email`='".strip($email)."',  
														`shortbio`='".strip($shortbio)."',  
														`workExperience`='".strip($workExperience)."',  
														`education`='".strip($education)."',  
														`treinings`='".strip($treinings)."',  
														`certificate`='".strip($certificate)."',  
														`languages`='".strip($languages)."',  
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
				_refresh_404("/".ADMIN_FOLDER."/".$_GET["lang"]."/edit/categoryItem/".$_GET["addid"]."/".$Max);
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
				<label for="startjob"><i><?=l("startjob")?></i></label>
				<input type="text" name="startjob" class="datepicker" id="startjob" value="<?=(isset($_POST['startjob'])) ? date("d/m/Y",$_POST['startjob']) : date("d/m/Y");?>" />
				<div class="checker_none datex" onclick="$('.m_startjob').fadeIn('slow');">
						<div class="msg m_startjob"><?=l("fillstartjob")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="namelname"><i><?=l("namelname")?></i> <font color="#f00">*</font></label>
				<input type="text" name="namelname" class="namelname" id="namelname" value="<?=(isset($_POST['namelname'])) ? $_POST['namelname'] : "";?>" />
				<div class="checker_none namelname" onclick="$('.m_title').fadeIn('slow');">
						<div class="msg m_title"><?=l("fillnamelname")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="profesion"><i><?=l("profesion")?></i> <font color="#f00">*</font></label>
				<input type="text" name="profesion" class="profesion" id="profesion" value="<?=(isset($_POST['profesion'])) ? $_POST['profesion'] : "";?>" />
				<div class="checker_none profesion" onclick="$('.m_profesion').fadeIn('slow');">
						<div class="msg m_profesion"><?=l("fillprofesion")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="dob"><i><?=l("dob")?></i></label>
				<input type="text" name="dob" class="datepicker" id="dob" value="<?=(isset($_POST['dob'])) ? date("d/m/Y",$_POST['dob']) : date("d/m/Y");?>" />
				<div class="checker_none datex" onclick="$('.m_dob').fadeIn('slow');">
						<div class="msg m_dob"><?=l("filldob")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="bornplace"><i><?=l("bornplace")?></i></label>
				<input type="text" name="bornplace" class="bornplace" id="bornplace" value="<?=(isset($_POST['bornplace'])) ? $_POST['bornplace'] : "";?>" />
				<div class="checker_none bornplace" onclick="$('.m_bornplace').fadeIn('slow');">
						<div class="msg m_bornplace"><?=l("fillbornplace")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="livingplace"><i><?=l("livingplace")?></i></label>
				<input type="text" name="livingplace" class="livingplace" id="livingplace" value="<?=(isset($_POST['livingplace'])) ? $_POST['livingplace'] : "";?>" />
				<div class="checker_none livingplace" onclick="$('.m_livingplace').fadeIn('slow');">
						<div class="msg m_livingplace"><?=l("filllivingplace")?> !</div>
				</div>
			</div><div class="clearer"></div>			
			
			<div class="boxes">
				<label for="phonenumber"><i><?=l("phonenumber")?></i></label>
				<input type="text" name="phonenumber" class="phonenumber" id="phonenumber" value="<?=(isset($_POST['phonenumber'])) ? $_POST['phonenumber'] : "";?>" />
				<div class="checker_none phonenumber" onclick="$('.m_phonenumber').fadeIn('slow');">
						<div class="msg m_phonenumber"><?=l("fillphonenumber")?> !</div>
				</div>
			</div><div class="clearer"></div>
			
			<div class="boxes">
				<label for="email"><i><?=l("email")?></i></label>
				<input type="text" name="email" class="email" id="email" value="<?=(isset($_POST['email'])) ? $_POST['email'] : "";?>" />
				<div class="checker_none email" onclick="$('.m_email').fadeIn('slow');">
						<div class="msg m_email"><?=l("fillemail")?> !</div>
				</div>
			</div><div class="clearer"></div>			
			
			
			<div class="boxes">
				<label for="shortbio"><i><?=l("shortbio")?></i> <font color="#f00">*</font></label><div class="clearer"></div>
				<textarea name="shortbio" class="shortbio" id="shortbio"><?=(isset($_POST['shortbio'])) ? $_POST['shortbio'] : "";?></textarea>
			</div>
			<div class="clearer"></div>
			
			<div class="boxes">
				<label for="workExperience"><i><?=l("workExperience")?></i></label><div class="clearer"></div>
				<textarea name="workExperience" class="workExperience" id="workExperience"><?=(isset($_POST['workExperience'])) ? $_POST['workExperience'] : "";?></textarea>
			</div>
			<div class="clearer"></div>
			
			<div class="boxes">
				<label for="education"><i><?=l("education")?></i></label><div class="clearer"></div>
				<textarea name="education" class="education" id="education"><?=(isset($_POST['education'])) ? $_POST['education'] : "";?></textarea>
			</div>
			<div class="clearer"></div>
			
			<div class="boxes">
				<label for="treinings"><i><?=l("treinings")?></i></label><div class="clearer"></div>
				<textarea name="treinings" class="treinings" id="treinings"><?=(isset($_POST['treinings'])) ? $_POST['treinings'] : "";?></textarea>
			</div>
			<div class="clearer"></div>
			
			<div class="boxes">
				<label for="certificate"><i><?=l("certificate")?></i></label><div class="clearer"></div>
				<textarea name="certificate" class="certificate" id="certificate"><?=(isset($_POST['certificate'])) ? $_POST['certificate'] : "";?></textarea>
			</div>
			<div class="clearer"></div>
			
			<div class="boxes">
				<label for="languages"><i><?=l("languages")?></i></label><div class="clearer"></div>
				<textarea name="languages" class="languages" id="languages"><?=(isset($_POST['languages'])) ? $_POST['languages'] : "";?></textarea>
			</div>
			<div class="clearer"></div>
				
			<div class="boxes">				
				<input type="submit" class="submit" id="submit" value="<?=l("add")?>" />
				<input type="reset" class="reset" id="reset" value="<?=l("clear")?>" />	
			</div><div class="clearer"></div><br />
			
		</form>
<?php
endif;

if($_GET["addid"]=="1") : 


if(isset($_POST['p_date'],$_POST['p_title']))
{	
	if(!empty($_POST['p_date']) && !empty($_POST['p_title']))
	{	
			insert_action("catalog","add catalog item","0");
			$ex = explode("/",$_POST['p_date']);
			$dd = $ex[1]."/".$ex[0]."/".$ex[2];
			$p_date = strtotime($dd); 			
			$p_title = $_POST["p_title"]; 
			$p_type = $_POST["p_type"]; 
			$p_client = $_POST["p_client"]; 
			$p_location = $_POST["p_location"]; 
			$p_buildingsize = $_POST["p_buildingsize"]; 
			$p_budget = $_POST["p_budget"]; 
			$p_programe = $_POST["p_programe"]; 			
			$p_status = $_POST["p_status"]; 			
			$p_credits = $_POST["p_credits"]; 
			$p_competitionphrase = $_POST["p_competitionphrase"]; 
			$p_adviser = $_POST["p_adviser"]; 
			

			$select = mysql_query("SELECT MAX(idx) AS maxi FROM `website_catalogs_items`");
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
					$insert = mysql_query("INSERT INTO `website_catalogs_items` SET 
														`idx`='".(int)$Max."', 
														`p_date`='".(int)$p_date."',  
														`p_title`='".strip($p_title)."',  
														`p_type`='".strip($p_type)."',  
														`catalog_id`='".(int)$_GET['addid']."', 
														`p_client`='".strip($p_client)."',  
														`p_location`='".strip($p_location)."', 
														`p_buildingsize`='".strip($p_buildingsize)."', 
														`p_budget`='".strip($p_budget)."',  
														`p_programe`='".strip($p_programe)."',  
														`p_status`='".strip($p_status)."',  
														`p_credit`='".strip($p_credits)."',  
														`p_competitionphrase`='".strip($p_competitionphrase)."',  
														`p_advisors`='".strip($p_adviser)."', 
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
				_refresh_404("/".ADMIN_FOLDER."/".$_GET["lang"]."/edit/categoryItem/".$_GET["addid"]."/".$Max);
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
				<label for="date"><i><?=l("date")?></i></label>
				<input type="text" name="p_date" class="datepicker" id="date" value="<?=(isset($_POST['p_date'])) ? date("d/m/Y",$_POST['p_date']) : date("d/m/Y");?>" />
				<div class="checker_none date" onclick="$('.mdate').fadeIn('slow');">
						<div class="msg mdate"><?=l("filldate")?> !</div>
				</div>
			</div><div class="clearer"></div>

			<div class="boxes">
				<label for="title"><i><?=l("title")?></i> <font color="#f00">*</font></label>
				<input type="text" name="p_title" class="title" id="title" value="<?=(isset($_POST['p_title'])) ? $_POST['p_title'] : "";?>" />
				<div class="checker_none namelname" onclick="$('.mtitle').fadeIn('slow');">
						<div class="msg mtitle"><?=l("filltitle")?> !</div>
				</div>
			</div><div class="clearer"></div>

			<div class="boxes">
				<label for="type"><i><?=l("type")?></i> <font color="#f00">*</font></label>
				<select name="p_type">
					<option value="public"><?=l("public")?></option>
					<option value="commercial"><?=l("commercial")?></option>
					<option value="housing"><?=l("housing")?></option>
					<option value="competition"><?=l("competition")?></option>
					<option value="interior"><?=l("interior")?></option>
					<option value="realized"><?=l("realized")?></option>
				</select>
				<div class="checker_none typex" onclick="$('.mtype').fadeIn('slow');">
						<div class="msg mtype"><?=l("filltype")?> !</div>
				</div>
			</div><div class="clearer"></div>

			<div class="boxes">
				<label for="client"><i><?=l("client")?></i> <font color="#f00">*</font></label>
				<input type="text" name="p_client" class="client" id="client" value="<?=(isset($_POST['p_client'])) ? $_POST['p_client'] : "";?>" />
				<div class="checker_none client" onclick="$('.mclient').fadeIn('slow');">
						<div class="msg mclient"><?=l("fillclient")?> !</div>
				</div>
			</div><div class="clearer"></div>

			<div class="boxes">
				<label for="location"><i><?=l("location")?></i> <font color="#f00">*</font></label>
				<input type="text" name="p_location" class="location" id="location" value="<?=(isset($_POST['p_location'])) ? $_POST['p_location'] : "";?>" />
				<div class="checker_none location" onclick="$('.mlocation').fadeIn('slow');">
						<div class="msg mlocation"><?=l("filllocation")?> !</div>
				</div>
			</div><div class="clearer"></div>

			<div class="boxes">
				<label for="buildingsize"><i><?=l("buildingsize")?></i> <font color="#f00">*</font></label>
				<input type="text" name="p_buildingsize" class="buildingsize" id="buildingsize" value="<?=(isset($_POST['p_buildingsize'])) ? $_POST['p_buildingsize'] : "";?>" />
				<div class="checker_none buildingsize" onclick="$('.mbuildingsize').fadeIn('slow');">
						<div class="msg mbuildingsize"><?=l("fillbuildingsize")?> !</div>
				</div>
			</div><div class="clearer"></div>

			<div class="boxes">
				<label for="budget"><i><?=l("budget")?></i> <font color="#f00">*</font></label>
				<input type="text" name="p_budget" class="budget" id="budget" value="<?=(isset($_POST['p_budget'])) ? $_POST['p_budget'] : "";?>" />
				<div class="checker_none budget" onclick="$('.mbudget').fadeIn('slow');">
						<div class="msg mbudget"><?=l("fillbudget")?> !</div>
				</div>
			</div><div class="clearer"></div>

			<div class="boxes">
				<label for="programe"><i><?=l("programe")?></i> <font color="#f00">*</font></label>
				<input type="text" name="p_programe" class="programe" id="programe" value="<?=(isset($_POST['p_programe'])) ? $_POST['p_programe'] : "";?>" />
				<div class="checker_none programe" onclick="$('.mprograme').fadeIn('slow');">
						<div class="msg mprograme"><?=l("fillprograme")?> !</div>
				</div>
			</div><div class="clearer"></div>

			<div class="boxes">
				<label for="status"><i><?=l("status")?></i> <font color="#f00">*</font></label>
				<input type="text" name="p_status" class="status" id="status" value="<?=(isset($_POST['p_status'])) ? $_POST['p_status'] : "";?>" />
				<div class="checker_none status" onclick="$('.mstatus').fadeIn('slow');">
						<div class="msg mstatus"><?=l("fillstatus")?> !</div>
				</div>
			</div><div class="clearer"></div>

			<div class="boxes">
				<label for="credits"><i><?=l("credits")?></i> <font color="#f00">*</font></label>
				<input type="text" name="p_credits" class="credits" id="credits" value="<?=(isset($_POST['p_credits'])) ? $_POST['p_credits'] : "";?>" />
				<div class="checker_none credits" onclick="$('.mcredits').fadeIn('slow');">
						<div class="msg mcredits"><?=l("fillcredits")?> !</div>
				</div>
			</div><div class="clearer"></div>

			<div class="boxes">
				<label for="competitionphrase"><i><?=l("competitionphrase")?></i> <font color="#f00">*</font></label><div class="clearer"></div>
				<textarea name="p_competitionphrase" class="competitionphrase" id="competitionphrase"><?=(isset($_POST['p_competitionphrase'])) ? $_POST['p_competitionphrase'] : "";?></textarea>
			</div><div class="clearer"></div>

			<div class="boxes">
				<label for="adviser"><i><?=l("adviser")?></i> <font color="#f00">*</font></label>
				<input type="text" name="p_adviser" class="adviser" id="adviser" value="<?=(isset($_POST['p_adviser'])) ? $_POST['p_adviser'] : "";?>" />
				<div class="checker_none adviser" onclick="$('.madviser').fadeIn('slow');">
						<div class="msg madviser"><?=l("filladviser")?> !</div>
				</div>
			</div><div class="clearer"></div>

			<div class="boxes">				
				<input type="submit" class="submit" id="submit" value="<?=l("add")?>" />
				<input type="reset" class="reset" id="reset" value="<?=l("clear")?>" />	
			</div><div class="clearer"></div><br />

</form>

<?php
endif;
?>