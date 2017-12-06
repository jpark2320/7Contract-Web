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
                        <h1 class="page-header">Edit Estimate</h1>
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
                                        $sql = "SELECT * FROM estimate WHERE id ='$id';";
                                        $result = mysqli_query($conn, $sql);
                                        $row = mysqli_fetch_array($result);
                                        $_SESSION['id'] = $row['id'];
                                        $company = $row['company'];
                                        $apt = $row['apt'];
                                        $size = $row['size'];
                                        $unit = $row['unit'];
                                        $price = $row['price'];
                                        $po = $row['PO'];
                                    }
                                ?>

                                <form name="info" action="#">
                                    <table width="100%" class="table table-striped table-bordered table-hover">
                                        <colgroup>
                                            <col width="15%">
                                            <col width="35%">
                                            <col width="15%">
                                            <col width="35%">
                                        </colgroup>
                                        <tr>
                                            <td align="right"><b><h5>Company</h5></b></td>
                                            <td align="left"><input type="text" class="form-control" name="company" value="<?php echo isset($company) ? $company : '' ?>"></td>
                                            <td align="right"><b><h5>Apt</h5></b></td>
                                            <td align="left"><input type="text" class="form-control" name="apt" value="<?php echo isset($apt) ? $apt : '' ?>"></td>
                                        </tr>
                                        <tr>
                                            <td align="right"><b><h5>Unit</h5></b></td>
                                            <td align="left"><input type="text" class="form-control" name="unit" value="<?php echo isset($unit) ? $unit : '' ?>"></td>
                                            <td align="right"><b><h5>P.O</h5></b></td>
                                            <td align="left"><input type="text" class="form-control" name="po" value="<?php echo isset($po) ? $po : '' ?>"></td>
                                        </tr>
                                        <tr>
                                            <td align="right"><b><h5>Size</h5></b></td>
                                            <td align="left"><input type="text" class="form-control" name="size" value="<?php echo isset($size) ? $size : '' ?>"></td>
                                            <td align="right"><b><h5>Date</h5></b></td>
                                            <td align="left"><input type="date" class="form-control theDate" name="date"></td>
                                        </tr>
                                    </table>
                                    <?php
                                        echo '
                                            <table width="100%" id="data_table" class="table table-striped table-bordered table-hover">
                                                <colgroup>
                                                    <col width="70%">
                                                    <col width="10%">
                                                    <col width="10%">
                                                    <col width="10%">
                                                </colgroup>
                                                <thead>
                                                    <tr align="center">
                                                        <td><b>Description</b></td>
                                                        <td><b>Qty</b></td>
                                                        <td><b>Price</b></td>
                                                        <td colspan="2"></td>
                                                    </tr>
                                                </thead>
                                                <tbody id="pdf_table">
                                                    <tr>
                                                        <td><input class="form-control" type="text" name="description" id="new_description"></td>
                                                        <td><input class="form-control" type="text" name="qty" id="new_quantity"></td>
                                                        <td><input class="form-control" type="text" name="price" id="new_price"></td>
                                                        <td colspan="2"><input id="new_add" class="btn btn-primary btn-block add" type="button" onclick="add_row(1)" value="Add"></td>
                                                    </tr>
                                        ';

                                        $sql = "SELECT * FROM estimate_description WHERE estimate_id =".$_SESSION['id'].";";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            $i = 0;
                                            while($row = $result->fetch_assoc()) {
                                                echo '<tr id="row'.$i.'"><td id="description_row'.$i.'"><div class="lineBreak">'.$row['description'].'</div></td>';
                                                echo '<td id="quantity_row'.$i.'"><div class="lineBreak">'.$row['quantity'].'</div></td>';

                                                echo '<td id="price_row'.$i.'"><div class="lineBreak">'.$row['price'].'</div></td>';
                                                echo '
                                                    <td colspan="2"><div class="btn-group"><button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button><ul class="dropdown-menu" role="menu"><li><a id="edit_button'.$i.'" class="edit" onclick="edit_row('.$i.')">Edit</a></li><li><a id="save_button'.$i.'" class="save" onclick="save_row('.$i.')">Save</a></li><li><a class="delete" onclick="delete_row('.$i.')">Delete</a></li></ul></div></td></tr>
                                                ';
                                                $i++;
                                            }
                                        }
                                                    


                                        echo '
                                                </tbody>
                                            </table>
                                            <br>
                                        ';
                                    ?>
                                    <div class="row">
                                        <div class="col-sm-offset-5 col-sm-3 text-center">
                                            <div class="text-center btn-group">
                                                <button class="btn btn-primary" type="button" onclick="pass_data(5, 'estimate_edit_process.php', 3)">Save</button>
                                                <button class="btn btn-primary" type="button" onclick="location.href='view_estimate.php'">Back</button>
                                                <button class="btn btn-primary" type="button" onclick="pass_data(5, 'create_estimate.php', 4)">Create PDF</button>
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
        <?php include('includes/functions.js'); ?>
    </body>
</html>
