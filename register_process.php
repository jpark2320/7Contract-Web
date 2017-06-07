<?php
    session_start();
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db = "7Contract";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $db);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_POST['uid'];
    $password = $_POST['upw'];
    $repassword = $_POST['upw2'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    if ($password1 == $password2) {
        $sql = "INSERT INTO Users (username, password, first, last, email, isadmin)
        VALUES ('$username', '$password', '$fname', '$lname', '$email', 0)";
        $result = $conn->query($sql);
        header("location: index.php");
    } else {
        $_SESSION['message'] = "You have to enter same password";
    }
?>
