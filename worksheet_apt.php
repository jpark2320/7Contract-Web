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

                if (isset($_GET['apt'])) {
                    $apt = $_GET['apt'];
                    $_SESSION['apt'] = $apt;
                } else {
                    $apt = $_SESSION['apt'];
                    $_SESSION['apt'] = $apt;
                }
                $company = $_GET['company'];
                echo '<div align="center"><b>Apt : '.$apt.'</b></div>';

                if (!isset($_SESSION['sort'])) {
                    $_SESSION['sort'] = 'asc';
                }
                if ($_SESSION['sort']=='asc') {
                    echo '<div align="left" style="float: left;"><h><a href="?st=desc">Show descending order</a></h></div>';
                } else {
                    echo '<div align="left" style="float: left;"><h><a href="?st=asc">Show ascending order</a></h></div>';
                }
                if ($_SESSION['unpaid']) {
                    echo '<div align="right"><a href="?unpaid=0">Show All</a></div>';
                } else {
                    echo '<div align="right"><a href="?unpaid=1">Show Unpaid</a></div>';
                }
                if (isset($_GET['st'])) {
                    $_SESSION['sort'] = $_GET['st'];
                    echo '<script>window.location.href = "worksheet_apt.php";</script>';
                }

                echo '
                    <table border="2" width="100%">
                        <thead>
                            <tr style="border: 2px double black;" bgcolor="#c9c9c9">
                                <td align="center"><b><a href="?orderBy=ispaidoff">Check</a></b></td>
                                <td align="center"><b><a href="?orderBy=ispaidoff">Paid off</a></b></td>
                                <td align="center"><b><a href="?orderBy=invoice">Invoice #</a></b></td>
                                <td align="center"><b><a href="?orderBy=po">P.O. #</a></b></td>
                                <td align="center"><b><a href="?orderBy=company">Company</a></b></td>
                                <td align="center"><b><a href="?orderBy=manager">Manager</a></b></td>
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

                $orderBy = array('invoice', 'po', 'apt', 'unit', 'size', 'price', 'date', 'ispaidoff');
                $order = 'date';
                if (isset($_GET['orderBy']) && in_array($_GET['orderBy'], $orderBy)) {
                    $order = $_GET['orderBy'];
                }
                $sql = "SELECT * FROM Worksheet WHERE apt=\"".$apt."\" AND company=\"".$company."\"";
                if ($_SESSION['unpaid']) {
                    $sql .= 'AND ispaidoff=0 ';
                }
                if (strlen($_POST['year'])>0 && strlen($_POST['month'])>0) {
                    $sql .= "AND YEAR(date)=".$_POST['year']." AND MONTH(date)=".$_POST['month']." ";
                } else if (strlen($_POST['year'])>0){
                    $sql .= "AND YEAR(date)=".$_POST['year']." ";
                }
                $sql .= 'ORDER BY '.$order;
                if (isset($_GET['unpaid'])) {
                    $_SESSION['unpaid'] = $_GET['unpaid'];
                    echo '<script>window.location.href = "worksheet_apt.php";</script>';
                }
                if ($_SESSION['sort']=='desc') {
                    $sql = $sql.' DESC';
                }
                
                $result = mysqli_query($conn, $sql);
                if (!$result) {
                    printf("Error: %s\n", mysqli_error($conn));
                    exit();
                }

                while($row = mysqli_fetch_array($result)) {
                    $temp_invoice = '7C'.$row['invoice'];
                    $temp_company = $row['company'];
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
                        <form action="outstanding_pdf.php" method="post">
                            <td align="center">
                                <input type="checkbox" name="check[]" value="'.$temp_invoice.'">
                            </td>
                    ';

                    if ($row['ispaidoff'] == 1) {
                        echo '<td align="center"><img src="./img/status_light_green" width="10px"></td>';
                    } else {
                        echo '<td align="center"><img src="./img/status_light_red" width="10px"></td>';
                    }

                    echo '
                                    <td align="center"><a href="invoice_detail.php?invoice_num='.$temp_invoice.'">'.$temp_invoice.'</a></td>
                                    <td align="center">'.$row['PO'].'</td>
                                    <td align="center"><a href="worksheet_company.php?company='.$temp_company.'">'.$temp_company.'</a></td>
                                    <td align="center"><a href="worksheet_manager.php?manager='.$temp_manager.'">'.$temp_manager.'</a></td>
                                    <td align="center">'.$temp_unit.'</td>
                                    <td align="center">'.$row['size'].'</td>
                                    <td align="center">'.$row['price'].'</td>
                                    <td align="center">'.$row['salary'].'</td>
                                    <td align="center">'.$row['profit'].'</td>
                                    <td align="center"><a href="worksheet_description.php?invoice='.$row['invoice'].'&apt='.$row['apt'].'&unit='.$row['unit'].'&size='.$row['size'].'&from_apt=1">'.$row['description'].'</a></td>
                                    <td align="center">'.$row['date'].'</td>
                                </tr>
                            </tbody>
                    ';
                }
                echo '
                        </table>
                        <br>
                        <input type="submit" name="sub" value="Make PDF"></input>
                        <input type="button" value="Back" onclick="location.href=\'worksheet.php\'"></input>
                    </form>
                ';
                mysqli_close($conn);
            ?>
        </div>
        <br><br><br><br><br>

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>
