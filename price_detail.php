<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <!-- Header Tag -->
    <?php include('./includes/head_tag.html'); ?>
    <body id="myPage">

        <!-- Header -->
        <?php include('./includes/nav_bar.php'); ?>

        <!-- Body -->
        <div class="primary" align="center">
            <h3 class="text-center">Work History Details</h3><br>
            <?php
                include('./includes/data_range.html');
                if (!isset($_SESSION['email'])) {
                    echo "<script>alert(\"You need to sign in first.\");</script>";
                    echo '<script>window.location.href = "signin.php";</script>';
                    exit();
                }
                // connection with mysql database
                include('./includes/connection.php');

                if ($_SESSION['isadmin']) {

                    if (!isset($_SESSION['sort'])) {
                        $_SESSION['sort'] = 'asc';
                    }
                    if ($_SESSION['sort']=='asc') {
                        echo '<div align="left"><h><a href="?st=desc">Show Descending Order</a></h></div>';
                    } else {
                        echo '<div align="left"><h><a href="?st=asc">Show Ascending Order</a></h></div>';
                    }
					echo '
                        <div align="right" style="float: right;">
                            <form action="" method="post">
                                <select id="pay" name="pay">
                                    <option value="2">Show All</option>
                                    <option value="1">Show Paid</option>
                                    <option value="0">Show Unpaid</option>
                                </select>
                                <input type="submit" value="Go!"/>
                            </form>
                        </div>
                        <br></br>
                    ';

                    if (isset($_GET['st'])) {
                        $_SESSION['sort'] = $_GET['st'];
                        echo '<script>window.location.href = "price_detail.php";</script>';
                    }

                    echo '
                        <table id="ResponsiveTable" border="2" width="100%">
                            <thead id="HeadRow">
                                <tr style="border: 2px double black;" bgcolor="#c9c9c9">
                                    <td align="center"><b><a href="?orderBy=ispaidoff">Paid Off</a></b></td>
                                    <td align="center"><b><a href="?orderBy=invoice">Invoice #</a></b></td>
                                    <td align="center"><b><a href="?orderBy=po">P.O.</a></b></td>
                                    <td align="center"><b><a href="?orderBy=apt">Apt</a></b></td>
                                    <td align="center"><b><a href="?orderBy=unit">Unit #</a></b></td>
                                    <td align="center"><b><a href="?orderBy=size">Size</a></b></td>
                                    <td align="center"><b><a href="?orderBy=price">Price</a></b></td>
                                    <td align="center"><b><a href="?orderBy=price">Recieved</a></b></td>
                                    <td align="center"><b><a href="?orderBy=salary">Salary</a></b></td>
                                    <td align="center"><b><a href="?orderBy=profit">Profit</a></b></td>
                                    <td align="center"><b><a href="?orderBy=date">Date</a></b></td>
                                    <td align="center"><b><a href="?orderBy=date">Recieve</a></b></td>
                                </tr>
                            </thead>
                    ';

                    $orderBy = array('invoice', 'po', 'apt', 'unit', 'size', 'price', 'salary', 'profit', 'date', 'ispaidoff');
                    $order = 'invoice';
                    if (isset($_GET['orderBy']) && in_array($_GET['orderBy'], $orderBy)) {
                        $order = $_GET['orderBy'];
                    }
                    $sql = 'SELECT * FROM Worksheet ';

					if (isset($_POST['pay'])) {
                        if ($_POST['pay'] == 0) {
							$sql .= 'WHERE ispaidoff=0 ';
						} else if ($_POST['pay'] == 1) {
                            $sql .= 'WHERE ispaidoff=1 ';
                        } else {
                            $sql .= 'WHERE ispaidoff<2 ';
                        }
					} else {
                        $sql .= 'WHERE ispaidoff<2 ';
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
                    if ($_SESSION['sort']=='desc') {
                        $sql = $sql.' DESC';
                    }
                    $result = mysqli_query($conn, $sql);
                    $totalPrice = 0;
                    $totalPaid = 0;
                    $totalSalary = 0;
                    $totalProfit = 0;

                    $isOdd = false;
                    while($row = mysqli_fetch_array($result))
                    {
                        $invoice = '7C'.$row['invoice'];
                        if ($invoice == null) $invoice = '-';

                        $po = $row['PO']
                        if ($po == null) $po = '-';

                        $apt = $row['apt'];
                        if ($apt == null) $apt = '-';

                        $unit = $row['unit'];
                        if ($unit == null) $unit = '-';

                        $size = $row['size'];
                        if ($size == null) $size = '-';

                        $price = $row['price'];
                        if ($price == null) $price = '-';

                        $paid = $row['paid'];
                        if ($paid == null) $paid = '-';

                        $salary = $row['salary'];
                        if ($salary == null) $salary = '-';

                        $profit = $row['profit'];
                        if ($profit == null) $profit = '-';

                        $date = $row['date'];
                        if ($date == null) $profit = '-';

                        $totalPrice += $row['price'];
                        $totalSalary += $row['salary'];
                        $totalProfit += $row['profit'];
                        $totalPaid += $row['paid'];

                        echo '<tbody>';
                        if ($isOdd) {
                            $isOdd = false;
                            echo '<tr bgcolor="#e8fff1">';
                        } else {
                            $isOdd = true;
                            echo '<tr>';
                        }

                        if ($row['ispaidoff'] == 1) {
                            echo '<td tableHeadData="Paid Off" align="center"><img src="./img/status_light_green" width="10px"></td>';
                        } else {
                            echo '<td tableHeadData="Paid Off" align="center"><img src="./img/status_light_red" width="10px"></td>';
                        }

                        echo '
                                    <td tableHeadData="Invoice #" align="center"><a href="invoice_detail.php?invoice_num='.$invoice.'">'.$invoice.'</a></td>
                                    <td tableHeadData="P.O." align="center">'.$po.'</td>
                                    <td tableHeadData="Apt" align="center"><a href="worksheet_apt.php?apt='.$apt.'&company='.$row['company'].'">'.$apt.'</td>
                                    <td tableHeadData="Unit #" align="center">'.$unit.'</td>
                                    <td tableHeadData="Size" align="center">'.$size.'</td>
                                    <td tableHeadData="Price" align="center">'.number_format($price).'</td>
                                    <td tableHeadData="Received" align="center">'.number_format($paid).'</td>
                                    <td tableHeadData="Salary" align="center">'.number_format($salary).'</td>
                                    <td tableHeadData="Profit" align="center">'.number_format($profit).'</td>
                                    <td tableHeadData="Date" align="center">'.substr($date, 0, 11).'</td>
                                    <td tableHeadData="Receive" align="center"><button><a href="recieve.php?invoice='.$invoice.'&apt='.urlencode($apt).'&unit='.$unit.'&price='.$price.'&paid='.$paid.'">Recieve</a></button></td>
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
                                    <td align="center"></td>
                                    <td tableHeadData="Total Price" align="center"><b>'.number_format($totalPrice).'</b></td>
                                    <td tableHeadData="Total Received" align="center"><b>'.number_format($totalPaid).'</b></td>
                                    <td tableHeadData="Total Salary" align="center"><b>'.number_format($totalSalary).'</b></td>
                                    <td tableHeadData="Total Profit" align="center"><b>'.number_format($totalProfit).'</b></td>
                                    <td align="center"></td>
                                    <td align="center"></td>
                        ';
                        echo '

                                </tr>
                            </tbody>
                        ';
                    echo '</table>';
                }
                mysqli_close($conn);
            ?>
            <input id="btn_back" type="button" value="Back" onclick="location.href='worksheet.php'"></input>
            <br><br><br><br>
        </div>

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>
