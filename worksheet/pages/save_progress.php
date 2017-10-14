<?php
	session_start();
	include('./includes/connection.php');
    if (isset($_GET['json'])) {
    	$ar = explode("\\", $_GET['json']);
        $n = (int)(count($ar) / 3);
        $j = 0;
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
	$sql = "DELETE FROM save_progress WHERE invoice='$invoice'";
	$conn->query($sql);
	for ($i = 0; $i < count($arr); $i++) {
    	$desc = str_replace("\"", "'", $arr[$i][0]);
    	$qty = $arr[$i][1];
    	$price = str_replace(" ", "", $arr[$i][2]);

    	$sql = "INSERT INTO save_progress VALUES (null, '$invoice', '$qty', '$price', \"".$desc."\")";
    	$conn->query($sql);
    }
    unset($_SESSION['pdf_arr']);
    $_SESSION['i_pdf'] = 0;
    echo '<script>alert("Saved progress");</script>';
    echo '<script>window.location.href="invoice_detail.php";</script>';
?>