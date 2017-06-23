<?php
    // connection with mysql database
    include('./includes/connection.php');


    if ($_SESSION['isadmin']) {
        $po = $_POST['po'];
        $company = $_POST['company'];
        $apt = $_POST['apt'];
        $manager = $_POST['manager'];
        $unit = $_POST['unit'];
        $size = $_POST['size'];
        $price = $_POST['price'];
        $salary = $_POST['salary'];
        $profit = $_POST['profit'];
        $description = $_POST['description'];
        $invoice = $_SESSION['invoice'];
        $sql = "UPDATE Worksheet SET
        	PO=\"".$po."\", company=\"".$company."\", apt=\"".$apt."\", manager=\"".$manager."\",
            unit=\"".$unit."\", size=\"".$size."\", price=".$price.", salary=".$salary.",
            profit=".$profit.", description=\"".$description."\" WHERE invoice=\"".$invoice."\";";
        unset($_SESSION['invoice']);
        unset($_SESSION['po']);
        unset($_SESSION['company']);
        unset($_SESSION['apt']);
        unset($_SESSION['manager']);
        unset($_SESSION['size']);
        unset($_SESSION['unit']);
        unset($_SESSION['price']);
        unset($_SESSION['salary']);
        unset($_SESSION['profit']);
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
