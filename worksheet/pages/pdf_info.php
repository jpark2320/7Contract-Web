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
                                    <form name="info" action="#">
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
                                                    <td><input class="form-control" type="text" name="apt" id="apt" size="15" value="'.$apt.'" readonly></td>
                                                </tr>
                                                <tr>
                                                    <td align="right"><b><label>P.O. : </label></b></td>
                                                    <td align="left"><input class="form-control" type="text" name="po" id="po" size="15" value="'.$po.'" readonly></td>
                                                    <td align="right"><b><label>Unit # : </label></b></td>
                                                    <td align="left"><input class="form-control" type="text" name="unit" id="unit" size="15" value="'.$unit.'" readonly></td>
                                                </tr>
                                                <tr>
                                                    <td align="right"><b><label>Company : </label></b></td>
                                                    <td align="left"><input class="form-control" type="text" name="company" id="company" size="15"value="'.$company.'" readonly></td>
                                                    <td align="right"><b><label>Size : </label></b></td>
                                                    <td align="left"><input class="form-control" type="text" name="size" id="size" size="15" value="'.$size.'" readonly></td>
                                                </tr>
                                                <tr>
                                                    <td align="right"><b><label>Date : </label></b></td>
                                                    <td align="left"><input class="form-control" type="date" name="date" id="theDate" size="8"></td>
                                                    <td align="right"><b></b></td>
                                                    <td align="left"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <br>
                                    ';

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


                                    echo '
                                       <table width="100%" id="data_table" class="table table-bordered table-hover table-striped table-condensed">
                                        <thead>
                                            <colgroup>
                                                <col width="60%">
                                                <col width="15%">
                                                <col width="15%">
                                                <col width="10%">
                                            </colgroup>
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
                                                <td colspan="2"><input id="new_add" class="btn btn-primary btn-block" type="button" class="add" onclick="add_row()" value="Add"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                             
                                    ';
                                ?>
                                <div class="row">
                                        <div class="col-sm-offset-4 col-sm-4 text-center">
                                            <div class="text-center btn-group">
                                                <button class="btn btn-primary" type="button" name="submit" onclick="pass_data(6, 'create_pdf.php', 2)">Create PDF</button>
                                                <button class="btn btn-primary" type="button" onclick="location.href='save_progress.php'">Save Progress</button>
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
        <?php include('./includes/functions.js'); ?>
    </body>
</html>
