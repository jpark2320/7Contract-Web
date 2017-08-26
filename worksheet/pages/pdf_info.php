<?php if (!isset($_SESSION)) session_start(); ?>
<!DOCTYPE html>
<html lang="en">

    <?php include('./includes/head_tag.html'); ?>

    <body>
        <?php 
            include('./includes/connection.php');

            if (isset($_GET['invoice'])) {
                $i_detail = $_GET['invoice'];
                $_SESSION['invoice'] = str_replace('7C', '', $i_detail);
                $invoice = $_SESSION['invoice'];
                $sql = "SELECT * FROM save_progress WHERE invoice ='$invoice';";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $_SESSION['pdf_arr'][$_SESSION['i_pdf']][0] = $row['description'];
                        $_SESSION['pdf_arr'][$_SESSION['i_pdf']][1] = $row['quantity'];
                        $_SESSION['pdf_arr'][$_SESSION['i_pdf']][2] = $row['price'];
                        $_SESSION['i_pdf']++;
                    }
                }
            } else {
                $i_detail = '7C'.$_SESSION['invoice'];
            }
            $po = $_SESSION['po_pdf'];
            $company = $_SESSION['company_pdf'];
            $apt = $_SESSION['apt_pdf'];
            $unit = $_SESSION['unit_pdf'];
            $size = $_SESSION['size_pdf'];
        ?>

        <div id="wrapper">
            <?php include("./includes/nav_bar.php"); ?>
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Make PDF</h1>
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
                                    echo '
                                        <table width="100%" class="table table-striped table-bordered table-hover">
                                            <colgroup>
                                                <col width="25%">
                                                <col width="25%">
                                                <col width="25%">
                                                <col width="25%">
                                            </colgroup>
                                            <tbody>
                                                <tr>
                                                    <td align="right"><label><b>Invoice # : </label></b></td>
                                                    <td align="left">'.'7C'.$_SESSION['invoice'].'</td>
                                                    <td align="right"><label><b>Apt : </label></b></td>
                                                    <td>'.$apt.'</td>
                                                </tr>
                                                <tr>
                                                    <td align="right"><b><label>P.O. : </label></b></td>
                                                    <td align="left">'.$po.'</td>
                                                    <td align="right"><b><label>Unit # : </label></b></td>
                                                    <td align="left">'.$unit.'</td>
                                                </tr>
                                                <tr>
                                                    <td align="right"><b><label>Company : </label></b></td>
                                                    <td align="left">'.$company.'</td>
                                                    <td align="right"><b><label>Size : </label></b></td>
                                                    <td align="left">'.$size.'</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <br>
                                    ';
                                    if (isset($_GET['desc_edited_pdf'])) {
                                        $_SESSION['pdf_arr'][$_GET['index_edited_pdf']][0] = $_GET['desc_edited_pdf'];
                                    }
                                    if (isset($_GET['qty_edited_pdf'])) {
                                        $_SESSION['pdf_arr'][$_GET['index_edited_pdf']][1] = $_GET['qty_edited_pdf'];
                                    }
                                    if (isset($_GET['price_edited_pdf'])) {
                                        $_SESSION['pdf_arr'][$_GET['index_edited_pdf']][2] = $_GET['price_edited_pdf'];
                                    }
                                    $sql = "SELECT * FROM user_comment WHERE invoice=".$_SESSION['invoice'];
                                    $result = mysqli_query($conn, $sql);
                                    $isOdd = false;
                                    $i = 0;
                                    echo '
                                        <table width="100%" class="table table-striped table-bordered table-hover">
                                            <colgroup>
                                                <col width="5%">
                                                <col width="10%">
                                                <col width="45%">
                                                <col width="10%">
                                                <col width="10%">
                                                <col width="20%">
                                            </colgroup>
                                            <thead>
                                                <tr>
                                                    <td align="center"><b>#</b></td>
                                                    <td align="center"><b>Paid Off</b></td>
                                                    <td align="center"><b>Comment</b></td>
                                                    <td align="center"><b>Salary</b></td>
                                                    <td align="center"><b>Paid</b></td>
                                                    <td align="center"><b>Date</b></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                    ';
                                    while($row = mysqli_fetch_array($result))
                                    {
                                        $i++;

                                        if ($isOdd) {
                                            $isOdd = false;
                                            echo '<tr class="odd gradeX" align="center">';
                                        } else {
                                            $isOdd = true;
                                            echo '<tr class="even gradeX" align="center">';
                                        }

                                        echo '<td align="center">'.$i.'</td>';
                                        if ($row['ispaidoff'] == 1) {
                                            echo '<td><img src="./img/status_light_green" width="15px"><span hidden>3</span></td>';
                                        } else {
                                            echo '<td><img src="./img/status_light_red" width="15px"><span hidden>1</span></td>';
                                        }
                                        echo '
                                                <td align="center"><div class="lineBreak_desc">'.$row['comment'].'</div></td>
                                                <td align="center">'.number_format($row['salary']).'</td>
                                                <td align="center">'.number_format($row['paid']).'</td>
                                                <td align="center">'.$row['date'].'</td>
                                            </tr>
                                        ';

                                    }
                                    echo '</tbody></table>';

                                    if (isset($_POST['description'])) {
                                        if ($_POST['description'] !== null) {
                                            $_SESSION['description_pdf'] = $_POST['description'];
                                            $_SESSION['pdf_arr'][$_SESSION['i_pdf']][0] = $_SESSION['description_pdf'];
                                        }
                                    }
                                    if (isset($_POST['qty'])) {
                                        if ($_POST['qty'] !== null) {
                                            $_SESSION['qty_pdf'] = $_POST['qty'];
                                            $_SESSION['pdf_arr'][$_SESSION['i_pdf']][1] = $_SESSION['qty_pdf'];
                                        }
                                    }
                                    if (isset($_POST['price'])) {
                                        if ($_POST['price'] !== null) {
                                            $_SESSION['price_pdf'] = $_POST['price'];
                                            $_SESSION['pdf_arr'][$_SESSION['i_pdf']][2] = $_SESSION['price_pdf'];
                                        }
                                    }
                                    if (isset($_POST['submit'])) {
                                        $_SESSION['i_pdf']++;
                                    }

                                    echo '
                                        <form action="pdf_info.php" method="post">
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
                                                        <td><input class="form-control" type="text" name="description" required></td>
                                                        <td><input class="form-control" type="text" name="qty"></td>
                                                        <td><input class="form-control" type="text" name="price"></td>
                                                        <td colspan="2" align="center"><button class="btn btn-primary btn-block" type="submit" name="submit">Add</button></td>
                                                    </tr>
                                    ';
                                    if (isset($_SESSION['pdf_arr'])) {
                                        for ($i = 0; $i < sizeof($_SESSION['pdf_arr']); $i++) {
                                            if ($_SESSION['pdf_arr'][$i][0] !== null) {
                                                echo '<tr bgcolor="#c4daff"><td><div class="lineBreak_desc">'.$_SESSION['pdf_arr'][$i][0].'</div></td>';
                                            }
                                            if ($_SESSION['pdf_arr'][$i][1] !== null) {
                                                echo '<td>'.$_SESSION['pdf_arr'][$i][1].'</td>';
                                            }
                                            if ($_SESSION['pdf_arr'][$i][2] !== null) {
                                                echo '<td align="center">'.number_format($_SESSION['pdf_arr'][$i][2]).'</td>';
                                            }
                                            if ($_SESSION['pdf_arr'][$i][0] !== null) {
                                                echo '<td align="center"><button onclick="location.href=\'edit_pdf.php?description='.$_SESSION['pdf_arr'][$i][0].' &qty='.$_SESSION['pdf_arr'][$i][1].' &price='.$_SESSION['pdf_arr'][$i][2].' &index='.$i.'\'">Edit</button></td>';
                                            }
                                            if ($_SESSION['pdf_arr'][$i][0] !== null) {
                                                echo '<td align="center"><button onclick="location.href=\'edit_pdf.php?index_deleted='.$i.'\'">Delete</button></td></tr>';
                                            }
                                        }
                                    }

                                    echo '
                                                </tbody>
                                            </table>
                                            <br>
                                        </form>
                                        <form action="create_pdf.php" method="post">
                                            <table width="100%" class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <td align="center"><b>Date</b></td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr align="center">
                                                        <td><input class="form-control" type="date" name="date" id="theDate" value="" size="8"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                    ';
                                ?>
                                <div class="row">
                                    <div class="col-sm-offset-5 col-sm-10 text-center">
                                        <div class="text-center btn-group">
                                            <?php if(isset($_SESSION['pdf_arr'])): ?>
                                                <button class="btn btn-primary" type="submit" formtarget="_blank">Create Invoice PDF</button>
                                            <?php else: ?>
                                                <button class="btn btn-primary" type="button" onclick="alert('You need to add more than 1 description');" formtarget="_blank">Create Invoice PDF</button>
                                            <?php endif; ?>
                                            <button class="btn btn-primary" type="button" onclick="location.href='save_progress.php'">Save Progress</button>
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
        
        <?php include('./includes/functions.html'); ?>
    </body>
</html>
