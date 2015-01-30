<?php
@require 'rd_config.php';
function sitemap($x=0){
$select = mysql_query("SELECT `idx`,`title`,`url` FROM `website_menu` WHERE `cat_id`='".(int)$x."' AND `visibility`=0 AND `status`=0 ORDER BY `position` ASC ");
if(mysql_num_rows($select))
{
$out = '';
while($rows = mysql_fetch_array($select))
{
if(!preg_match("/http:/",$rows['url'])){
$out .= '<url><loc>http://moc.gov.ge/'.$rows['url'].'</loc></url>';		
}				
$out .= sitemap($rows['idx']);
}
}
return $out;
}
header("Content-type: text/xml");
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?=sitemap(0)?>
</urlset>