<?php
    include('./includes/connection.php');
    $company = $_POST['company'];
    $apt = $_POST['apt'];
    $unit = $_POST['unit'];
    $size = $_POST['size'];
    $price = $_POST['price'];
    $id = $_SESSION['id'];
    $arr = $_SESSION['edit_arr'];
    $sql = "UPDATE estimate SET company=\"".$company."\", apt=\"".$apt."\",
        unit=\"".$unit."\", size=\"".$size."\", description=\"".$arr[0][0]."\" WHERE id='$id';";
    $conn->query($sql);
    $sql = "DELETE FROM estimate_description WHERE estimate_id='$id'";
    $conn->query($sql);
    $total = 0;
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
        $sql = "INSERT INTO estimate_description VALUES (null, '$id', '$qty', '$price', \"".$desc."\")";
        $conn->query($sql);
        $total += $price;
    }
    $sql = "UPDATE estimate SET price='$total' WHERE id='$id'";
    $conn->query($sql);
    $conn->close();
    unset($_SESSION['edit_arr']);
    $_SESSION['i'] = 0;
    echo '<script>window.location.href="view_estimate.php";</script>';
?>
