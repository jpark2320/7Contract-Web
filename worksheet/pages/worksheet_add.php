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
                        <h1 class="page-header">Add New Worksheet</h1>
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
                                    <table width="100%" class="table table-bordered table-hover table-striped table-condensed">
                                        <colgroup>
                                            <col width="15%">
                                            <col width="35%">
                                            <col width="15%">
                                            <col width="35%">
                                        </colgroup>
                                        <tbody>
                                            <tr>
                                                <td align="right"><b><h5>Po.</h5></b></td>
                                                <td><input class="form-control" type="text" name="po" id="po" size="20"></td>
                                                <td align="right"><b><h5>Co.</h5></b></td>
                                                <td><input class="form-control" type="text" name="company" id="company" size="20"></td>
                                            </tr>
                                            <tr>
                                                <td align="right"><b><h5>Apt</h5></b></td>
                                                <td><input class="form-control" type="text" name="apt" id="apt" size="20"></td>
                                                <td align="right"><b><h5>Unit</h5></b></td>
                                                <td><input class="form-control" type="text" name="unit" id="unit" size="10"></td>
                                            </tr>
                                            <tr>
                                                <td align="right"><b><h5>Size</h5></b></td>
                                                <td><input class="form-control" type="text" name="size" id="size" size="10"></td>
                                                <td align="right"><b><h5>Mgr.</h5></b></td>
                                                <td><input class="form-control" type="text" name="manager" id="manager" size="10"></td>
                                            </tr>
                                            <tr>
                                                <td align="right"><b><h5>Date</h5></b></td>
                                                <td><input class="form-control theDate" type="date" name="date" size="8"></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <br>
                                    <table width="100%" id="data_table" class="table table-bordered table-hover table-striped table-condensed">
                                        <thead align="center">
                                            <tr>
                                                <td width="60%"><b>Description</b></td>
                                                <td width="17%"><b>Qty.</b></td>
                                                <td width="17%"><b>Price</b></td>
                                                <td width="6%"" colspan="2"><b></b></td>
                                            </tr>
                                        </thead>
                                        <tbody id="pdf_table">
                                            <tr>
                                                <td><input class="form-control" type="text" name="description" id="new_description"></td>
                                                <td><input class="form-control" type="text" name="qty" id="new_quantity"></td>
                                                <td><input class="form-control" type="text" name="price" id="new_price"></td>
                                                <td colspan="2"><input id="new_add" class="btn btn-primary btn-block" type="button" onclick="add_row()" value="Add"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="row">
                                        <div class="col-sm-offset-4 col-sm-4 text-center">
                                            <div class="text-center btn-group">
                                                <button class="btn btn-primary" type="button" onclick="pass_data(7, 'worksheet_process.php', 1)">Add Worksheet</button>
                                                <button class="btn btn-primary" type="button" onclick="location.href='worksheet.php'">Back</button>
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

        <!-- Functions -->
        <?php include('includes/functions.js'); ?>
    </body>
</html>
