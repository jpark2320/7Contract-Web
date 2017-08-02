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

                    <table width="30%">
                        <colgroup>
                            <col width="40%">
                            <col width="10%">
                            <col width="50%">
                        </colgroup>
                            <tr>
                                <td align="right"><b>Invoice #</b></td>
                                <td></td>
                                <td><?php echo isset($_SESSION['invoice']) ? "7C".$_SESSION['invoice'] : '-' ?></td>
                            </tr>
                            <tr>
                                <td align="right"><b>Apt</b></td>
                                <td></td>
                                <td><?php echo isset($_SESSION['apt']) ? $_SESSION['apt'] : '-' ?></td>
                            </tr>
                            <tr>
                                <td align="right"><b>Unit</b></td>
                                <td></td>
                                <td><?php echo isset($_SESSION['unit']) ? $_SESSION['unit'] : '-' ?></td>
                            </tr>
                            <tr>
                                <td align="right"><b>Price</b></td>
                                <td></td>
                                <td><?php echo isset($_SESSION['price']) ? "$ ".$_SESSION['price']  : '-' ?></td>
                            </tr>
                            <tr>
                                <td align="right"><b>Remaining Balance</b></td>
                                <td></td>
                                <td><?php echo isset($_SESSION['remaining']) ? "$ ".number_format((float)$_SESSION['remaining'], 2, '.', '') : '-' ?></td>
                            </tr>
                            <tr>
                                <td align="right"><b>Recieved Amount</b></td>
                                <td></td>
                                <td><input class="editInput" type="text" name="recieve" maxlength="36" size="30"></td>
                            </tr>
                    </table>
                    <br>
                    <button type="submit">Recieved</button>
                    <button type="button" onclick="location.href='price_detail.php'">Back</button>
                </form>
            </div>
        </div>

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>

