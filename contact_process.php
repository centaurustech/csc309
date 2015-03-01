<?php
//Third party library for sending e-mail.
require_once("PHPMailer/class.phpmailer.php");

//Extract form input.
$sender_name = trim($_POST["sender_name"]);
$sender_email = trim($_POST["sender_email"]);
$sender_message = trim($_POST["sender_message"]);

//Validate form input.
if ($sender_name == "" OR $sender_email == "" OR $sender_message == "") {
	echo "Please make sure to fill out all of the areas of the contact form.";
	exit;
}

if (!filter_var($sender_email, FILTER_VALIDATE_EMAIL)) {
    echo "Please ensure that you have provided a valid e-mail address.";
	exit;
}

//To guard against e-mail injection.
foreach($_POST as $value) {
	if (stripos($value, 'Content-Type:') !== FALSE) {
		echo "I'm sorry, but there was a problem with the input you entered.";
		exit;
	}
}

$email_body = "Name: " . $sender_name . "\n" . "E-mail: " . $sender_email . "\n" . "Message: " . $sender_message;

//Send the e-mail.
$mail = new PHPmailer;
//Might not need this.
/*$mail.isSMTP();    
$mail->isHTML(true);  */
$mail->From = $sender_email;
$mail->FromName = $sender_name;
$mail->Body = $email_body;
$mail->addAddress("bungalo1@hotmail.com");                                                     
$mail->Subject = "User Commentary"; //Maybe add a new input field later?

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}

//TODO: Add a client side script to bring up a dialogue box confirming that the message was sent.
?>