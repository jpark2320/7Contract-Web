<?php
    // connection with mysql database
    include('./includes/connection.php');

    if (isset($_GET['json'])) {
        $ar = explode("\\", $_GET['json']);
        if ($ar[0] != '-') {
            $po = $ar[0];
        } else {
            $po = null;
        }
        if ($ar[1] != '-') {
            $company = $ar[1];
        } else {
            $company = null;
        }
        if ($ar[2] != '-') {
            $apt = $ar[2];
        } else {
            $apt = null;
        }
        if ($ar[3] != '-') {
            $unit = $ar[3];
        } else {
            $unit = null;
        }
        if ($ar[4] != '-') {
            $size = $ar[4];
        } else {
            $size = null;
        }
        if ($ar[5] != '-') {
            $manager = $ar[5];
        } else {
            $manager = null;
        }
        $n = (int)((count($ar) - 6) / 3);
        $j = 6;
        for ($i = 0; $i < $n; $i++) {
            $arr[$i][0] = $ar[$j];
            $j++;
            if ($ar[$j] != '-') {
                $arr[$i][1] = $ar[$j];
            } else {
                $arr[$i][1] = 0;
            }
            $j++;
            if ($ar[$j] != '-') {
                $arr[$i][2] = $ar[$j];
            } else {
                $arr[$i][2] = 0;
            }
            $j++;
        }
    }
    
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
        $qty = $arr[$i][1];
        $price = $arr[$i][2];

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

    echo '<script>window.location.href="worksheet.php";</script>';
?>
