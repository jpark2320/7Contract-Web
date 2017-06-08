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
    $repassword = $_POST['upw2'];
    $fname = $_POST['fname'];
    $_SESSION['fname'] = $fname;
    $lname = $_POST['lname'];
    $_SESSION['lname'] = $lname;
    $email = $_POST['email'];
    $_SESSION['email'] = $email;
    if (strlen($username) == 0 || strlen($password) == 0 || strlen($fname) == 0 
        || strlen($lname) == 0 || strlen($email) == 0) {
        echo "<script>
        alert(\"You have to fill in all fields.\");
        </script>";
        echo '<script>window.location.href = "register.php";</script>';
        exit();
    }
    $check = "SELECT * FROM Users WHERE username='$username'";
    $checkresult = $conn->query($check);
    $count = mysqli_num_rows($checkresult);
    if ($count == 0) {
        if ($password == $repassword) {
            $sql = "INSERT INTO Users (username, password, first, last, email, isadmin)
            VALUES ('$username', '$password', '$fname', '$lname', '$email', 0)";
            $result = $conn->query($sql);
            unset($_SESSION['uid']);
            unset($_SESSION['fname']);
            unset($_SESSION['lname']);
            unset($_SESSION['email']);
            $_SESSION['username'] = $username;
            $_SESSION['isadmin'] = 0;
            header("location: index.php");
        } else {
            echo "<script>
            alert(\"Password must be the same in Confirm Password field.\");
            </script>";
            echo '<script>window.location.href = "register.php";</script>';
        }
    } else {
        echo "<script>
            alert(\"The username already exists.\");
            </script>";
        echo '<script>window.location.href = "register.php";</script>';
    }
?>
