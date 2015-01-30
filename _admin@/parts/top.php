<div class="mask"></div>
<div class="mbox ui-widget-content"></div>
<div class="header">
<div class="center">
<div class="logo"><a href="<?=$_GET['lang']?>/home">404</a></div>
<div class="title">{ <?=($_GET['lang']=="ka") ? WEBSITE_NAME_KA : WEBSITE_NAME_EN?> }</div> 
<div class="quick_info">
<div class="info"><a href="<?=$_GET['lang']?>/login"><?=l("signout")?></a></div>
<div class="info"><a href="<?=$_GET["lang"]?>/table/setting"><?=l("settings")?></a></div>
<?php $current = $_SERVER['REQUEST_URI']; ?>
<div class="info"><a href="<?= str_replace("/ka/","/en/",$current)?>" <?=($_GET['lang']=="en") ? 'class="active"' : ''?>>EN</a> / <a href="<?= str_replace("/en/","/ka/",$current)?>" <?=($_GET['lang']=="ka") ? 'class="active"' : ''?>>KA</a></div><div class="clearer"></div>
<div class="info"><?=l("lastvisit")?>: <span><?=date("d/m/Y H:s",(int)$_SESSION['lastLogged'])?></span></div>
<div class="info"><?=l("login")?>: # <span><?=$_SESSION['logged']?></span></div>			
</div>
<div class="clearer"></div>
</div>
</div>
<div class="clearer"></div>