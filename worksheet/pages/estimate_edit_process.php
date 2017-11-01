<?php
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
        $n = (int)((count($ar) - 5) / 3);
        $j = 5;
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
    $id = $_SESSION['id'];
    $sql = "UPDATE estimate SET company=\"".$company."\", apt=\"".$apt."\", PO=\"".$po."\",
        unit=\"".$unit."\", size=\"".$size."\", description=\"".$arr[0][0]."\" WHERE id='$id';";
    $conn->query($sql);
    $sql = "DELETE FROM estimate_description WHERE estimate_id='$id'";
    $conn->query($sql);
    $total = 0;
    for ($i = 0; $i < count($arr); $i++) {
        $desc = str_replace("\"", "'", $arr[$i][0]);
        if (!empty($arr[$i][1])) {
            $qty = rtrim($arr[$i][1], " ");
        } else {
            $qty = 0;
        }
        if (!empty($arr[$i][2])) {
            $price = rtrim($arr[$i][2], " ");
        } else {
            $price = 0;
        }
        $sql = "INSERT INTO estimate_description VALUES (null, '$id', '$qty', '$price', \"".$desc."\")";
        $conn->query($sql);
        $total += $price;
    }
    $sql = "UPDATE estimate SET price='$total' WHERE id='$id'";
    $conn->query($sql);
    $conn->close();

    echo '<script>window.location.href="view_estimate.php";</script>';
?>
