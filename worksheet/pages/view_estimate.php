<?php
    session_start();
    unset($_SESSION['edit_arr']);
    $_SESSION['i'] = 0;
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
                        <h1 class="page-header">View Estimate</h1>
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

                                    $sql = "SELECT * FROM estimate";
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_array($result);

                                    
                                    if (isset($_GET['st'])) {
                                        $_SESSION['sort'] = $_GET['st'];
                                        echo '<script>window.location.href = "view_estimate.php";</script>';
                                    }

                                    echo '
                                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                            <thead>
                                                <tr>
                                                    <td align="center"><b><a href="?orderBy=id">ID</a></b></td>
                                                    <td align="center"><b><a href="?orderBy=apt">Apartment</a></b></td>
                                                    <td align="center"><b><a href="?orderBy=unit">Unit #</a></b></td>
                                                    <td align="center"><b><a href="?orderBy=size">Size</a></b></td>
                                                    <td align="center"><b><a href="?orderBy=price">Price</a></b></td>
                                                    <td align="center"><b>Description</b></td>
                                                    <td align="center"><b><a href="?orderBy=date">Date</a></b></td>
                                    ';
                                    if ($_SESSION['isadmin'] == 2) {                
                                        echo '<td align="center"><b>Option</b></td>';
                                    }
                                    echo '
                                                </tr>
                                            </thead>
                                    ';
                                    $orderBy = array('id', 'company', 'apt', 'unit', 'size', 'price', 'date');
                                    $order = 'id';
                                    if (isset($_GET['orderBy']) && in_array($_GET['orderBy'], $orderBy)) {
                                        $order = $_GET['orderBy'];
                                    }
                                    $sql = "SELECT * FROM estimate ORDER BY ".$order;
                                    if ($_SESSION['sort']=='desc') {
                                        $sql = $sql.' DESC';
                                    }
                                    $result = mysqli_query($conn, $sql);
                                    $isOdd = false;
                                    while($row = mysqli_fetch_array($result))
                                    {
                                        $company = $row['company'];
                                        if ($company == null) $company = "-";

                                        $apt = $row['apt'];
                                        if ($apt == null) $apt = "-";

                                        $unit = $row['unit'];
                                        if ($unit == null) $unit = "-";

                                        $size = $row['size'];
                                        if ($size == null) $size = "-";

                                        $price = $row['price'];
                                        if ($price == null) $price = "-";
                                        $price = str_replace(".00", "", $price);
                                        $description = $row['description'];
                                        if ($description == null) $description = "-";
                                        if (strlen($description) > 40) {
                                            $description = substr($description, 0, 40)." ...";
                                        }

                                        $date = $row['date'];
                                        if ($date == null) $date = "-";

                                        echo '<tbody>';
                                        if ($isOdd) {
                                            $isOdd = false;
                                            echo '<tr bgcolor="#e8fff1">';
                                        } else {
                                            $isOdd = true;
                                            echo '<tr>';
                                        }

                                        echo '
                                                    <td tableHeadData="ID" align="center">'.$row['id'].'</td>
                                                    <td tableHeadData="Apartment" align="center"><a href="worksheet_apt.php?apt='.$apt.'">'.$apt.'</a></td>
                                                    <td tableHeadData="Unit" align="center">'.$unit.'</td>
                                                    <td tableHeadData="Size" align="center">'.$size.'</td>
                                                    <td tableHeadData="Price" align="center">'.number_format($price).'</td>
                                                    <td tableHeadData="Description" align="left"><a href="estimate_description.php?id='.$row['id'].'&company='.$company.'&apt='.$apt.'&unit='.$unit.'&size='.$size.'">'.$description.'</a></td>
                                                    <td tableHeadData="Date" align="center">'.substr($date, 0, 10).'</td>
                                        ';
                                        if ($_SESSION['isadmin']) {
                                            echo '
                                                <td align="center">
                                                    <button onclick="location.href=\'toWorksheet.php?id='.$row['id'].'&company='.$company.'&apt='.$apt.'&unit='.$unit.'&size='.$size.'&price='.$price.'&description='.$description.'\'">Convert</button>
                                                    <button onclick="location.href=\'estimate_edit.php?id='.$row['id'].'\'">Edit</button>
                                                    <button onclick="deleteBtn('.$row['id'].')">Remove</button>
                                                </td>
                                            ';
                                        }
                                    }
                                    echo '</table>';
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
