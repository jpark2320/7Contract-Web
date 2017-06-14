<?php
    session_start();
    $servername = "localhost:3307";
    $username = "root";
    $password = "";
    $db = "7Contract";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $db);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // 왜 값이 안나타나는겨 assign.php까지는 나타나는데

    $message = $_POST['assign_message'];
    $arr = $_SESSION['workersArray'];
    $invoice_num = $_SESSION['invoice_num'];
    $apt_num = $_SESSION['apt_num'];
    $unit_num = $_SESSION['unit_num'];
    if (isset($_SESSION['apt_num']))
    echo "<script>alert(\"$invoice_num\");</script>";
    // echo "<script>alert(\"$apt_num\");</script>";
    // echo "<script>alert(\"$unit_num\");</script>";

    for ($i = 0; $i < sizeof($arr); $i++) {
        $sql = "INSERT INTO subworksheet VALUES (0, '$arr[$i]', '$invoice_num', '$apt_num', '$unit_num', '$message', 'temp_comment', NOW())";
        if ($conn->query($sql) === FALSE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    unset($_SESSION['invoice_num']);
    unset($_SESSION['apt_num']);
    unset($_SESSION['unit_num']);

    $conn->close();
    echo "<script>alert(\"Successfully assigned.\");</script>";
    echo '<script>window.location.href = "worksheet.php";</script>';
?>
