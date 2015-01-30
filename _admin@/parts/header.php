<?php
if(!isset($_SESSION['admin_user']) && $_COOKIE['admin_user']=="")
{
_refresh_404('login');
exit();
}
else
{
if(isset($_SESSION['admin_user'],$_SESSION['admin_name']))
{
$user = $_SESSION['admin_user'];
$name = $_SESSION['admin_name'];
}
else
{
$user = $_COOKIE['admin_user'];
$name = $_COOKIE['admin_name'];
}
}
?>
<!DOCTYPE html>
<html>
<head>
<title>ადმინ პანელი 1.4</title>
<base href="<?=url()?>/<?=ADMIN_FOLDER?>/" /> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/general.css?<?=time();?>" rel="stylesheet" type="text/css" />
<link href="css/<?=$_GET['lang']?>.css?<?=time();?>" rel="stylesheet" type="text/css" />
<script src="script/jquery-1.11.0.min.js" type="text/javascript"></script>
<script src="script/javascript.js" type="text/javascript"></script>
<!--TinyMce-->
<script type="text/javascript" src="_plugins/tinymce/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
    selector: "textarea",
    theme: "modern",
    height: 200,
    plugins: [
         "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
         "save table contextmenu directionality emoticons template paste textcolor", 
		 "insertdatetime"
   ],
   content_css: "css/content.css",
   toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l ink image | print preview media fullpage | forecolor backcolor emoticons | insertdatetime", 
   insertdatetime_formats: ["%Y.%m.%d", "%H:%M"], 
   style_formats: [
        {title: 'Bold text', inline: 'b'},
        {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
        {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
        {title: 'Example 1', inline: 'span', classes: 'example1'},
        {title: 'Example 2', inline: 'span', classes: 'example2'},
        {title: 'Table styles'},
        {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
    ]
 });
</script>
<?php if($_GET["404"]=="edit") : ?>
<link rel="stylesheet" type="text/css" href="_plugins/tabs/style.css" />
<!--[if IE 7]>
<link rel="stylesheet" type="text/css" href="_plugins/tabs/style_ie.css" />
<![endif]-->
<script type="text/javascript" src="_plugins/tabs/script.js"></script>
<?php 
endif;
if(isset($_GET['datepicker'])) :
?>
<link rel="stylesheet" href="_plugins/datepicker/jquery-ui.css" />
<script src="_plugins/datepicker/jquery-ui-<?=$_GET['lang']?>.js"></script>
<script>
$(function() {
	$( ".datepicker" ).datepicker({
		changeYear: true,
		yearRange:'-80:+1'
	});
});
</script>
<?php
endif;
?>
</head>
<body>