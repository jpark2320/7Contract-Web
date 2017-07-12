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
            include('./includes/connection.php');
            if (isset($_GET['id'])) {
                $_SESSION['id'] = $_GET['id'];
                $_SESSION['paid'] = $_GET['paid'];
                $_SESSION['salary'] = $_GET['salary'];
            } else {
                 echo '<script>alert("Something is not valid.");</script>';
                 echo '<script>window.location.href="worksheet.php";</script>';
                 exit();
            }
            $remaining = $_GET['salary'] - $_GET['paid'];
        ?>

        <!-- Body -->
        <div class="primary" align="center">
            <h3 class="text-center">Pay</h3><br>

            <div class="row" align="center">
                <form action="pay_process.php" method="POST">

                    <table width="400">
                        <colgroup>
                            <col width="50%">
                            <col width="50%">
                        </colgroup>
                            <tr>
                                <td><label>Name</label></td>
                                <td><?php echo $_GET['username']?></td>
                            </tr>
                            <tr>
                                <td><label>Comment</label></td>
                                <td><?php echo $_GET['comment']?></td>
                            </tr>
                            <tr>
                                <td><label>Salary</label></td>
                                <td><?php echo "$ ".$_GET['salary']?></td>
                            </tr>
                            <tr>
                                <td><label>Remaining Balance</label></td>
                                <td><?php echo "$ ".number_format((float)$remaining, 2, '.', '')?></td>
                            </tr>
                            <tr>
                                <td><label>Pay Amount</label></td>
                                <td><input type="text" name="pay" maxlength="36" size="30"></td>
                            </tr>
                    </table>
                    <br>
                    <input type="submit" value="Pay">
                    <input type="button" value="Back" onclick="location.href='invoice_detail.php'">
                </form>
            </div>
        </div>

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>
