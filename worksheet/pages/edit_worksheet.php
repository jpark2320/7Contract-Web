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
                        <h1 class="page-header">Edit Worksheet Information</h1>
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

                                    // This is for values from deleting in estimate_info.php
                                    if (isset($_GET['index_deleted'])) {
                                        echo '<script>window.location.href="worksheet_add.php";</script>';
                                        array_splice($_SESSION['arr'], $_GET['index_deleted'], 1);
                                        $_SESSION['i']--;
                                        exit();
                                    }

                                    // This is for values passed from editing in estimate_info.php
                                    if (isset($_GET['description'])) {
                                        $description = $_GET['description'];
                                    }
                                    if (isset($_GET['qty'])) {
                                        $qty = $_GET['qty'];
                                    }
                                    if (isset($_GET['price'])) {
                                        $price = $_GET['price'];
                                    }
                                    if (isset($_GET['index'])) {
                                        $index = $_GET['index'];
                                    }
                                ?>
                                <form action="worksheet_add.php" method="GET">
                                    <div class="form-group">
                                        <label for="usr">Description:</label>
                                        <input type="text" class="form-control" name="desc_edited_estm" value="<?php echo isset($description) ? rtrim($description," ") : '' ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="usr">Qty:</label>
                                        <input type="text" class="form-control" name="qty_edited_estm" value="<?php echo isset($qty) ? rtrim($qty," ") : '' ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="usr">Price:</label>
                                        <input type="text" class="form-control" name="price_edited_estm" value="<?php echo isset($price) ? rtrim($price," ") : '' ?>">
                                    </div>
                                    <div hidden><input type="text" name="index_edited_estm" value="<?php echo $index ?>"></div>
                                    <div class="row">
                                        <div class="col-sm-offset-5 col-sm-2 text-center">
                                            <div class="text-center btn-group">
                                                <button class="btn btn-primary" type="submit">Edit</button>
                                                <button class="btn btn-primary" type="button" onclick="location.href='worksheet_add.php'">Back</button>
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
