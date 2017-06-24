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
            <h3 class="text-center">Work History Details</h3><br>

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
                                        <td align="center"><b><a href="?orderBy=invoice">Invoice #</a></b></td>
                                        <td align="center"><b><a href="?orderBy=po">P.O. #</a></b></td>
                                        <td align="center"><b><a href="?orderBy=apt">Apt #</a></b></td>
                                        <td align="center"><b><a href="?orderBy=unit">Unit #</a></b></td>
                                        <td align="center"><b><a href="?orderBy=size">Size</a></b></td>
                                        <td align="center"><b><a href="?orderBy=price">Price</a></b></td>
                                        <td align="center"><b><a href="?orderBy=salary">Salary</a></b></td>
                                        <td align="center"><b><a href="?orderBy=profit">Profit</a></b></td>
                                        <td align="center"><b><a href="?orderBy=date">Date</a></b></td>
                                    </tr>
                                </thead>
                        ';

                        $orderBy = array('invoice', 'po', 'apt', 'unit', 'size', 'price', 'salary', 'profit', 'date');
                        $order = 'invoice';
                        if (isset($_GET['orderBy']) && in_array($_GET['orderBy'], $orderBy)) {
                            $order = $_GET['orderBy'];
                        }
                        $sql = 'SELECT * FROM Worksheet ORDER BY '.$order;
                        if ($_SESSION['sort']=='desc') {
                            $sql = $sql.' DESC';
                        }
                        $result = mysqli_query($conn, $sql);
                        $totalPrice = 0;
                        $totalSalary = 0;
                        $totalProfit = 0;
                        while($row = mysqli_fetch_array($result))
                        {
                            $temp = '7C'.$row['invoice'];
                            $temp2 = $row['apt'];
                            $temp3 = $row['unit'];
                            $totalPrice += $row['price'];
                            $totalSalary += $row['salary'];
                            $totalProfit += $row['profit'];
                            echo '
                                <tbody>
                                    <tr>
                            ';

                            echo '
                                        <td align="center"><a href="invoice_detail.php?invoice_num='.$temp.'">'.$temp.'</a></td>
                                        <td align="center">'.$row['PO'].'</td>
                                        <td align="center">'.$temp2.'</td>
                                        <td align="center">'.$temp3.'</td>
                                        <td align="center">'.$row['size'].'</td>
                                        <td align="center">'.$row['price'].'</td>
                                        <td align="center">'.$row['salary'].'</td>
                                        <td align="center">'.$row['profit'].'</td>
                                        <td align="center">'.$row['date'].'</td>
                            ';
                            echo '

                                    </tr>
                                </tbody>
                            ';
                        }
                        echo '
                                <tbody>
                                    <tr>
                            ';

                            echo '
                                        <td align="center"></td>
                                        <td align="center"></td>
                                        <td align="center"></td>
                                        <td align="center"></td>
                                        <td align="center"></td>
                                        <td align="center"><b>'.number_format($totalPrice, 2, '.', '').'</b></td>
                                        <td align="center"><b>'.number_format($totalSalary, 2, '.', '').'</b></td>
                                        <td align="center"><b>'.number_format($totalProfit, 2, '.', '').'</b></td>
                                        <td align="center"><b></b></td>
                            ';
                            echo '

                                    </tr>
                                </tbody>
                            ';
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
