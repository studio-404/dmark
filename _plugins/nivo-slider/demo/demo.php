<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<html lang="en">
<head>
    <title>Nivo Slider Demo</title>
    <link rel="stylesheet" href="../themes/default/default.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="../themes/light/light.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="../themes/dark/dark.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="../themes/bar/bar.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="../nivo-slider.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="style.css" type="text/css" media="screen" />
</head>
<body>
    <div id="wrapper">
        <a href="http://dev7studios.com" id="dev7link" title="Go to dev7studios">dev7studios</a>

        <div class="slider-wrapper theme-default">
            <div id="slider" class="nivoSlider">
				<?php 
				$x=0;
				foreach($_GET['img'] as $img)
				{
					$title = $_GET['title'][$x];
					?>
					<img src="../../../crop.php?img=image/slide/<?=$img?>&width=577&height=319" data-thumb="../../../crop.php?img=../../../image/slide/<?=$img?>&width=577&height=319" alt="<?=$title?>" title="<?=$title?>" width="577" height="319" style="margin:0; border:0px; outline:0px;" />
					<?php
					$x++;
				}
			?>
            </div>
            <div id="htmlcaption" class="nivo-html-caption">
                <strong>This</strong> is an example of a <em>HTML</em> caption with <a href="#">a link</a>. 
            </div>
        </div>

    </div>
    <script type="text/javascript" src="scripts/jquery-1.9.0.min.js"></script>
    <script type="text/javascript" src="../jquery.nivo.slider.js"></script>
    <script type="text/javascript">
    $(window).load(function() {
        $('#slider').nivoSlider();
    });
    </script>
</body>
</html>