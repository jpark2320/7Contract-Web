<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

    <?php 
        include('./includes/head_tag.html'); 

        include('./includes/connection.php');
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if ($_SESSION['isadmin'] > 0) {
                $email = $_GET['email'];
            } else {
                $email = $_SESSION['email'];
            }
            if (isset($_GET['username'])) {
                $username = $_GET['username'];
            }
        }

        if (isset($_SESSION['invoice'])) {
            $invoice = $_SESSION['invoice'];
        }
    ?>

    <body>

        <div id="wrapper">
            <?php include("./includes/nav_bar.php"); ?>
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Show Comment</h1>
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
                                                <col width="30%">
                                                <col width="70%">
                                            </colgroup>
                                    ';
                                    if ($_SESSION['isadmin'] > 0) {
                                        echo '
                                            <tr>
                                                <td align="right"><b>Username</b></td>
                                                <td align="left">'.$username.'</td>
                                            </tr>
                                            <tr>
                                                <td align="right"><b>Invoice</b></td>
                                                <td align="left">'.$_SESSION['invoice'].'</td>
                                            </tr>
                                        ';    
                                    }
                                    echo '
                                            <tr>
                                                <td align="right"><b>Apt</b></td>
                                                <td align="left">'.$_GET['apt'].'</td>
                                            </tr>
                                            <tr>
                                                <td align="right"><b>Unit</b></td>
                                                <td align="left">'.$_GET['unit'].'</td>
                                            </tr>
                                        </table>
                                    ';

                                    echo '
                                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    ';
                                    if ($_SESSION['isadmin'] == 2) {
                                        echo '
                                            <colgroup>
                                                <col width="5%">
                                                <col width="7%">
                                                <col width="59%">
                                                <col width="7%">
                                                <col width="7%">
                                                <col width="10%">
                                                <col width="5%">
                                            </colgroup>
                                            <thead align="center">
                                                <tr>
                                                    <td><b>#</b></td>
                                                    <td><b>Paid</b></td>
                                                    <td><b>Comment</b></td>
                                                    <td><b>Salary</b></td>
                                                    <td><b>Paid</b></td>
                                                    <td><b>Date</b></td>
                                                    <td></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                        ';
                                    } else {
                                        echo '
                                            <colgroup>
                                                <col width="5%">
                                                <col width="85%">
                                                <col width="10%">
                                            </colgroup>
                                            <thead>
                                                <tr align="center">
                                                    <td><b>#</b></td>
                                                    <td><b>Comment</b></td>
                                                    <td><b>Date</b></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                        ';
                                    }

                                    $sql = "SELECT * FROM user_comment WHERE sub_id='$id' AND email='$email'";
                                    $result = mysqli_query($conn, $sql);

                                    $isOdd = false;
                                    $i = 0;

                                    while($row = mysqli_fetch_array($result)) {

                                        $i++;

                                        if ($isOdd) {
                                            $isOdd = false;
                                            echo '<tr class="odd gradeX" align="center">';
                                        } else {
                                            $isOdd = true;
                                            echo '<tr class="even gradeX" align="center">';
                                        }
                                        if ($_SESSION['isadmin'] == 2) {
                                            echo '<td>'.$i.'</td>';
                                            if ($row['ispaidoff'] == 1) {
                                                echo '<td><img src="./img/status_light_green" width="15px"><span hidden>3</span></td>';
                                            } else {
                                                echo '<td><img src="./img/status_light_red" width="15px"><span hidden>1</span></td>';
                                            }
                                            echo '
                                                <td align="left"><div class="lineBreak">'.$row['comment'].'</div></td>
                                                <td>'.number_format($row['salary']).'</td>
                                                <td>'.number_format($row['paid']).'</td>
                                                <td>'.substr($row['date'], 0, 11).'</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">
                                                        <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li><a onclick="location.href=\'pedit.php?id='.$row['id'].' &comment='.urlencode($row['comment']).'&username='.$username.'\'">Edit</a></li>
                                                            <li><a onclick="location.href=\'pay.php?id='.$row['id'].'&salary='.number_format($row['salary']).' &comment='.urlencode($row['comment']).'&username='.urlencode($username).'&paid='.number_format($row['paid']).'\'">Pay</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                                </tr>
                                            ';
                                        } else {
                                            echo '
                                                    <td>'.$i.'</td>
                                                    <td><div class="lineBreak">'.$row['comment'].'</div></td>
                                                    <td>'.substr($row['date'], 0, 11).'</td>
                                                </tr>
                                            ';
                                        }
                                    }
                                    echo '</tbody></table>';
                                ?>
                                <div class="row">
                                    <div class="col-sm-offset-5 col-sm-2 text-center">
                                        <?php if($_SESSION['isadmin'] > 0): ?>
                                            <button class="btn btn-primary" type="button" onclick="location.href='invoice_detail.php'">Back</button>
                                        <?php else: ?>
                                            <button class="btn btn-primary" type="button" onclick="location.href='worksheet.php'">Back</button>
                                        <?php endif ?>
                                    </div>
                                </div>
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