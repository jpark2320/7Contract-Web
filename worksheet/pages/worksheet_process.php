<?php
    // connection with mysql database
    include('./includes/connection.php');

    if (isset($_GET['json'])) {
        $ar = explode("\\", $_GET['json']);
        $po = $ar[0];
        $company = $ar[1];
        $apt = $ar[2];
        $unit = $ar[3];
        $size = $ar[4];
        $manager = $ar[5];
        $date = $ar[6];
        $n = (int)((count($ar) - 7) / 3);
        $j = 7;
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
    } else {
        echo "<script>alert('somethings wrong');</script>;";
        echo '<script>window.location.href = "worksheet.php";</script>';
    }

    if (isset($_SESSION['arr'])) {
        $arr = $_SESSION['arr'];
    }
    $sql = "INSERT INTO worksheet VALUES (null, '$po', '$company', '$apt', '$manager', '$unit', '$size', 0, 0, 0, 0, '', NOW(), 0, 0)";
    $conn->query($sql);
    $sql = "SELECT MAX(invoice) FROM worksheet";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $maxid = $row['MAX(invoice)'];
    // echo "<script>alert(\"".$maxid."\");</script>;";
    $total = 0;
    // print_r($arr);
    if (isset($arr)) {
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
    }
    if (isset($arr)) {
        $sql = "UPDATE worksheet SET price='$total', description=\"".$arr[0][0]."\" WHERE invoice='$maxid'";
    }
    $conn->query($sql);
    echo "<script>
            alert(\"Successfully Added.\");
            </script>";
    echo '<script>window.location.href = "worksheet.php";</script>';
?>
