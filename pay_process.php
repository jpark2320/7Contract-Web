<?php
    session_start();
    // connection with mysql database
    include('./includes/connection.php');

    if ($_SESSION['isadmin']) {
        if (isset($_SESSION['id'])) {
            $id = $_SESSION['id'];
        } else {
            echo "<script>alert('You are not admin.');</script>";
            echo '<script>window.location.href="worksheet.php";</script>';
            exit();
        }
        $balance = $_SESSION['paid'] + $_POST['pay'];
        if ($_SESSION['salary'] <= $balance) {
        	$paidoff = 1;
        } else {
        	$paidoff = 0;
        }
        // echo "<script>alert(\"".$_GET['pay']."\");</script>";
        $sql = "UPDATE user_comment SET paid=".$balance.", ispaidoff=".$paidoff." WHERE id=".$id;
        $conn->query($sql);
        $sql = "SELECT sub_id FROM user_comment WHERE id='$id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        $sub_id = $row['sub_id'];
        $sql = "SELECT paid FROM user_comment WHERE sub_id='$sub_id'";
        $result = mysqli_query($conn, $sql);
        $totalpaid = 0;
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $totalpaid += $row['paid'];
            }
        }
        $sql = "UPDATE subworksheet SET paid='$totalpaid' WHERE id='$sub_id'";
        $conn->query($sql);
    }

    $conn->close();
    unset($_SESSION['paid']);
    unset($_SESSION['salary']);
    unset($_SESSION['id']);
    echo '<script>window.location.href="invoice_detail.php";</script>';
?>
