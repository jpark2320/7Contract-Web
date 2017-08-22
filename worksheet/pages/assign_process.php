<?php
    // connection with mysql database
    include('./includes/connection.php');

    $message = $_POST['assign_message'];
    $arr = $_POST['workersArray'];

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
    $mail->setFrom('7contractor@gmail.com', '7 Contract');
    $mail->addReplyTo('7contractor@gmail.com', '7 Contract');

    for ($i = 0; $i < sizeof($arr); $i++) {
        $worker = explode("\*", $arr[$i]);
        $sql = "INSERT INTO subworksheet VALUES (null, '$worker[0]', '$i_num', '$a_num', '$u_num', 0, 0, '$message', '', NOW(), 0, 0)";
        if ($conn->query($sql) === FALSE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        if (isset($worker[0]) && isset($worker[1])) {
            $mail->addAddress($worker[0], $worker[1]);
        } else if (isset($worker[0])) {
            $mail->addAddress($worker[0]);
        } else if (isset($worker[1])) {
            $mail->addAddress($worker[1]);
        }
    }
    $sql = "UPDATE worksheet SET isworkdone=1 WHERE invoice=".$i_num.";";
    $conn->query($sql);
    unset($_SESSION['i_num']);
    unset($_SESSION['a_num']);
    unset($_SESSION['u_num']);

    $mail->Subject = '[7 Contract] Work Request for Apt:'.$a_num.' Unit:'.$u_num.'.';
    $contact = "\n\n\n\n".'Seven Contract LLC.'."\n"."sevencontract1@gmail.com"."\n"."(678)727-3371";
    $mail->Body = $message;
    if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
    $conn->close();
    echo "<script>alert(\"Successfully assigned.\");</script>";
    echo '<script>window.location.href = "worksheet.php";</script>';
?>