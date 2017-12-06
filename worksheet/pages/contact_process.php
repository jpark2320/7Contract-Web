<?php

	date_default_timezone_set('Etc/UTC');
	require('/PHPMailer/class.phpmailer.php');
 	require('/PHPMailer/class.smtp.php');
 	if (isset($_POST['email'])) {
 		$from = $_POST['email'];
 	}
 	if (isset($_POST['name'])) {
 		$name = $_POST['name'];
 	}
 	if (isset($_POST['message'])) {
 		$message = $_POST['message'];
 	}

 	$mail = new PHPMailer();
 	$mail->IsSMTP();
 	$mail->SMTPDebug = 1;
 	$mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
	$mail->SMTPAuth = true;
	$mail->SMTPAutoTLS = false;
	$mail->SMTPSecure = 'ssl';
 	$mail->Host = "ssl://smtp.gmail.com";
 	$mail->Port = 465;
 	$mail->IsHTML(true);
	$mail->Username = "7contractor@gmail.com";
	$mail->Password = "7contract.com";
	$mail->SetFrom($from, $name);
	$mail->addReplyTo($from, $name);
	$mail->AddAddress('sevencontract@gmail.com', 'Seven Contract');
	$mail->Subject = '[7 Contract] Message from '.$name;
	$mail->Body = $message;
	if (!$mail->send()) {
	    echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
	    echo "<script>
            alert(\"Message Successfully Sent!\");
            </script>";
	}
	echo '<script>window.location.href = "contact.php";</script>';
?>
