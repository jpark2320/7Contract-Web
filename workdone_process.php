<?php
    // connection with mysql database
    include('./includes/connection.php');

    session_start();

    $invoice = $_GET['invoice_num'];
    $email = $_GET['email_user']; // 이 부분좀 확인해봐 GET으로 invoice 넘버는 잘 받아지는데 email은 아무것도 안받아진다

    // 저번처럼 isset으로 확인안해서 이것도 시도해봤는데 안된다.
    // if (isset($_GET['email_user'])) {
    //     $email = $_GET['email_user'];
    // }

    echo "<script>alert(\"Successfully finished work!\");</script>";
    echo "<script>alert(".$invoice.");</script>"; // 확인용
    echo "<script>alert(".$email.");</script>"; // 확인용

    $sql = "UPDATE SubWorksheet SET isworkdone=1 WHERE invoice='".$invoice."' email='".$email."';";

    $conn->query($sql);
    $conn->close();
    echo '<script>window.location.href = "worksheet.php";</script>';
?>
