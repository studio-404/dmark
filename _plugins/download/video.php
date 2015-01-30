<?php
error_reporting(0);
// place this code inside a php file and call it f.e. "download.php"
$path = "http://static.video.yandex.net/swf/video/player10-loader.swf?login=giya17&storage_directory=s7zdkr3jux.709&storage_url_prefix=http%3A%2F%2Fstatic.video.yandex.net&clip_storage_url_prefix=http%3A%2F%2Fstreaming.video.yandex.ru&related_url_prefix=http%3A%2F%2Fvideo.yandex.ru%2Fxml%2Frelated-films.xml&videopage_url_prefix=http%3A%2F%2Fvideo.yandex.ru&player_url_prefix=http%3A%2F%2Fstatic.video.yandex.net&token_url_prefix=http%3A%2F%2Fstatic.video.yandex.net%2Fget-token&r=354456"; // change the path to fit your websites document structure
$fullPath = $path.$_GET['download_file'];

if ($fd = fopen ($fullPath, "r")) {
    $fsize = filesize($fullPath);
    $path_parts = pathinfo($fullPath);
    $ext = strtolower($path_parts["extension"]);
    switch ($ext) {
        case "pdf":
        header("Content-type: application/pdf"); // add here more headers for diff. extensions
        header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\""); // use 'attachment' to force a download
        break;
        default;
        header("Content-type: application/octet-stream");
        header("Content-Disposition: filename=\"".$path_parts["basename"]."\"");
    }
    header("Content-length: $fsize");
    header("Cache-control: private"); //use this to open files directly
    while(!feof($fd)) {
        $buffer = fread($fd, 2048);
        echo $buffer;
    }
}
fclose ($fd);
echo '<meta http-equiv="refresh" content="0; url='.$_GET['returnurl'].'" />';
exit();
// example: place this kind of link into the document where the file download is offered:
// <a href="_public/download/index.php?download_file=some_file.pdf&ext=pdf">Download here</a>
?>