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
    $_SESSION['uid'] = $username;
    $password = $_POST['upw'];
	$sql = "SELECT * FROM Users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);
    $count = mysqli_num_rows($result);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $_SESSION['isadmin'] = $row["isadmin"];
        }
    } else {
        echo "<script>
        alert(\"Username & Password Incorrect.\");
        </script>";
        echo '<script>window.location.href = "signin.php";</script>';
        exit();
    }
    if ($count == 1){
        unset($_SESSION['uid']);
        unset($_SESSION['fname']);
        unset($_SESSION['lname']);
        unset($_SESSION['email']);
		$_SESSION['username'] = $username;
        echo "<script>
        alert(\"You are successfully logged in.\");
        </script>";
        echo '<script>window.location.href = "index.php";</script>';
	}
?>
