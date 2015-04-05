<?php
//Third party library for sending e-mail.
require_once("PHPMailer/class.phpmailer.php");
require_once("PHPMailer/class.smtp.php");

//Extract form input.
$sender_name = htmlspecialchars(trim($_POST["sender_name"]));
$sender_email = htmlspecialchars(trim($_POST["sender_email"]));
$sender_message = htmlspecialchars(trim($_POST["sender_message"]));

if (!filter_var($sender_email, FILTER_VALIDATE_EMAIL)) {
	$message = "Please ensure that you have provided a valid e-mail address!";
    header("Location:contact_result.php?message=$message&success=0");
	exit;
}

//To guard against e-mail injection and spamming.
foreach($_POST as $value) {
	if ((stripos($value, 'Content-Type:') !== FALSE) OR ($_POST['spam_honeypot'] != '')) {
		$message = "I'm sorry, but there was a problem with your input.";
		header("Location:contact_result.php?message=$message&success=0");
		exit;
	}
}

$email_body = "Name: " . $sender_name . "\n" . "E-mail: " . $sender_email . "\n" . "Message: " . $sender_message;

//Send the e-mail.
$mail = new PHPmailer();
//$mail->SMTPDebug = 3;
$mail->IsSMTP();    
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'tls';
$mail->Host = "smtp.gmail.com";
$mail->Port = 587;
$mail->Username = "contactcommunityfund@gmail.com";
$mail->Password = "community693";
$mail->From = $sender_email;
$mail->FromName = $sender_name;
$mail->Body = $email_body;
$mail->addAddress("contactcommunityfund@gmail.com");                                                     
$mail->Subject = "User Commentary"; //Maybe add a new input field to the contact form later?

if(!$mail->send()) {
	$message = "We're sorry, but there was an error in attempting to send your message: " . $mail->ErrorInfo;
    header("Location:contact_result.php?message=$message&success=0");
} else {
	$message = "Thank you! You're message has been sent. We'll get back to you as soon as we are able!";
    header("Location:contact_result.php?message=$message&success=1");
}

//header('Refresh: 3;url=index.php');
?>