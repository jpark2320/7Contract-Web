<?php 
    if (!isset($_SESSION)) {
        session_start(); 
    }
?>
<!DOCTYPE html>
<html lang="en">

    <?php 
        include('./includes/head_tag.html'); 

        include('./includes/connection.php');

        if (isset($_GET['invoice_num'])) {
            $invoice = $_GET['invoice_num'];
            $invoice = str_replace("7C", "", $invoice);
            $sql = "SELECT * FROM Worksheet WHERE invoice ='".$invoice."';";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
            $_SESSION['invoice'] = $row['invoice'];
            $_SESSION['po'] = $row['PO'];
            $_SESSION['company'] = $row['company'];
            $_SESSION['apt'] = $row['apt'];
            $_SESSION['manager'] = $row['manager'];
            $_SESSION['size'] = $row['size'];
            $_SESSION['unit'] = $row['unit'];
            $_SESSION['price'] = $row['price'];
            $_SESSION['description'] = $row['description'];
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
                                <?php
                                    if (isset($_GET['desc_edited_estm'])) {
                                        $_SESSION['arr'][$_GET['index_edited_estm']][0] = $_GET['desc_edited_estm'];
                                    }
                                    if (isset($_GET['qty_edited_estm'])) {
                                        $_SESSION['arr'][$_GET['index_edited_estm']][1] = $_GET['qty_edited_estm'];
                                    }
                                    if (isset($_GET['price_edited_estm'])) {
                                        $_SESSION['arr'][$_GET['index_edited_estm']][2] = $_GET['price_edited_estm'];
                                    }

                                    if (isset($_POST['description'])) {
                                        if (strlen($_POST['description']) > 0) {
                                            $_SESSION['arr'][$_SESSION['i']][0] = $_POST['description'];
                                        } else {
                                            echo '<script>alert("Description is required");</script>';
                                            echo '<script>window.location.href="edit_admin.php";</script>';
                                            exit();
                                        }
                                    }
                                    if (isset($_POST['price'])) {
                                        if ($_POST['price'] !== null) {
                                            $_SESSION['arr'][$_SESSION['i']][1] = $_POST['qty'];
                                        }
                                    }
                                    if (isset($_POST['qty'])) {
                                        if ($_POST['qty'] !== null) {
                                            $_SESSION['arr'][$_SESSION['i']][2] = $_POST['price'];
                                        }
                                    }

                                    if (isset($_POST['submit'])) {
                                        $_SESSION['i']++;
                                    }

                                    echo '
                                        <form action="edit_admin.php" method="post">
                                            <table width="100%" class="table table-striped table-bordered table-hover">
                                                <colgroup>
                                                    <col width="70%">
                                                    <col width="10%">
                                                    <col width="10%">
                                                    <col width="10%">
                                                </colgroup>
                                                <thead>
                                                    <tr>
                                                        <th>Description</b></th>
                                                        <th>Qty</b></th>
                                                        <th>Price</b></th>
                                                        <th colspan="2"></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="pdf_table">
                                                    <tr>
                                                        <td><input class="form-control" type="text" name="description"></td>
                                                        <td><input class="form-control" type="text" name="qty"></td>
                                                        <td><input class="form-control" type="text" name="price"></td>
                                                        <td colspan="2"><button class="btn btn-primary btn-block" type="submit" name="submit">Add</button></td>
                                                    </tr>
                                    ';
                                    if (isset($_SESSION['arr'])) {
                                        for ($i = 0; $i < sizeof($_SESSION['arr']); $i++) {
                                            if ($_SESSION['arr'][$i][0] !== null) {
                                                echo '<tr align="center"><td align="left"><div class="lineBreak">'.$_SESSION['arr'][$i][0].'</div></td>';
                                            }
                                            if ($_SESSION['arr'][$i][1] !== null) {
                                                echo '<td>'.$_SESSION['arr'][$i][1].'</td>';
                                            }

                                            if ($_SESSION['arr'][$i][2] !== null) {
                                                echo '<td>'.$_SESSION['arr'][$i][2].'</td>';
                                            }
                                            if ($_SESSION['arr'][$i][0] !== null) {
                                                echo '<td align="center"><button type="button" onclick="location.href=\'edit_invoice_detail.php?description='.$_SESSION['arr'][$i][0].' &qty='.$_SESSION['arr'][$i][1].' &price='.$_SESSION['arr'][$i][2].' &index='.$i.'\'">Edit</button></td>';
                                            }
                                            if ($_SESSION['arr'][$i][0] !== null) {
                                                echo '<td align="center"><button type="button" onclick="\'edit_invoice_detail.php?index_deleted='.$i.'\'">Delete</button></td></tr>';
                                            }
                                        }
                                    }

                                    echo '
                                                </tbody>
                                            </table>
                                            <br>
                                        </form>
                                    ';
                                    unset($_POST);
                                ?>
                                <form action="edit_process.php" method="POST">
                                    <table width="100%" class="table table-striped table-bordered table-hover">
                                        <colgroup>
                                            <col width="20%">
                                            <col width="80%">
                                        </colgroup>
                                        <tr>
                                            <td align="right"><b><h5>Apt</h5></b></td>
                                            <td align="left"><input type="text" class="form-control" name="apt" value="<?php echo isset($_SESSION['apt']) ? $_SESSION['apt'] : '' ?>"></td>
                                        </tr>
                                        <tr>
                                            <td align="right"><b><h5>Unit</h5></b></td>
                                            <td align="left"><input type="text" class="form-control" name="unit" value="<?php echo isset($_SESSION['unit']) ? $_SESSION['unit'] : '' ?>"></td>
                                        </tr>
                                        <tr>
                                            <td align="right"><b><h5>P.O.</h5></b></td>
                                            <td align="left"><input type="text" class="form-control" name="po" value="<?php echo isset($_SESSION['po']) ? $_SESSION['po'] : '' ?>"></td>
                                        </tr>
                                        <tr>
                                            <td align="right"><b><h5>Company</h5></b></td>
                                            <td align="left"><input type="text" class="form-control" name="company" value="<?php echo isset($_SESSION['company']) ? $_SESSION['company'] : '' ?>"></td>
                                        </tr>
                                        <tr>
                                            <td align="right"><b><h5>Manager</h5></b></td>
                                            <td align="left"><input type="text" class="form-control" name="manager" value="<?php echo isset($_SESSION['manager']) ? $_SESSION['manager'] : '' ?>"></td>
                                        </tr>
                                        <tr>
                                            <td align="right"><b><h5>Size</h5></b></td>
                                            <td align="left"><input type="text" class="form-control" name="size" value="<?php echo isset($_SESSION['size']) ? $_SESSION['size'] : '' ?>"></td>
                                        </tr>
                                    </table>
                                    <div class="row">
                                        <div class="col-sm-offset-5 col-sm-2 text-center">
                                            <div class="text-center btn-group">
                                                <button class="btn btn-primary" type="submit">Edit</button>
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
    </body>
</html>
