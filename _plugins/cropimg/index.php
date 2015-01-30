<?php
session_start();

$name = "r.png";
$im = imagecreatefrompng($name);
$im = imagecreate(80, 25);
$string = $_SESSION['encoded_admin'];
$bg = imagecolorallocate($im, 34, 34, 34);
$red = imagecolorallocate($im, 255, 255, 255);
imagestring($im, 16, 8, 3, $string, $red);
$filename = sha1("_".time()).".png";
$name = "thumbs/".$filename; 
imagepng($im,$name,7);
$dir    = 'thumbs/';
$files = scandir($dir);

foreach($files as $file)
{
	if($file!="." && $file!=".." && $file!=$filename)
	{
		$cerationTime = @filemtime($file);
		$now = time() - 30;
		if($cerationTime<$now)
		{
			@unlink($dir.$file);
		}
	}
}
header("location: " . $name);
?>