<?php
    // connection with mysql database
    include('./includes/connection.php');

    $po = $_POST['po'];
    $company = $_POST['company'];
    $apt = $_POST['apt'];
    $manager = $_POST['manager'];
    $unit = $_POST['unit'];
    $size = $_POST['size'];
    $date = $_POST['date'];
    $arr = $_SESSION['arr'];
    $sql = "INSERT INTO worksheet VALUES (null, '$po', '$company', '$apt', '$manager', '$unit', '$size', 0, 0, 0, 0, '', NOW(), 0, 0)";
    $conn->query($sql);
    $sql = "SELECT MAX(invoice) FROM worksheet";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $maxid = $row['MAX(invoice)'];
    // echo "<script>alert(\"".$maxid."\");</script>;";
    $total = 0;
    // print_r($arr);
    for ($i = 0; $i < count($arr); $i++) {
        $desc = str_replace("\"", "'", $arr[$i][0]);
        if (!empty($arr[$i][1])) {
            $qty = $arr[$i][1];
        } else {
            $qty = 0;
        }
        if (!empty($arr[$i][2])) {
            $price = $arr[$i][2];
        } else {
            $price = 0;
        }
        $sql = "INSERT INTO worksheet_description VALUES (null, '$maxid', '$qty', '$price', \"".$desc."\")";
        // echo "<script>alert(\"".$price."\");</script>;";
        $conn->query($sql) or die($conn->error());
        $total += $price;
    }
    $sql = "UPDATE worksheet SET price='$total', description=\"".$arr[0][0]."\" WHERE invoice='$maxid'";
    $conn->query($sql);
    echo "<script>
            alert(\"Successfully Added.\");
            </script>";
    echo '<script>window.location.href = "worksheet.php";</script>';
?>
