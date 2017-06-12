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
        <div id="contact" class="container">
            <h3 class="text-center">Write a worksheet!</h3><br>

            <div class="row" align="center">
                <?php
                    $servername = "localhost:3307";
                    $username = "root";
                    $password = "";
                    $db = "7Contract";

                    // Create connection
                    $conn = new mysqli($servername, $username, $password, $db);

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
                    $sql = "SELECT * FROM Worksheet";
                    $result = mysqli_query($conn, $sql);

                    echo '
                        <table border="2" width="1000">
                            <thead>
                                <tr>
                                    <td align="center"><b>ID</b></td>
                                    <td align="center"><b>Apt #</b></td>
                                    <td align="center"><b>Unit #</b></td>
                                    <td align="center"><b>Invoice #</b></td>
                                    <td align="center"><b>P.O. #</b></td>
                                    <td align="center"><b>Cost</b></td>
                                    <td align="center"><b># of Workers</b></td>
                                    <td align="center"><b>Assign</b></td>
                                </tr>
                            </thead>';

                            while($row = mysqli_fetch_array($result))
                            {
                                echo '
                                    <tbody>
                                        <tr>
                                            <td align="center">'.$row['id'].'</td>
                                            <td align="center">'.$row['Apt'].'</td>
                                            <td align="center">'.$row['Unit_Num'].'</td>
                                            <td align="center">'.$row['Invoice_Num'].'</td>
                                            <td align="center">'.$row['PO_Num'].'</td>
                                            <td align="center">'.$row['cost'].'</td>
                                            <td align="center">'.$row['Num_Worker'].'</td>
                                            <td align="center"><input type="submit" value="Send" onclick="location.href=\'assign.php\'"></input></td>
                                        </tr>
                                    </tbody>';
                            }
                    echo '</table>';
                    mysqli_close($conn);
                ?>


                </tbody>
                <br><br>
                <table border="2" width="1000">
                    <thead>
                        <tr>
                            <td align="center"><b>Apt</b></th>
                            <td align="center"><b>Unit #</b></th>
                            <td align="center"><b>Invoice #</b></th>
                            <td align="center"><b>P.O. #</b></th>
                            <td align="center"><b>Cost</b></th>
                            <td align="center"><b># of Workers</b></th>
                            <td align="center"><b>Add</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        <form action="worksheet_process.php" method="POST">
                            <tr>
                                <td align="center"><input type="text" name="aptcode" value="<?php echo isset($_SESSION['uid']) ? $_SESSION['uid'] : '' ?>" /></td>
                                <td align="center"><input type="text" name="unit_num"></td>
                                <td align="center"><input type="text" name="invoice"></td>
                                <td align="center"><input type="text" name="po"></td>
                                <td align="center"><input type="text" name="cost"></td>
                                <td align="center"><input type="text" name="num_workers"></td>
                                <td align="center"><input type="submit" value="OK"></td>
                            </tr>
                        </form>
                    </tbody>
                </table>
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
