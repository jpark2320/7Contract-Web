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
	$sql = "SELECT * FROM Users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);
    $count = mysqli_num_rows($result);
    if ($count == 1){
		$_SESSION['username'] = $username;
		echo $result["isamin"]. "";
	}else{
		$fmsg = "Invalid Login Credentials.";
	}
	if (isset($_SESSION['username'])) {
		$username = $_SESSION['username'];
	}

?>
