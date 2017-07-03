<?php
	// connection with mysql database
	include('./includes/connection.php');

    $email = $_POST['email'];
    $_SESSION['echeck'] = $email;
    $password = md5($_POST['upw']);
	$sql = "SELECT * FROM Users WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);
    $count = mysqli_num_rows($result);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $_SESSION['isadmin'] = $row['isadmin'];
            $_SESSION['email'] = $email;
            unset($_SESSION['echeck']);
            echo '<script>window.location.href = "index.php";</script>';
            exit();
        }
    } else {
        echo "<script>
        alert(\"Email Address or Password Incorrect.\");
        </script>";
        echo '<script>window.location.href = "signin.php";</script>';
        exit();
    }
?>
