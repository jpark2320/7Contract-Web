<?php
    if (!isset($_SESSION)) {
        session_start();
    }
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

                                    if (!isset($_SESSION['email'])) {
                                        echo "<script>alert(\"You need to sign in first.\");</script>";
                                        echo '<script>window.location.href = "signin.php";</script>';
                                        exit();
                                    } else {

                                        include('./includes/data_range.html');

                                        if (isset($_SESSION['isadmin'])) {
                                            if ($_SESSION['isadmin'] > 0) {

                                                echo '
                                                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                                        <thead>
                                                            <tr>
                                                                <th>Status</th>
                                                                <th>Invoice #</th>
                                                                <th>P.O.</th>
                                                                <th>Company</th>
                                                                <th>Apt</th>
                                                                <th>Manager</th>
                                                                <th>Unit #</th>           
                                                                <th>Price</th>
                                                                <!-- <th>Description</th> -->
                                                                <th>Date</th>
                                                                <th>Assign</th>
                                                                <th>Edit</th>
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
                                                while($row = mysqli_fetch_array($result))
                                                {
                                                    $temp_invoice = '7C'.$row['invoice'];

                                                    $temp_description = $row['description'];
                                                    if ($temp_description == null) $temp_description = '-';

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
                                                            <td>'.$row['PO'].'</td>
                                                            <td><a href="worksheet_company.php?company='.$row['company'].'">'.$row['company'].'</a></td>
                                                            <td><a href="worksheet_apt.php?apt='.$row['apt'].'&company='.$row['company'].'">'.$row['apt'].'</a></td>
                                                            <td><a href="worksheet_manager.php?manager='.$row['manager'].'">'.$row['manager'].'</a></td>
                                                            <td>'.$row['unit'].'</td>
                                                            <td>'.number_format($row['price']).'</td>
                                                            <!-- <td><a class="lineBreak" href="worksheet_description.php?invoice='.$temp_invoice.'&apt='.$temp_apt.'&unit='.$row['unit'].'&size='.$row['size'].'">'.$temp_description.'</a></td> -->
                                                            <td>'.substr($row['date'], 0, 11).'</td>
                                                            <td><button onclick="location.href=\'assign.php?invoice_num='.$temp_invoice.' &apt='.$temp_apt.' &unit_num='.$temp_unit.'\'">Send</button></td>
                                                            <td><button onclick="location.href=\'edit_admin.php?invoice_num='.$temp_invoice.'\'">Edit</button></td>
                                                        </tr>
                                                    ';
                                                }
                                                echo '</tbody></table>';
                                            } else {

                                                include('./includes/sort.php');

                                                echo '
                                                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                                        <thead>
                                                            <tr>
                                                                <th>Status</th>
                                                                <th>Apt</th>
                                                                <th>Unit #</th>
                                                                <th>Message</th>
                                                                <th>Date</th>
                                                                <th>Comment</th>
                                                                <th>Process</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                ';

                                                $sql = 'SELECT * FROM SubWorksheet ';
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
                                                while($row = mysqli_fetch_array($result))
                                                {
                                                    $temp2_invoice = $row['invoice'];
                                                    $temp2_email = $row['email'];
                                                    $temp2_id = $row['id'];

                                                    $temp2_apt = $row['apt'];
                                                    if ($temp2_apt == null) $temp2_apt = '-';

                                                    $temp2_unit = $row['unit'];
                                                    if ($temp2_apt == null) $temp2_apt = '-';

                                                    $temp2_message = $row['message'];
                                                    if ($temp2_message == null) $temp2_message = '-';

                                                    $temp2_date = $row['date'];
                                                    if ($temp2_date == null) $temp2_date = '-';

                                                    if ($isOdd) {
                                                        $isOdd = false;
                                                        echo '<tr bgcolor="#e8fff1">';
                                                    } else {
                                                        $isOdd = true;
                                                        echo '<tr>';
                                                    }

                                                    if ($row['isworkdone'] == 1) {
                                                        echo '<td tableHeadData="Status" align="center"><img src="./img/status_light_green" width="10px"></td>';
                                                    } else {
                                                        echo '<td tableHeadData="Status" align="center"><img src="./img/status_light_red" width="10px"></td>';
                                                    }

                                                    echo '
                                                            <td tableHeadData="Apt" align="center">'.$temp2_apt.'</td>
                                                            <td tableHeadData="Unit #" align="center">'.$temp2_unit.'</td>
                                                            <td tableHeadData="Message" align="center"><div class="lineBreak_msg">'.$temp2_message.'</div></td>
                                                            <td tableHeadData="Date" align="center">'.$temp2_date.'</td>
                                                            <td tableHeadData="Comment" align="center"><button onclick="location.href=\'show_comment.php?id='.$temp2_id.'&apt='.$temp2_apt.'&unit='.$temp2_unit.'\'">Show</button><button onclick="location.href=\'edit_user.php?id='.$temp2_id.'&invoice='.$temp2_invoice.'\'">Add</button></td>
                                                            <td tableHeadData="Process" align="center"><button id="btn_workdone" onclick="location.href=\'workdone_process.php?invoice_num='.urlencode($temp2_invoice).' &email_user='.urlencode($temp2_email).' &id='.urlencode($temp2_id).'\'">Work Done</button></td>
                                                        </tr>
                                                    ';
                                                }
                                                echo '</tbody></table>';
                                            }
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

    </body>

</html>








































