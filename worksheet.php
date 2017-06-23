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

                        include('./includes/sort.php');

                        echo '
                            <table border="2" width="958">
                                <thead>
                                    <tr>
                                        <td align="center"><b><a href="?orderBy=isworkdone">Status</a></b></td>
                                        <td align="center"><b><a href="?orderBy=invoice">Invoice #</a></b></td>
                                        <td align="center"><b><a href="?orderBy=po">P.O. #</a></b></td>
                                        <td align="center"><b><a href="?orderBy=apt">Apt #</a></b></td>
                                        <td align="center"><b><a href="?orderBy=unit">Unit #</a></b></td>
                                        <td align="center"><b><a href="?orderBy=size">Size</a></b></td>
                                        <td align="center"><b><a href="?orderBy=price">Price</a></b></td>
                                        <td align="center"><b>Description</b></td>
                                        <td align="center"><b><a href="?orderBy=date">Date</a></b></td>
                                        <td align="center"><b>Assign</b></b></td>
                                        <td align="center"><b>Edit</b></b></td>
                                    </tr>
                                </thead>
                        ';

                        $orderBy = array('invoice', 'po', 'apt', 'unit', 'size', 'price', 'date', 'isworkdone');
                        $order = 'date';
                        if (isset($_GET['orderBy']) && in_array($_GET['orderBy'], $orderBy)) {
                            $order = $_GET['orderBy'];
                        }
                        $sql = 'SELECT * FROM Worksheet ORDER BY '.$order;
                        if ($_SESSION['sort']=='desc') {
                            $sql = $sql.' DESC';
                        }
                        $result = mysqli_query($conn, $sql);

                        while($row = mysqli_fetch_array($result))
                        {
                            $temp = '7C'.$row['invoice'];
                            $temp2 = $row['apt'];
                            $temp3 = $row['unit'];

                            echo '
                                <tbody>
                                    <tr>
                            ';

                            if ($row['isworkdone'] == 2) {
                                echo '<td align="center"><img src="./img/status_light_green" width="10px"></td>';
                            } else if ($row['isworkdone'] == 1) {
                                echo '<td align="center"><img src="./img/status_light_yellow" width="10px"></td>';
                            } else {
                                echo '<td align="center"><img src="./img/status_light_red" width="10px"></td>';
                            }

                            echo '
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
                                        <td align="center"><a href="edit_admin.php?invoice_num='.$temp.'">Edit</a></td>
                                    </tr>
                                </tbody>
                            ';
                        }
                        echo '</table>';
                    } else {

                        include('./includes/sort.php');

                        echo '
                            <table border="2" width="958">
                                <thead>
                                    <tr>
                                        <td align="center"><b><a href="?orderBy=isworkdone">Status</a></b></td>
                                        <td align="center"><b><a href="?orderBy=apt">Apt #</a></b></td>
                                        <td align="center"><b><a href="?orderBy=unit">Unit #</a></b></td>
                                        <td align="center"><b>Message</b></td>
                                        <td align="center"><b>Comment</b></td>
                                        <td align="center"><b><a href="?orderBy=date">Date</a></b></td>
                                        <td align="center"><b>Edit</b></td>
                                        <td align="center"><b>Process</b></td>
                                    </tr>
                                </thead>
                        ';

                        $orderBy = array('apt', 'unit', 'date', 'isworkdon');
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
                            $temp = $row['invoice'];
                            $temp2 = $row['email'];

                            echo '
                                <tbody>
                                    <tr>
                            ';

                            if ($row['isworkdone'] == 1) {
                                echo '<td align="center"><img src="./img/status_light_green" width="10px"></td>';
                            } else {
                                echo '<td align="center"><img src="./img/status_light_red" width="10px"></td>';
                            }

                            echo '
                                        <td align="center">'.$row['apt'].'</td>
                                        <td align="center">'.$row['unit'].'</td>
                                        <td align="center">'.$row['message'].'</td>
                                        <td align="center">'.$row['comment'].'</td>
                                        <td align="center">'.$row['date'].'</td>
                                        <td align="center"><a href="edit_user.php?invoice_num='.$temp.'">Edit</a></td>
                                        <td align="center"><a href="workdone_process.php?invoice_num='.urlencode($temp).' &email_user='.urlencode($temp2).'">Work Done</a></td>
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
