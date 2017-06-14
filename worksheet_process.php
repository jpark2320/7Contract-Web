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
    $invoice = $_POST['invoice'];
    $po = $_POST['po'];
    $apt = $_POST['apt'];
    $unit = $_POST['unit'];
    $size = $_POST['size'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $sql = "INSERT INTO worksheet VALUES ('$invoice', '$po', '$apt', '$unit', '$size', '$price', '$description', NOW())";
    $result = $conn->query($sql);
    echo "<script>
            alert(\"Successfully Added.\");
            </script>";
    echo '<script>window.location.href = "worksheet.php";</script>';

?>
