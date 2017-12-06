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
                        <h1 class="page-header">User History</h1>
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

                                    include('./includes/data_range.html');

                                    $email = $_SESSION['user_email'];
                                    $username = $_SESSION['user_name'];

                                    echo '
                                        <form action="user_pdf.php" method="post" target="_blank">
                                            <table width="100%" class="table">
                                                <colgroup>
                                                    <col width="50%">
                                                    <col width="50%">
                                                </colgroup> 
                                                <tbody>
                                                    <tr>
                                                        <td align="right"><b>Username</b></td>
                                                        <td align="left">'.$username.'</td>
                                                    </tr>
                                                    <tr>
                                                        <td align="right"><b>Email</b></td>
                                                        <td align="left">'.$email.'</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                                <colgroup>
                                                    <col width="5%">
                                                    <col width="5%">
                                                    <col width="5%">
                                                    <col width="61%">
                                                    <col width="7%">
                                                    <col width="7%">
                                                    <col width="10%">
                                                </colgroup>
                                                <thead>
                                                    <tr align="center">
                                                        <td></td>
                                                        <td><b>#</b></td>
                                                        <td><b>Paid</b></td>
                                                        <td><b>Comment</b></td>
                                                        <td><b>Salary</b></td>
                                                        <td><b>Paid</b></td>
                                                        <td><b>Date</b></td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                    ';
                                    
                                    $sql = "SELECT * FROM user_comment WHERE email='$email' ";
                                    if (isset($year)) $year = $_POST['year'];
                                    if (isset($month)) $month = $_POST['month'];
                                    if (isset($week)) {
                                        $week = $_POST['week'] * 7 + 1;
                                        $week_end = $week + 6;
                                    }
                                    if (isset($year) && isset($month) && isset($week)) {
                                        $q = "AND date BETWEEN '".$year."-".$month."-".$week." 00:00:00' AND '".$year."-".$month."-".$week_end." 23:59:59'";
                                    }
                                    if (isset($year) && isset($month) && isset($week)) {
                                        if (strlen($_POST['year'])>0 && strlen($_POST['month'])>0 && strlen($_POST['week'])>0) {
                                            $sql .= $q;
                                        } else if (strlen($_POST['year'])>0 && strlen($_POST['month'])>0) {
                                            $sql .= "AND YEAR(date)=".$_POST['year']." AND MONTH(date)=".$_POST['month']." ";
                                        } else if (strlen($_POST['year'])>0){
                                            $sql .= "AND YEAR(date)=".$_POST['year']." ";
                                        }
                                    }
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
                                        echo '
                                                <td align="center"><input type="checkbox" name="check[]" value="'.$row['id'].'"></td>
                                                <td align="center">'.$i.'</td>';
                                        if ($row['ispaidoff'] == 1) {
                                            echo '<td><img src="./img/status_light_green" width="15px"><span hidden>3</span></td>';
                                        } else {
                                            echo '<td><img src="./img/status_light_red" width="15px"><span hidden>1</span></td>';
                                        }
                                        echo '
                                                <td><div class="lineBreak">'.$row['comment'].'</div></td>
                                                <td>'.$row['salary'].'</td>
                                                <td>'.$row['paid'].'</td>
                                                <td>'.substr($row['date'], 0, 11).'</td>
                                            </tr>
                                        ';
                                    }
                                    echo '</tbody></table>';
                                ?>
                                <div class="row">
                                    <div class="col-sm-offset-5 col-sm-3 text-center">
                                        <div class="text-center btn-group">
                                            <button class="btn btn-primary" type="submit" name="submit">Make PDF</button>
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


        <?php include('./includes/functions.js'); ?>
    </body>
</html>