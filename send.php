<?php
    session_start();
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db = "7Contract";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $db);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $uname = $_POST['uname'];
    $aptcode = $_POST['aptcode'];
    $unit = $_POST['unit'];
    $invoice = $_POST['invoice'];
    $sql = "INSERT INTO SubWorksheet VALUES (0, '$aptcode', '$unit','$invoice', '$uname')";
    $result = $conn->query($sql);
    echo "<script>
            alert(\"Successfully Added.\");
            </script>";
    echo '<script>window.location.href = "worksheet.php";</script>';

?>
