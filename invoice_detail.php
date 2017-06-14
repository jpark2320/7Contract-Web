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
            <h3 class="text-center">Invoice # Details</h3><br>

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
                    if (!isset($_SESSION['sort'])) {
                        $_SESSION['sort'] = 'asc';
                    }
                    if ($_SESSION['sort']=='asc') {
                        echo '<div align="left"><h><a href="?st=desc">Show descending order</a></h><div>';
                    } else {
                        echo '<div align="left"><h><a href="?st=asc">Show ascending order</a></h><div>';
                    }
                    if (isset($_GET['st'])) {
                        $_SESSION['sort'] = $_GET['st'];
                        echo '<script>window.location.href = "invoice_detail.php";</script>';
                    }
                    echo '
                            <table border="2" width="1000">
                                <thead>
                                    <tr>
                                        <td align="center"><a href="?orderBy=A.first">First Name</a></td>
                                        <td align="center"><a href="?orderBy=A.last">Last Name</a></td>
                                        <td align="center"><a href="?orderBy=A.email">Email Address</a></td>
                                        <td align="center"><b>Message</b></td>
                                        <td align="center"><b>Comment</b></td>
                                        <td align="center"><a href="?orderBy=B.date">Date</a></td>
                                    </tr>
                                </thead>';
                        $orderBy = array('A.first', 'A.last', 'A.email', 'B.date');
                        $order = 'date';
                        if (isset($_GET['orderBy']) && in_array($_GET['orderBy'], $orderBy)) {
                            $order = $_GET['orderBy'];
                        }
                        $sql = 'SELECT * FROM
                        	(SELECT users.first, users.last, users.email from users) AS A 
							INNER JOIN 
							(SELECT * FROM SubWorksheet WHERE invoice = \'1\') AS B 
							ON A.email =B.email ORDER BY '.$order;
                        if ($_SESSION['sort']=='desc') {
                            $sql = $sql.' DESC';
                        } 
                        $result = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_array($result))
                        {
                            echo '
                                <tbody>
                                    <tr>
                                        <td align="center">'.$row['first'].'</td>
                                        <td align="center">'.$row['last'].'</td>
                                        <td align="center">'.$row['email'].'</td>
                                        <td align="center">'.$row['message'].'</td>
                                        <td align="center">'.$row['comment'].'</td>
                                        <td align="center">'.$row['date'].'</td>
                                    </tr>
                                </tbody>';
                        }
                        echo '</table>';
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
