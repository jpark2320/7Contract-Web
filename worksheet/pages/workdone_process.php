<?php
    // connection with mysql database
    include('./includes/connection.php');
    if (!isset($_SESSION))
        session_start();

    if (isset($_GET['invoice_num'])) {
        $invoice = str_replace("7C", "", $_GET['invoice_num']);
    }
    if (isset($_GET['email_user'])) {
        $email = $_GET['email_user'];
    }
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    }
    $sql = "UPDATE SubWorksheet SET isworkdone = 1 WHERE id='".$id."' AND invoice='".$invoice."' AND email='".$email."';";
    $conn->query($sql);
    $sone = "SELECT * FROM subworksheet WHERE isworkdone = 1 AND invoice='".$invoice."';";
    $result = $conn->query($sone);
    $num_sone = $result->num_rows;
    $stwo = "SELECT * FROM subworksheet WHERE invoice='".$invoice."';";
    $result = $conn->query($stwo);
    $num_stwo = $result->num_rows;
    if ($num_sone == $num_stwo) {
        $sql = "UPDATE Worksheet SET isworkdone = 2 WHERE invoice='".$invoice."';";
    } else {
        $sql = "UPDATE Worksheet SET isworkdone = 1 WHERE invoice='".$invoice."';";
    }
    $conn->query($sql);
    $conn->close();
    echo '<script>window.location.href = "worksheet.php";</script>';
?>
