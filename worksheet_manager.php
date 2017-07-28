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
                    echo '<div align="left"><h><a href="?st=desc">Show Descending Order</a></h></div>';
                } else {
                    echo '<div align="left"><h><a href="?st=asc">Show Ascending Order</a></h></div>';
                }
                if (isset($_GET['st'])) {
                    $_SESSION['sort'] = $_GET['st'];
                    echo '<script>window.location.href = "worksheet_manager.php";</script>';
                }

                echo '
                    <table id="ResponsiveTable" border="2" width="100%">
                        <thead id="HeadRow">
                            <tr style="border: 2px double black;" bgcolor="#c9c9c9">
                                <td align="center"><b><a href="?orderBy=invoice">Invoice #</a></b></td>
                                <td align="center"><b><a href="?orderBy=po">P.O.</a></b></td>
                                <td align="center"><b><a href="?orderBy=company">Company</a></b></td>
                                <td align="center"><b><a href="?orderBy=apt">Apt</a></b></td>
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
                $sql = "SELECT * FROM Worksheet WHERE manager=\"".$manager."\" ";
				if (isset($_POST['year']) && isset($_POST['month'])) {
					if (strlen($_POST['year'])>0 && strlen($_POST['month'])>0) {
						$sql .= "AND YEAR(date)=".$_POST['year']." AND MONTH(date)=".$_POST['month']." ";
					} else if (strlen($_POST['year'])>0){
						$sql .= "AND YEAR(date)=".$_POST['year']." ";
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

                    $temp_company = $row['company'];
                    if ($temp_company == null) $temp_company = '-';

                    $temp_apt = $row['apt'];
                    if ($temp_apt == null) $temp_apt = '-';

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
                    if (isset($isOdd)) {
                        if ($isOdd) {
                            $isOdd = false;
                            echo '<tr bgcolor="#e8fff1">';
                        } else {
                            $isOdd = true;
                            echo '<tr>';
                        }
                    }

                    echo '
                                <td tableHeadData="Invoice #" align="center"><a href="invoice_detail.php?invoice_num='.$temp_invoice.'">'.$temp_invoice.'</a></td>
                                <td tableHeadData="P.O." align="center">'.$temp_po.'</td>
                                <td tableHeadData="Company" align="center"><a href="worksheet_company.php?company='.$temp_company.'">'.$temp_company.'</a></td>
                                <td tableHeadData="Apt" align="center"><a href="worksheet_apt.php?apt='.$temp_apt.'&company='.$temp_company.'">'.$temp_apt.'</a></td>
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
                                <td tableHeadData="Description" align="center"><a href="worksheet_description.php?invoice='.$temp_invoice.'&apt='.$temp_apt.'&unit='.$temp_unit.'&size='.$temp_size.'&from_manager=1">'.$temp_description.'</a></td>
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
