<?php
    session_start();
    date_default_timezone_set('Etc/UTC');
?>
<!DOCTYPE html>
<html lang="en">

    <?php include('./includes/head_tag.html'); ?>

    <body>

        <div id="wrapper">

            <?php include("./includes/nav_bar.php"); ?>

            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Add Worksheet</h1>
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

                                <?php include('./includes/connection.php'); ?>
                                <form name="info" action="#">
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>PO</b></th>
                                                <th>Company</b></th>
                                                <th>Apt</b></th>
                                                <th>Unit #</b></th>
                                                <th>Size</b></th>
                                                <th>Manager</b></th>
                                                <th>Date</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr align="center">
                                                <td tableHeadData="PO"><input class="textInput" type="text" name="po" id="po" value="" size="20"></td>
                                                <td tableHeadData="Company"><input class="textInput" type="text" name="company" id="company" value="" size="20"></td>
                                                <td tableHeadData="Apt"><input class="textInput" type="text" name="apt" id="apt" value="" size="20"></td>
                                                <td tableHeadData="Unit #"><input class="textInput" type="text" name="unit" id="unit" value="" size="10"></td>
                                                <td tableHeadData="Size"><input class="textInput" type="text" name="size" id="size" value="" size="10"></td>
                                                <td tableHeadData="Size"><input class="textInput" type="text" name="manager" id="manager" value="" size="10"></td>
                                                <td tableHeadData="Date"><input class="textInput" type="date" name="date" id="theDate" value="" size="8"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <br>
                                    <table id="data_table" class="table table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>Description</th>
                                                <th>Qty</th>
                                                <th>Price</th>
                                                <th colspan="2"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="pdf_table">
                                            <tr>
                                                <td tableHeadData="Description"><input class="textInput" type="text" name="description" id="new_description"></td>
                                                <td tableHeadData="Qty"><input class="textInput" type="text" name="qty" id="new_quantity"></td>
                                                <td tableHeadData="Price"><input class="textInput" type="text" name="price" id="new_price"></td>
                                                <td colspan="2" align="center"><input type="button" class="add" onclick="add_row()" value="Add"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <br>
                                    <input type="button" name="submit" value="Add to Worksheet" onclick="pass_data(7, 'worksheet_process.php')"></input>
                                    <input type="button" value="Back" onclick="location.href='worksheet.php'"></input>
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

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>

    </body>

</html>
