<?php
	include('./includes/connection.php');
    if (!isset($_SESSION))
        session_start();

    if (count($_SESSION['arr']) == 0) {
    	echo '<script>alert("You need to add at least 1 column");</script>';
        echo '<script>window.location.href = "worksheet.php";</script>';
        exit();
    }
    $id = $_SESSION['id'];
    $invoice = $_SESSION['invoice'];
    $email = $_SESSION['email'];
    $arr = $_SESSION['arr'];
    for ($i = 0; $i < sizeof($_SESSION['arr']); $i++) {
    	$s = str_replace("\"", "'", $arr[$i]);
    	$sql = "INSERT INTO user_comment VALUES (null, '$invoice', '$id', '$email', 0, 0, \"".$s."\", NOW(), 0)";
    	$conn->query($sql);
    }
    $conn->close();
    echo '<script>alert("Successfully Added");</script>';
    echo '<script>window.location.href = "worksheet.php";</script>';
?>