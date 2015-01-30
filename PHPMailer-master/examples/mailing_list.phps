<?php

error_reporting(E_STRICT | E_ALL);

date_default_timezone_set('Asia/Tbilisi');

//Connect to the database and select the recipients from your mailing list that have not yet been sent to
//You'll need to alter this to match your database
@include("../../rd_config.php");

require '../PHPMailerAutoload.php';

$mail = new PHPMailer();

$body = file_get_contents('contents.html');

$mail->isSMTP();
$mail->Host = 'smtp.example.com';
$mail->SMTPAuth = true;
$mail->SMTPKeepAlive = true; // SMTP connection will not close after each email sent, reduces SMTP overhead
$mail->Port = 25;
$mail->Username = 'book@404.ge';
$mail->Password = 'gio123';
$mail->setFrom('book@404.ge', 'სტუდია 404');
$mail->addReplyTo('book@404.ge', 'სტუდია 404');

$mail->Subject = "მომსახურების ფასების მთვლელი";

//Same body for all messages, so set this before the sending loop
//If you generate a different body for each recipient (e.g. you're using a templating system),
//set it inside the loop
$mail->msgHTML($body);
//msgHTML also sets AltBody, so if you want a custom one, set it afterwards
$mail->AltBody = 'მესიჯის სანახავათ გთხოვთ გამოიყენოთ html წამკითხველი!';



/*
$result = mysql_query("SELECT `profile_name`, `profile_email` FROM `profile_website` WHERE `sent` != 1");

while ($row = mysql_fetch_array($result)) {
    $mail->addAddress($row['profile_email'], $row['profile_name']);
    //$mail->addStringAttachment($row['photo'], 'YourPhoto.jpg'); //Assumes the image data is stored in the DB

    if (!$mail->send()) {
        echo "Mailer Error (" . str_replace("@", "&#64;", $row["profile_email"]) . ') ' . $mail->ErrorInfo . '<br />';
        break; //Abandon sending
    } else {
        echo "Message sent to :" . $row['profile_name'] . ' (' . str_replace("@", "&#64;", $row['profile_email']) . ')<br />';
        //Mark it as sent in the DB
        mysql_query(
            "UPDATE `profile_website` SET `sent` = 1 WHERE `profile_email` = '" . mysql_real_escape_string($row['profile_email']) . "'"
        );
    }
    // Clear all addresses and attachments for next loop
    $mail->clearAddresses();
    //$mail->clearAttachments();
}
*/

	$mail->addAddress("giorgigvazava87@gmail.com","გიორგი გვაზავა");
    //$mail->addStringAttachment($row['photo'], 'YourPhoto.jpg'); //Assumes the image data is stored in the DB

    if (!$mail->send()) {
        echo "Mailer Error (" . str_replace("@", "&#64;", "giorgigvazava87@gmail.com") . ') ' . $mail->ErrorInfo . '<br />';
        break; //Abandon sending
    } else {
        echo "Message sent to :" . "გიორგი გვაზავა" . ' (' . str_replace("@", "&#64;", "giorgigvazava87@gmail.com") . ')<br />';

    }
    // Clear all addresses and attachments for next loop
    $mail->clearAddresses();
    //$mail->clearAttachments();
