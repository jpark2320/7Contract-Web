<?php
    session_start();
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $db = "7contract";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $db);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>
