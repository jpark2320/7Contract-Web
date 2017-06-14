<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
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

        <!-- Header -->
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

        <!-- Body -->
        <div class="container">
            <h3 class="text-center">Worksheet!</h3><br>

            <div class="row" align="center">
                <?php
                    if (!isset($_SESSION['email'])) {
                        echo "<script>
                                alert(\"You need to sign in first\");
                                </script>";
                        echo '<script>window.location.href = "signin.php";</script>';
                        exit();
                    }
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

                    if ($_SESSION['isadmin']) {

                        echo '<div align="right"><a href="worksheet_add.php"><img src="./img/worksheet_add.png" width="42"></a></div>';

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
                            echo '<script>window.location.href = "worksheet.php";</script>';
                        }

                        echo '
                            <table border="2" width="958">
                                <thead>
                                    <tr>
                                        <td align="center"><a href="?orderBy=invoice">Invoice #</a></td>
                                        <td align="center"><a href="?orderBy=po">P.O. #</a></td>
                                        <td align="center"><a href="?orderBy=apt">Apt #</a></td>
                                        <td align="center"><a href="?orderBy=unit">Unit #</a></td>
                                        <td align="center"><a href="?orderBy=size">Size</a></td>
                                        <td align="center"><a href="?orderBy=price">Price</a></td>
                                        <td align="center"><b>Description</b></td>
                                        <td align="center"><a href="?orderBy=date">Date</a></td>
                                        <td align="center"><b>Assign</b></td>
                                        <td align="center"><b>Edit</b></td>
                                    </tr>
                                </thead>';
                        $orderBy = array('invoice', 'po', 'apt', 'unit', 'size', 'price', 'date');
                        $order = 'date';
                        if (isset($_GET['orderBy']) && in_array($_GET['orderBy'], $orderBy)) {
                            $order = $_GET['orderBy'];
                        }
                        $sql = 'SELECT * FROM Worksheet ORDER BY '.$order;
                        if ($_SESSION['sort']=='desc') {
                            $sql = $sql.' DESC';
                        }
                        $result = mysqli_query($conn, $sql);
                        unset($_SESSION['i_num']);
                        unset($_SESSION['a_num']);
                        unset($_SESSION['u_num']);
                        while($row = mysqli_fetch_array($result))
                        {
                            $temp = $row['invoice'];
                            $temp2 = $row['apt'];
                            $temp3 = $row['unit'];

                            echo '
                                <tbody>
                                    <tr>
                                        <td align="center"><a href="invoice_detail.php?invoice_num='.$temp.'">'.$temp.'</a></td>
                                        <td align="center">'.$row['PO'].'</td>
                                        <td align="center">'.$temp2.'</td>
                                        <td align="center">'.$temp3.'</td>
                                        <td align="center">'.$row['size'].'</td>
                                        <td align="center">'.$row['price'].'</td>
                                        <td align="center">'.$row['description'].'</td>
                                        <td align="center">'.$row['date'].'</td>
                            ';
                            echo '
                                        <td align="center">
                                            <a href="assign.php?invoice_num='.$temp.' &apt_num='.$temp2.' &unit_num='.$temp3.'">Send</a>
                                        </td>
                                        <td align="center"><a href="edit.php?invoice_num='.$temp.'">Edit</a></td>
                                    </tr>
                                </tbody>
                            ';
                        }
                        echo '</table>';
                    } else {
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
                            echo '<script>window.location.href = "worksheet.php";</script>';
                        }
                        echo '
                            <table border="2" width="958">
                                <thead>
                                    <tr>
                                        <td align="center"><a href="?orderBy=apt">Apt #</a></td>
                                        <td align="center"><a href="?orderBy=unit">Unit #</a></td>
                                        <td align="center"><b>Message</b></td>
                                        <td align="center"><b>Comment</b></td>
                                        <td align="center"><a href="?orderBy=date">Date</a></td>
                                    </tr>
                                </thead>';
                        $orderBy = array('apt', 'unit', 'date');
                        $order = 'date';
                        if (isset($_GET['orderBy']) && in_array($_GET['orderBy'], $orderBy)) {
                            $order = $_GET['orderBy'];
                        }
                        $sql = 'SELECT * FROM SubWorksheet WHERE email =\''.$_SESSION['email'].'\' ORDER BY '.$order;
                        if ($_SESSION['sort']=='desc') {
                            $sql = $sql.' DESC';
                        }
                        $result = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_array($result))
                        {
                            echo '
                                <tbody>
                                    <tr>
                                        <td align="center">'.$row['apt'].'</td>
                                        <td align="center">'.$row['unit'].'</td>
                                        <td align="center">'.$row['message'].'</td>
                                        <td align="center">'.$row['comment'].'</td>
                                        <td align="center">'.$row['date'].'</td>
                                    </tr>
                                </tbody>';
                        }
                        echo '</table>';
                    }
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