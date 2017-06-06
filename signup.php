<?php
    $servername = "localhost:3307";
    $username = "root";
    $password = "123456";
    $db = "7contract";

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

    $sql = "INSERT INTO users (username, password, firstname, lastname)
            VALUES ('$username', '$password', '$fname', '$lname')";
    $result = $conn->query($sql);

    header("Location: index.php");
?>
