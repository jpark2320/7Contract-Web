<?php
    // connection with mysql database
    include('./includes/connection.php');

    //I think I should add column which leads to description in worksheet table.
    $id = $_GET['id'];
    $company = $_GET['company'];
    $apt = $_GET['apt'];
    $unit = $_GET['unit'];
    $size = $_GET['size'];
    $price = $_GET['price'];
    $po = $_GET['po'];
    $description = $_GET['description'];
    $sql = "INSERT INTO worksheet VALUES (0, null, '$po', '$company', '$apt', '', '$unit', '$size', $price, 0, 0, 0, '$description', NOW(), 0, 0)";
    $conn->query($sql);

    $sql = "SELECT MAX(invoice) FROM worksheet";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $maxid = $row['MAX(invoice)'];
    $sort = $maxid * -1;
    $sql = "UPDATE worksheet SET sort = '$sort' WHERE invoice = '$maxid'";
    $conn->query($sql);
    $sql = "SELECT * FROM estimate_description WHERE estimate_id = '$id'";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result)) {
    	$sql = "INSERT INTO worksheet_description VALUES (null, '$maxid', ".$row['quantity'].", ".$row['price'].", \"".$row['description']."\")";
    	$conn->query($sql);
    }

    
    echo "<script>
            alert(\"Successfully Added to Worksheet.\");
            </script>";
    echo '<script>window.location.href = "worksheet.php";</script>';
?>