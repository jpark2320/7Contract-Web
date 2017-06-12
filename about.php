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
                        <?php if (isset($_SESSION['email'])): ?>
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
            <h3 class="text-center">We do the following...</h3>
            <p class="text-center"><em>Ask us if you need anything more than them!</em></p>
            <br><br>

            <div class="row" align="center">
                <p>
                    <section>
                        <img src="./img/apple.jpeg">
                    </section>
                    Ask us if you need anything more than them!Ask us if you need anything more than them!Ask us if you need anything more than them!Ask us if you need anything more than them!
                    Ask us if you need anything more than them!Ask us if you need anything more than them!Ask us if you need anything more than them!Ask us if you need anything more than them!
                    Ask us if you need anything more than them!Ask us if you need anything more than them!Ask us if you need anything more than them!Ask us if you need anything more than them!
                    Ask us if you need anything more than them!Ask us if you need anything more than them!Ask us if you need anything more than them!Ask us if you need anything more than them!
                </p>
            </div>
            <br><br><br>

            <div class="row" align="center">
                <p>
                    <section>
                        <img src="./img/banana.jpeg">
                    </section>
                    Ask us if you need anything more than them!Ask us if you need anything more than them!Ask us if you need anything more than them!Ask us if you need anything more than them!
                    Ask us if you need anything more than them!Ask us if you need anything more than them!Ask us if you need anything more than them!Ask us if you need anything more than them!
                    Ask us if you need anything more than them!Ask us if you need anything more than them!Ask us if you need anything more than them!Ask us if you need anything more than them!
                    Ask us if you need anything more than them!Ask us if you need anything more than them!Ask us if you need anything more than them!Ask us if you need anything more than them!
                </p>
            </div>
            <br><br><br>

            <div class="row" align="center">
                <p>
                    <section>
                        <img src="./img/grape.jpeg">
                    </section>
                    Ask us if you need anything more than them!Ask us if you need anything more than them!Ask us if you need anything more than them!Ask us if you need anything more than them!
                    Ask us if you need anything more than them!Ask us if you need anything more than them!Ask us if you need anything more than them!Ask us if you need anything more than them!
                    Ask us if you need anything more than them!Ask us if you need anything more than them!Ask us if you need anything more than them!Ask us if you need anything more than them!
                    Ask us if you need anything more than them!Ask us if you need anything more than them!Ask us if you need anything more than them!Ask us if you need anything more than them!
                </p>
            </div>
            <br><br><br>

            <div class="row" align="center">
                <p>
                    <section>
                        <img src="./img/kiwi.jpeg">
                    </section>
                    Ask us if you need anything more than them!Ask us if you need anything more than them!Ask us if you need anything more than them!Ask us if you need anything more than them!
                    Ask us if you need anything more than them!Ask us if you need anything more than them!Ask us if you need anything more than them!Ask us if you need anything more than them!
                    Ask us if you need anything more than them!Ask us if you need anything more than them!Ask us if you need anything more than them!Ask us if you need anything more than them!
                    Ask us if you need anything more than them!Ask us if you need anything more than them!Ask us if you need anything more than them!Ask us if you need anything more than them!
                </p>
            </div>
            <br><br><br>

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
