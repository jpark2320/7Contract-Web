<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <!-- Header Tag -->
    <?php include('./includes/head_tag.html'); ?>
    <body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="50">

        <!-- Header -->
        <?php include('./includes/nav_bar.php'); ?>

        <?php
            // connection with mysql database
            include('./includes/connection.php');;
            if (isset($_GET['id'])) {
                $_SESSION['id'] = $_GET['id'];
            } else if (isset($_SESSION['id'])) {
                $_SESSION['id'] = $_SESSION['id'];
            } else {
            	 echo '<script>alert("Something is not valid.");</script>';
            	 echo '<script>window.location.href="invoice_detail.php";</script>';
            	 exit();
            }
        ?>

        <!-- Body -->
        <div class="primary" align="center">
            <h3 class="text-center">Edit</h3>

            <div class="row" align="center">
                <form action="pedit_process.php" method="POST">

                    <table width="30%">
                        <colgroup>
                            <col width="15%">
                            <col width="5%">
                            <col width="80%">
                        </colgroup>
                            <tr>
                                <td align="right"><b>Name</b></td>
                                <td></td>
                                <td><?php echo isset($_GET['username']) ? $_GET['username'] : '' ?></td>
                            </tr>
                            <tr>
                                <td align="right"><b>Comment</b></td>
                                <td></td>
                                <td><?php echo isset($_GET['comment']) ? $_GET['comment'] : '' ?></td>
                            </tr>
                            <tr>
                                <td align="right"><b>Salary</b></td>
                                <td></td>
                                <td><input class="editInput" type="text" name="salary"></td>
                            </tr>
                    </table>
                    <br>
                    <button type="submit">Edit</button>
                    <button type="button" onclick="location.href='invoice_detail.php'">Back</button>
                </form>
            </div>
        </div>

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>
