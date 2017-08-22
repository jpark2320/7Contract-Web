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
                        <h1 class="page-header">Price Edit</h1>
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
                                    include('./includes/connection.php');;
                                    if (isset($_GET['id'])) {
                                        $_SESSION['id'] = $_GET['id'];
                                    } else if (isset($_SESSION['id'])) {
                                        $_SESSION['id'] = $_SESSION['id'];
                                    } else {
                                         echo '<script>alert("Something is not valid.");</script>';
                                         echo '<script>window.location.href="invoice_detail.php";</script>';
                                         exit();
                                    }
                                ?>
                                <form action="pedit_process.php" method="POST">
                                    <div class="form-group">
                                        <label for="usr">Name:</label>
                                        <input type="text" class="form-control" name="po" value="<?php echo isset($_GET['username']) ? $_GET['username'] : '' ?>" readonly="readonly">
                                    </div>
                                    <div class="form-group">
                                        <label for="usr">Comment:</label>
                                        <input type="text" class="form-control" name="po" value="<?php echo isset($_GET['comment']) ? $_GET['comment'] : '' ?>" readonly="readonly">
                                    </div>
                                    <div class="form-group">
                                        <label for="usr">Salary:</label>
                                        <input class="form-control" type="text" name="salary">
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-offset-5 col-sm-2 text-center">
                                            <div class="text-center btn-group">
                                                <button class="btn btn-primary" type="submit">Edit</button>
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
