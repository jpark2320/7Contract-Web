<?php
    session_start();
    // connection with mysql database
    include('./includes/connection.php');

    if ($_SESSION['isadmin']) {
        if (isset($_SESSION['invoice'])) {
            $invoice = $_SESSION['invoice'];
            $email = $_SESSION['temail'];
            if (isset($_POST['message'])) {
                $message = $_POST['message'];
                $comment = $_POST['comment'];
                $price = $_POST['price'];
            }
        } else {
            echo "<script>alert('Hello World');</script>";
        }
        echo '<script>alert("'.$comment.'");</script>';       



        $sql = "UPDATE subworksheet SET price=".$price.", message=\"".$message."\", comment=\"".$comment."\" WHERE invoice=".$invoice." AND email=\"".$email."\"";
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
    unset($_SESSION['invoice']);
    unset($_SESSION['temail']);
    unset($_SESSION['message']);
    unset($_SESSION['comment']);
    unset($_SESSION['price']);
    echo '<script>window.location.href="invoice_detail.php";</script>';
?>
