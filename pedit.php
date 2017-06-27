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
            unset($_SESSION['invoice']);
            unset($_SESSION['temail']);
            unset($_SESSION['id']);
            unset($_SESSION['message']);
            unset($_SESSION['comment']);
            unset($_SESSION['price']);
            if (isset($_GET['invoice'])) {
                $_SESSION['invoice'] = $_GET['invoice'];
                $_SESSION['temail'] = $_GET['email'];
                $_SESSION['id'] = $_GET['id'];
				$_SESSION['message'] = $_GET['message'];
				$_SESSION['comment'] = $_GET['comment'];
				$_SESSION['price'] = $_GET['price'];
            } else {
            	 echo '<script>alert("Something is not valid.");</script>';
            	 echo '<script>window.location.href="worksheet.php";</script>';
            	 exit();
            }
        ?>

        <!-- Body -->
        <div class="container">
            <h3 class="text-center">Edit</h3><br>

            <div class="row" align="center">
                <form action="pedit_process.php" method="POST">

                    <table width="400">
                        <colgroup>
                            <col width="50%">
                            <col width="50%">
                        </colgroup>
                            <tr>
                                <td><label>Message</label></td>
                                <td><input type="text" name="message" maxlength="36" size="30" value="<?php echo isset($_SESSION['message']) ? $_SESSION['message'] : '' ?>"></td>
                            </tr>
                            <tr>
                                <td><label>Comment</label></td>
                                <td><input type="text" name="comment" maxlength="36" size="30" value="<?php echo isset($_SESSION['comment']) ? $_SESSION['comment'] : '' ?>"></td>
                            </tr>
                            <tr>
                                <td><label>Price</label></td>
                                <td><input type="text" name="price" maxlength="36" size="30" value="<?php echo isset($_SESSION['price']) ? $_SESSION['price'] : '' ?>"></td>
                            </tr>
                    </table>
                    <br>
                    <input type="submit" value="Edit">
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
