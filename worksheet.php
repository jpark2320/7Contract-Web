<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <!-- Header Tag -->
    <?php include('./includes/head_tag.html'); ?>
    <body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="50">

        <!-- Header -->
        <?php include('./includes/nav_bar.php'); ?>

        <!-- Body -->
        <div class="container">
            <h3 class="text-center">Worksheet!</h3><br>

            <div class="row" align="center">
                <?php
                    if (!isset($_SESSION['email'])) {
                        echo "<script>alert(\"You need to sign in first.\");</script>";
                        echo '<script>window.location.href = "signin.php";</script>';
                        exit();
                    }
                    // connection with mysql database
                    include('./includes/connection.php');

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
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>
