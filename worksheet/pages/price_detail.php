<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

    <?php include('./includes/head_tag.html'); ?>

    <body>
        <div id="wrapper">
            <?php include("./includes/nav_bar.php"); ?>
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Payment History</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                DataTables Advanced Tables
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <?php
                                    if (!isset($_SESSION['email'])) {
                                        echo "<script>alert(\"You need to sign in first.\");</script>";
                                        echo '<script>window.location.href = "signin.php";</script>';
                                        exit();
                                    }
                                    include('./includes/connection.php');

                                    if ($_SESSION['isadmin'] == 2) {
                                        include('./includes/data_range.html');
                                        
                                        include('./includes/sort_pay.html');

                                        echo '
                                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                                <colgroup>
                                                    <col width="6%">
                                                    <col width="7%">
                                                    <col width="6%">
                                                    <col width="10%">
                                                    <col width="6%">
                                                    <col width="6%">
                                                    <col width="8%">
                                                    <col width="8%">
                                                    <col width="8%">
                                                    <col width="8%">
                                                    <col width="8%">
                                                    <col width="11%">
                                                    <col width="8%">
                                                    <col width="0%">
                                                </colgroup>
                                                <thead>
                                                    <tr align="center">
                                                        <td><b>Paid</b></td>
                                                        <td><b>Invoice</b></td>
                                                        <td><b>P.O.</b></td>
                                                        <td><b>Apt</b></td>
                                                        <td><b>Unit</b></td>
                                                        <td><b>Size</b></td>
                                                        <td><b>Price</b></td>
                                                        <td><b>Recieved</b></td>
                                                        <td><b>Remaining</b></td>
                                                        <td><b>Salary</b></td>
                                                        <td><b>Profit</b></td>
                                                        <td><b>Date</b></td>
                                                        <td></td>
                                                        <td style="display: none"></td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                        ';

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

                                        $result = mysqli_query($conn, $sql);
                                        $totalPrice = 0;
                                        $totalPaid = 0;
                                        $totalSalary = 0;
                                        $totalProfit = 0;
                                        $totalRemaining = 0;

                                        $isOdd = false;
                                        while($row = mysqli_fetch_array($result)) {
                                            
                                            $invoice = '7C'.$row['invoice'];

                                            $totalPrice += $row['price'];
                                            $totalSalary += $row['salary'];
                                            $profit = $row['price'] - $row['salary'];
                                            $totalProfit += $profit;
                                            $totalPaid += $row['paid'];
                                            $remaining = $row['price'] - $row['paid'];
                                            $totalRemaining += $remaining;
                                            if ($isOdd) {
                                                $isOdd = false;
                                                echo '<tr class="odd gradeX" align="center">';
                                            } else {
                                                $isOdd = true;
                                                echo '<tr class="even gradeX" align="center">';
                                            }

                                            if ($row['ispaidoff'] == 1) {
                                                echo '<td><img src="./img/status_light_green" width="15px"><span hidden>3</span></td>';
                                            } else {
                                                echo '<td><img src="./img/status_light_red" width="15px"><span hidden>1</span></td>';
                                            }

                                            echo '
                                                    <td><a href="invoice_detail.php?invoice_num='.$invoice.'">'.$invoice.'</a></td>
                                                    <td>'.$row['PO'].'</td>
                                                    <td><a href="worksheet_apt.php?apt='.$row['apt'].'&company='.$row['company'].'">'.$row['apt'].'</td>
                                                    <td>'.$row['unit'].'</td>
                                                    <td>'.$row['size'].'</td>
                                                    <td>'.number_format($row['price'], 2).'</td>
                                                    <td>'.number_format($row['paid'], 2).'</td>
                                                    <td>'.number_format($remaining, 2).'</td>
                                                    <td>'.number_format($row['salary'], 2).'</td>
                                                    <td>'.number_format($profit, 2).'</td>
                                                    <td>'.substr($row['date'], 0, 11).'</td>
                                                    <td><button class="btn btn-primary btn-sm" onclick="location.href=\'recieve.php?invoice='.$invoice.'&apt='.urlencode($row['apt']).'&unit='.$row['unit'].'&price='.$row['price'].'&paid='.$row['paid'].'\'">Recieve</button></td>
                                                    <td style="display: none">'.$row['sort'].'</td>
                                                </tr>
                                            ';
                                        }
                                        echo '
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td align="center"><b>'.number_format($totalPrice, 2).'</b></td>
                                                        <td align="center"><b>'.number_format($totalPaid, 2).'</b></td>
                                                        <td align="center"><b>'.number_format($totalRemaining, 2).'</b></td>
                                                        <td align="center"><b>'.number_format($totalSalary, 2).'</b></td>
                                                        <td align="center"><b>'.number_format($totalProfit, 2).'</b></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td style="display: none">'.$row['sort'].'</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        ';
                                    } else {
                                        echo '<script>alert("You must log in with admin account.");</script>';
                                        echo '<script>window.location.href="signin.php";</script>';
                                    }
                                    mysqli_close($conn);
                                ?>
                                
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
        </div>
        <!-- /#wrapper -->

        <!-- jQuery -->
        <script src="../vendor/jquery/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="../vendor/metisMenu/metisMenu.min.js"></script>

        <!-- DataTables JavaScript -->
        <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
        <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
        <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="../dist/js/sb-admin-2.js"></script>

        <?php include('./includes/functions.js'); ?>
    </body>
</html>
