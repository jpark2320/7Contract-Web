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
                        <h1 class="page-header">Pay</h1>
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
                                        $_SESSION['id'] = $_GET['id'];
                                        $_SESSION['paid'] = $_GET['paid'];
                                        $_SESSION['salary'] = $_GET['salary'];
                                    } else {
                                         echo '<script>alert("Something is not valid.");</script>';
                                         echo '<script>window.location.href="worksheet.php";</script>';
                                         exit();
                                    }
                                    $remaining = $_GET['salary'] - $_GET['paid'];
                                ?>
                                <form action="pay_process.php" method="POST">
                                    <table width="100%" class="table table-striped table-bordered table-hover">
                                        <colgroup>
                                            <col width="20%">
                                            <col width="80%">
                                        </colgroup>
                                        <tr>
                                            <td align="right"><b><h5>Name</h5></b></td>
                                            <td align="left"><h5 style="font-weight:normal"><?php echo $_GET['username']?></h5></td>
                                        </tr>
                                        <tr>
                                            <td align="right"><b><h5>Comment</h5></b></td>
                                            <td align="left"><h5 style="font-weight:normal"><div class="lineBreak"><?php echo $_GET['comment']?></div></h5></td>
                                        </tr>
                                        <tr>
                                            <td align="right"><b><h5>Salary</h5></b></td>
                                            <td align="left"><h5 style="font-weight:normal"><?php echo "$ ".$_GET['salary']?></h5></td>
                                        </tr>
                                        <tr>
                                            <td align="right"><b><h5>Remaining Balance</h5></b></td>
                                            <td align="left"><h5 style="font-weight:normal"><?php echo "$ ".number_format((float)$remaining, 2, '.', '')?></h5></td>
                                        </tr>
                                        <tr>
                                            <td align="right"><b><h5>Paying Amount</h5></b></td>
                                            <td align="left"><input class="form-control" type="text" name="pay"></td>
                                        </tr>
                                    </table>
                                    <div class="row">
                                        <div class="col-sm-offset-5 col-sm-2 text-center">
                                            <div class="text-center btn-group">
                                                <button class="btn btn-primary" type="submit">Pay</button>
                                                <button class="btn btn-primary" type="button" onclick="location.href='invoice_detail.php'">Back</button>
                                            </div>  
                                        </div>
                                    </div>
                                </form>
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
