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
            <h3 class="text-center">Pay</h3>

            <div class="row" align="center">
                <form action="pay_process.php" method="POST">

                    <table width="30%">
                        <colgroup>
                            <col width="40%">
                            <col width="5%">
                            <col width="55%">
                        </colgroup>
                        <tbody>
                            <tr>
                                <td align="right"><b>Name</b></td>
                                <td></td>
                                <td><?php echo $_GET['username']?></td>
                            </tr>
                            <tr>
                                <td align="right"><b>Comment</b></td>
                                <td></td>
                                <td><div class="lineBreak_cmt_AtPay"><?php echo $_GET['comment']?></div></td>
                            </tr>
                            <tr>
                                <td align="right"><b>Salary</b></td>
                                <td></td>
                                <td><?php echo "$ ".$_GET['salary']?></td>
                            </tr>
                            <tr>
                                <td align="right"><b>Remaining Balance</b></td>
                                <td></td>
                                <td><?php echo "$ ".number_format((float)$remaining, 2, '.', '')?></td>
                            </tr>
                            <tr>
                                <td align="right"><b>Pay Amount</b></td>
                                <td></td>
                                <td><input class="editInput" type="text" name="pay"></td>
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    <button type="submit">Pay</button>
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
