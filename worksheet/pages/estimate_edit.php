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
                                        $_SESSION['company'] = $row['company'];
                                        $_SESSION['apt'] = $row['apt'];
                                        $_SESSION['size'] = $row['size'];
                                        $_SESSION['unit'] = $row['unit'];
                                        $_SESSION['price'] = $row['price'];
                                        $_SESSION['po'] = $row['PO'];
                                        $sql = "SELECT * FROM estimate_description WHERE estimate_id ='$id';";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while($row = $result->fetch_assoc()) {
                                                $_SESSION['edit_arr'][$_SESSION['i']][0] = $row['description'];
                                                $_SESSION['edit_arr'][$_SESSION['i']][1] = $row['quantity'];
                                                $_SESSION['edit_arr'][$_SESSION['i']][2] = $row['price'];
                                                $_SESSION['i']++;
                                            }
                                        }
                                    }

                                    if (isset($_GET['desc_edited_estm'])) {
                                        $_SESSION['edit_arr'][$_GET['index_edited_estm']][0] = $_GET['desc_edited_estm'];
                                    }
                                    if (isset($_GET['qty_edited_estm'])) {
                                        $_SESSION['edit_arr'][$_GET['index_edited_estm']][1] = $_GET['qty_edited_estm'];
                                    }
                                    if (isset($_GET['price_edited_estm'])) {
                                        $_SESSION['edit_arr'][$_GET['index_edited_estm']][2] = $_GET['price_edited_estm'];
                                    }

                                    if (isset($_POST['description'])) {
                                        if (strlen($_POST['description']) > 0) {
                                            $_SESSION['edit_arr'][$_SESSION['i']][0] = $_POST['description'];
                                        } else {
                                            echo '<script>alert("Description is required");</script>';
                                            echo '<script>window.location.href="estimate_edit.php";</script>';
                                            exit();
                                        }
                                    }
                                    if (isset($_POST['price'])) {
                                        if ($_POST['price'] !== null) {
                                            $_SESSION['edit_arr'][$_SESSION['i']][1] = $_POST['qty'];
                                        }
                                    }
                                    if (isset($_POST['qty'])) {
                                        if ($_POST['qty'] !== null) {
                                            $_SESSION['edit_arr'][$_SESSION['i']][2] = $_POST['price'];
                                        }
                                    }

                                    if (isset($_POST['submit'])) {
                                        $_SESSION['i']++;
                                    }

                                    echo '
                                        <form action="estimate_edit.php" method="post">
                                            <table width="100%" class="table table-striped table-bordered table-hover">
                                                <colgroup>
                                                    <col width="70%">
                                                    <col width="10%">
                                                    <col width="10%">
                                                    <col width="5%">
                                                    <col width="5%">
                                                </colgroup>
                                                <thead>
                                                    <tr>
                                                        <td align="center"><b>Description</b></td>
                                                        <td align="center"><b>Qty</b></td>
                                                        <td align="center"><b>Price</b></td>
                                                        <td colspan="2"></td>
                                                    </tr>
                                                </thead>
                                                <tbody id="pdf_table">
                                                    <tr>
                                                        <td><input class="form-control" type="text" name="description"></td>
                                                        <td><input class="form-control" type="text" name="qty"></td>
                                                        <td><input class="form-control" type="text" name="price"></td>
                                                        <td colspan="2" align="center"><button type="submit" name="submit">Add</button></td>
                                                    </tr>
                                    ';
                                    if (isset($_SESSION['edit_arr'])) {
                                        for ($i = 0; $i < sizeof($_SESSION['edit_arr']); $i++) {
                                            if ($_SESSION['edit_arr'][$i][0] !== null) {
                                                echo '<tr bgcolor="#c4daff"><td><div class="lineBreak">'.$_SESSION['edit_arr'][$i][0].'</div></td>';
                                            }
                                            if ($_SESSION['edit_arr'][$i][1] !== null) {
                                                echo '<td>'.$_SESSION['edit_arr'][$i][1].'</td>';
                                            }

                                            if ($_SESSION['edit_arr'][$i][2] !== null) {
                                                echo '<td>'.$_SESSION['edit_arr'][$i][2].'</td>';
                                            }
                                            if ($_SESSION['edit_arr'][$i][0] !== null) {
                                                echo '<td align="center"><button type="button" onclick="location.href=\'edit_estimate_detail.php?description='.$_SESSION['edit_arr'][$i][0].' &qty='.$_SESSION['edit_arr'][$i][1].' &price='.$_SESSION['edit_arr'][$i][2].' &index='.$i.'\'">Edit</button></td>';
                                            }
                                            if ($_SESSION['edit_arr'][$i][0] !== null) {
                                                echo '<td align="center"><button type="button" onclick="location.href=\'edit_estimate_detail.php?index_deleted='.$i.'\'">Delete</button></td></tr>';
                                            }
                                        }
                                    }

                                    echo '
                                                </tbody>
                                            </table>
                                        </form>
                                    ';
                                ?>
                                <form action="estimate_edit_process.php" method="POST">
                                    <table width="100%" class="table table-striped table-bordered table-hover">
                                        <colgroup>
                                            <col width="20%">
                                            <col width="80%">
                                        </colgroup>
                                        <tr>
                                            <td align="right"><b><h5>Company</h5></b></td>
                                            <td align="left"><input type="text" class="form-control" name="company" value="<?php echo isset($_SESSION['company']) ? $_SESSION['company'] : '' ?>"></td>
                                        </tr>
                                        <tr>
                                            <td align="right"><b><h5>Apt</h5></b></td>
                                            <td align="left"><input type="text" class="form-control" name="apt" value="<?php echo isset($_SESSION['apt']) ? $_SESSION['apt'] : '' ?>"></td>
                                        </tr>
                                        <tr>
                                            <td align="right"><b><h5>Unit</h5></b></td>
                                            <td align="left"><input type="text" class="form-control" name="unit" value="<?php echo isset($_SESSION['unit']) ? $_SESSION['unit'] : '' ?>"></td>
                                        </tr>
                                        <tr>
                                            <td align="right"><b><h5>P.O</h5></b></td>
                                            <td align="left"><input type="text" class="form-control" name="po" value="<?php echo isset($_SESSION['po']) ? $_SESSION['po'] : '' ?>"></td>
                                        </tr>
                                        <tr>
                                            <td align="right"><b><h5>Size</h5></b></td>
                                            <td align="left"><input type="text" class="form-control" name="size" value="<?php echo isset($_SESSION['size']) ? $_SESSION['size'] : '' ?>"></td>
                                        </tr>
                                    </table>
                                    <div class="row">
                                        <div class="col-sm-offset-5 col-sm-2 text-center">
                                            <div class="text-center btn-group">
                                                <button class="btn btn-primary" type="submit">Save</button>
                                                <button class="btn btn-primary" type="button" onclick="location.href='view_estimate.php'">Back</button>
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
