<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <!-- Header Tag -->
    <?php include('./includes/head_tag.html'); ?>
    <body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="50">

        <!-- Header -->
        <?php include('./includes/nav_bar.php'); ?>

        <!-- Body -->
        <div class="primary" align="center">
            <h3 class="text-center">Worksheet!</h3><br>

            <?php
                include('./includes/data_range.html');
                if (!isset($_SESSION['email'])) {
                    echo "<script>alert(\"You need to sign in first.\");</script>";
                    echo '<script>window.location.href = "signin.php";</script>';
                    exit();
                }
                // connection with mysql database
                include('./includes/connection.php');

                if (isset($_GET['company'])) {
                    $company = $_GET['company'];
                    $_SESSION['company'] = $company;
                } else {
                    $company = $_SESSION['company'];
                }

                echo '<div align="center"><b>Company : '.$company.'</b></div>';

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
                    echo '<script>window.location.href = "worksheet_company.php";</script>';
                }

                echo '
                    <table border="2" width="100%">
                        <thead>
                            <tr style="border: 2px double black;" bgcolor="#c9c9c9">
                                <td align="center"><b><a href="?orderBy=invoice">Invoice #</a></b></td>
                                <td align="center"><b><a href="?orderBy=po">P.O. #</a></b></td>
                                <td align="center"><b><a href="?orderBy=apt">Apt #</a></b></td>
                                <td align="center"><b><a href="?orderBy=manager">Manager</a></b></td>
                                <td align="center"><b><a href="?orderBy=unit">Unit #</a></b></td>
                                <td align="center"><b><a href="?orderBy=size">Size</a></b></td>
                                <td align="center"><b><a href="?orderBy=price">Price</a></b></td>
                ';
                if ($_SESSION['isadmin'] == 2) {
                    echo '
                        <td align="center"><b><a href="?orderBy=salary">Salary</a></b></td>
                        <td align="center"><b><a href="?orderBy=profit">Profit</a></b></td>
                    ';
                }
                echo '
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
                $sql = "SELECT * FROM Worksheet WHERE company=\"".$company."\" ";
                if (isset($_POST['year']) && isset($_POST['month'])) {
                    $sql .= "AND YEAR(date)=".$_POST['year']." AND MONTH(date)=".$_POST['month']." ";
                } else if (isset($_POST['year'])){
                    $sql .= "AND YEAR(date)=".$_POST['year']." ";
                }
                $sql .= 'ORDER BY '.$order;
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
                    $temp_apt = $row['apt'];
                    $temp_manager = $row['manager'];
                    $temp_unit = $row['unit'];

                    echo '<tbody>';
                    if ($isOdd) {
                        $isOdd = false;
                        echo '<tr bgcolor="#e8fff1">';
                    } else {
                        $isOdd = true;
                        echo '<tr>';
                    }

                    echo '
                                <td align="center"><a href="invoice_detail.php?invoice_num='.$temp_invoice.'">'.$temp_invoice.'</a></td>
                                <td align="center">'.$row['PO'].'</td>
                                <td align="center"><a href="worksheet_apt.php?apt='.$temp_apt.'">'.$temp_apt.'</a></td>
                                <td align="center"><a href="worksheet_manager.php?manager='.$temp_manager.'">'.$temp_manager.'</a></td>
                                <td align="center">'.$temp_unit.'</td>
                                <td align="center">'.$row['size'].'</td>
                                <td align="center">'.$row['price'].'</td>
                    ';
                    if ($_SESSION['isadmin'] == 2) {
                        echo '
                            <td align="center">'.$row['salary'].'</td>
                            <td align="center">'.$row['profit'].'</td>
                        ';
                    }
                    echo '
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
        <br><br><br><br><br>

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>
