<?php
    session_start();
    // connection with mysql database
    include('./includes/connection.php');
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
    $message = $_POST['assign_message'];
    $arr = $_SESSION['workersArray'];

    $i_num = $_SESSION['i_num'];
    $a_num = $_SESSION['a_num'];
    $u_num = $_SESSION['u_num'];

    $email = $_SESSION['email'];
    $sqlq = "SELECT * FROM Users WHERE email='$email'";
    $result = $conn->query($sqlq);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $from = $row['first']." ".$row['last'];
        }
    }

    $mail->setFrom($_SESSION['email'], $from);
    $mail->addReplyTo($_SESSION['email'], $from);
    $mail->Subject = "[7Contract] Work Request for Apt: ".$a_num.", Unit: ".$u_num;
    $mail->Body    = $message;
    for ($i = 0; $i < sizeof($arr); $i++) {
        $sql = "INSERT INTO subworksheet VALUES (0, '$arr[$i]', '$i_num', '$a_num', '$u_num', '$message', 'temp_comment', NOW())";
        $sqlw = "SELECT * FROM Users WHERE email='$arr[$i]'";
        $result = $conn->query($sqlw);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $sendto = $row['first']." ".$row['last'];
            }
        }
        $mail->addAddress($arr[$i], $sendto);
        if ($conn->query($sql) === FALSE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    unset($_SESSION['i_num']);
    unset($_SESSION['a_num']);
    unset($_SESSION['u_num']);

    $conn->close();
    if (!$mail->send()) {
        echo "<script>alert(\"It's succesfully assigned!\")</script>";// . $mail->ErrorInfo;
    } else {
        echo "<script>alert(\"Message has been sent succesfully\")</script>";
    }
    echo '<script>window.location.href = "worksheet.php";</script>';
?>
