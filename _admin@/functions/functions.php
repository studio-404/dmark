<?php
/*
** studio 404's Functions
** 2013
*/
function _title_404()
{
return 'Admin Panel 1.2';
}
function _post_404($post)
{
$p = mysql_real_escape_string($post);  
return strip_tags($p);
}
function _desc_strip($post)
{
/*$string = str_replace("<div><br></div>","<br>", $post);
$string = str_replace("</div>","", $string);
$search = array('<div>','</p>','<span>');
$replace = array('<br><div>','<br><br /></p>','<br><span>');
$string = str_replace($search, $replace, $string);*/
$string = mysql_real_escape_string($post);
//$string = strip_tags($string,'<br><a><i><em><b><u><strong><ul><li><sup><sub><ul><li><table><thead><tbody><th><tr><td><h4><img><map><area>');
return $string;
}
function _refresh_404($url)
{
header("Location: ".$url."");
echo '<meta http-equiv="refresh" content="0; url='.$url.'"/>';
exit();
}
function _select_language_by_id($id,$column)
{
$select = mysql_query("SELECT * FROM languages WHERE status!=1 AND id='".$id."' ");
$row=mysql_fetch_array($select);
return $row[$column];
}
function _create_file_404($file,$data) {
if(!file_exists($file))
{
$f=fopen($file, "wb");
fwrite($f, $data);
fclose($f);
}	
}
function _copy_file_404($file,$newfile){
	if (!copy($file, $newfile)) {
		echo "Error occured, Cant copy file";
	}
}
function _select_type_404($check_type)
{
if(isset($_GET[type]))
{ 
$type=$_GET[type]; 
}
else
{
$type="";
}
if($check_type==$type)
{
$out='selected="selected"';
}
else
{
$out='';
}
return $out;
}
function _select_mtype_404($check_type)
{
if(isset($_GET[menuType]))
{ 
$type=$_GET[menuType]; 
}
else
{
$type="";
}
if($check_type==$type)
{
$out='selected="selected"';
}
else
{
$out='';
}
return $out;
}
function _current_page_404($url)
{
$explode = explode(",",$url);
$page=$_GET['404'];
if(in_array($page,$explode))
{
$p = "mega-current";
}
else
{
$p="";
}
return $p;
}
function get_linked($idx,$langs)
{
$select = mysql_query("SELECT * FROM site_menu WHERE status!=1 AND idx='".$idx."' AND langs='".$langs."' ");
$rows = mysql_fetch_array($select);
if(!$select){ echo mysql_error; }
return $rows['name'];
}
function _count_photos($type,$connect_id)
{
$select = mysql_query("SELECT gallery_attachment.idx as ga_idx, gallery_attachment.connect_id as ga_connect_id, gallery_attachment.gallery_id as ga_gallery_id, gallery_attachment.langs as ga_langs, gallery_attachment.type as ga_type, 
gallery.id as g_id, gallery.langs as g_langs, gallery.status as g_status, 
gallery_photos.gallery_id as gp_gallery_id, gallery_photos.langs as gp_langs, gallery_photos.status as gp_status 
FROM gallery_attachment, gallery, gallery_photos 
WHERE gallery_attachment.connect_id='".(int)$connect_id."' AND 
gallery_attachment.langs='geo' AND 
gallery_attachment.type='"._post_404($type)."' AND 
gallery_attachment.gallery_id=gallery.id AND 
gallery.status!=1 AND 
gallery_photos.gallery_id=gallery.id AND 
gallery_photos.langs='geo' AND 
gallery_photos.status!=1");
$result = mysql_num_rows($select);
return $result;
}
function _check_exists_404($type,$idx)
{
if($type=="catalog"){ $table="catalogs"; }
else if($type=="news"){ $table="content_news"; }
else if($type=="text"){ $table="content_text"; }
$select=mysql_query("SELECT * FROM $table WHERE idx='".$idx."' ");
if(mysql_num_rows($select)<=0)
{
_refresh_404('home');
exit();
}
}
function _path_404()
{
if(isset($_GET['404']))
{
$page = $_GET['404'];
if($page=="languages")
{
$link="languages";
$name="Languages";
$out = '<a href="'.$link.'">'.$name.'</a>';
}
else if($page=="editLanguages")
{
$select = mysql_query("SELECT * FROM languages WHERE id='".(int)$_GET['lang_id']."' ");
$rows = mysql_fetch_array($select);
$link="languages";
$link2="editLanguages-".(int)$_GET['lang_id'];
$name="Languages";
$name2=$rows['name'];
$out = '<a href="'.$link.'">'.$name.'</a> -&#62; <a href="'.$link2.'">'.$name2.'</a>';
}
else if($page=="addLanguages")
{
$link="languages";
$link2="addLanguages";
$name="Languages";
$name2="Add";
$out = '<a href="'.$link.'">'.$name.'</a> -&#62; <a href="'.$link2.'">'.$name2.'</a>';
}
else if($page=="page")
{
if(isset($_GET[lang])){ $m="-".$_GET[lang]; }
else{ $m=''; }
$link="page".$m;
$name="Site Pages";
$out = '<a href="'.$link.'">'.$name.'</a>';
}
else if($page=="editpage")
{
$select = mysql_query("SELECT * FROM site_menu WHERE id='".(int)$_GET['edit']."' ");
$rows = mysql_fetch_array($select);
$link="page";
$link2="editpage-".(int)$_GET['edit'];
$name="Site Pages";
$name2=$rows['name'];
$out = '<a href="'.$link.'">'.$name.'</a> -&#62; <a href="'.$link2.'">'.$name2.'</a>';
}
else if($page=="addPage")
{
if(isset($_GET[type])){ $m="-".$_GET[type]; }
else{ $m=''; }
$link="page";
$link2="addPage".$m;
$name="Site Pages";
$name2="Add";
$out = '<a href="'.$link.'">'.$name.'</a> -&#62; <a href="'.$link2.'">'.$name2.'</a>';
}
else if($page=="query")
{
if(isset($_GET[lang])){ $m="-".$_GET[lang]; }
else{ $m=''; }
$link="query".$m;
$name="Query";
$out = '<a href="'.$link.'">'.$name.'</a>';
}
else if($page=="addNews")
{
$link="query";
$link2="addNews";
$name="Query";
$name2="Add News";
$out = '<a href="'.$link.'">'.$name.'</a> -&#62; <a href="'.$link2.'">'.$name2.'</a>';
}
else if($page=="addCatalog")
{
$link="query";
$link2="addCatalog";
$name="Query";
$name2="Add Catalog Item";
$out = '<a href="'.$link.'">'.$name.'</a> -&#62; <a href="'.$link2.'">'.$name2.'</a>';
}
else if($page=="edit")
{
$select = mysql_query("SELECT * FROM content_text WHERE id='".(int)$_GET['edit']."' ");
$rows = mysql_fetch_array($select);
$link="query";
$link2="edit-".$_GET[type]."-".(int)$_GET['edit'];
$name="Query";
$name2=$rows['title'];
$out = '<a href="'.$link.'">'.$name.'</a> -&#62; <a href="'.$link2.'">'.$name2.'</a>';
}
else if($page=="editNews")
{
$select = mysql_query("SELECT * FROM content_news WHERE id='".(int)$_GET['edit']."' ");
$rows = mysql_fetch_array($select);
$link="query";
$link2="editNews-".(int)$_GET['edit'];
$name="Query";
$name2=$rows['title'];
$out = '<a href="'.$link.'">'.$name.'</a> -&#62; <a href="'.$link2.'">'.$name2.'</a>';
}
else if($page=="editCatalog")
{
$select = mysql_query("SELECT * FROM catalogs WHERE id='".(int)$_GET['edit']."' ");
$rows = mysql_fetch_array($select);
$link="query";
$link2="editCatalog-".(int)$_GET['edit'];
$name="Query";
$name2=$rows['title'];
$out = '<a href="'.$link.'">'.$name.'</a> -&#62; <a href="'.$link2.'">'.$name2.'</a>';
}
else if($page=="editor")
{
$select = mysql_query("SELECT * FROM site_menu WHERE file_name='".$_GET['filename']."' ");
$rows = mysql_fetch_array($select);
$link="editor";
$link2="editor-".$_GET['filename'];
$name="Editor";
$name2=$rows['name'];
if(isset($_GET['filename']))
{
if($name2==""){ $name2="Test"; }
if($link2==""){ $link2="test.php"; }
$out = '<a href="'.$link.'">'.$name.'</a> -&#62; <a href="'.$link2.'">'.$name2.'</a>';
}
else
{
$out = '<a href="'.$link.'">'.$name.'</a>';
}
}
else if($page=="gallery")
{
if(isset($_GET[lang])){ $m="-".$_GET[lang]; }
else{ $m=''; }
$link="gallery".$m;
$name="Gallery";
$out = '<a href="'.$link.'">'.$name.'</a>';
}
else if($page=="addGallery")
{
$link="gallery";
$name="Gallery";
$link2="addGallery";
$name2="Add Gallery";
$out = '<a href="'.$link.'">'.$name.'</a> -&#62; <a href="'.$link2.'">'.$name2.'</a>';
}
else if($page=="editgallery")
{
$link="gallery";
$name="Gallery";
$link2="editgallery-".(int)$_GET['gallery_id'];
$name2="Edit Gallery";
$out = '<a href="'.$link.'">'.$name.'</a> -&#62; <a href="'.$link2.'">'.$name2.'</a>';
}
else if($page=="gallery_photo")
{
$link="gallery";
$name="Gallery";
$link2=_current_url_404();
$name2="Gallery Photos";
$out = '<a href="'.$link.'">'.$name.'</a> -&#62; <a href="'.$link2.'">'.$name2.'</a>';
}
else if($page=="photo")
{
$select = mysql_query("SELECT * FROM gallery_photos WHERE id='".(int)$_GET['edit']."' ");
$rows = mysql_fetch_array($select);
$link="gallery";
$name="Gallery";
$link2="photo-".(int)$_GET[lang]."-".(int)$_GET['edit'];
$name2=$rows['title'];
if($name2==""){ $name2="No Title"; }
$out = '<a href="'.$link.'">'.$name.'</a> -&#62; <a href="'.$link2.'">'.$name2.'</a>';
}
else if($page=="settings")
{
$link="settings";
$name="Settings";
$out = '<a href="'.$link.'">'.$name.'</a>';
}
else if($page=="adminsettings")
{
$link="adminsettings";
$name="Admin Settings";
$out = '<a href="'.$link.'">'.$name.'</a>';
}
else if($page=="edittable")
{
$link="query-".$_GET[lang]."-table";
$name="Table";
$link2="edittable-".$_GET['idx'];
$name2="Edit table";
$out = '<a href="'.$link.'">'.$name.'</a> -&#62; <a href="'.$link2.'">'.$name2.'</a>';
}
else if($page=="editJq")
{
$link="editJq-".$_GET[edit];
$name="Question And Answers";
$out = '<a href="'.$link.'">'.$name.'</a>';
}
else if($page=="addJq")
{
$link="addJq";
$name="Add Question And Answers";
$out = '<a href="'.$link.'">'.$name.'</a>';
}
else if($page=="poll")
{
$link="poll";
$name="Poll";
$out = '<a href="'.$link.'">'.$name.'</a>';
}
else if($page=="addPoll")
{
$link="addPoll";
$name="Add Poll";
$out = '<a href="'.$link.'">'.$name.'</a>';
}
else if($page=="editPoll")
{
$link="editPoll";
$name="Edit Poll";
$out = '<a href="'.$link.'">'.$name.'</a>';
}
else if($page=="filemanager")
{
$link="filemanager";
$name="File manager";
$out = '<a href="'.$link.'">'.$name.'</a>';
}
}
return $out;
}
function _current_url_404()
{
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
return $actual_link;
}
function _admin_permission($id,$check)
{
switch($check)
{
case "language": 
$column="par_languages";
break;
case "addlanguage":
$column="par_language_add";
break;
case "deletelanguage":
$column="par_language_delete";
break;
case "deletepage":
$column="par_page_delete";
break;
case "editor":
$column="par_editor";
break;
case "gallery":
$column="par_gallery";
break;
case "adminName":
$column="pa_name";
break;
}
$select = mysql_query("SELECT 
panel_admins.id as pa_id, 
panel_admins.name as pa_name, 
panel_admin_rights.a_id as par_a_id, 
panel_admin_rights.languages as par_languages, 
panel_admin_rights.language_add as par_language_add, 
panel_admin_rights.language_delete as par_language_delete, 
panel_admin_rights.page_delete as par_page_delete, 
panel_admin_rights.editor as par_editor, 
panel_admin_rights.gallery as par_gallery 
FROM panel_admins, panel_admin_rights 
WHERE panel_admins.id='".(int)$id."' AND 
panel_admin_rights.a_id=panel_admins.id ");
$rows=mysql_fetch_array($select);
return $rows[$column];
}
function getadmin($id,$c)
{
$select=mysql_query("SELECT * FROM panel_admins WHERE id='".(int)$id."' ");
$rows=mysql_fetch_array($select);
return $rows[$c];
}
function cut_text($text,$number,$dots=false)
{
	if($dots){ $d=""; }else{ $d="..."; }
	$charset = 'UTF-8';
	$length = $number;
	$string = $text;
	if(mb_strlen($string, $charset) > $length) {
	$string = mb_substr($string, 0, $length, $charset) . $d;
	}
	else
	{
		$string=$text;
	}
	return stripslashes($string); 
}
function _outText($text)
{
	return html_entity_decode(stripslashes($text));
}

function pagination($sql,$path,$itemsPerPage)
{
	$out = array();
	$select = mysql_query($sql);
	$nr = mysql_num_rows($select);
	if(isset($_GET['pn'])){	
	$pn = preg_replace('#[^0-9]#i','',$_GET['pn']);
	}
	else{
	$pn = 1;
	}	
	$lastPage = ceil($nr / $itemsPerPage);
	if($pn < 1){
	$pn = 1;
	}
	else if($pn > $lastPage){
	$pn = $lastPage;	
	}	
	$centerPages = '';
	$sub1 = $pn-1; // 0
	$sub2 = $pn-2; // -1
	$add1 = $pn+1; // 2
	$add2 = $pn+2; // 3	
	if($pn==1){
	$centerPages .= '<li><a href="javascript:void(0)" class="active">'.$pn.'</a></li>';
	$centerPages .= '<li><a href="'.$path.$add1.'" class="bluBG">'.$add1.'</a></li>';
	}
	else if($pn == $lastPage){
	$centerPages .= '<li><a href="'.$path.$sub1.'" class="bluBG">'.$sub1.'</a></li>';
	$centerPages .= '<li><a href="javascript:void(0)" class="active">'.$pn.'</a></li>';
	}
	else if($pn > 2 && $pn < ($lastPage-1)){
	$centerPages .= '<li><a href="'.$path.$sub2.'" class="bluBG">'.$sub2.'</a></li>';
	$centerPages .= '<li><a href="'.$path.$sub1.'" class="bluBG">'.$sub1.'</a></li>';
	$centerPages .= '<li><a href="javascript:void(0)" class="active">'.$pn.'</a></li>';
	$centerPages .= '<li><a href="'.$path.$add1.'" class="bluBG">'.$add1.'</a></li>';
	$centerPages .= '<li><a href="'.$path.$add2.'" class="bluBG">'.$add2.'</a></li>';
	}
	else if($pn > 1 && $pn < $lastPage){
	$centerPages .= '<li><a href="'.$path.$sub1.'" class="bluBG">'.$sub1.'</a></li>';
	$centerPages .= '<li><a href="javascript:void(0)" class="active">'.$pn.'</a></li>';
	$centerPages .= '<li><a href="'.$path.$add1.'" class="bluBG">'.$add1.'</a></li>';
	}
	$limit = 'LIMIT '.($pn-1)*$itemsPerPage.','.$itemsPerPage;
	if($nr > 0)
	{
	$out[0] = $sql." $limit";
	}
	$paginationDisplay = '<ul class="pagination">';
	if($lastPage != 1){
	//$paginationDisplay1 = '<font id="texti">გვერდი: <strong>'.$pn.'</strong> სულ: '.$lastPage.' </font>';
	}
	if($pn != 1){
	$previous = $pn-1;
	$paginationDisplay .= '<li><a href="'.$path.'1" class="bluBG">'.l("first_page").'</a></li>';
	$paginationDisplay .= '<li><a id="back" href="'.$path.$previous.'" class="bluBG">'.l("back_page").'</a></li>';
	}
	$paginationDisplay .= $centerPages;
	if($pn != $lastPage){
	$nextPage = $pn+1;
	$paginationDisplay .= '<li><a id="next" href="'.$path.$nextPage.'" class="bluBG">'.l("next_page").'</a></li>';
	$paginationDisplay .= '<li><a href="'.$path.$lastPage.'" class="bluBG">'.l("last_page").'</a></li>';
	}
	$outputList = $paginationDisplay."</ul>";
	if($nr <= $itemsPerPage)
	{
		$outputList = "";
	}
	$n=1;
	$out[1]=$outputList;
	$out[2]=$nr;
	return $out;
}
function get_system_nav(){
	$select = mysql_query("SELECT * FROM `system_nav` WHERE `cat_id`=0 AND `langs`='" . (string) $_GET['lang'] . "' AND `status`!=1 AND `visibility`!=1 ORDER BY `position` ASC");
	//echo "SELECT * FROM system_nav WHERE cat_id=0 AND langs='" . (string) $_GET['lang'] . "' AND status!=1 AND visibility!=1 ORDER BY position ASC";
	
	$out = '<ul class="nav">';
	while ($rows = mysql_fetch_array($select)) {
		if(check_permission($rows['idx'])){
			$out .= '<li>';
			$out .= '<div class="' . $rows['icon_class'] . '"></div>';
			if ($rows['onclick']) {
				$out .= '<a href="' . $rows['url'] . '" onclick="' . (string) $rows['onclick'] . '">' . strtoupper($rows['text']) . '</a>';
			} else {
				$out .= '<a href="' . $rows['url'] . '" onclick="$(\'.sub_' . $rows['idx'] . '\').slideToggle(\'slow\')" '.active_menu($rows['url'],$rows['idx']).'>' . strtoupper($rows['text']) . '</a>';
			}

			$out .= '<div class="clear:both"></div>';
			$out .= sub_nav($rows['idx'], $_GET['lang']);
			$out .= '</li>';
		}
	}
	$out .= '</ul>';
	return $out;
}

function sub_nav($rows_id, $lang) {
        $select2 = mysql_query("SELECT * FROM `system_nav` WHERE `cat_id`='" . (int) $rows_id . "' AND `langs`='" . (string) $lang . "' AND `status`!=1 AND `visibility`!=1  ORDER BY `position` ASC");
		//echo "SELECT * FROM system_nav WHERE cat_id='" . (int) $rows_id . "' AND langs='" . (string) $lang . "' AND status!=1 ORDER BY position ASC";
        if (mysql_num_rows($select2)) {
            $out2 = '<ul class="sub_menu sub_' . $rows_id . '">';
            while ($rows2 = mysql_fetch_array($select2)) {
				if(check_permission($rows2['id'],true)){
					$explode = explode("/", URL);
					$addThis = rtrim($explode[0]."/".$explode[1]."/".$explode[2]);   
					$actives = ($addThis==$rows2['url']) ? 'class="active"' : '';
					$out2 .= '<li class="active"><a href="' . $rows2['url'] . '" '.active_menu($rows2['url'],$rows2['idx']).'>' . $rows2['text'] . '</a></li>';
				}
            }
            $out2 .= '</ul>';
        } else {
            $out2 = '';
        }
        return $out2;
    }
	
	
function topNav($lang) {
        $select = mysql_query("SELECT * FROM system_nav WHERE cat_id=0 AND langs='" . (string) $lang . "' AND status!=1 AND visibility!=1  ORDER BY position ASC");
        $out = '<ul>';
        while ($rows = mysql_fetch_array($select)) {
			if(check_permission($rows['idx'])){
				$out .= '<li>';     
				if ($rows['onclick']) {
				$out .= '<a href="' . $rows['url'] . '" onclick="' . (string) $rows['onclick'] . '"><div class="' . $rows['icon_class'] . '"></div></a>';
				}else{ 
				$out .= '<a href="' . $rows['url'] . '""><div class="' . $rows['icon_class'] . '"></div></a>';
				}
				$out .= topsub_nav($rows['idx'], $lang);
				$out .= '</li>';
			}
        }
        $out .= '</ul>';
        return $out;
 }
 
function topsub_nav($rows_id, $lang) {
        $select2 = mysql_query("SELECT * FROM system_nav WHERE cat_id='" . (int) $rows_id . "' AND langs='" . (string) $lang . "' AND status!=1 AND visibility!=1  ORDER BY position ASC");
        if (mysql_num_rows($select2)) {
            $out2 = '<ul class="dropdown">';
            while ($rows2 = mysql_fetch_array($select2)) {
				if(check_permission($rows2['id'],true)){
					$out2 .= '<li><a href="' . $rows2['url'] . '">' . $rows2['text'] . '</a></li>';
				}
            }
            $out2 .= '</ul>';
        } else {
            $out2 = '';
        }
        return $out2;
    }
	
function active_menu($url,$idx)
{
	$ac="";
	$getUrl =$_GET['lang']."/".$_GET['404'];
	if($url==$getUrl){
		$ac = 'class="active" ';
	}else{
		$getUrl .= "/".$_GET['show'];
		if($_GET['404']=="add" || $_GET['404']=="edit"){
			$getUrl = $_GET['lang']."/table/".$_GET['show'];
		}
		$select = mysql_query("SELECT text,url,cat_id FROM `system_nav` WHERE langs='".$_GET['lang']."' AND cat_id='".(int)$idx."' ");
		if(mysql_num_rows($select)){
			$url_array = array();
			while($rows = mysql_fetch_array($select)){
				$url_array[] = $rows['url'];
			}
			if(in_array($getUrl,$url_array)){
				$ac = 'class="active"';
			}else{
				$getUrl = $_GET['lang']."/".$_GET['404']."/".$_GET['show'];				
				if($getUrl==$rows['url']){
					$ac = 'class="active"';
				}else if(str_replace("/edit/","/add/",$getUrl)==$rows['url']){
					$ac = 'class="active"';
				}
			}
		}	
	}
	return $ac;
}

function l($var,$langs=false){
	$getLang = (!$langs) ? $_GET['lang'] : $langs;
	if($getLang) :
	$_404p = $getLang."_l.php";
	$path = ROOT."/".ADMIN_FOLDER."/cache/";

	if(!file_exists($path.$_404p))
	{
		ob_start();
		$out =" <?php ";
		$select = mysql_query("SELECT text,variable,langs FROM plain_text WHERE status!=1 AND langs='".mysql_real_escape_string($getLang)."' ");
		$nr = mysql_num_rows($select);
		if($nr){
			$x=1;
			while($rows = mysql_fetch_array($select)){ 
				$out .= " $".$rows['variable']."=\"".str_replace('"','\"',$rows['text'])."\";";
				$x++;
			}
		}
		$out .= " ?> ";
		echo $out;
		$data = ob_get_contents();
		ob_end_clean();
		_create_file_404($path.$_404p,$data);
		@include($path.$_404p);
	}
	else
	{
		@include($path.$_404p);
	}
	$show = $$var;
	endif;
	if($show==""){ $show='VAR: '.$var.'; LANG: '.$getLang; }
	return $show; 
}

function getOS() { 
    $user_agent=$_SERVER['HTTP_USER_AGENT'];
    $os_platform    =   "Unknown OS Platform";
    $os_array       =   array(
                            '/windows nt 6.3/i'     =>  'Windows 8.1',
                            '/windows nt 6.2/i'     =>  'Windows 8',
                            '/windows nt 6.1/i'     =>  'Windows 7',
                            '/windows nt 6.0/i'     =>  'Windows Vista',
                            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                            '/windows nt 5.1/i'     =>  'Windows XP',
                            '/windows xp/i'         =>  'Windows XP',
                            '/windows nt 5.0/i'     =>  'Windows 2000',
                            '/windows me/i'         =>  'Windows ME',
                            '/win98/i'              =>  'Windows 98',
                            '/win95/i'              =>  'Windows 95',
                            '/win16/i'              =>  'Windows 3.11',
                            '/macintosh|mac os x/i' =>  'Mac OS X',
                            '/mac_powerpc/i'        =>  'Mac OS 9',
                            '/linux/i'              =>  'Linux',
                            '/ubuntu/i'             =>  'Ubuntu',
                            '/iphone/i'             =>  'iPhone',
                            '/ipod/i'               =>  'iPod',
                            '/ipad/i'               =>  'iPad',
                            '/android/i'            =>  'Android',
                            '/blackberry/i'         =>  'BlackBerry',
                            '/webos/i'              =>  'Mobile'
                        );
    foreach ($os_array as $regex => $value) { 
        if (preg_match($regex, $user_agent)) {
            $os_platform    =   $value;
        }
    }   
    return $os_platform;
}

function getBrowser() {
	$user_agent=$_SERVER['HTTP_USER_AGENT'];
    $browser        =   "Unknown Browser";
    $browser_array  =   array(
                            '/msie/i'       =>  'Internet Explorer',
                            '/firefox/i'    =>  'Firefox',
                            '/safari/i'     =>  'Safari',
                            '/chrome/i'     =>  'Chrome',
                            '/opera/i'      =>  'Opera',
                            '/netscape/i'   =>  'Netscape',
                            '/maxthon/i'    =>  'Maxthon',
                            '/konqueror/i'  =>  'Konqueror',
                            '/mobile/i'     =>  'Handheld Browser'
                        );
    foreach ($browser_array as $regex => $value) { 
        if (preg_match($regex, $user_agent)) {
            $browser    =   $value;
        }
    }
    return $browser;
}

function check_permission($idx,$sub = false){ 
	if(isset($_SESSION['admin_id'],$_GET['lang'])){
		$column = ($sub) ? "sub" : "main";		
		$select = mysql_query("SELECT `".$column."` FROM `panel_admin_rights` WHERE `a_id`='".(int)$_SESSION['admin_id']."' AND `langs`='".mysql_real_escape_string($_GET["lang"])."' ");
		
		if(mysql_num_rows($select)){ 
			$rows = mysql_fetch_array($select);
			$ex = explode(",",$rows[$column]);
			if(in_array($idx,$ex)){ $out = true; }
			else{ $out = false; }
		}else{
			$out = false;
		}
	}else{
		$out = false;
	}
	return $out;
}

function check_permission_admin($idx, $get = false, $sub = false){ 
	if(isset($_SESSION['admin_id'],$_GET['lang'])){
		$column = ($sub) ? "sub" : "main";
		$value = ($get) ? $get : $_SESSION['admin_id'];
		$select = mysql_query("SELECT `".$column."` FROM panel_admin_rights WHERE a_id='".(int)$value."' AND `langs`='".strip($_GET["lang"])."' ");
		if(mysql_num_rows($select)){ 
			$rows = mysql_fetch_array($select);
			$ex = explode(",",$rows[$column]);
			if(in_array($idx,$ex)){ $out = true; }
			else{ $out = false; }
		}else{
			$out = false;
		}
	}else{
		$out = false;
	}
	return $out;
}

function get_bread(){
	$out = '<a href="'.$_GET['lang'].'/home">'.l("main").'</a> ';	
	if(isset($_GET['show'])){ 
		$url = $_GET['lang']."/".$_GET['404'].'/'.$_GET['show']; 		
		if(isset($_GET["item"])){ $u = "/".$_GET["item"];  }
		$select = mysql_query("SELECT text,url,cat_id FROM `system_nav` WHERE langs='".$_GET['lang']."' AND url='".mysql_real_escape_string($url)."' "); 
		if(mysql_num_rows($select)){
			$rows = mysql_fetch_array($select);
			$select2 = mysql_query("SELECT text,url FROM `system_nav` WHERE langs='".$_GET['lang']."' AND idx='".$rows['cat_id']."' ");
			if(mysql_num_rows($select2)){
				$rows2 = mysql_fetch_array($select2);
				$out .= htmlentities(">").' <a href="'.$rows2['url'].'">'.$rows2['text'].'</a> ';				
				if($_GET['404']!="table" && $_GET['show']!="slide"){
					$url2 = $_GET['lang']."/table/".$_GET['show'];
					$select3 = mysql_query("SELECT text,url FROM `system_nav` WHERE langs='".$_GET['lang']."' AND url='".mysql_real_escape_string($url2)."' "); 
					$rows3 = mysql_fetch_array($select3);
					if(isset($_GET['addid'])){ $addid = "/".$_GET['addid']; }else{ $addid = ""; }					
					$out_url = $rows3['url'].$addid.$edit;
					if(isset($_GET['edit'])&&$_GET['show']=="photo"){ $out_url = "javascript:void(0)"; }
					if(isset($_GET["item"])){ $it = "/".$_GET["edit"]; }
					if($_GET["show"]=="photo" && $_GET["404"]=="edit"){ 
					$select_gallery_id = mysql_query("SELECT `gallery_id` FROM `website_gallery_photos` WHERE `idx`='".(int)$_GET["edit"]."' ");
					$rows_gallery_id = mysql_fetch_array($select_gallery_id);
					$out_url=$_GET["lang"]."/table/photo/".$rows_gallery_id["gallery_id"]; 					
					}
					$out .= htmlentities(">").' <a href="'.$out_url.$it.'">'.$rows3['text'].'</a> ';
				}
			}
			$edit = (isset($_GET['edit'])) ? "/".$_GET['edit'] :"";
			$gallery_id = (isset($_GET['gallery_id'])) ? "/".$_GET['gallery_id'] :"";
			$item_idx = (isset($_GET['item'])) ? "/".$_GET['item'] :"";
			$out .= htmlentities(">").' <a href="'.$rows['url'].$edit.$gallery_id.$item_idx.'">'.$rows['text'].'</a> ';
		}		
	}else{ 
		$url = $_GET['lang']."/".$_GET['404'];
		$select = mysql_query("SELECT text,url,cat_id FROM `system_nav` WHERE langs='".$_GET['lang']."' AND url='".mysql_real_escape_string($url)."' "); 
		if(mysql_num_rows($select)){
			$rows = mysql_fetch_array($select);
			if(!$rows['cat_id'] && $_GET['404']!="home"){
				$out .= htmlentities(">").' <a href="'.$rows['url'].'">'.$rows['text'].'</a> ';	
			}
		}
	}
	return $out;
}
function getContent($title = false)
{
	if(isset($_GET['show'])){ $m = '/'.$_GET['show']; }else{ $m=""; }
	$url = $_GET['lang']."/".$_GET['404'].$m;
	$select = mysql_query("SELECT `id`,`idx`,`text` FROM `system_nav`  WHERE `url`='".$url."' AND `langs`='".$_GET['lang']."' ");
	if(!mysql_num_rows($select)){ die("Something not right code -- ".$url); }
	$rows = mysql_fetch_array($select);
	if($title){
		$out = $rows['text'];
		return $out;
	}else{
		global $p;
		$inc = "inc/".$_GET['show']."_".$_GET['404'].".php";
		if(file_exists($inc)){
			require_once($inc);
		}else{
			echo "Load problem ...";
		}
	}
}

function get_nav_for_rights($edit=false)
{
	$out="";
	$select = mysql_query("SELECT `id`,`idx`,`icon_class`,`text` FROM `system_nav` WHERE `cat_id`=0 AND `status`!=1 AND `langs`='".mysql_real_escape_string($_GET['lang'])."' AND `visibility`!=1 ORDER BY `position` ASC ");
	$check_x=1;
	while($rows = mysql_fetch_array($select))
	{
		if($rows['icon_class']=="icon-home" || $rows['icon_class']=="icon-signout"){ $dis = ' disabled="disabled" '; $che = ' checked="checked" '; }
		else{ $dis = ''; $che = ''; }
		
		$main_checked = ($edit && check_permission_admin($rows["idx"],$_GET["edit"])) ? 'checked="checked"' : '';
		
		$out .= '<label><input type="checkbox" name="rights['.$rows["idx"].']" value="'.$rows['idx'].'" '.$dis.$che.' id="mainx_'.$check_x.'" onclick="ch(\''.$check_x.'\')" '.$main_checked.' /> '.$rows['text'].'</label>';
		$sub_select = mysql_query("SELECT `id`,`icon_class`,`text` FROM `system_nav` WHERE `cat_id`='".$rows['idx']."' AND `status`!=1 AND `langs`='".mysql_real_escape_string($_GET['lang'])."' AND `visibility`!=1 ORDER BY `position` ASC");
		while($sub = mysql_fetch_array($sub_select))
		{
			$sub_checked = ($edit && check_permission_admin($sub["id"],$_GET["edit"],true)) ? 'checked="checked"' : '';
			$out .= '<label style="padding:2px 0px 2px 10px; background:#f2f2f2; width:780px"><input type="checkbox" name="sub_rights['.$sub["id"].']" value="'.$sub['id'].'" class="subx_'.$check_x.'" '.$sub_checked.' /> '.$sub['text'].'</label>';
		}
		$check_x++;
	}
	return $out;
}
function get_rights_checked($table)
{
	$out = false;
	$_panel_admin_rights = mysql_query("SELECT `".$table."` FROM panel_admin_rights WHERE a_id='".(int)$_GET['edit']."' ");
	if(mysql_num_rows($_panel_admin_rights)){
		$rows_admin_rights = mysql_fetch_array($_panel_admin_rights);
		if($rows_admin_rights[$table]){
			$out=true;
		}else{
			$out=false;
		}
	}else{
		$out=false;
	}
	return $out;
}
function select_admin_by_id($id,$column)
{
$select = mysql_query("SELECT ".$column." FROM `panel_admins` WHERE status!=1 AND id='".$id."' ");
$row=mysql_fetch_array($select);
return $row[$column];
}

function upload_file($allowedExts,$file,$maxSize,$path,$newName)
{
	$temp = explode(".", $_FILES[$file]["name"]);
	$extension = strtolower(end($temp));
	if ( ($_FILES[$file]["size"] < $maxSize) && in_array($extension, $allowedExts) ) 
	{
		if ($_FILES[$file]["error"] > 0) {
			$out = 0;
		} else {		
			if (file_exists($path . $_FILES[$file]["name"])) {
				$out = 0;
			} else {
				$new_name = $newName.".".$extension;
				move_uploaded_file($_FILES[$file]["tmp_name"], $path . $new_name);
				$out=1;
			}
		}
	} else {
	  $out=0;
	}
	return $out;
}

function multy_upload_files($allowedExts,$file,$x,$maxSize,$path,$newName){
	$temp = explode(".", $_FILES[$file]["name"][$x]);
	$extension = strtolower(end($temp));
	if ( ($_FILES[$file]["size"][$x] < 200000000) && in_array($extension, $allowedExts) ) 
	{
		if ($_FILES[$file]["error"][$x] > 0) {
			$out = 0;
		} else {		
			$new_name = $newName.".".$extension;
			move_uploaded_file($_FILES[$file]["tmp_name"][$x], $path . $new_name);
			$out=1;
		}
	} else {
	  $out=0;
	}
	return $out;
}

function select_sub_menus($idx)
{
	$out = false;
	$select = mysql_query("SELECT * FROM website_menu WHERE cat_id='".(int)$idx."' AND langs='".mysql_real_escape_string($_GET['lang'])."' AND status!=1 AND visibility!=1 ORDER BY position ASC");
	if(mysql_num_rows($select))
	{
		$out = array();
		while($rows = mysql_fetch_array($select))
		{
			$out['id'][] = $rows['id'];
			$out['idx'][] = $rows['idx'];
			$out['title'][] = $rows['title'];
			$out['url'][] = $rows['url'];
			$out['type'][] = $rows['type'];
			$out['position'][] = $rows['position'];
			$out['show'][] = $rows['show'];
			$out['menu_type'][] = $rows['menu_type'];
		}
		
		if(is_array($out))
		{
			for($x=0;$x<=count($out['id']);$x++)
			{
				if($out['id'][$x]) :
					$dash="";
					for($y=1; $y<=$out['menu_type'][$x];$y++){
						$dash .= "-";
					}
				?>
					<tr style="background:#ccc">
						<td>
							<?php 
							if(count($out['id']) > 1) {
								if(($x+1)!=count($out['id'])) :
								?>
								<div class="plus" onclick="moveAction('plus','<?=$out['idx'][$x]?>','<?=$out['position'][$x]?>','<?=$out['menu_type'][$x]?>')"></div>
								<?php
								endif;
								if($x!=0) :
								?>
								<div class="minus" onclick="moveAction('minus','<?=$out['idx'][$x]?>','<?=$out['position'][$x]?>','<?=$out['menu_type'][$x]?>')"></div>
								<?php 
								endif;
							}
							?>
						</td>
						<td><?=$out['idx'][$x]?></td>
						<td><?=$out['menu_type'][$x]?></td>
						<td><?=$out['position'][$x]?></td>
						<td title="<?=$out['title'][$x]?>"><?=cut_text($dash.$out['title'][$x],30)?></td>
						<td title="<?=$out['url'][$x]?>"><?=cut_text($out['url'][$x],30)?></td>
						<td><?=$out['type'][$x]?></td>
						<td>
							<div class="icon-add" title="<?=l("addSubmenu")?>"><a href="javascript:void(0)" onclick="sendPost(<?=$out['idx'][$x]?>)"></a></div>
							<div class="icon-url" title="<?=l("url")?>"><a href="<?=MAIN_DIR.$out['url'][$x]?>" target="_blank"></a></div>
							<?php 
							$vis = (!$out["show"][$x]) ? "opacity: 1; filter: alpha(opacity=100);" : "opacity: 0.4; filter: alpha(opacity=40);";
							$command = (!$out["show"][$x]) ? "in" : "vi";
							?>
							<div class="icon-view" title="<?=l("visibility")?>" style="<?=$vis?>"><a href="javascript:void(0)" onclick="openPop('change_vis.php?edit=<?=$out["idx"][$x]?>&command=<?=$command?>&lang=<?=$_GET['lang']?>')"></a></div>

							<div class="icon-edit" title="<?=l("edit")?>"><a href="<?=$_GET['lang']?>/edit/navigation/<?=$out['idx'][$x]?>"></a></div>
							<div class="icon-delete" title="<?=l("delete")?>"><a href="javascript:void(0)" onclick="delete_request('<?=$out['idx'][$x]?>','<?=l("delete_elem")?>,<?=l("delete")?>,<?=l("close")?>')"></a></div>
						</td>
					</tr>
				<?php
					echo select_sub_menus($out['idx'][$x]);
				endif;
			}
		}
	}
}
function menu_hierarchy($cat_id = 0){
	$select = mysql_query("SELECT idx,title,menu_type,cat_id FROM website_menu WHERE status!=1 AND cat_id='".(int)$cat_id."' AND langs='".mysql_real_escape_string($_GET['lang'])."' AND `visibility`=0  ORDER BY `position` ASC ");
	$out="";
	if(mysql_num_rows($select)){
		if(!$cat_id){
		$out = '<select name="step"><option value="0">'.l("choose").'</option>';
		}
		while($rows = mysql_fetch_array($select))
		{
			$nbsp = "";
			for($x=2;$x<=$rows['menu_type'];$x++){
				$nbsp .= " - ";
			}
			$p = ($_POST["from_nav_step"]==$rows['idx']) ? "selected='selected'" : "";
			$out .= '<option value="'.$rows['idx'].'" '.$p.'>'.$nbsp.$rows['title'].'</option>';
			$out .= menu_hierarchy($rows['idx']);
		}
		if(!$cat_id){
		$out .= '</select>';
		}
	}	
	return $out;
}

function get_gallery_idx($type,$idx)
{
	$select = mysql_query("SELECT 
	`website_gallery`.`idx` AS gallery_idx 
	FROM 
	`website_gallery_attachment`, `website_gallery` 
	WHERE 
	`website_gallery_attachment`.`connect_id`='".(int)$idx."' AND 
	`website_gallery_attachment`.`langs`='".mysql_real_escape_string($_GET['lang'])."' AND 
	`website_gallery_attachment`.`type`='".mysql_real_escape_string($type)."' AND 
	`website_gallery_attachment`.`gallery_idx`=`website_gallery`.`idx` AND 
	`website_gallery`.`langs`='".mysql_real_escape_string($_GET['lang'])."' AND 
	`website_gallery`.`status`!=1 
	");
	if(mysql_num_rows($select))
	{
		$rows = mysql_fetch_array($select);
		$out=$_GET['lang']."/table/photo/".$rows['gallery_idx'];
	}else{
		$out = 'javascript:void(0)';
	}
	//$out = "SELECT `gallery_idx` FROM `website_gallery_attachment` WHERE `connect_id`='".(int)$idx."' AND `type`='".mysql_real_escape_string($type)."' ";
	return $out;
}
function get_channel_name($channel_id)
{
	$select = mysql_query("SELECT `channel_name` FROM `website_youtube` WHERE `id`='".(int)$channel_id."' ");
	$rows = mysql_fetch_array($select);
	return $rows['channel_name'];
}
function str_limit($string, $max_length) 
{
	if (mb_strlen($string, 'UTF-8') > $max_length){
		$string = mb_substr($string, 0, $max_length, 'UTF-8');
		$pos = mb_strrpos($string, ' ', false, 'UTF-8');
		if($pos === false) {
			return ''.mb_substr($string, 0, $max_length, 'UTF-8').'…';
		}
		return ''.mb_substr($string, 0, $pos, 'UTF-8').'…';
	}else{
		return $string;
	}
}

function get_channels_opt()
{
	$out ="";
	$select = mysql_query("SELECT `id`,`channel_name` FROM `website_youtube` WHERE `status`!=1 ");
	while($rows = mysql_fetch_array($select))
	{
		if(!empty($rows["channel_name"]))
		$out .= "<option value='{$rows["id"]}'>".$rows["channel_name"]."</option>";
	}
	return $out;
}

function channel_info($cha_id)
{
	$select = mysql_query("SELECT * FROM `website_youtube` WHERE `id`='".(int)$cha_id."' AND `status`!=1 ");
	$rows = mysql_fetch_array($select);
	$out = array();
	$out["channel_name"] = $rows["channel_name"];
	$out["channel_link"] = $rows["channel_link"];
	$out["key"] = $rows["key"];
	$out["email"] = $rows["email"];
	$out["app_password"] = $rows["app_password"];
	return $out;
}

function youTube($api_key, $api_email, $api_password, $api_video, $api_video_title, $api_video_desc, $api_video_cat, $api_video_tags, $api_video_pri)
{
	$url = "http://akademqalaqiedu.ge/404@/_plugins/youtube/yAPI.php?developerKey=".$api_key."&username=".$api_email."&password=".$api_password."&filename=".$api_video."&title=".$api_video_title."&description=".$api_video_desc."&category=".$api_video_cat."&tags=".$api_video_tags."&private=".$api_video_pri;
	//$get_youtube_api = file_get_contents($url);
	$cron_job = "* * * * * wget -O - ".$url." >/dev/null 2>&1";
	return $url;	
}

function syncYoutube($channel_id, $from, $quentity)
{
	$select = mysql_query("SELECT `channel_username` FROM `website_youtube` WHERE `id`='".(int)$channel_id."' ");
	if(mysql_num_rows($select))
	{
		$rows = mysql_fetch_array($select); 
		$e = simplexml_load_file("http://gdata.youtube.com/feeds/api/users/".$rows["channel_username"]."/uploads/?start-index=".$from."&max-results=".$quentity);
		// echo "http://gdata.youtube.com/feeds/api/users/".$rows["channel_username"]."/uploads/?start-index=".$from."&max-results=".$quentity; 
		foreach($e->entry as $xml)
		{
			$title = $xml->title;
			$desc = $xml->content;
			foreach($xml->category[1]->attributes() as $key => $val){
				if($key == "term"){
					$cat = $val;
				}
			}
			foreach($xml->link[0]->attributes() as $key => $val)
			{
				if($key=="href"){
					$short1 = explode("http://www.youtube.com/watch?v=",$val);
					$short2 = explode("&feature=youtube_gdata",$short1[1]);
				
				$link = $val;
				$link_id = $short2[0];
				}
			}
			if(!empty($channel_id) && !empty($title) && !empty($desc) && !empty($cat) && !empty($link_id))
			{
				$check = mysql_query("SELECT `id` FROM `website_youtube_videos` WHERE `status`!=1 AND `channel_id`='".(int)$channel_id."' AND `video_link`='".mysql_real_escape_string($link_id)."' ");
				if(!mysql_num_rows($check))
				{
					$insert_date = time();
					$insert = mysql_query("INSERT INTO `website_youtube_videos` SET 
																			`date`='".(int)$insert_date."', 
																			`channel_id`='".(int)$channel_id."', 
																			`title`='".mysql_real_escape_string($title)."', 
																			`description`='".mysql_real_escape_string($desc)."', 
																			`category`='".mysql_real_escape_string($cat)."', 
																			`video_link`='".mysql_real_escape_string($link_id)."', 
																			`upload_status`='uploaded' 
																			");
				}
			}
		}
	}
}

function insert_language_items($table,$langs,$status=true){
	$show_sql = "SHOW COLUMNS FROM ".$table;
	$result = mysql_query($show_sql);
	$colums = "";
	$inserts = "";
	$insert_cols = array();
	if (mysql_num_rows($result) > 0) {
	
		while ($row = mysql_fetch_array($result)) {
			if($row["Field"]=="langs" || $row["Field"]=="id" || $row["Field"]==""){ continue; }
			$colums .= "`".$row["Field"]."`,";
			$insert_cols[] = $row["Field"];
		}			
		
		$colums = rtrim($colums, ",");
		$s = ($status) ? " AND `status`!=1" : ""; 
		$select_sql = "SELECT ".$colums." FROM ".$table." WHERE `langs`='ka' ".$s;
		$select = mysql_query($select_sql);
		if(mysql_num_rows($select) > 0){
			while($rows = mysql_fetch_array($select))
			{			
				foreach($insert_cols as $col){
					if($col!=" "){
						if($table == "website_menu" && $col=="url"){
							$val = str_replace("ka/",$langs."/",$rows[$col]);
							$inserts .= ', `'.$col.'`="'.mysql_real_escape_string($val).'", ';
						}else{
							$inserts .= ', `'.$col.'`="'.mysql_real_escape_string($rows[$col]).'", ';
						}
					}
				}
				
				$inserts = str_replace(', ,',', ',$inserts);
				$inserts = substr($inserts, 0, -2);
				$sql = "INSERT INTO `".$table."` SET `langs`='".$langs."'".$inserts;		
				$inserts = "";
				$insert_var = mysql_query($sql);
				
			}
		}
	}
}
function claerFolder($path){
	$files = glob($path); // get all file names
	foreach($files as $file){ // iterate files
	  if(is_file($file))
	  unlink($file); // delete file
	}
}

function select_languages($visibility=false){
	$o = array();
	$vis = ($visibility) ? " AND visibility!=1" : "";
	$select = mysql_query("SELECT `shortname` AS language, `outname` AS name, `img` AS image FROM `website_languages` WHERE `status`!=1 $vis");
	while($out = mysql_fetch_array($select))
	{
		$o["language"][] = $out["language"];
		$o["name"][] = $out["name"];
		$o["image"][] = $out["image"];
	}
	return $o;
}

function delete_language_items($a,$l){
	$sql = "DELETE FROM `".mysql_real_escape_string($a)."` WHERE langs='".mysql_real_escape_string($l)."'";
	$delete = mysql_query($sql);
	$path = "../public/css/".$l.".css";
	claerFolder($path);
	$path2 = "cache/*";
	claerFolder($path2);
}

function strip($val)
{ 
	//return mysql_real_escape_string(($val,"<i><b><p><span><strong><table><tbody><tr><td><th><em><stroke><ul><ol><li><img><a><br /><iframe><br><script><map><area>"));
	$out = mysql_real_escape_string($val);
	return $out;
}

function newsLetter($sender,$email,$subject,$href,$newsDate,$long_text)
{
	$text = '<img src="'.MAIN_DIR.'public/img/logo.png" width="116" height="136" align="left" style="margin:0px 15px 15px 15px" />';
	$text .= '<br /><hr style="width:100%; height:1px; background:#0030b8; margin:10px 0" />';
	$text .= '<h3>'.strip_tags($subject).'</h3>';
	$text .= '<em>'.date("d/m/Y",(int)$newsDate).'</em><br />';
	$text .= html_entity_decode($long_text);
	$text .= '<p><a href="'.$href.'" style="color:#0030b8">'.MAIN_DIR.'</a></p>';
	$headers = "From: " . strip_tags($sender) . "\r\n";
	$headers .= "Reply-To: ". strip_tags($sender) . "\r\n";
	$headers .= "CC: test@gmail.com\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
	$message = '<html><head><title>'.MAIN_DIR.' - newsletter</title></head><body style="background-image:url(\''.MAIN_DIR.'/public/img/pattern.png\'); padding:20px;">';
	$message .= wordwrap($text, 900, "\n");
	$message .= '</body></html>';
	$sended = mail($email, $subject, $message, $headers);
	return $sended;
}

function croned($type){
	$select_cronTime = mysql_query("SELECT `date` FROM `website_croned` WHERE `type`='".$type."' ");
	$cron = mysql_fetch_array($select_cronTime);
	$cron_time = date("Y-m-d H:i",$cron["date"]); 
	$niceTime = nicetime($cron_time); 
	return $niceTime;
}

function nicetime($date)
{
    if(empty($date)) {
        return "No date provided";
    } 
	$periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
    $lengths = array("60","60","24","7","4.35","12","10");
    $now = time();
    $unix_date = strtotime($date);
    // check validity of date
    if(empty($unix_date)) {    
        return "Bad date";
    }
     // is it future date or past date
    if($now > $unix_date) {    
        $difference = $now - $unix_date;
        $tense = "ago";
     } else {
        $difference = $unix_date - $now;
        $tense = "from now";
    }
     for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
        $difference /= $lengths[$j];
    }
     $difference = round($difference);
     if($difference != 1) {
        $periods[$j].= "s";
    }
     return "$difference $periods[$j] {$tense}";
}

function recurse_copy($src,$dst) {
    $dir = opendir($src);
    @mkdir($dst);
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
           if ( is_dir($src . '/' . $file) ) {
                recurse_copy($src . '/' . $file,$dst . '/' . $file);
            }
            else {
                copy($src . '/' . $file,$dst . '/' . $file);
            }
        }
    }
    closedir($dir);
}
function backup_tables($fileName,$tables='*')
{		
	//get all of the tables
	if($tables == '*')
	{
		$tables = array();
		$result = mysql_query('SHOW TABLES');
		while($row = mysql_fetch_row($result))
		{
			$tables[] = $row[0];
		}
	}
	else
	{
		$tables = is_array($tables) ? $tables : explode(',',$tables);
	}
	//cycle through
	foreach($tables as $table)
	{
		$result = mysql_query('SELECT * FROM '.$table);
		$num_fields = mysql_num_fields($result);
		$return .= 'DROP TABLE '.$table.';';
		$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
		$return.= "\n\n".$row2[1].";\n\n";
		for ($i = 0; $i < $num_fields; $i++) 
		{
			while($row = mysql_fetch_row($result))
			{
				$return.= 'INSERT INTO '.$table.' VALUES(';
				for($j=0; $j<$num_fields; $j++) 
				{
					$row[$j] = addslashes($row[$j]);
					$row[$j] = ereg_replace("\n","\\n",$row[$j]);
					if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
					if ($j<($num_fields-1)) { $return.= ','; }
				}
				$return.= ");\n";
			}
		}
		$return.="\n\n\n";
	}
	$handle = fopen($fileName,'w+');
	fwrite($handle,$return);
	fclose($handle);
}

function zip($p,$n)
{
	// Get real path for our folder
	$rootPath = realpath($p);
	// Initialize archive object
	$zip = new ZipArchive;
	$zip->open($n, ZipArchive::CREATE);
	// Initialize empty "delete list"
	$filesToDelete = array();
	// Create recursive directory iterator
	$files = new RecursiveIteratorIterator(
	new RecursiveDirectoryIterator($rootPath),
	RecursiveIteratorIterator::LEAVES_ONLY
	);
	foreach ($files as $name => $file) {
	// Get real path for current file
	$filePath = $file->getRealPath();

	// Add current file to archive
	$zip->addFile($filePath);

	// Add current file to "delete list" (if need)
	if ($file->getFilename() != 'important.txt') 
	{
		$filesToDelete[] = $filePath;
	}
	}
	// Zip archive will be created only after closing object
	$zip->close();
	// Delete all files from "delete list"
	foreach ($filesToDelete as $file)
	{
		claerFolder($file);
	}
}

function insert_action($type,$action,$actioned_idx){
	$admin_id = $_SESSION['admin_id'];
	$date = time();
	$ip = $_SERVER['REMOTE_ADDR'];
	$current_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$insert = mysql_query("
	INSERT INTO `website_actions` SET 
	`ip`='".strip($ip)."', 
	`admin_id`='".(int)$admin_id."', 
	`date`='".(int)$date."', 
	`type`='".strip($type)."', 
	`action`='".strip($action)."', 
	`actioned_idx`='".strip($actioned_idx)."', 
	`request_url`='".strip($current_url)."' 
	");
	echo mysql_error();
}

function randomPassword($nu,$nl="numbers&letters") {
	if($nl=="numbers&letters"){
		$a = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
	}else if($nl=="letters"){
		$a = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ";
	}else if($nl=="numbers"){
		$a = "0123456789";
	}
	$pass = array(); //remember to declare $pass as an array
	$alphaLength = strlen($a) - 1; //put the length -1 in cache
	for ($i = 0; $i < $nu; $i++) {
	$n = rand(0, $alphaLength);
	$pass[] = $a[$n];
	}
	return implode($pass); //turn the array into a string
}

function grand_admins(){
	$select = mysql_query("SELECT `id` FROM `panel_admins` WHERE `permition`=1 AND `status`!=1");
	while($rows = mysql_fetch_array($select)){
		$out[] = $rows["id"];
	}
	return $out;
}

function check_if_permition($table,$id = "",$idx = "",$additional=""){
	if(!empty($id)){ $w = " `id`='".(int)$id."' "; }
	if(!empty($idx)){ $w = " `idx`='".(int)$idx."' AND `langs`='".mysql_real_escape_string($_GET["lang"])."' "; }
	$check_permition = mysql_query("SELECT `access_admins` FROM `".mysql_real_escape_string($table)."` WHERE $w $additional ");
	
	if(mysql_num_rows($check_permition)){ 
		$access_rows = mysql_fetch_array($check_permition); 
		$admin_id = $_SESSION['admin_id'];
		$ex_access = explode(",",$access_rows["access_admins"]);
		
		if(in_array($admin_id,$ex_access)){ $admin_permition = true; }
		else{ $admin_permition = false; }
	}else{ $admin_permition = false; }
	return $admin_permition;
}

function rights($table,$id,$idx){
	if($id){ $w = " `id`='".(int)$id."' "; }
	if($idx){ $w = " `idx`='".(int)$idx."' AND `langs`='".strip(MAIN_LANGUAGE)."' "; }
	$check_permition = mysql_query("SELECT `access_admins` FROM `".strip($table)."` WHERE $w ");
	$out="";
	if(mysql_num_rows($check_permition)){ 
		$access_rows = mysql_fetch_array($check_permition); 
		$admin_id = $_SESSION['admin_id'];
		$ex_access = explode(",",$access_rows["access_admins"]);
		if(!in_array($admin_id,$ex_access)){ 
			$out = '<label>'.l("noRight").'</label>'; 
		}else{
			$select_all_admins = mysql_query("SELECT `id`,`name`,`access_admins`,`permition` FROM `panel_admins` WHERE `status`!=1");
			while($r = mysql_fetch_array($select_all_admins))
			{
				$checked = in_array($r["id"],$ex_access) ? 'checked="checked"' : '';
				$disabled = ($r["permition"] || $admin_id==$r["id"]) ? 'disabled="disabled"' : '';
				$out .= '<label for="i_'.$r["id"].'"> '.$r["name"].' <input type="checkbox" name="i[]" id="i_'.$r["id"].'" value="'.$r["id"].'" '.$checked.' '.$disabled .' /> </label><br />';
			}
			$out .= '<br /><input type="submit" class="submit" id="submit" value="'.l("edit").'" /><div class="closex" onclick="location.reload()">'.l("close").'</div>';
		}
	}
	return $out;
}

function change_permition($table,$id,$idx){
	if($id){ $w = " `id`='".(int)$id."' "; }
	if($idx){ $w = " `idx`='".(int)$idx."' "; } // AND `langs`='".strip(MAIN_LANGUAGE)."'
	$admin_id = ($_SESSION['admin_id']!=1) ? ",".$_SESSION['admin_id'] : '';
	$new_access = "1".$admin_id;
	if(isset($_POST["i"])){
		foreach($_POST["i"] as $i){
			$new_access .= ','.$i;
		}
		if($new_access){
			$update = mysql_query("UPDATE `".$table."` SET `access_admins`='".strip($new_access)."' WHERE $w ");
		}
	}else{
		$update = mysql_query("UPDATE `".$table."` SET `access_admins`='".strip($new_access)."' WHERE $w ");
	}
}

function insert_slide_from_news($news_item_idx,$news_idx)
{
	$select_max = mysql_query("SELECT MAX(`idx`) AS maxIdx, MAX(`position`) AS maxPos FROM `website_slider` WHERE `status`!=1");
	if(mysql_num_rows($select_max))
	{
		$max_row = mysql_fetch_array($select_max);	
		$maxIdx = $max_row["maxIdx"]+1;
		$maxPos = $max_row["maxPos"]+1;
	}else{
		$maxIdx = 1;
		$maxPos = 1;
	}
	$select_languages = select_languages(); 
	foreach($select_languages["language"] as $language)
	{	
		$select = mysql_query("
		SELECT 
		`website_news_items`.`date` AS wni_date, 
		`website_news_items`.`idx` AS wni_idx, 
		`website_news_items`.`news_idx` AS wni_news_idx, 
		`website_news_items`.`title` AS wni_title, 
		`website_news_items`.`short_text` AS wni_short_text, 
		`website_news_attachment`.`connect_id` AS wna_connect_id 
		FROM 
		`website_news`,`website_news_attachment`,`website_news_items`
		WHERE 
		`website_news`.`idx`='".(int)$news_idx."' AND 
		`website_news`.`langs`='".mysql_real_escape_string($language)."' AND 
		`website_news`.`status`!=1 AND 
		`website_news`.`idx`=`website_news_attachment`.`news_idx` AND 
		`website_news_attachment`.`langs`='".mysql_real_escape_string($language)."' AND 
		`website_news_attachment`.`news_idx`=`website_news_items`.`news_idx` AND 
		`website_news_items`.`idx`='".(int)$news_item_idx."' AND 
		`website_news_items`.`langs`='".mysql_real_escape_string($language)."' AND 
		`website_news_items`.`status`!=1 
		");	
		
		if(mysql_num_rows($select))
		{
			$rows = mysql_fetch_array($select);
			$item_date = $rows["wni_date"];
			$item_idx = $rows["wni_idx"];
			$news_idx = $rows["wni_news_idx"];
			$item_title = $rows["wni_title"];
			$item_text = $rows["wni_short_text"];
			$news_connect_id = $rows["wna_connect_id"];
			$select_image = mysql_query("
			SELECT 
			`website_gallery_photos`.`photo` AS p 
			FROM 
			`website_gallery_attachment`,`website_gallery`,`website_gallery_photos` 
			WHERE 
			`website_gallery_attachment`.`connect_id`='".(int)$item_idx."' AND 
			`website_gallery_attachment`.`langs`='".mysql_real_escape_string($language)."' AND 
			`website_gallery_attachment`.`type`='news' AND 
			`website_gallery_attachment`.`gallery_idx`=`website_gallery`.`idx` AND 
			`website_gallery`.`langs`='".mysql_real_escape_string($language)."' AND 
			`website_gallery`.`status`!=1 AND 
			`website_gallery`.`idx`=`website_gallery_photos`.`gallery_id` AND 
			`website_gallery_photos`.`langs`='".mysql_real_escape_string($language)."' AND 
			`website_gallery_photos`.`status`!=1 
			ORDER BY `website_gallery_photos`.`position` ASC LIMIT 1
			");
			if(mysql_num_rows($select_image))
			{
				$image_rows = mysql_fetch_array($select_image); 	
				$image_news = $image_rows["p"];
				
				$file_to_copy = ROOT."/image/gallery/".$image_news;
				$where = ROOT."/image/slide/slide_".$image_news;
				
				if(file_exists($file_to_copy)){	
					
					if(copy($file_to_copy,$where)){
						$newname = "slide_".$image_news;
						
						
						$admin_id = $_SESSION['admin_id'];
						$grand_id = implode(",",grand_admins());
						if(!in_array($admin_id,grand_admins())){
							$access_admins = $grand_id.",".$admin_id;
						}else{
							$access_admins = $grand_id;
						}
						
							$select_url = mysql_query("SELECT `url` FROM `website_menu` WHERE `idx`='".(int)$news_connect_id."' AND `status`!=1 AND `langs`='".mysql_real_escape_string($language)."' ");
							$url_rows = mysql_fetch_array($select_url);
							$gotourl = $url_rows["url"]."/".$item_idx."-".$item_title;
							// insert new slide
							$insert_slide = mysql_query("INSERT INTO `website_slider` SET 
																	`idx`='".(int)($maxIdx)."', 
																	`date`='".(int)$item_date."', 
																	`title`='".mysql_real_escape_string($item_title)."', 
																	`text`='".mysql_real_escape_string($item_text)."', 
																	`gotourl`='".mysql_real_escape_string($gotourl)."', 
																	`url_target`='_self', 
																	`image`='".mysql_real_escape_string($newname)."', 
																	`position`='".(int)($maxPos)."', 
																	`langs`='".mysql_real_escape_string($language)."', 
																	`access_admins`='".mysql_real_escape_string($access_admins)."' 
							");
						if(!mysql_error()){
							$msg = true;
						}else{
							$msg = false;
						}
					}else{
						$msg = false;
					}
				}else{
					$msg = false;
				}
			}else{
				$msg = false;
			}
		}else{
			$msg = false;
		}
	}
	return $msg; 
}

function check_sh($name)
{
	$out = "";
	$select = mysql_query("SELECT `status` FROM `website_sh` WHERE `name`='".mysql_real_escape_string($name)."' ");
	if(mysql_num_rows($select)){
		$rows = mysql_fetch_array($select);		
		if($rows["status"]){
			$out = 'checked="checked"';
		}
	}
	return $out;
}

function backspaceLink()
{
	$outLink="";
	$select = mysql_query("SELECT `connect_id`, `type` FROM `website_gallery_attachment` WHERE `gallery_idx`='".(int)$_GET["gallery_id"]."' ");
	if(mysql_num_rows($select)){
		$rows = mysql_fetch_array($select);
		if($rows["type"]=="text"){
			$outLink = $_GET["lang"]."/edit/text/".$rows["connect_id"];
		}else if($rows["type"]=="news"){
			$select_news = mysql_query("SELECT `news_idx` FROM `website_news_items` WHERE `idx`='".(int)$rows["connect_id"]."' ");
			if(mysql_num_rows($select_news)){
				$rows_news = mysql_fetch_array($select_news);
				$outLink = $_GET["lang"]."/edit/newsItem/".$rows_news["news_idx"]."/".$rows["connect_id"];
			}
		}else if($rows["type"]=="catalog"){
			$select_catalog = mysql_query("SELECT `catalog_id` FROM `website_catalogs_items` WHERE `idx`='".(int)$rows["connect_id"]."' ");
			if(mysql_num_rows($select_catalog)){
				$rows_catalog = mysql_fetch_array($select_catalog);
				$outLink = $_GET["lang"]."/edit/categoryItem/".$rows_catalog["catalog_id"]."/".$rows["connect_id"];
			}
		}
	}
	return $outLink;
}

/* function getYoutubeVideoId($url)
{
	$url = "";
	if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $url, $id)) {
	$values = $id[1];
	} else if (preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/', $url, $id)) {
	$values = $id[1];
	} else if (preg_match('/youtube\.com\/v\/([^\&\?\/]+)/', $url, $id)) {
	$values = $id[1];
	} else if (preg_match('/youtu\.be\/([^\&\?\/]+)/', $url, $id)) {
	$values = $id[1];
	} 	
	return $values;
} */

function getYoutubeVideoId($url) {
    $pattern = 
        '%^# Match any YouTube URL
        (?:https?://)?  # Optional scheme. Either http or https
        (?:www\.)?      # Optional www subdomain
        (?:             # Group host alternatives
          youtu\.be/    # Either youtu.be,
        |youtube(?:-nocookie)?\.com  # or youtube.com and youtube-nocookie
          (?:           # Group path alternatives
            /embed/     # Either /embed/
          | /v/         # or /v/
          | /watch\?v=  # or /watch\?v=
          )             # End path alternatives.
        )               # End host alternatives.
        ([\w-]{10,12})  # Allow 10-12 for 11 char YouTube id.
        %x'
        ;
    $result = preg_match($pattern, $url, $matches);
    if (false !== $result) {
        return $matches[1];
    }
    return false;
}

function getYoutubeImageSrc($url)
{
	$videoId = getYoutubeVideoId($url);
	$out = "http://img.youtube.com/vi/".$videoId."/1.jpg";
	return $out;
}

?>