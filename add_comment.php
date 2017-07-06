<?php
	include('./includes/connection.php');

    session_start();

    if (count($_SESSION['arr']) == 0) {
    	echo '<script>alert("You need to add at least 1 column");</script>';
        echo '<script>window.location.href = "worksheet.php";</script>';
        exit();
    }
    $id = $_SESSION['id'];
    $email = $_SESSION['email'];
    $arr = $_SESSION['arr'];
    for ($i = 0; $i < count($_SESSION['arr']); $i++) {
    	$sql = "INSERT INTO user_comment VALUES (null, '$id', '$email', 0, 0, '$arr[$i]', NOW(), 0)";
    	$conn->query($sql);
    }
    $conn->close();
    echo '<script>alert("Successfully Added");</script>';
    echo '<script>window.location.href = "worksheet.php";</script>';
?>