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
    $po = $_POST['po'];
    $apt = $_POST['apt'];
    $unit = $_POST['unit'];
    $size = $_POST['size'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $invoice = $_SESSION['invoice'];
    $sql = "UPDATE Worksheet SET 
    	PO = '".$po."', apt = '".$apt."', unit = '".$unit."', size = '".$size."', 
    	price = ".$price.", description = '".$description."' WHERE invoice = '".$invoice."';";

    $conn->close();
    // echo '<script>window.location.href = "worksheet.php";</script>';
?>
