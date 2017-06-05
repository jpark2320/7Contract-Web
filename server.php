<?php
    $username = "";
    $first = "";
    $last = "";
    $email = "";
    $errors = array();
    $db = mysqli_connect("localhost:3306", '7contract', '7contract.com', 'id1211736_login');
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    if (isset($_POST['register'])) {
        $username = mysql_real_escape_string($db, $_POST['username']);
        $password_1 = mysql_real_escape_string($db, $_POST['password_1']);
        $password_2 = mysql_real_escape_string($db, $_POST['password_2']);
        $first = mysql_real_escape_string($db, $_POST['first']);
        $last = mysql_real_escape_string($db, $_POST['last']);
        $email = mysql_real_escape_string($db, $_POST['email']);

        if (empty($username)) {
            array_push($errors, "Username is required");
        }
        if (empty($email)) {
            array_push($errors, "Email address is required");
        }
        if (empty($password_1)) {
            array_push($errors, "Password is required");
        }
        if (empty($password_2)) {
            array_push($errors, "You need to confirm password");
        }
        if (count($errors) == 0) {
            $password = md5($password_1);
            $sql = "INSERT INTO Users (username, password, first, last, email) VALUES ('$username', '$password', '$first', '$last', '$email');";
            mysqli_query($db, $sql);
        }
    }
?>