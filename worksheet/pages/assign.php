<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

    <?php include('./includes/head_tag.html'); ?>

    <body>
        <?php  
            if (isset($_GET['invoice_num'])) $_SESSION['i_num'] = $_GET['invoice_num'];
            if (isset($_GET['apt'])) $_SESSION['a_num'] = $_GET['apt'];
            if (isset($_GET['unit_num'])) $_SESSION['u_num'] = $_GET['unit_num'];
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
                                Invoice Number : <?php echo $_SESSION['i_num']; ?> 
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                
                                <form action="assign_process.php" method="POST">
                                    <?php

                                        // connection with mysql database
                                        include('./includes/connection.php');

                                        $sql = "SELECT * FROM users WHERE isadmin=0";
                                        $result = mysqli_query($conn, $sql);

                                        echo '
                                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                                <colgroup>
                                                    <col width="5%">
                                                    <col width="40%">
                                                    <col width="55%">
                                                </colgroup>
                                                <thead>
                                                    <tr align="center">
                                                        <td></td>
                                                        <td><b>Name</b></td>
                                                        <td><b>Email</b></td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                        ';
                                        
                                        $isOdd = false;
                                        while($row = mysqli_fetch_array($result)) {

                                            if ($isOdd) {
                                                $isOdd = false;
                                                echo '<tr class="odd gradeX" align="center">';
                                            } else {
                                                $isOdd = true;
                                                echo '<tr class="even gradeX" align="center">';
                                            }
                                            
                                            echo '
                                                    <td><input type="checkbox" name="workersArray[]" value="'.$row['email'].'"></td>
                                                    <td>'.$row['first'].' '.$row['last'].'</td>
                                                    <td>'.$row['email'].'</td>
                                                </tr>
                                            ';

                                        }
                                        echo '</tbody></table>';
                                        mysqli_close($conn);
                                    ?>
                                    <div class="form-group">
                                        <label for="comment">Comment:</label>
                                        <textarea class="form-control" rows="5" id="msg_assign" name="assign_message" placeholder="Leave a message here."></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-offset-5 col-sm-2 text-center">
                                            <div class="text-center btn-group">
                                                <button class="btn btn-primary" type="submit">Confirm</button>
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