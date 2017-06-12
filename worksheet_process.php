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
    $aptcode = $_POST['aptcode'];
    $unit_num = $_POST['unit_num'];
    $invoice = $_POST['invoice'];
    $po = $_POST['po'];
    $cost = $_POST['cost'];
    $num_workers = $_POST['num_workers'];
    $check = "INSERT INTO Worksheet VALUES (0, '$aptcode', '$unit_num', '$invoice', '$po', '$cost', '$num_workers')";
    $result = $conn->query($check);
    echo "<script>
            alert(\"Successfully Added.\");
            </script>";
    echo '<script>window.location.href = "worksheet.php";</script>';

?>
