<?php
session_start();
if (! $_SESSION['is_logged']) header("Location:index.html");
?>
<?php

 define ("MAX_SIZE","1000"); 


 function getExtension($str) {
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }

 $errors=0;
 if(isset($_POST['Submit'])) 
 {
 	$image=$_FILES['image']['name'];
  	if ($image) 
 	{
  		$filename = stripslashes($_FILES['image']['name']);
   		$extension = getExtension($filename);
 		$extension = strtolower($extension);
 if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) 
 		{
 			echo '<h1>Unknown extension!</h1>';
 			$errors=1;
 		}
 		else
 		{
 $size=filesize($_FILES['image']['tmp_name']);

if ($size > MAX_SIZE*1024)
{
	echo '<h1>You have exceeded the size limit!</h1>';
	$errors=1;
}


$image_name=time().'.'.$extension;
$newname="newspictures/".$image_name;
$copied = copy($_FILES['image']['tmp_name'], $newname);
if (!$copied) 
{
	echo '<h1>Copy unsuccessfull!</h1>';
	$errors=1;
}}}}

 if(isset($_POST['Submit']) && !$errors) 
 {
 	echo "<h1>File Uploaded Successfully!</h1>";

	$db_name = "dmark_dmark";
	$table  = "newsphotos";
	$host = "localhost";
	$user = "dmark_datval";
	$pass = "torpedo";
	$link = mysql_connect($host,$user,$pass) or die (mysql_errno($link).mysql_error($link));
	$db = mysql_select_db($db_name,$link) or die (mysql_errno($link).mysql_error($link));
	$newid = $_REQUEST['id'];
	$query = "INSERT INTO newsphotos ( newsID, address) VALUES ('$newid', '$newname')";
	$result = mysql_query($query, $link)  or die (mysql_errno($link).mysql_error($link));
	mysql_close($link);	
 }

 ?>

 <!--next comes the form, you must set the enctype to "multipart/frm-data" and use an input type "file" -->
 <form name="newad" method="post" enctype="multipart/form-data"  action="">
 <table>
 	<tr><td><input type="file" name="image"></td></tr>
 	<tr><td><input name="Submit" type="submit" value="Upload image"></td></tr>
 </table>	
 </form>
 <a href="news.php">Back to news</a>