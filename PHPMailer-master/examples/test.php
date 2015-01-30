<?php
require '../PHPMailerAutoload.php';
$mail = new PHPMailer;
$mail->IsSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'mail.404.ge';                 // Specify main and backup server
$mail->Port = 26;                                    // Set the SMTP port
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'book@404.ge';                 // yes, I have entered my username mail
$mail->Password = 'gio123';           // yes, API key is here
$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
$mail->From = 'book@404.ge';
$mail->FromName = 'GIO';
if($test_mode) {
	$mail->SMTPDebug = 2;
	$mail->AddAddress('giorgigvazava87@gmail.com');
} else {
	$mail->AddAddress("giorgigvazava87@gmail.com");
}
$mail->IsHTML(true);                                  // Set email format to HTML
$mail->WordWrap = 70;                                 // Set word wrap to 70 characters
//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments

$mail->Subject = 'hey';
$mail->Body    = 'This is the HTML message body <strong>in bold!</strong>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->Send()) {
	//redirect to
	echo 'Message could not be sent.<br>';
	echo 'Mailer Error: ' . $mail->ErrorInfo;
	exit;
}