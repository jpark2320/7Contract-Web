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
        <div id="contact" class="container">
            <h3 class="text-center">Assign workers!</h3><br>

            <div class="row" align="center">
                <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $db = "7contract";

                    // Create connection
                    $conn = new mysqli($servername, $username, $password, $db);

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
                    $sql = "SELECT * FROM users";
                    $result = mysqli_query($conn, $sql);

                    echo '
                        <table border="2" width="500px">
                            <thead>
                                <tr>
                                    <td align="center" width="200px"><b>Subcontractors</b></th>
                                    <td align="center" width="100px"></th>
                                    <td align="center" width="200px"><b>Added</b></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <form class="" action="assign.php" method="post">
                                        <td align="center">
                                            <select name="workers[]" multiple="multiple" size="10">';

                            while($row = mysqli_fetch_array($result))
                            {
                                echo '<option value="'. $row['email'] .'">'.$row['email'].'</option>';
                            }
                            echo '
                                    </select>
                                </td>
                                <td align="center">
                                    <input type="submit" name="" value="->">
                                </td>
                                <td align="center">
                                    <select multiple="multiple" size="10">
                            ';
                            if (isset($_POST['workers'])) {
                                $workersArray = $_POST['workers'];
                                for ($i = 0; $i < sizeof($workersArray); $i++) {
                                    echo '<option value="">'.$workersArray[$i].'</option>';
                                }
                                echo '
                                                </select>
                                            </td>
                                        </form>
                                    </tr>
                                </tbody>';
                            }
                    echo '</table>';
                    echo '
                        <h5 class="text-center" font-color="red">When you need multiple choices, use "control" key.</h5>
                        <br>
                        <input type="submit" value="Confirm" onclick="location.href=\'assign.php\'"></input>
                        <input type="submit" value="Back" onclick="location.href=\'worksheet.php\'"></input>';
                    mysqli_close($conn);
                ?>
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
