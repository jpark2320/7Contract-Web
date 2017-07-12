<?php
	session_start();
	include('./includes/connection.php');
	$arr = $_SESSION['pdf_arr'];
	$invoice = $_SESSION['invoice'];
	$sql = "DELETE FROM save_progress WHERE invoice='$invoice'";
	$conn->query($sql);
	for ($i = 0; $i < count($arr); $i++) {
    	$desc = str_replace("\"", "'", $arr[$i][0]);
    	if (!empty($arr[$i][1])) {
    		$qty = $arr[$i][1];
    	} else {
    		$qty = 0;
    	}
    	if (!empty($arr[$i][2])) {
    		$price = str_replace(" ", "", $arr[$i][2]);
    	} else {
    		$price = 0;
    	}
    	$sql = "INSERT INTO save_progress VALUES (null, '$invoice', '$qty', '$price', \"".$desc."\")";
    	$conn->query($sql);
    }
    unset($_SESSION['pdf_arr']);
    $_SESSION['i_pdf'] = 0;
    echo '<script>alert("Saved progress");</script>';
    echo '<script>window.location.href="invoice_detail.php";</script>';
?>