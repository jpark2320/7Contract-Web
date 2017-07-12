<?php
    session_start();
    // connection with mysql database
    include('./includes/connection.php');

    if ($_SESSION['isadmin']) {
        $id = $_SESSION['id'];
        $salary = $_POST['salary'];

        $sql = "UPDATE user_comment SET salary=".$salary." WHERE id=".$id.";";
        $conn->query($sql);
        $sql = "SELECT sub_id FROM user_comment WHERE id='$id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        $sub_id = $row['sub_id'];
        $sql = "SELECT salary FROM user_comment WHERE sub_id='$sub_id'";
        $result = mysqli_query($conn, $sql);
        $totalSalary = 0;
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $totalSalary += $row['salary'];
            }
        }
        $sql = "UPDATE subworksheet SET price='$totalSalary' WHERE id='$sub_id'";
        $conn->query($sql);
        // echo "<script>alert(\"".$_SESSION['invoice']."\");</script>";
        $sql = "SELECT price FROM subworksheet WHERE invoice='".$_SESSION['invoice']."'";
        $result = $conn->query($sql);
        $total = 0;
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $total += $row['price'];
            }
        }
        $sql = "UPDATE worksheet SET salary='$total' WHERE invoice='".$_SESSION['invoice']."'";
        $conn->query($sql);
        $sql = "SELECT price, salary FROM worksheet WHERE invoice='".$_SESSION['invoice']."'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        $profit = $row['price'] - $row['salary'];
        $sql = "UPDATE worksheet SET profit='$profit' WHERE invoice='".$_SESSION['invoice']."'";
        $conn->query($sql);
    }

    $conn->close();
    echo '<script>window.location.href="invoice_detail.php";</script>';
?>
