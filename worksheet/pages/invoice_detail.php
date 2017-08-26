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
            include('./includes/connection.php');

            if (isset($_GET['invoice_num'])) {
                $i_detail = $_GET['invoice_num'];
                $_SESSION['invoice'] = str_replace('7C', '', $i_detail);
            } else {
                $i_detail = '7C'.str_replace('7C', '', $_SESSION['invoice']);
            }
            $sql = "SELECT * FROM Worksheet WHERE invoice='".$_SESSION['invoice']."'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
            $_SESSION['po_pdf'] = $row['PO'];
            $_SESSION['company_pdf'] = $row['company'];
            $_SESSION['apt_pdf'] = $row['apt'];
            $_SESSION['unit_pdf'] = $row['unit'];
            $_SESSION['size_pdf'] = $row['size'];
            date_default_timezone_set('Etc/UTC');
            $_SESSION['date_pdf'] = date("Y-m-d");
        ?>

        <div id="wrapper">
            <?php include("./includes/nav_bar.php"); ?>
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Invoice Detail</h1>
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
                                        echo '
                                            <table width="100%" class="table table-striped table-bordered table-hover">
                                                <colgroup>
                                                    <col width="50%">
                                                    <col width="50%">
                                                </colgroup>
                                                <tr>
                                                    <td align="right"><b>Invoice</b></td>
                                                    <td align="left">'."7C".$_SESSION['invoice'].'</td>
                                                </tr>
                                                <tr>
                                                    <td align="right"><b>Apt</b></td>
                                                    <td align="left">'.$_SESSION['apt_pdf'].'</td>
                                                </tr>
                                                <tr>
                                                    <td align="right"><b>Unit</b></td>
                                                    <td align="left">'.$_SESSION['unit_pdf'].'</td>
                                                </tr>
                                            </table>
                                        ';

                                        $i_detail = str_replace('7C', '', $i_detail);
                                        $_SESSION['invoice'] = $i_detail;

                                        echo '
                                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                                <colgroup>
                                                    <col width="7%">
                                                    <col width="6%">
                                                    <col width="10%">
                                                    <col width="43%">
                                                    <col width="10%">
                                                    <col width="7%">
                                                    <col width="7%">
                                                    <col width="10%">
                                                </colgroup>
                                                <thead>
                                                    <tr align="center">
                                                        <td><b>Status</b></td>
                                                        <td><b>Paid</b></td>
                                                        <td><b>Name</b></td>
                                                        <td><b>Message</b></td>
                                                        <td><b>Comment</b></td>
                                        ';
                                        if ($_SESSION['isadmin'] == 2) {
                                            echo '
                                                <td><b>Salary</b></td>
                                                <td><b>Paid</b></td>
                                            ';
                                        }
                                        echo '
                                                    <td><b>Date</b></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                        ';
                                        
                                        $sql = "SELECT * FROM
                                            (SELECT users.first, users.last, users.email from users) AS A
                                            INNER JOIN
                                            (SELECT * FROM SubWorksheet WHERE invoice='$i_detail') AS B
                                            ON A.email=B.email";
                                        $result = mysqli_query($conn, $sql);

                                        $isOdd = false;
                                        while($row = mysqli_fetch_array($result)) {

                                            $id = $row['id'];

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
                                            if ($row['ispaidoff'] == 1) {
                                                echo '<td><img src="./img/status_light_green" width="15px"><span hidden>3</span></td>';
                                            } else {
                                                echo '<td><img src="./img/status_light_red" width="15px"><span hidden>1</span></td>';
                                            }

                                            echo '
                                                <td><a href="user_detail.php?invoice='.urlencode($i_detail).' &email='.urlencode($row['email']).' &user_name='.urlencode($row['first'].' '.$row['last']).'">'.$row['first'].' '.$row['last'].'</a></td>
                                                <td align="left"><div class="lineBreak">'.$row['message'].'</div></td>
                                                <td><button class="btn btn-primary btn-xs btn-block" type="button" onclick="location.href=\'show_comment.php?id='.$id.'&email='.$row['email'].'&apt='.$_SESSION['apt_pdf'].'&unit='.$_SESSION['unit_pdf'].'&username='.urlencode($row['first'].' '.$row['last']).'\'">Show Comment</button></td>
                                            ';
                                            if ($_SESSION['isadmin'] == 2) {
                                                echo '
                                                    <td>'.number_format($row['price']).'</td>
                                                    <td>'.number_format($row['paid']).'</td>
                                                ';
                                            }
                                            echo '
                                                    <td>'.substr($row['date'], 0, 11).'</td>
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
                                            <?php
                                                if (isset($_SESSION['po_pdf']) && isset($_SESSION['company_pdf']) && isset($_SESSION['apt_pdf']) && isset($_SESSION['unit_pdf']) && isset($_SESSION['size_pdf'])) {
                                                    echo '<button class="btn btn-primary" onclick="location.href=\'pdf_info.php?invoice='.urlencode($i_detail).' &po='.$_SESSION['po_pdf'].' &company='.$_SESSION['company_pdf'].' &apt='.$_SESSION['apt_pdf'].' &unit='.$_SESSION['unit_pdf']. ' &size='.$_SESSION['size_pdf'].'\'">Make PDF</button>';
                                                }
                                            ?>
                                            <button class="btn btn-primary" type="button" onclick="location.href='worksheet.php'">Back</button>
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