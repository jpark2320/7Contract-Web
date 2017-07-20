<?php

	date_default_timezone_set('Etc/UTC');
	require 'PHPMailer/PHPMailerAutoload.php';
	$mail = new PHPMailer;
	$mail->isSMTP();
	$mail->SMTPDebug = 0;
	$mail->Debugoutput = 'html';
	$mail->Host = 'smtp.gmail.com';
	$name = $_POST['name'];
	$from = $_POST['email'];
	$message = $_POST['message'];
	$mail->Port = 587;
	$mail->SMTPSecure = 'tls';
	$mail->SMTPAuth = true;
	$mail->Username = "7contractor@gmail.com";
	$mail->Password = "7contract.com";
	$mail->setFrom($from, $name);
	$mail->addReplyTo($from, $name);
	$mail->addAddress('sevencontract1@gmail.com', 'Seven Contract');
	$mail->Subject = '[7 Contract] Message from '.$name;
	$mail->Body    = $message;
	if (!$mail->send()) {
	    echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
	    echo "<script>
            alert(\"Message Successfully Sent!\");
            </script>";
	}
	echo '<script>window.location.href = "contact.php";</script>';
?>
