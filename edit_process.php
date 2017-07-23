<?php
    // connection with mysql database
    include('./includes/connection.php');

    $po = $_POST['po'];
    $company = $_POST['company'];
    $apt = $_POST['apt'];
    $manager = $_POST['manager'];
    $unit = $_POST['unit'];
    $size = $_POST['size'];
    $arr = $_SESSION['arr'];
    $invoice = $_SESSION['invoice'];
    $sql = "UPDATE Worksheet SET
    	PO=\"".$po."\", company=\"".$company."\", apt=\"".$apt."\", manager=\"".$manager."\",
        unit=\"".$unit."\", size=\"".$size."\", description=\"".$arr[0][0]."\" WHERE invoice=\"".$invoice."\";";
    $conn->query($sql);
    $total = 0;
    $sql = "DELETE FROM worksheet_description WHERE invoice='$invoice'";
    $conn->query($sql);
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
        $sql = "INSERT INTO worksheet_description VALUES (null, '$invoice', '$qty', '$price', \"".$desc."\")";
        $conn->query($sql);
        $total += $price;
    }
    $sql = "UPDATE worksheet SET price='$total' WHERE invoice='$invoice'";
    $conn->query($sql);

    $sql = "UPDATE subworksheet SET apt=\"".$apt."\", unit=\"".$unit."\" WHERE invoice=\"".$invoice."\";";
    $conn->query($sql);

    $conn->close();
    unset($_SESSION['arr']);
    $_SESSION['i'] = 0;


    unset($_SESSION['invoice']);
    unset($_SESSION['id']);
    unset($_SESSION['po']);
    unset($_SESSION['company']);
    unset($_SESSION['apt']);
    unset($_SESSION['manager']);
    unset($_SESSION['size']);
    unset($_SESSION['unit']);
    unset($_SESSION['price']);
    unset($_SESSION['salary']);
    unset($_SESSION['profit']);
    unset($_SESSION['description']);

    echo '<script>window.location.href="worksheet.php";</script>';
?>
