<?php
    // connection with mysql database
    include('./includes/connection.php');


    if ($_SESSION['isadmin']) {
        $po = $_POST['po'];
        $apt = $_POST['apt'];
        $size = $_POST['size'];
        $unit = $_POST['unit'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $invoice = $_SESSION['invoice'];
        $sql = "UPDATE Worksheet SET
        	PO=\"".$po."\", apt=\"".$apt."\", unit=\"".$unit."\", size=\"".$size."\",
        	price=".$price.", description=\"".$description."\" WHERE invoice=\"".$invoice."\";";
        unset($_SESSION['invoice']);
        unset($_SESSION['po']);
        unset($_SESSION['apt']);
        unset($_SESSION['size']);
        unset($_SESSION['unit']);
        unset($_SESSION['price']);
        unset($_SESSION['description']);
    } else {
        $comment = $_POST['comment'];
        $invoice = $_SESSION['invoice'];
        $sql = "UPDATE SubWorksheet SET comment=\"".$comment."\" WHERE email=\"".$_SESSION['email']."\" AND invoice=\"".$invoice."\";";
        unset($_SESSION['invoice']);
    }

    $conn->query($sql);
    $conn->close();
    echo '<script>window.location.href="worksheet.php";</script>';
?>
