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
                if (!isset($_SESSION['email'])) {
                    echo "<script>alert(\"You need to sign in first.\");</script>";
                    echo '<script>window.location.href = "signin.php";</script>';
                    exit();
                }
                include('./includes/connection.php');

                if (isset($_GET['company'])) {
                    $company = $_GET['company'];
                    $_SESSION['company'] = $company;
                } else {
                    $company = $_SESSION['company'];
                }
                echo '<div align="center"><b>Company : '.$company.'</b></div>';

                include('./includes/data_range.html');

                include('./includes/sort.php');
                if (isset($_GET['st'])) {
                    $_SESSION['sort'] = $_GET['st'];
                    echo '<script>window.location.href = "worksheet_company.php";</script>';
                }

                echo '
                    <table id="ResponsiveTable" border="2" width="100%">
                        <thead id="HeadRow">
                            <tr style="border: 2px double black;" bgcolor="#c9c9c9">
                                <td align="center"><b><a href="?orderBy=invoice">Invoice #</a></b></td>
                                <td align="center"><b><a href="?orderBy=po">P.O.</a></b></td>
                                <td align="center"><b><a href="?orderBy=apt">Apt</a></b></td>
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

                $orderBy = array('invoice', 'po', 'apt', 'unit', 'size', 'price', 'salary','date', 'isworkdone');
                $order = 'date';
                if (isset($_GET['orderBy']) && in_array($_GET['orderBy'], $orderBy)) {
                    $order = $_GET['orderBy'];
                }
                $sql = "SELECT * FROM Worksheet WHERE company=\"".$company."\" ";
				if (isset($_POST['date']) && isset($_POST['end_date'])) {
                    $start_date = $_POST['date'];
                    $end_date = $_POST['end_date'];
                    if (strlen($end_date) > 0) {
                        $sql .= "AND DATE(date) >= '$start_date' AND DATE(date) <= '$end_date' ";
                    } else {
                        $sql .= "AND DATE(date) >= '$start_date' ";
                    }
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
                    if ($temp_invoice == null) $temp_invoice = '-';

                    $temp_po = $row['PO'];
                    if ($temp_po == null) $temp_po = '-';

                    $temp_apt = $row['apt'];
                    if ($temp_apt == null) $temp_apt = '-';

                    $temp_manager = $row['manager'];
                    if ($temp_manager == null) $temp_manager = '-';

                    $temp_unit = $row['unit'];
                    if ($temp_unit == null) $temp_unit = '-';

                    $temp_size = $row['size'];
                    if ($temp_size == null) $temp_size = '-';

                    $temp_price = $row['price'];
                    if ($temp_price == null) $temp_price = '-';

                    $temp_salary = $row['salary'];
                    if ($temp_salary == null) $temp_salary = '-';

                    $temp_profit = $row['profit'];
                    if ($temp_profit == null) $temp_profit = '-';

                    $temp_description = $row['description'];
                    if ($temp_description == null) $temp_description = '-';

                    $temp_date = $row['date'];
                    if ($temp_date == null) $temp_date = '-';

                    echo '<tbody>';
                    if ($isOdd) {
                        $isOdd = false;
                        echo '<tr bgcolor="#e8fff1">';
                    } else {
                        $isOdd = true;
                        echo '<tr>';
                    }

                    echo '
                                <td tableHeadData="Invoice #" align="center"><a href="invoice_detail.php?invoice_num='.$temp_invoice.'">'.$temp_invoice.'</a></td>
                                <td tableHeadData="P.O." align="center">'.$temp_po.'</td>
                                <td tableHeadData="Apt" align="center"><a href="worksheet_apt.php?apt='.$temp_apt.'&company='.$row['company'].'">'.$temp_apt.'</a></td>
                                <td tableHeadData="Manager" align="center"><a href="worksheet_manager.php?manager='.$temp_manager.'">'.$temp_manager.'</a></td>
                                <td tableHeadData="Unit #" align="center">'.$temp_unit.'</td>
                                <td tableHeadData="Size" align="center">'.$temp_size.'</td>
                                <td tableHeadData="Price" align="center">'.$temp_price.'</td>
                    ';
                    if ($_SESSION['isadmin'] == 2) {
                        echo '
                            <td tableHeadData="Salary" align="center">'.$temp_salary.'</td>
                            <td tableHeadData="Profit" align="center">'.$temp_profit.'</td>
                        ';
                    }
                    echo '
                                <td tableHeadData="Description" align="center"><a class="lineBreak" href="worksheet_description.php?invoice='.$temp_invoice.'&apt='.$temp_apt.'&unit='.$temp_unit.'&size='.$temp_size.'&from_company=1">'.$temp_description.'</a></td>
                                <td tableHeadData="Date" align="center">'.$temp_date.'</td>
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

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>
