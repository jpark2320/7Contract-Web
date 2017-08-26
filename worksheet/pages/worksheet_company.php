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
                        <h1 class="page-header">Worksheet by Company</h1>
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

                                    if (isset($_GET['company'])) {
                                        $company = $_GET['company'];
                                        $_SESSION['company'] = $company;
                                    } else {
                                        $company = $_SESSION['company'];
                                    }

                                    echo '
                                        <br>
                                        <div align="center"><b>Company : '.$company.'</b></div>
                                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                            <colgroup>
                                                <col width="10%">
                                                <col width="10%">
                                                <col width="5%">
                                                <col width="40%">
                                                <col width="10%">
                                                <col width="5%">
                                                <col width="10%">
                                                <col width="5%">
                                                <col width="5%">
                                            </colgroup>
                                            <thead>
                                                <tr align="center">
                                                    <td><b>Invoice</b></td>
                                                    <td><b>Apt</b></td>
                                                    <td><b>Unit</b></td>
                                                    <td><b>Description</b></td>
                                                    <td><b>Date</b></td>
                                                    <td><b>P.O.</b></td>
                                                    <td><b>Manager</b></td>
                                                    <td><b>Size</b></td>
                                                    <td><b>Price</b></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                    ';

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
                                    $result = mysqli_query($conn, $sql);
                                    if (!$result) {
                                        printf("Error: %s\n", mysqli_error($conn));
                                        exit();
                                    }

                                    $isOdd = false;
                                    while($row = mysqli_fetch_array($result))
                                    {
                                        $temp_invoice = '7C'.$row['invoice'];

                                        if ($isOdd) {
                                            $isOdd = false;
                                            echo '<tr class="odd gradeX" align="center">';
                                        } else {
                                            $isOdd = true;
                                            echo '<tr class="even gradeX" align="center">';
                                        }

                                        echo '
                                                <td><a href="invoice_detail.php?invoice_num='.$temp_invoice.'">'.$temp_invoice.'</a></td>
                                                <td><a href="worksheet_apt.php?apt='.$row['apt'].'&company='.$row['company'].'">'.$row['apt'].'</a></td>
                                                <td>'.$row['unit'].'</td>
                                                <td align="left"><a href="worksheet_description.php?invoice='.$temp_invoice.'&apt='.$row['apt'].'&unit='.$row['unit'].'&size='.$row['size'].'&from_company=1"><div class="lineBreak">'.$row['description'].'</div></a></td>
                                                <td>'.substr($row['date'], 0, 11).'</td>
                                                <td>'.$row['PO'].'</td>
                                                <td><a href="worksheet_manager.php?manager='.$row['manager'].'">'.$row['manager'].'</a></td>
                                                <td>'.$row['size'].'</td>
                                                <td>'.$row['price'].'</td>
                                            </tr>
                                        ';
                                    }
                                    echo '</tbody></table>';
                                    mysqli_close($conn);
                                ?>
                                <div class="row">
                                    <div class="col-sm-offset-5 col-sm-2 text-center">
                                        <div class="text-center btn-group">
                                            <button class="btn btn-primary" type="button" onclick="location.href='worksheet.php'">Back</button>
                                        </div>  
                                    </div>
                                </div>
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

        <?php include('./includes/functions.html'); ?>
    </body>
</html>
