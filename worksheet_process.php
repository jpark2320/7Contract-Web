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
    $invoice = $_POST['invoice'];
    $po = $_POST['po'];
    $apt = $_POST['apt'];
    $unit = $_POST['unit'];
    $size = $_POST['size'];
    $price = $_POST['price'];
    $descrption = $_POST['descrption'];
    $sql = "INSERT INTO Worksheet VALUES ('$invoice', '$po', '$apt', '$unit', '$size', '$price', '$descrption', NOW())";
    $result = $conn->query($sql);
    echo "<script>
            alert(\"Successfully Added.\");
            </script>";
    echo '<script>window.location.href = "worksheet.php";</script>';

?>
