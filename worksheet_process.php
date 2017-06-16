<?php
    // connection with mysql database
    include('./includes/connection.php');
    
    $invoice = $_POST['invoice'];
    $po = $_POST['po'];
    $apt = $_POST['apt'];
    $unit = $_POST['unit'];
    $size = $_POST['size'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $sql = "INSERT INTO worksheet VALUES ('$invoice', '$po', '$apt', '$unit', '$size', '$price', '$description', NOW())";
    $result = $conn->query($sql);
    $conn->close();
    echo "<script>
            alert(\"Successfully Added.\");
            </script>";
    echo '<script>window.location.href = "worksheet.php";</script>';

?>
