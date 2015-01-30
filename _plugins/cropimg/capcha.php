<?php
session_start();
$name = "s.png";
$im = imagecreatefrompng($name);

$im = imagecreate(65, 25);
$string = $_SESSION['encoded'];
$bg = imagecolorallocate($im, 145, 151, 166);
$red = imagecolorallocate($im, 255, 255, 255);
imagestring($im, 16, 8, 3, $string, $red);
$filename = sha1("_".time()).".png";
$name = "thumbs/s/".$filename;
imagepng($im,$name,7);
$dir    = 'thumbs/s/';
$files = scandir($dir);
foreach($files as $file)
{
	if($file!="." && $file!=".." && $file!=$filename)
	{
		$cerationTime = @filemtime($file);
		$now = time() - 30;
		if($cerationTime<$now)
		{
			unlink($dir.$file);
		}
	}
}
header("location: " . $name);
?>