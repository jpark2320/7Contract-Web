<?php
	
	date_default_timezone_set('Etc/UTC');
	require 'PHPMailer/PHPMailerAutoload.php';
	//Create a new PHPMailer instance
	$mail = new PHPMailer();
	$mail->isSMTP();
	$mail->SMTPDebug = 0;

	$mail->Debugoutput = 'html';
	$mail->Host = 'smtp.gmail.com';

	$mail->Port = 587;
	$mail->SMTPSecure = 'tls';
	$mail->SMTPAuth = true;
	$mail->Username = "7contractor@gmail.com";
	$mail->Password = "7contract.com";
	$from = $_POST['name'];
	$email = $_POST['email'];
	$message = $_POST['message'];
	$mail->setFrom($email, $from);
	$mail->addReplyTo($email, $from);
	$mail->addAddress('leepogii@gmail.com', 'Min Ho Lee');
	$mail->Subject = 'Email from 7Contract.com by '.$from;
	$mail->Body    = $message;

	if (!$mail->send()) {
	    echo "<script>alert(\"The message sent failed\")</script>";// . $mail->ErrorInfo;
	} else {
	    echo "<script>alert(\"Message has been sent succesfully\")</script>";
	}
	echo '<script>window.location.href = "index.php";</script>';
?>