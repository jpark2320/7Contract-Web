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
                        <h1 class="page-header">User Detail</h1>
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
                                <form action="pedit.php" method="post">
                                    <?php
                                        // connection with mysql database
                                        include('./includes/connection.php');

                                        $_SESSION['invoice'] = $_GET['invoice'];
                                        $email = $_GET['email'];
                                        $_SESSION['user_email'] = $email;
                                        $user_name = $_GET['user_name'];
                                        $_SESSION['user_name'] = $user_name;
                                        echo '
                                            <table width="100%" class="table table-striped table-bordered table-hover">
                                                <colgroup>
                                                    <col width="50%">
                                                    <col width="50%">
                                                </colgroup>
                                                <tbody>
                                                    <tr>
                                                        <td align="right"><b>User Name : </b></td>
                                                        <td align="left">'.$user_name.'</td>
                                                    </tr>
                                                    <tr>
                                                        <td align="right"><b>Email : </b></td>
                                                        <td align="left">'.$email.'</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                                <thead>
                                                    <tr>
                                                        <td align="center"><b>Status</b></td>
                                                        <td align="center"><b>Paid off</b></td>
                                                        <td align="center"><b>Invoice #</b></td>
                                                        <td align="center"><b>Apt</b></td>
                                                        <td align="center"><b>Unit #</b></td>
                                                        <td align="center"><b>Price</b></td>
                                                        <td align="center"><b>Message</b></td>
                                                        <td align="center"><b>Comment</b></td>
                                                        <td align="center"><b>Date</b></td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                        ';
                                        if (isset($i_detail))
                                            $i_detail = substr($i_detail, 2);

                                        $sql = "SELECT * FROM
                                            (SELECT users.first, users.last, users.email from users) AS A
                                            INNER JOIN
                                            (SELECT * FROM SubWorksheet WHERE email='$email') AS B
                                            ON A.email=B.email";
                                        $result = mysqli_query($conn, $sql);

                                        $idOdd = false;
                                        while($row = mysqli_fetch_array($result)) {

                                            if (isset($isOdd)) {
                                                if ($isOdd) {
                                                    $isOdd = false;
                                                    echo '<tr class="odd gradeX" align="center">';
                                                } else {
                                                    $isOdd = true;
                                                    echo '<tr class="even gradeX" align="center">';
                                                }
                                            }

                                            $invoice = "7C".$row['invoice'];

                                            if ($row['isworkdone'] == 1) {
                                                echo '<td><img src="./img/status_light_green" width="15px"><span hidden>3</span></td>';
                                            } else {
                                                echo '<td><img src="./img/status_light_red" width="15px"><span hidden>1</span></td>';
                                            }
                                            if ($row['ispaidoff'] == 1) {
                                                echo '<td><img src="./img/status_light_green" width="15px"><span hidden>3</span></td>';
                                            } else {
                                                echo '<td><img src="./img/status_light_red" width="15px"><span hidden>1</span></td>';
                                            }
                                            echo '
                                                    <td align="center"><a href="invoice_detail?invoice_num='.$invoice.'">'.$invoice.'</a></td>
                                                    <td align="center"><a href="invoice_detail?invoice_num='.$row['apt'].'">'.$row['apt'].'</a></td>
                                                    <td align="center">'.$row['unit'].'</td>
                                                    <td align="center">'.$row['price'].'</td>
                                                    <td align="center">'.$row['message'].'</td>
                                                    <td align="center"><button id="btn_showComment" onclick="location.href=\'show_comment.php?id='.$row['id'].'&email='.$email.'&apt='.$row['apt'].'&unit='.$row['unit'].'&username='.urlencode($user_name).'&from_user=1\'">Show Comments</button></td>
                                                    <td align="center">'.$row['date'].'</td>
                                                </tr>
                                            ';
                                        }
                                        echo '</tbody></table>';
                                        mysqli_close($conn);
                                    ?>
                                </form>
                                <div class="row">
                                    <div class="col-sm-offset-5 col-sm-2 text-center">
                                        <div class="text-center btn-group">
                                            <button class="btn btn-primary" type="button" onclick="location.href='user_history.php'">Show All History</button>
                                            <button class="btn btn-primary" type="button" onclick="location.href='invoice_detail.php'">Back</button>
                                        </div>  
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
