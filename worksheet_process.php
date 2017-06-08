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
    $aptcode = $_POST['aptcode'];
    $invoice = $_POST['invoice'];
    $po = $_POST['po'];
    $cost = $_POST['cost'];
    $check = "INSERT INTO Worksheet VALUES (0, '$aptcode', '$invoice', '$po', '$cost')";
    $result = $conn->query($check);
    echo "<script>
            alert(\"Successfully Added.\");
            </script>";
    echo '<script>window.location.href = "worksheet.php";</script>';

?>
