<?php
    session_start();
    // connection with mysql database
    include('./includes/connection.php');

    if ($_SESSION['isadmin']) {
        if (isset($_SESSION['invoice'])) {
            $invoice = $_SESSION['invoice'];
            $id = $_SESSION['id'];
            $remaining = $_SESSION['remaining'];
            $paid = $_SESSION['paid'];
            $price = $_SESSION['price'];
            $pay = $_POST['pay'];
        } else {
            echo "<script>alert('You are not admin.');</script>";
            echo '<script>window.location.href="worksheet.php";</script>';
            exit();
        }
        $balance = $paid + $pay;
        if ($price <= $balance) {
        	$paidoff = 1;
        } else {
        	$paidoff = 0;
        }
        echo "<script>alert(\"".$balance."\");</script>";
        $sql = "UPDATE subworksheet SET paid=".$balance.", ispaidoff=".$paidoff." WHERE id=".$id;
        $conn->query($sql);
    }

    $conn->close();
    unset($_SESSION['invoice']);
    unset($_SESSION['remaining']);
    unset($_SESSION['message']);
    unset($_SESSION['comment']);
    unset($_SESSION['price']);
    unset($_SESSION['paid']);
    unset($_SESSION['id']);
    echo '<script>window.location.href="price_detail.php";</script>';
?>
