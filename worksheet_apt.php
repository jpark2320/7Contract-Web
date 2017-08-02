<?php 
    if(!isset($_SESSION)) {
        session_start();
    }
?>
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

                if (isset($_GET['apt'])) {
                    $apt = $_GET['apt'];
                    $_SESSION['apt'] = $apt;
                } else {
                    $apt = $_SESSION['apt'];
                    $_SESSION['apt'] = $apt;
                }

                if (isset($_GET['company'])) {
                    $company = $_GET['company'];
                } else {
                    $company = $_SESSION['company'];
                }
                echo '<div align="center"><b>Apt : '.$apt.'</b></div>';

                include('./includes/data_range.html');

				include('./includes/sort_pay.html');

                include('./includes/sort.php');
                if (isset($_GET['st'])) {
                    $_SESSION['sort'] = $_GET['st'];
                    echo '<script>window.location.href = "worksheet_apt.php";</script>';
                }

                echo '
                    <table id="ResponsiveTable" border="2" width="100%">
                        <thead id="HeadRow">
                            <tr style="border: 2px double black;" bgcolor="#c9c9c9">
                                <td align="center"><b><a href="?orderBy=ispaidoff">Check</a></b></td>
                                <td align="center"><b><a href="?orderBy=ispaidoff">Paid off</a></b></td>
                                <td align="center"><b><a href="?orderBy=invoice">Invoice #</a></b></td>
                                <td align="center"><b><a href="?orderBy=po">P.O.</a></b></td>
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
                $sql = "SELECT * FROM Worksheet WHERE apt=\"".$apt."\" AND company=\"".$company."\" ";
                if (isset($_POST['pay'])) {
                    if ($_POST['pay'] == 0) {
                        $sql .= 'AND ispaidoff=0 ';
                    } else if ($_POST['pay'] == 1) {
                        $sql .= 'AND ispaidoff=1 ';
                    } else {
                        $sql .= 'AND ispaidoff<2 ';
                    }
                } else {
                    $sql .= 'AND ispaidoff<2 ';
                }

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
                $isOdd = false;
                while($row = mysqli_fetch_array($result)) 
                {
                    $temp_invoice = '7C'.$row['invoice'];
                    if ($temp_invoice == null) $temp_invoice = '-';

                    $temp_po = $row['PO'];
                    if ($temp_po == null) $temp_po = '-';

                    $temp_company = $row['company'];
                    if ($temp_company == null) $temp_company = '-';

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
                        <form action="outstanding_pdf.php" method="post">
                            <td tableHeadData="Check" align="center">
                                <input type="checkbox" name="check[]" value="'.$temp_invoice.'">
                            </td>
                    ';

                    if ($row['ispaidoff'] == 1) {
                        echo '<td tableHeadData="Paid Off" align="center"><img src="./img/status_light_green" width="10px"></td>';
                    } else {
                        echo '<td tableHeadData="Paid Off" align="center"><img src="./img/status_light_red" width="10px"></td>';
                    }

                    echo '
                                    <td tableHeadData="Invoice #" align="center"><a href="invoice_detail.php?invoice_num='.$temp_invoice.'">'.$temp_invoice.'</a></td>
                                    <td tableHeadData="P.O." align="center">'.$temp_po.'</td>
                                    <td tableHeadData="Company" align="center"><a href="worksheet_company.php?company='.$temp_company.'">'.$temp_company.'</a></td>
                                    <td tableHeadData="Manager" align="center"><a href="worksheet_manager.php?manager='.$temp_manager.'">'.$temp_manager.'</a></td>
                                    <td tableHeadData="Unit #" align="center">'.$temp_unit.'</td>
                                    <td tableHeadData="Size" align="center">'.$temp_size.'</td>
                                    <td tableHeadData="Price" align="center">'.$temp_price.'</td>
                                    <td tableHeadData="Salary" align="center">'.$temp_salary.'</td>
                                    <td tableHeadData="Profit" align="center">'.$temp_profit.'</td>
                                    <td tableHeadData="Description" align="center"><a class="lineBreak" href="worksheet_description.php?invoice='.$temp_invoice.'&apt='.$row['apt'].'&unit='.$temp_unit.'&size='.$temp_size.'&from_apt=1">'.$temp_description.'</a></td>
                                    <td tableHeadData="Date" align="center">'.$temp_date.'</td>
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

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>
