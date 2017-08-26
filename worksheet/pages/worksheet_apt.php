<?php if (!isset($_SESSION)) session_start(); ?>
<!DOCTYPE html>
<html lang="en">

    <?php include('./includes/head_tag.html'); ?>

    <body>
        <div id="wrapper">
            <?php include("./includes/nav_bar.php"); ?>
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Worksheet by Apartment</h1>
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
                                    include('./includes/connection.php');                

                                    include('./includes/data_range.html');

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

                                    include('./includes/sort_pay.html');

                                    echo '
                                        <form action="outstanding_pdf.php" method="post">
                                            <br>
                                            <div align="center"><b>Apt : '.$apt.'</b></div><br>
                                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                                <thead align="center">
                                                    <tr>
                                                        <td><b>Check</b></td>
                                                        <td><b>Paid off</b></td>
                                                        <td><b>Invoice #</b></td>
                                                        <td><b>P.O.</b></td>
                                                        <td><b>Company</b></td>
                                                        <td><b>Manager</b></td>
                                                        <td><b>Unit #</b></td>
                                                        <td><b>Size</b></td>
                                                        <td><b>Price</b></td>
                                                        <td><b>Salary</b></td>
                                                        <td><b>Profit</b></td>
                                                        <td><b>Description</b></td>
                                                        <td><b>Date</b></td>
                                                    </tr>
                                                </thead>
                                                <tbody align="center">
                                    ';

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

                                    if (isset($_GET['unpaid'])) {
                                        $_SESSION['unpaid'] = $_GET['unpaid'];
                                        echo '<script>window.location.href = "worksheet_apt.php";</script>';
                                    }

                                    $result = mysqli_query($conn, $sql);
                                    if (!$result) {
                                        printf("Error: %s\n", mysqli_error($conn));
                                        exit();
                                    }

                                    $isOdd = false;
                                    while($row = mysqli_fetch_array($result)) {

                                        $temp_invoice = '7C'.$row['invoice'];

                                        if (isset($isOdd)) {
                                            if ($isOdd) {
                                                $isOdd = false;
                                                echo '<tr class="odd gradeX" align="center">';
                                            } else {
                                                $isOdd = true;
                                                echo '<tr class="even gradeX" align="center">';
                                            }
                                        }

                                        echo '
                                            <td><input type="checkbox" name="check[]" value="'.$temp_invoice.'"></td>
                                        ';

                                        if ($row['ispaidoff'] == 1) {
                                            echo '<td><img src="./img/status_light_green" width="15px"><span hidden>3</span></td>';
                                        } else {
                                            echo '<td><img src="./img/status_light_red" width="15px"><span hidden>1</span></td>';
                                        }

                                        echo '
                                                <td><a href="invoice_detail.php?invoice_num='.$temp_invoice.'">'.$temp_invoice.'</a></td>
                                                <td>'.$row['PO'].'</td>
                                                <td><a href="worksheet_company.php?company='.$row['company'].'">'.$row['company'].'</a></td>
                                                <td><a href="worksheet_manager.php?manager='.$row['manager'].'">'.$row['manager'].'</a></td>
                                                <td>'.$row['unit'].'</td>
                                                <td>'.$row['size'].'</td>
                                                <td>'.$row['price'].'</td>
                                                <td>'.$row['salary'].'</td>
                                                <td>'.$row['profit'].'</td>
                                                <td><a class="lineBreak" href="worksheet_description.php?invoice='.$temp_invoice.'&apt='.$row['apt'].'&unit='.$row['unit'].'&size='.$row['size'].'&from_apt=1">'.$row['description'].'</a></td>
                                                <td>'.substr($row['date'], 0, 11).'</td>
                                            </tr>
                                        ';
                                    }
                                    echo '
                                                </tbody>
                                            </table>
                                            <div class="row">
                                                <div class="col-sm-offset-5 col-sm-2 text-center">
                                                    <div class="text-center btn-group">
                                                        <button class="btn btn-primary" type="submit" name="sub" target="_blank">Make PDF</button>
                                                        <button class="btn btn-primary" type="button" onclick="location.href=\'worksheet.php\'">Back</button>
                                                    </div>  
                                                </div>
                                            </div>
                                        </form>
                                    ';
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
            <!-- /#page-wrapper -->
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

        <!-- Page-Level Demo Scripts - Tables - Use for reference -->
        <script>
            $(document).ready(function() {
                $('#dataTables-example').DataTable({
                    responsive: true
                });
            });
        </script>
    </body>
</html>