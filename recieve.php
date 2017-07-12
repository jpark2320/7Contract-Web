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
            unset($_SESSION['unit']);
            unset($_SESSION['price']);
            unset($_SESSION['apt']);
            unset($_SESSION['paid']);
            if (isset($_GET['invoice'])) {
                $_SESSION['invoice'] = str_replace('7C', '', $_GET['invoice']);
                $_SESSION['unit'] = $_GET['unit'];
                $_SESSION['apt'] = $_GET['apt'];
                $_SESSION['price'] = $_GET['price'];
                $_SESSION['paid'] = $_GET['paid'];
            } else {
                 echo '<script>alert("Something is not valid.");</script>';
                 echo '<script>window.location.href="worksheet.php";</script>';
                 exit();
            }
            $sql = "SELECT * FROM worksheet WHERE invoice=".$_SESSION['invoice'].";";
            $result = $conn->query($sql);
	        if ($result->num_rows > 0) {
	            while($row = $result->fetch_assoc()) {
	                $_SESSION['remaining'] = $_SESSION['price'] - $row['paid'];
	            }
	        }
        ?>

        <!-- Body -->
        <div class="primary" align="center">
            <h3 class="text-center">Recieve</h3><br>

            <div class="row" align="center">
                <form action="recieve_process.php" method="POST">

                    <table width="400">
                        <colgroup>
                            <col width="50%">
                            <col width="50%">
                        </colgroup>
                            <tr>
                                <td><label>Invoice #</label></td>
                                <td><?php echo "7C".$_SESSION['invoice']?></td>
                            </tr>
                            <tr>
                                <td><label>Apt</label></td>
                                <td><?php echo $_SESSION['apt']?></td>
                            </tr>
                            <tr>
                                <td><label>Unit</label></td>
                                <td><?php echo $_SESSION['unit']?></td>
                            </tr>
                            <tr>
                                <td><label>Price</label></td>
                                <td><?php echo "$ ".$_SESSION['price']?></td>
                            </tr>
                            <tr>
                                <td><label>Remaining Balance</label></td>
                                <td><?php echo "$ ".number_format((float)$_SESSION['remaining'], 2, '.', '')?></td>
                            </tr>
                            <tr>
                                <td><label>Recieved Amount</label></td>
                                <td><input type="text" name="recieve" maxlength="36" size="30"></td>
                            </tr>
                    </table>
                    <br>
                    <input type="submit" value="Recieved">
                    <input type="button" value="Back" onclick="location.href='price_detail.php'">
                </form>
            </div>
        </div>

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>

