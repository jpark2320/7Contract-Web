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
            unset($_SESSION['username']);
            unset($_SESSION['id']);
            unset($_SESSION['message']);
            unset($_SESSION['comment']);
            unset($_SESSION['price']);
            if (isset($_GET['invoice'])) {
                $_SESSION['invoice'] = $_GET['invoice'];
                $_SESSION['username'] = $_GET['username'];
                $_SESSION['id'] = $_GET['id'];
                $_SESSION['message'] = $_GET['message'];
                $_SESSION['comment'] = $_GET['comment'];
                $_SESSION['price'] = $_GET['price'];
            } else {
                 echo '<script>alert("Something is not valid.");</script>';
                 echo '<script>window.location.href="worksheet.php";</script>';
                 exit();
            }
            $sql = "SELECT * FROM subworksheet WHERE id=".$_SESSION['id'].";";
            $result = $conn->query($sql);
	        if ($result->num_rows > 0) {
	            while($row = $result->fetch_assoc()) {
	            	$_SESSION['paid'] = $row['paid'];
	                $_SESSION['remaining'] = $_SESSION['price'] - $row['paid'];
	            }
	        }
        ?>

        <!-- Body -->
        <div class="container">
            <h3 class="text-center">Edit</h3><br>

            <div class="row" align="center">
                <form action="pay_process.php" method="POST">

                    <table width="400">
                        <colgroup>
                            <col width="50%">
                            <col width="50%">
                        </colgroup>
                            <tr>
                                <td><label>Name</label></td>
                                <td><?php echo $_SESSION['username']?></td>
                            </tr>
                            <tr>
                                <td><label>Message</label></td>
                                <td><?php echo $_SESSION['message']?></td>
                            </tr>
                            <tr>
                                <td><label>Comment</label></td>
                                <td><?php echo $_SESSION['comment']?></td>
                            </tr>
                            <tr>
                                <td><label>Salary</label></td>
                                <td><?php echo "$ ".$_SESSION['price']?></td>
                            </tr>
                            <tr>
                                <td><label>Remaining Balance</label></td>
                                <td><?php echo "$ ".number_format((float)$_SESSION['remaining'], 2, '.', '')?></td>
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
