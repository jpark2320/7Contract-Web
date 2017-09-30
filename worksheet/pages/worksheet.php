<?php
    if (!isset($_SESSION)) session_start();
    $_SESSION['i_pdf'] = 0;
    $_SESSION['i_estm'] = 0;
    $_SESSION['i'] = 0;
    unset($_SESSION['unpaid']);
    unset($_SESSION['arr']);
    unset($_SESSION['estm_arr']);
    unset($_SESSION['edit_arr']);
    unset($_SESSION['pdf_arr']);
?>
<!DOCTYPE html>
<html lang="en">

    <?php include('./includes/head_tag.html'); ?>

    <body>
        <?php 
            if (!isset($_SESSION['email'])) {
                echo '<script>alert("You must sign in first.");</script>';
                echo '<script>window.location.href="signin.php";</script>';
                exit();
            }
        ?>

        <div id="wrapper">
            <?php include("./includes/nav_bar.php"); ?>
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Worksheet</h1>
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
                                    // connection with mysql database
                                    include('./includes/connection.php');

                                    include('./includes/data_range.html');

                                    if (isset($_SESSION['isadmin'])) {
                                        if ($_SESSION['isadmin'] > 0) {

                                            echo '
                                                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                                    <colgroup>
                                                        <col width="5%">
                                                        <col width="5%">
                                                        <col width="10%">
                                                        <col width="5%">
                                                        <col width="30%">
                                                        <col width="10%">
                                                        <col width="5%">
                                                        <col width="10%">
                                                        <col width="10%">
                                                        <col width="5%">
                                                        <col width="5%">
                                                    </colgroup>
                                                    <thead>
                                                        <tr align="center">
                                                            <td><b>Status</b></td>
                                                            <td><b>Invoice</b></td>
                                                            <td><b>Apt</b></td>
                                                            <td><b>Unit</b></td>
                                                            <td><b>Description</b></td>
                                                            <td><b>Date</b></td>
                                                            <td><b>P.O.</b></td>
                                                            <td><b>Company</b></td>
                                                            <td><b>Manager</b></td>
                                                            <td><b>Size</b></td>
                                                            <td><b>Price</b></td>
                                                            <td></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                            ';
                                            
                                            $sql = 'SELECT * FROM Worksheet ';
                                            if (isset($_POST['date']) && isset($_POST['end_date'])) {
                                                $start_date = $_POST['date'];
                                                $end_date = $_POST['end_date'];
                                                if (strlen($end_date) > 0) {
                                                    $sql .= "WHERE DATE(date) >= '$start_date' AND DATE(date) <= '$end_date' ";
                                                } else {
                                                    $sql .= "WHERE DATE(date) >= '$start_date' ";
                                                }
                                            }

                                            $result = mysqli_query($conn, $sql);

                                            $isOdd = false;
                                            while($row = mysqli_fetch_array($result)) {

                                                $temp_invoice = '7C'.$row['invoice'];

                                                if ($isOdd) {
                                                    $isOdd = false;
                                                    echo '<tr class="odd gradeX" align="center">';
                                                } else {
                                                    $isOdd = true;
                                                    echo '<tr class="even gradeX" align="center">';
                                                }

                                                if ($row['isworkdone'] == 2) {
                                                    echo '<td><img src="./img/status_light_green" width="15px"><span hidden>3</span></td>';
                                                } else if ($row['isworkdone'] == 1) {
                                                    echo '<td><img src="./img/status_light_yellow" width="15px"><span hidden>2</span></td>';
                                                } else {
                                                    echo '<td><img src="./img/status_light_red" width="15px"><span hidden>1</span></td>';
                                                }

                                                echo '
                                                        <td><a href="invoice_detail.php?invoice_num='.$temp_invoice.'">'.$temp_invoice.'</a></td>
                                                        <td><a href="worksheet_apt.php?apt='.$row['apt'].'&company='.$row['company'].'">'.$row['apt'].'</a></td>
                                                        <td>'.$row['unit'].'</td>
                                                        <td align="left"><a href="worksheet_description.php?invoice='.$temp_invoice.'&apt='.$row['apt'].'&unit='.$row['unit'].'&size='.$row['size'].'"><div class="lineBreak">'.$row['description'].'</div></a></td>
                                                        <td>'.substr($row['date'], 0, 11).'</td>
                                                        <td>'.$row['PO'].'</td>
                                                        <td><a href="worksheet_company.php?company='.$row['company'].'">'.$row['company'].'</a></td>
                                                        <td><a href="worksheet_manager.php?manager='.$row['manager'].'">'.$row['manager'].'</a></td>
                                                        <td>'.$row['size'].'</td>
                                                        <td>'.number_format($row['price']).'</td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">
                                                                <span class="caret"></span>
                                                                </button>
                                                                <ul class="dropdown-menu" role="menu">
                                                                    <li><a onclick="location.href=\'assign.php?invoice_num='.$temp_invoice.' &apt='.$row['apt'].' &unit_num='.$row['unit'].'\'">Send</a></li>
                                                                    <li><a onclick="location.href=\'edit_admin.php?invoice_num='.$temp_invoice.'\'">Edit</a></li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                ';
                                            }
                                            echo '</tbody></table>';
                                        } else {
                                            echo '
                                                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                                    <colgroup>
                                                        <col width="5%">
                                                        <col width="10%">
                                                        <col width="5%">
                                                        <col width="65%">
                                                        <col width="10%">
                                                        <col width="5%">
                                                    </colgroup>
                                                    <thead>
                                                        <tr align="center">
                                                            <td><b>Status</b></td>
                                                            <td><b>Apt</b></td>
                                                            <td><b>Unit #</b></td>
                                                            <td><b>Message</b></td>
                                                            <td><b>Date</b></d>
                                                            <td></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                            ';
                                            $email = $_SESSION['email'];
                                            $sql = "SELECT * FROM SubWorksheet WHERE email='$email'";
                                            if (isset($_POST['date']) && isset($_POST['end_date'])) {
                                                $start_date = $_POST['date'];
                                                $end_date = $_POST['end_date'];
                                                if (strlen($end_date) > 0) {
                                                    $sql .= "WHERE email =\"".$_SESSION['email']."\" AND DATE(date) >= '$start_date' AND DATE(date) <= '$end_date' ORDER BY ".$order;
                                                } else {
                                                    $sql .= "WHERE email =\"".$_SESSION['email']."\" AND DATE(date) >= '$start_date' ORDER BY".$order;
                                                }
                                            }

                                            $result = mysqli_query($conn, $sql);

                                            $isOdd = false;
                                            while($row = mysqli_fetch_array($result)) {

                                                $temp2_invoice = '7C'.$row['invoice'];

                                                if ($isOdd) {
                                                    $isOdd = false;
                                                    echo '<tr class="odd gradeX" align="center">';
                                                } else {
                                                    $isOdd = true;
                                                    echo '<tr class="even gradeX" align="center">';
                                                }

                                                if ($row['isworkdone'] == 1) {
                                                    echo '<td><img src="./img/status_light_green" width="15px"><span hidden>3</span></td>';
                                                } else {
                                                    echo '<td><img src="./img/status_light_red" width="15px"><span hidden>1</span></td>';
                                                }

                                                echo '
                                                        <td>'.$row['apt'].'</td>
                                                        <td>'.$row['unit'].'</td>
                                                        <td align="left"><div class="lineBreak">'.$row['message'].'</div></td>
                                                        <td>'.substr($row['date'], 0, 11).'</td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">
                                                                <span class="caret"></span>
                                                                </button>
                                                                <ul class="dropdown-menu" role="menu">
                                                                    <li><a onclick="location.href=\'show_comment.php?id='.$row['id'].'&apt='.$row['apt'].'&unit='.$row['unit'].'\'">Show</a></li>
                                                                    <li><a onclick="location.href=\'edit_user.php?id='.$row['id'].'&invoice='.$temp2_invoice.'\'">Add</a></li>
                                                                    <li><a id="btn_workdone" onclick="location.href=\'workdone_process.php?invoice_num='.urlencode($temp2_invoice).' &email_user='.urlencode($row['email']).' &id='.urlencode($row['id']).'\'">Finish</a></li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                ';
                                            }
                                            echo '</tbody></table>';
                                        }
                                    }
                                    mysqli_close($conn);
                                ?>
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