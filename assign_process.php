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

    $message = $_POST['assign_message'];
    $arr = $_SESSION['workersArray'];

    $i_num = $_SESSION['i_num'];
    $a_num = $_SESSION['a_num'];
    $u_num = $_SESSION['u_num'];

    for ($i = 0; $i < sizeof($arr); $i++) {
        $sql = "INSERT INTO subworksheet VALUES (0, '$arr[$i]', '$i_num', '$a_num', '$u_num', '$message', 'temp_comment', NOW())";
        if ($conn->query($sql) === FALSE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    unset($_SESSION['i_num']);
    unset($_SESSION['a_num']);
    unset($_SESSION['u_num']);

    $conn->close();
    echo "<script>alert(\"Successfully assigned.\");</script>";
    echo '<script>window.location.href = "worksheet.php";</script>';
?>