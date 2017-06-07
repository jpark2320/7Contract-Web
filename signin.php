<?php 
    session_start();
    if (isset($_SESSION['username'])) {
        echo "<script>
        alert(\"".$_SESSION['username']."\");
        </script>";
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <!-- <link rel="stylesheet" href="./css/styles.css"> -->
        <link rel="stylesheet" href="./css/styles.css">
        <title>
            Welcome to SEVEN CONTRACT LLC.
        </title>
    </head>
    <body>
        <header id="start">
            <div id="account">
                <a href="signin.php">Sign in</a>
            </div>
            <h1 id="title"><a href="index.php">SEVEN CONTRACT LLC.</a></h1>
            <div id="navigation">
                <ul>
                    <li><a href="about.php">About</a></li>
                    <li><a href="request.php">Request</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </div>
        </header>
        <div id="login">
            <form class="" action="signin_process.php" method="POST">
                <p>
                    <label for="">Username:</label>
                    <input type="text" name="uid">
                </p>
                <p>
                    <label for="">Password:</label>
                    <input type="password" name="upw">
                </p>
                <p>
                    <input type="submit" name="" value="login">
                </p>
            </form>
            <br>
            <p>Forgot ID or PASSWORD?</p>
            Find my <a href="register.php">Id</a> or <a href="#">Password</a><br><br><br>
            <p>No account?</p>
            <a href="register.php">Register</a>
        </div>
        <footer>
            <p>Copyright ©2017 SEVEN CONTRACT LLC. All rights reserved.</p>
        </footer>
    </body>
</html>
