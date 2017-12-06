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
                        <h1 class="page-header">Estimate Description</h1>
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
                                    if (isset($_GET['id'])) {
                                        $id = $_GET['id'];
                                    }  
                                    echo '
                                        <table width="100%" class="table table-striped table-bordered table-hover">
                                            <colgroup>
                                                <col width="15%">
                                                <col width="35%">
                                                <col width="15%">
                                                <col width="35%">
                                            </colgroup>
                                            <tbody>
                                                <tr>
                                                    <td align="right"><b>Company : </b></td>
                                                    <td align="left">'.$_GET['company'].'</td>
                                                    <td align="right"><b>Apartment : </b></td>
                                                    <td align="left">'.$_GET['apt'].'</td>
                                                </tr>
                                                <tr>
                                                    <td align="right"><b>Unit # : </b></td>
                                                    <td align="left">'.$_GET['unit'].'</td>
                                                    <td align="right"><b>Size : </b></td>
                                                    <td align="left">'.$_GET['size'].'</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table width="100%" class="table table-striped table-bordered table-hover">
                                            <colgroup>
                                                <col width="5%">
                                                <col width="10%">
                                                <col width="10%">
                                                <col width="75%">
                                            </colgroup>
                                            <thead>
                                                <tr>
                                                    <td align="center"><b>#</b></td>
                                                    <td align="center"><b>Quantity</b></td>
                                                    <td align="center"><b>Price</b></td>
                                                    <td align="center"><b>Description</b></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                    ';
                                    
                                    $sql = "SELECT * FROM estimate_description WHERE estimate_id='$id'";
                                    $result = mysqli_query($conn, $sql);

                                    $isOdd = false;
                                    $i = 0;

                                    while($row = mysqli_fetch_array($result)) {

                                        $i++;

                                        if ($isOdd) {
                                            $isOdd = false;
                                            echo '<tr class="odd gradeX" align="center">';
                                        } else {
                                            $isOdd = true;
                                            echo '<tr class="even gradeX" align="center">';
                                        }
                                        echo '        
                                                <td align="center">'.$i.'</td>
                                                <td align="center">'.$row['quantity'].'</td>
                                                <td align="center">'.$row['price'].'</td>
                                                <td align="center"><div class="lineBreak">'.$row['description'].'</div></td>
                                            </tr>
                                        ';

                                    }
                                    echo '</tbody></table>';
                                ?>
                                <div class="row">
                                    <div class="col-sm-offset-5 col-sm-2 text-center">
                                        <div class="text-center btn-group">
                                            <button class="btn btn-primary" type="button" onclick="location.href='view_estimate.php'">Back</button>
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