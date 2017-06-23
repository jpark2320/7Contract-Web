<?php
    // connection with mysql database
    include('./includes/connection.php');

    $message = $_POST['assign_message'];
    $arr = $_SESSION['workersArray'];

    $i_num = $_SESSION['i_num'];
    $i_num = substr($i_num, 2);
    $a_num = $_SESSION['a_num'];
    $u_num = $_SESSION['u_num'];

    for ($i = 0; $i < sizeof($arr); $i++) {
        $sql = "INSERT INTO subworksheet VALUES (0, '$arr[$i]', '$i_num', '$a_num', '$u_num', 0, '$message', '', NOW(), 0)";
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
