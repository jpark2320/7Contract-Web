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
                        <h1 class="page-header">Worksheet</h1>
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
                                    if (isset($_GET['invoice'])) {
                                        $invoice = $_GET['invoice'];
                                        $invoice = str_replace("7C", "", $invoice);
                                    }
                                    echo '
                                        <table width="100%" class="table table-striped table-bordered table-hover">
                                            <colgroup>
                                                <col width="50%">
                                                <col width="50%">
                                            </colgroup>
                                            <tr>
                                                <td align="right"><b>Invoice</b></td>
                                                <td align="left">'.$_GET['invoice'].'</td>
                                            </tr>
                                            <tr>
                                                <td align="right"><b>Apt</b></td>
                                                <td align="left">'.$_GET['apt'].'</td>
                                            </tr>
                                            <tr>
                                                <td align="right"><b>Unit</b></td>
                                                <td align="left">'.$_GET['unit'].'</td>
                                            </tr>
                                                <td align="right"><b>Size</b></td>
                                                <td align="left">'.$_GET['size'].'</td>
                                            </tr>
                                        </table>
                                    ';

                                    echo '
                                        <table width="100%" class="table table-striped table-bordered table-hover">
                                            <colgroup>
                                                <col width="5%">
                                                <col width="10%">
                                                <col width="10%">
                                                <col width="75%">
                                            </colgroup>
                                            <thead>
                                                <tr align="center">
                                                    <td><b>#</b></td>
                                                    <td><b>Quantity</b></td>
                                                    <td><b>Price</b></td>
                                                    <td><b>Description</b></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                    ';
                                    
                                    $sql = "SELECT * FROM worksheet_description WHERE invoice='$invoice'";
                                    
                                    $result = mysqli_query($conn, $sql);
                                    $isOdd = false;
                                    $i = 0;
                                    $total = 0;
                                    while($row = mysqli_fetch_array($result)) {

                                        $i++;

                                        $quantity = $row['quantity'];
                                        if ($quantity == 0) $quantity = '';

                                        $total += $row['price'];

                                        if ($isOdd) {
                                            $isOdd = false;
                                            echo '<tr class="odd gradeX" align="center">';
                                        } else {
                                            $isOdd = true;
                                            echo '<tr class="even gradeX" align="center">';
                                        }
                                        
                                        echo '
                                                <td>'.$i.'</td>
                                                <td>'.$quantity.'</td>
                                                <td>'.number_format($row['price']).'</td>
                                                <td align="left"><div class="lineBreak">'.$row['description'].'</div></td>
                                            </tr>
                                        ';
                
                                    }
                                    echo '
                                        </tbody>
                                        <tbody>
                                            <tr align="center">
                                                <td></td>
                                                <td><b>Total :</b></td>
                                                <td><b>'.number_format($total).'</b></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                        </table>
                                    ';
                                ?>
                                <div class="row">
                                    <div class="col-sm-offset-5 col-sm-2 text-center">
                                        <div class="text-center btn-group">
                                            <?php if (isset($_GET['from_company'])): ?>
                                                <button class="btn btn-primary" type="button" onclick="location.href='worksheet_company.php'">Back</button>
                                            <?php elseif (isset($_GET['from_apt'])): ?>
                                                <button class="btn btn-primary" type="button" onclick="location.href='worksheet_apt.php'">Back</button>
                                            <?php elseif (isset($_GET['from_manager'])): ?>
                                                <button class="btn btn-primary" type="button" onclick="location.href='worksheet_manager.php'">Back</button>
                                            <?php else: ?>
                                                <button class="btn btn-primary" type="button" onclick="location.href='worksheet.php'">Back</button>
                                            <?php endif; ?>
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
    </body>
</html>