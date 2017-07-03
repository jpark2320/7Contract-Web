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

                    if (isset($_GET['manager'])) {
                        $manager = $_GET['manager'];
                        $_SESSION['manager'] = $manager;
                    } else {
                        $manager = $_SESSION['manager'];
                    }

                    echo '<div align="center"><b>Manager : '.$manager.'</b></div>';

                    if (!isset($_SESSION['sort'])) {
                        $_SESSION['sort'] = 'asc';
                    }
                    if ($_SESSION['sort']=='asc') {
                        echo '<div align="left"><h><a href="?st=desc">Show descending order</a></h></div>';
                    } else {
                        echo '<div align="left"><h><a href="?st=asc">Show ascending order</a></h></div>';
                    }
                    if (isset($_GET['st'])) {
                        $_SESSION['sort'] = $_GET['st'];
                        echo '<script>window.location.href = "worksheet_manager.php";</script>';
                    }

                    echo '
                        <table border="2" width="958">
                            <thead>
                                <tr style="border: 2px double black;" bgcolor="#c9c9c9">
                                    <td align="center"><b><a href="?orderBy=invoice">Invoice #</a></b></td>
                                    <td align="center"><b><a href="?orderBy=po">P.O. #</a></b></td>
                                    <td align="center"><b><a href="?orderBy=company">Company</a></b></td>
                                    <td align="center"><b><a href="?orderBy=apt">Apt #</a></b></td>
                                    <td align="center"><b><a href="?orderBy=unit">Unit #</a></b></td>
                                    <td align="center"><b><a href="?orderBy=size">Size</a></b></td>
                                    <td align="center"><b><a href="?orderBy=price">Price</a></b></td>
                                    <td align="center"><b><a href="?orderBy=salary">Salary</a></b></td>
                                    <td align="center"><b><a href="?orderBy=profit">Profit</a></b></td>
                                    <td align="center"><b>Description</b></td>
                                    <td align="center"><b><a href="?orderBy=date">Date</a></b></td>
                                </tr>
                            </thead>
                    ';

                    $orderBy = array('invoice', 'po', 'apt', 'unit', 'size', 'price', 'date', 'isworkdone');
                    $order = 'date';
                    if (isset($_GET['orderBy']) && in_array($_GET['orderBy'], $orderBy)) {
                        $order = $_GET['orderBy'];
                    }
                    $sql = 'SELECT * FROM Worksheet WHERE manager="'.$manager.'" ORDER BY '.$order;
                    if ($_SESSION['sort']=='desc') {
                        $sql = $sql.' DESC';
                    }
                    $result = mysqli_query($conn, $sql);
                    if (!$result) {
                        printf("Error: %s\n", mysqli_error($conn));
                        exit();
                    }

                    $isOdd = false;
                    while($row = mysqli_fetch_array($result))
                    {
                        $temp_invoice = '7C'.$row['invoice'];
                        $temp_company = $row['company'];
                        $temp_apt = $row['apt'];
                        $temp_unit = $row['unit'];

                        echo '<tbody>';
                        if ($isOdd) {
                            $isOdd = false;
                            echo '<tr bgcolor="#ffeed3">';
                        } else {
                            $isOdd = true;
                            echo '<tr>';
                        }

                        echo '
                            <tbody>
                                <tr>
                                    <td align="center"><a href="invoice_detail.php?invoice_num='.$temp_invoice.'">'.$temp_invoice.'</a></td>
                                    <td align="center">'.$row['PO'].'</td>
                                    <td align="center"><a href="worksheet_company.php?company='.$temp_company.'">'.$temp_company.'</a></td>
                                    <td align="center"><a href="worksheet_apt.php?apt_num='.$temp_apt.'">'.$temp_apt.'</a></td>
                                    <td align="center">'.$temp_unit.'</td>
                                    <td align="center">'.$row['size'].'</td>
                                    <td align="center">'.$row['price'].'</td>
                                    <td align="center">'.$row['salary'].'</td>
                                    <td align="center">'.$row['profit'].'</td>
                                    <td align="center">'.$row['description'].'</td>
                                    <td align="center">'.$row['date'].'</td>
                                </tr>
                            </tbody>
                        ';
                    }
                    echo '</table>';
                    mysqli_close($conn);
                ?>
                <br>
                <input type="button" value="Back" onclick="location.href='worksheet.php'"></input>
            </div>
        </div>
        <br><br><br><br><br>

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>
