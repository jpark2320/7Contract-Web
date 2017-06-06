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
                <a href="#">Sign in</a>
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
            <form action="signup.php" method="POST">
                <p>
                    <label>Username:</label>
                    <input type="text" name="uid">
                </p>
                <p>
                    <label>Password:</label>
                    <input type="password" name="upw">
                </p>
                <p>
                    <label>Re-password:</label>
                    <input type="password" name="upw2">
                </p>
                <p>
                    <label>First Name:</label>
                    <input type="text" name="fname">
                </p>
                <p>
                    <label>Last Name:</label>
                    <input type="text" name="lname">
                </p>
                <input type="submit" value="Register">
                <input type="submit" value="Back">
            </form>
        </div>
        <footer>
            <p>Copyright ©2017 SEVEN CONTRACT LLC. All rights reserved.</p>
        </footer>
    </body>
</html>
