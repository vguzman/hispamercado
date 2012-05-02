<?php
require_once('class.phpmailer.php');

$mail = new phpmailer;

// Set mailer to use AmazonSES.
$mail->IsAmazonSES();

// Set AWSAccessKeyId and AWSSecretKey provided by amazon.
$mail->AddAmazonSESKey("<AWSAccessKeyId>", "<AWSSecretKey>");

// "From" must be a verified address.
$mail->From = "nobody@example.com";
$mail->FromName = "Nobody";

$mail->AddAddress("Somebody@example.com", "Somebody");
$mail->Subject = "A test mail from phpmailer using Amazon SES.";
$mail->Body = "Looks like it works!";
$mail->Send(); // send message

/* End of File */
