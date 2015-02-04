<?php
if(!isset($_GET['lang']) && ($_GET['lang']!="ka" || $_GET['lang']!="en")){ die("Fatal Error"); }
if(isset($_POST['email'],$_POST['password']))
{
@require('checkUser.php');
}
?>
<!DOCTYPE html>
<html>
<head>
<title>ადმინ პანელი 1.4</title>
<base href="<?=MAIN_DIR?>/<?=ADMIN_FOLDER?>/" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?=MAIN_DIR?>/<?=ADMIN_FOLDER?>/css/general.css?<?=time();?>" rel="stylesheet" type="text/css" />
<link href="<?=MAIN_DIR?>/<?=ADMIN_FOLDER?>/css/<?=$_GET['lang']?>.css?<?=time();?>" rel="stylesheet" type="text/css" />
<script src="http://code.jquery.com/jquery-1.11.0.min.js" type="text/javascript"></script>
<script src="<?=MAIN_DIR?>/<?=ADMIN_FOLDER?>/script/javascript.js" type="text/javascript"></script>
</head>
<body>

<div class="header">
	<div class="center">
		<div class="logo"><a href="<?=$_SERVER['PHP_SELF']?>">404</a></div>
		<div class="title"><span>/</span> <?=l("panel")?></div> 
		
		<div class="quick_info">
			<div class="info"><a href="en/login" <?=($_GET['lang']=="en") ? 'class="active"' : ''?>>EN</a> / <a href="ka/login" <?=($_GET['lang']=="ka") ? 'class="active"' : ''?>>KA</a></div><div class="clearer"></div>		
		</div>
	<div class="clearer"></div>
	</div>
</div>

<div class="clearer"></div>

<div class="center">
	<div class="box">
		<div class="head">
			<div class="text"><?=l("loginsystem")?></div>
			<div class="lines"></div>
			<div class="clearer"></div>
		</div>
		<div class="body">
			<form action="" method="post">			
				<?php if(!empty($_msg)) : ?>
				<div class="fill fill_e">
					<label style="text-align:center; color:red;"><?=$_msg?></label>	
				</div>
				<?php endif; ?>
				<div class="fill fill_1">
					<label><?=l("username")?>: <font color="#f00">*</font></label>
					<input type="text" name="email" value="" autocomplete="off" />
					<div class="checker_none email" onclick="$('.m_username').fadeIn('slow');">
						<div class="msg m_username"><?=l("fillusername")?> !</div>
					</div>					
				</div>
				<div class="clearer"></div>
				
				<div class="fill fill_2">
					<label><?=l("password")?>: <font color="#f00">*</font></label>
					<input type="password" name="password" value="" />
					<div class="checker_none password" onclick="$('.m_password').fadeIn('slow');"> 
						<div class="msg m_password"><?=l("fillpassword")?> !</div>
					</div>
				</div>
				<div class="clearer"></div>
				
				<div class="fill fill_2">
					<label><?=l("fillsymbols")?>: <font color="#f00">*</font></label>
					<input type="text" name="picture" value="" class="picture" autocomplete="off"  />
					<?php
					$_SESSION['encoded_admin'] = randomPassword(5,"letters");
					?>
					<img src="<?=MAIN_DIR?>/_plugins/cropimg/index.php" width="80" height="25" />
					<div class="checker_none encoded" onclick="$('.m_picture').fadeIn('slow');"> 
						<div class="msg m_picture"><?=l("fillsymbolsright")?> !</div>
					</div>
				</div>
				<div class="clearer"></div>
				
				<div class="fill">
					<input type="submit" name="" value="<?=l("enter")?>" />
				</div>
				<div class="clearer"></div>
				<div class="copy"><a href="http://404.ge" target="_blank">&copy; Giorgi Gvazava</a></div>
				<div class="clearer"></div>
			</form>
		</div>
	</div>
</div>
<?php
unset($_SESSION['admin_id']);
unset($_SESSION['admin_user']);
unset($_SESSION['admin_name']);
unset($_SESSION['permition']);
unset($_SESSION['logged']);
unset($_SESSION['lastLogged']);
?>


</body>

</html>