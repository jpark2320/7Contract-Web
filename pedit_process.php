<?php
    // connection with mysql database
    include('./includes/connection.php');


    if ($_SESSION['isadmin']) {
        $invoice = $_GET['invoice'];
        $email = $_GET['email'];
        $price = $_GET['price'];
        $sql = "UPDATE subworksheet SET price=".$price." WHERE invoice='$invoice' AND email='$email";
        $conn->query($sql);
        $sql = "SELECT price FROM subworksheet WHERE invoice='$invoice'";
        $result = $conn->query($sql);
        $totalSalary = 0;
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $totalSalary += $row['price'];
            }
        }
        $sql = "UPDATE worksheet SET salary='$totalSalary' WHERE invoice='$invoice'";
        $conn->query($sql);
        $sql = "SELECT price FROM worksheet WHERE invoice='$invoice'";
        $result = $conn->query($sql);
        $total = 0;
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $total = $row['price'];
            }
        }
        $profit = $total - $totalSalary;
        $sql = "UPDATE worksheet SET profit='$profit' WHERE invoice='$invoice'";
        $conn->query($sql);
    }

    $conn->close();
    echo '<script>window.location.href="invoice_detail.php";</script>';
?>
