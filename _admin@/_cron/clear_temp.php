<?php
$src = '../../_temporaty';
$dir = opendir($src);
$x=1;
while(false !== ( $file = readdir($dir)) )
{
	if (( $file != '.' ) && ( $file != '..' ))
	{
		if ( file_exists($src . '/' . $file) )
		{
			@unlink($src . '/' . $file);
		}
	}
}
closedir($dir);
?>