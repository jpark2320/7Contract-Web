<?php
    // connection with mysql database
    include('./includes/connection.php');

    $message = $_POST['assign_message'];
    $arr = $_SESSION['workersArray'];

    $i_num = $_SESSION['i_num'];
    $i_num = substr($i_num, 2);
    $a_num = $_SESSION['a_num'];
    $u_num = $_SESSION['u_num'];

    date_default_timezone_set('Etc/UTC');
    require 'PHPMailer/PHPMailerAutoload.php';
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->Debugoutput = 'html';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Username = "7contractor@gmail.com";
    $mail->Password = "7contract.com";
    $mail->setFrom('sevencontract1@gmail.com', 'Seven Contract');
    $mail->addReplyTo('sevencontract1@gmail.com', 'Seven Contract');

    for ($i = 0; $i < sizeof($arr); $i++) {
        $worker = split("\*", $arr[$i]);
        $sql = "INSERT INTO subworksheet VALUES (null, '$worker[0]', '$i_num', '$a_num', '$u_num', 0, 0, '$message', '', NOW(), 0, 0)";
        if ($conn->query($sql) === FALSE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $mail->addAddress($worker[0], $worker[1]);

        echo $worker[0]." AND ". $worker[1];
    }
    $mail->addAddress("leepogii@gmail.com", "MINO Lee");
    $sql = "UPDATE worksheet SET isworkdone=1 WHERE invoice=".$i_num.";";
    $conn->query($sql);
    unset($_SESSION['i_num']);
    unset($_SESSION['a_num']);
    unset($_SESSION['u_num']);

    $mail->Subject = '[7 Contract] Work Request for Apt:'.$a_num.' Unit:'.$u_num.'.';
    $contact = "\n\n\n\n".'Seven Contract LLC.'."\n"."sevencontract1@gmail.com"."\n"."(678)727-3371";
    $mail->Body = $message.$contact;
    if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        echo "Message sent!";
    }
    $conn->close();
    echo "<script>alert(\"Successfully assigned.\");</script>";
    echo '<script>window.location.href = "worksheet.php";</script>';
?>
