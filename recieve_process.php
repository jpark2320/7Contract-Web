<?php
    session_start();
    // connection with mysql database
    include('./includes/connection.php');

    if ($_SESSION['isadmin']) {
        if (isset($_SESSION['invoice'])) {
            $invoice = $_SESSION['invoice'];
            $paid = $_SESSION['paid'];
            $price = $_SESSION['price'];
            $recieve = $_POST['recieve'];
        } else {
            echo "<script>alert('You are not admin.');</script>";
            echo '<script>window.location.href="worksheet.php";</script>';
            exit();
        }
        $balance = $paid + $recieve;
        if ($price <= $balance) {
        	$paidoff = 1;
        } else {
        	$paidoff = 0;
        }
        $sql = "SELECT salary FROM worksheet";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        $profit = $balance - $row['salary'];
        $sql = "UPDATE worksheet SET paid=".$balance.", ispaidoff=".$paidoff.", profit=".$profit." WHERE invoice=".$invoice;
        $conn->query($sql);
    }

    $conn->close();
    unset($_SESSION['invoice']);
    unset($_SESSION['paid']);
    unset($_SESSION['price']);
    unset($_SESSION['apt']);
    unset($_SESSION['unit']);
    echo '<script>window.location.href="price_detail.php";</script>';
?>
