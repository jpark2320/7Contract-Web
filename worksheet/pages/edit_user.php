<?php 
    if (!isset($_SESSION)) {
        session_start(); 
    }
?>
<!DOCTYPE html>
<html lang="en">

    <?php 
        include('./includes/head_tag.html'); 

        include('./includes/connection.php');

        if (isset($_GET['id'])) {
            $_SESSION['id'] = $_GET['id'];
            $_SESSION['invoice'] = $_GET['invoice'];
        }
    ?>
    <body>
        <div id="wrapper">
            <?php include("./includes/nav_bar.php"); ?>
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Add Comment</h1>
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
                                    if (isset($_GET['cmt_edited_user'])) {
                                        $_SESSION['arr'][$_GET['index_edited_user']] = $_GET['cmt_edited_user'];
                                    }

                                    if (isset($_POST['comment'])) {
                                        if ($_POST['comment'] !== null) {
                                            $_SESSION['arr'][$_SESSION['i']] = $_POST['comment'];
                                        }
                                    }
                                    if (isset($_POST['submit'])) {
                                        $_SESSION['i']++;
                                    }

                                    echo '
                                        <form action="edit_user.php" method="post">
                                            <table width="100%" class="table table-striped table-bordered table-hover">
                                                <colgroup>
                                                    <col width="95%">
                                                    <col width="5%">
                                                </colgroup>
                                                <thead>
                                                    <tr>
                                                        <td align="center"><b>Comment</b></td>
                                                        <td></td>
                                                    </tr>
                                                </thead>
                                                <tbody id="pdf_table">
                                                    <tr>
                                                        <td><input class="form-control" type="text" name="comment" placeholder="Type comment" required></td>
                                                        <td><button class="btn btn-primary btn-block" type="submit" name="submit">Add</button></td>
                                    ';
                                    if (isset($_SESSION['arr'])) {
                                        for ($i = 0; $i < sizeof($_SESSION['arr']); $i++) {
                                            if ($_SESSION['arr'][$i] !== null) {
                                                echo '<tr bgcolor="#c4daff"><td><div class="lineBreak_desc">'.$_SESSION['arr'][$i].'</div></td>';
                                            }
                                            if ($_SESSION['arr'][$i] !== null) {
                                                echo '
                                                    <td align="center">
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">
                                                            <span class="caret"></span>
                                                            </button>
                                                            <ul class="dropdown-menu" role="menu">
                                                                <li><a onclick="location.href=\'edit_comment.php?comment='.$_SESSION['arr'][$i].' &index='.$i.'\'">Edit</a></li>
                                                                <li><a onclick="location.href=\'edit_comment.php?index_deleted='.$i.'\'">Delete</a></li>
                                                            </ul>
                                                        </div>
                                                    </td></tr>
                                                ';
                                            }
                                        }
                                    }
                                    echo '
                                                </tbody>
                                            </table>
                                        </form>
                                    ';
                                ?>
                                <div class="row">
                                    <div class="col-sm-offset-5 col-sm-2 text-center">
                                        <div class="text-center btn-group">
                                            <form>
                                                <button class="btn btn-primary" type="button" onclick="location.href='add_comment.php'">Submit</button>
                                                <button class="btn btn-primary" type="button" onclick="location.href='worksheet.php'">Back</button>
                                            </form>    
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