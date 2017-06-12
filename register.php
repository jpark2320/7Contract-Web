<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Theme Made By www.w3schools.com - No Copyright -->
        <title>Bootstrap Theme The Band</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="./css/styles.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="50">
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.php">SEVEN CONTRACT LLC.</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="index.php">HOME</a></li>
                        <li><a href="about.php">ABOUT</a></li>
                        <li><a href="contact.php">CONTACT</a></li>
                        <li><a href="worksheet.php">WORKSHEET</a></li>
                        <?php if (isset($_SESSION['username'])): ?>
                            <li id="abc"><a href="signout.php">SIGNOUT</a></li>
                        <?php  else: ?>
                            <li id="abc"><a href="signin.php">SIGNIN</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- (Body Section) -->
        <div id="contact" class="container">
            <h3 class="text-center">Sign up right now!</h3><br>

            <div class="row" align="center">
                <form action="register_process.php" method="POST">
                    <p>
                        <label>Email Address:</label>
                        <input type="email" name="email">
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
        </div>

        <!-- Footer -->
        <footer class="text-center">
            <a class="up-arrow" href="#myPage" data-toggle="tooltip" title="TO TOP">
                <span class="glyphicon glyphicon-chevron-up"></span>
            </a><br><br>
            <p>Copyright ©2017 SEVEN CONTRACT LLC. All rights reserved.</p>
        </footer>
    </body>
</html>
