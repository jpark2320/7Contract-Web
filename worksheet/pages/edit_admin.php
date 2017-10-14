<!DOCTYPE html>
<html lang="en">

    <?php 
        unset($_SESSION);
        include('./includes/head_tag.html'); 

        include('./includes/connection.php');

        if (isset($_GET['invoice_num'])) {
            $invoice = $_GET['invoice_num'];
            $invoice = str_replace("7C", "", $invoice);
            $sql = "SELECT * FROM Worksheet WHERE invoice ='".$invoice."';";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
            $po = $row['PO'];
            $company = $row['company'];
            $apt = $row['apt'];
            $manager = $row['manager'];
            $size = $row['size'];
            $unit = $row['unit'];
            $price = $row['price'];
            $description = $row['description'];
            $sql = "SELECT * FROM worksheet_description WHERE invoice ='$invoice';";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $_SESSION['arr'][$_SESSION['i']][0] = $row['description'];
                    $_SESSION['arr'][$_SESSION['i']][1] = $row['quantity'];
                    $_SESSION['arr'][$_SESSION['i']][2] = $row['price'];
                    $_SESSION['i']++;
                }
            }
        }
    ?>

    <body>
        <div id="wrapper">
            <?php include("./includes/nav_bar.php"); ?>
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Edit Worksheet</h1>
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
                                <form name="info" action="#">
                                    <table width="100%" class="table table-striped table-bordered table-hover">
                                        <colgroup>
                                            <col width="10%">
                                            <col width="40%">
                                            <col width="10%">
                                            <col width="40%">
                                        </colgroup>
                                        <tr>
                                            <td align="right"><b><h5>Apt</h5></b></td>
                                            <td align="left"><input type="text" class="form-control" name="apt" value="<?php echo isset($_SESSION['apt']) ? $_SESSION['apt'] : '' ?>"></td>
                                            <td align="right"><b><h5>Unit</h5></b></td>
                                            <td align="left"><input type="text" class="form-control" name="unit" value="<?php echo isset($_SESSION['unit']) ? $_SESSION['unit'] : '' ?>"></td>
                                        </tr>
                                        <tr>
                                            <td align="right"><b><h5>P.O.</h5></b></td>
                                            <td align="left"><input type="text" class="form-control" name="po" value="<?php echo isset($_SESSION['po']) ? $_SESSION['po'] : '' ?>"></td>
                                            <td align="right"><b><h5>Co</h5></b></td>
                                            <td align="left"><input type="text" class="form-control" id="company" name="company" value="<?php echo isset($_SESSION['company']) ? $_SESSION['company'] : '' ?>"></td>
                                        </tr>
                                        <tr>
                                            <td align="right"><b><h5>Mgr</h5></b></td>
                                            <td align="left"><input type="text" class="form-control" name="manager" value="<?php echo isset($_SESSION['manager']) ? $_SESSION['manager'] : '' ?>"></td>
                                            <td align="right"><b><h5>Size</h5></b></td>
                                            <td align="left"><input type="text" class="form-control" name="size" value="<?php echo isset($_SESSION['size']) ? $_SESSION['size'] : '' ?>"></td>
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
                                                        <td colspan="2"><input id="new_add" class="btn btn-primary btn-block add" type="button" onclick="add_row()" value="Add"></td>
                                                    </tr>
                                        ';

                                        $num = sizeof($_SESSION['arr']);
                                        if (isset($_SESSION['arr'])) {
                                            for ($i = 0; $i < sizeof($_SESSION['arr']); $i++) {
                                                if ($_SESSION['arr'][$i][0] !== null) {
                                                    echo '<tr id="row'.$num.'"><td id="description_row'.$num.'"><div class="lineBreak">'.$_SESSION['arr'][$i][0].'</div></td>';
                                                }
                                                if ($_SESSION['arr'][$i][1] !== null) {
                                                    echo '<td id="quantity_row'.$num.'"><div class="lineBreak">'.$_SESSION['arr'][$i][1].'</div></td>';
                                                }

                                                if ($_SESSION['arr'][$i][2] !== null) {
                                                    echo '<td id="price_row'.$num.'"><div class="lineBreak">'.$_SESSION['arr'][$i][2].'</div></td>';
                                                }
                                                if ($_SESSION['arr'][$i][0] !== null) {
                                                    echo '
                                                        <td><div class="btn-group"><button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button><ul class="dropdown-menu" role="menu"><li><a id="edit_button'.$num.'" class="edit" onclick="edit_row('.$num.')">Edit</a></li><li><a id="save_button'.$num.'" class="save" onclick="save_row('.$num.')">Save</a></li><li><a class="delete" onclick="delete_row('.$num.')">Delete</a></li></ul></div></td></tr>
                                                    ';
                                                }

                                                // if ($_SESSION['arr'][$i][0] !== null) {
                                                //     echo '<td align="center"><button class="btn btn-primary btn-block" type="button" onclick="location.href=\'edit_invoice_detail.php?description='.$_SESSION['arr'][$i][0].' &qty='.$_SESSION['arr'][$i][1].' &price='.$_SESSION['arr'][$i][2].' &index='.$i.'\'">Edit</button></td>';
                                                // }
                                                // if ($_SESSION['arr'][$i][0] !== null) {
                                                //     echo '<td align="center"><button class="btn btn-primary btn-block" type="button" onclick="\'edit_invoice_detail.php?index_deleted='.$i.'\'">Delete</button></td></tr>';
                                                // }
                                            }
                                            $num++;
                                        }

                                        echo '
                                                </tbody>
                                            </table>
                                            <br>
                                        ';
                                        unset($_POST);
                                    ?>
                                    
                                    <div class="row">
                                        <div class="col-sm-offset-5 col-sm-2 text-center">
                                            <div class="text-center btn-group">
                                                <button class="btn btn-primary" type="submit" onclick="pass_data(7, 'edit_process.php', 3)">Save</button>
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

        <!-- Page-Level Demo Scripts - Tables - Use for reference -->
        <script>
            $(document).ready(function() {
                $('#dataTables-example').DataTable({
                    responsive: true
                });
            });
        </script>

        <!-- Functions -->
        <?php include('includes/functions.js'); ?>
    </body>
</html>
