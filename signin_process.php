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

    $email = $_POST['email'];
    $_SESSION['echeck'] = $email;
    $password = $_POST['upw'];
	$sql = "SELECT * FROM Users WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);
    $count = mysqli_num_rows($result);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $_SESSION['isadmin'] = $row["isadmin"];
            $_SESSION['email'] = $email;
            unset($_SESSION['echeck']);
            echo '<script>window.location.href = "index.php";</script>';
        }
    } else {
        echo "<script>
        alert(\"Email Address or Password Incorrect.\");
        </script>";
        echo '<script>window.location.href = "signin.php";</script>';
    }
?>