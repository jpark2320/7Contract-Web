<?php
    // connection with mysql database
    include('./includes/connection.php');

    // $invoice = $_POST['invoice'];
    $po = $_POST['po'];
    $company = $_POST['company'];
    $apt = $_POST['apt'];
    $manager = $_POST['manager'];
    $unit = $_POST['unit'];
    $size = $_POST['size'];
    $price = $_POST['price'];
    if (empty($price))
        $price = 0;
    $salary = $_POST['salary'];
    $profit = $_POST['profit'];
    $description = $_POST['description'];
    $sql = "INSERT INTO worksheet VALUES (null, '$po', '$company', '$apt', '$manager', '$unit', '$size', $price, 0, 0, '$description', NOW(), 0)";
    $result = $conn->query($sql);
    echo "<script>
            alert(\"Successfully Added.\");
            </script>";
    echo '<script>window.location.href = "worksheet.php";</script>';

?>
