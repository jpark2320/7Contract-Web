<?php
    // connection with mysql database
    include('./includes/connection.php');

    session_start();

    if (isset($_GET['invoice_num'])) {
        $invoice = $_GET['invoice_num'];
    } 
    if (isset($_GET['email_user'])) {
        $email = $_GET['email_user'];
    } 
    $sql = "UPDATE SubWorksheet SET isworkdone = 1 WHERE invoice='".$invoice."' AND email='".$email."';";
    $conn->query($sql);
    $sone = "SELECT * FROM subworksheet WHERE isworkdone = 1 AND invoice='".$invoice."';";
    $result = $conn->query($sone);
    $num_sone = $result->num_rows;
    $stwo = "SELECT * FROM subworksheet WHERE invoice='".$invoice."';";
    $result = $conn->query($stwo);
    $num_stwo = $result->num_rows;
    echo '<script type="text/javascript">alert("' . $num_sone . " " . $num_stwo .'")</script>';
    if ($num_sone == $num_stwo) {
        $sql = "UPDATE Worksheet SET isworkdone = 2 WHERE invoice='".$invoice."';";
    } else {
        $sql = "UPDATE Worksheet SET isworkdone = 1 WHERE invoice='".$invoice."';";
    }
    $conn->query($sql);
    $conn->close();
    echo '<script>window.location.href = "worksheet.php";</script>';
?>
