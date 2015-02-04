<?php
$lang_file = ADMIN_FOLDER."/cache/".$_GET['lang']."_l.php";
@require($lang_file); 
if(!$_SESSION["sendNum"]){
	$_SESSION["sendNum"] = 1;
}else{
	if($_SESSION["sendNum"]<=14){
		$add = $_SESSION["sendNum"] + 1;
		$_SESSION["sendNum"] = $add;
	}
}
if($_SESSION["sendNum"] > 15){
	echo "1"; // error
}else{
	/*
	** get user ip
	*/
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {  //check ip from share internet
		$ip=$_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  //to check ip is pass from proxy
		$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip=$_SERVER['REMOTE_ADDR'];
	}
	/*
	** host name
	*/
	$host = gethostbyaddr($ip); 
	$date = date("d/m/Y H:m:s");
	
	if(isset($_POST["namelname"],$_POST["email"],$_POST["text"]) && !empty($_POST["namelname"]) && !empty($_POST["email"]) && !empty($_POST["text"])){
		$to = 'giorgigvazava87@gmail.com'; 
		$subject = 'Dmark.ge';
		$headers = "From: " . strip_tags($_POST['email']) . "\r\n";
		$headers .= "Reply-To: ". strip_tags($_POST['email']) . "\r\n";
		//$headers .= "CC: gvazavag@yahoo.com\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=utf-8\r\n";
		$message = '<html><body>';
		$message .= '<h1>შეტყობინება</h1>';
		$message .= '<b>IP მისამართი:</b> <i>'.$ip.'</i><br />';
		$message .= '<b>Host:</b> <i>'.$host.'</i><br />';
		$message .= '<b>Date:</b> <i>'.$date.'</i><br />';
		$message .= '<b>Name and Surname:</b> <i>'.strip_tags(str_replace(array('"',"'"),array("“","“"),$_POST["namelname"])).'</i><br />';
		$message .= '<b>Email:</b> <i>'.strip_tags(str_replace(array('"',"'"),array("“","“"),$_POST["email"])).'</i><br />';
		$message .= '<b>Message:</b> <i>'.strip_tags(str_replace(array('"',"'"),array("“","“"),$_POST["text"])).'</i><br />';
		$message .= '</body></html>';
		$m = mail($to, $subject, $message, $headers);
		if($m==true){ 
			echo 2; // done 
		}else{ 
			echo 1; // error 
		}
	}else{
		echo 1; // error
	}
}
?>