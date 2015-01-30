<?php

error_reporting(E_STRICT | E_ALL);

date_default_timezone_set('Asia/Tbilisi');

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="refresh" content="20" />
<?php
//Connect to the database and select the recipients from your mailing list that have not yet been sent to
//You'll need to alter this to match your database
@include("../../rd_config.php");

require '../PHPMailerAutoload.php';

$mail = new PHPMailer();

$body = file_get_contents('contents.html');

$mail->isSMTP();
$mail->Host = 'mail.404.ge';
$mail->SMTPAuth = true;
$mail->CharSet = 'UTF-8';
$mail->SMTPKeepAlive = true; // SMTP connection will not close after each email sent, reduces SMTP overhead
$mail->Port = 26;
$mail->Username = 'book@404.ge';
$mail->Password = 'gio123';
$mail->setFrom('contact@mgmholding.com', 'MGM HOLDING');
$mail->addReplyTo('contact@mgmholding.com', 'MGM HOLDING');

$mail->Subject = "სიახლე! უფასო სერვისი";

//Same body for all messages, so set this before the sending loop
//If you generate a different body for each recipient (e.g. you're using a templating system),
//set it inside the loop
$mail->msgHTML($body);
//msgHTML also sets AltBody, so if you want a custom one, set it afterwards
$mail->AltBody = 'მესიჯის სანახავათ გთხოვთ გამოიყენოთ html წამკითხველი!';
//$mail->AddEmbeddedImage('http://book.404.ge/public/img/bg.png', 'logo_2u');

$result = mysql_query("SELECT `profile_name`, `profile_email` FROM `__profiles` WHERE `sent` != 1 ORDER BY `id` ASC LIMIT 50");

while ($row = mysql_fetch_array($result)) {
	 //Mark it as sent in the DB
   mysql_query(
        "UPDATE `__profiles` SET `sent` = 1 WHERE `profile_email` = '" . mysql_real_escape_string($row['profile_email']) . "'"
    );
	if(!filter_var($row['profile_email'], FILTER_VALIDATE_EMAIL))
	{
		continue;
	}
    $mail->addAddress($row['profile_email'], $row['profile_name']);
    //$mail->addStringAttachment($row['photo'], 'YourPhoto.jpg'); //Assumes the image data is stored in the DB

    if (!$mail->send()) {
        echo "Mailer Error (" . str_replace("@", "&#64;", $row["profile_email"]) . ') ' . $mail->ErrorInfo . '<br />';
        break; //Abandon sending
    } else {
        echo "Message sent to :" . $row['profile_name'] . ' (' . str_replace("@", "&#64;", $row['profile_email']) . ')<br />';
    }
    // Clear all addresses and attachments for next loop
    $mail->clearAddresses();
    //$mail->clearAttachments();
}
$select_sent = mysql_query("SELECT `id` FROM `__profiles` WHERE `sent`=1");
echo "<strong>SENT: <i>".mysql_num_rows($select_sent)."<i></strong>";
/*
	$mails = array("giorgigvazava87@gmail.com"=>"გიო გვაზავა","kategvazava@gmail.com"=>"ქეთევან გვაზავა");
	
	foreach($mails as $m => $n){
	$mail->addAddress($m,"სტუდია 404");
    //$mail->addStringAttachment($row['photo'], 'YourPhoto.jpg'); //Assumes the image data is stored in the DB

    if (!$mail->send()) {
        echo "Mailer Error (" . str_replace("@", "&#64;", $m) . ') ' . $mail->ErrorInfo . '<br />';
    } else {
        echo "Message sent to :" . $n . ' (' . str_replace("@", "&#64;", $m) . ')<br />';

    }
    // Clear all addresses and attachments for next loop
    $mail->clearAddresses();
    //$mail->clearAttachments();
	}
	*/