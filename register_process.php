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
    $repassword = $_POST['upw2'];
    $fname = $_POST['fname'];
    $_SESSION['fcheck'] = $fname;
    $lname = $_POST['lname'];
    $_SESSION['lcheck'] = $lname;
    if (strlen($password) == 0 || strlen($fname) == 0
        || strlen($lname) == 0 || strlen($email) == 0) {
        echo "<script>
        alert(\"You have to fill in all fields.\");
        </script>";
        echo '<script>window.location.href = "register.php";</script>';
    }
    $check = "SELECT * FROM Users WHERE email='$email'";
    $checkresult = $conn->query($check);
    $count = mysqli_num_rows($checkresult);
    if ($count == 0) {
        if ($password == $repassword) {
            $password = md5($password);
            $sql = "INSERT INTO Users (email, password, first, last, isadmin)
            VALUES ('$email', '$password', '$fname', '$lname', 0)";
            $result = $conn->query($sql);
            $_SESSION['email'] = $email;
            unset($_SESSION['echeck']);
            unset($_SESSION['fcheck']);
            unset($_SESSION['lcheck']);
            header("location: index.php");
        } else {
            echo "<script>
            alert(\"Password must be the same in Confirm Password field.\");
            </script>";
            echo '<script>window.location.href = "register.php";</script>';
        }
    } else {
        echo "<script>
            alert(\"The email address already exists.\");
            </script>";
        echo '<script>window.location.href = "register.php";</script>';
    }
?>
