<?php 
	session_start(); 
	date_default_timezone_set('Etc/UTC');
?>
<!DOCTYPE html>
<html lang="en">
    <!-- Header Tag -->
    <?php include('./includes/head_tag.html'); ?>
    <body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="50">

        <!-- Header -->
        <?php include('./includes/nav_bar.php'); ?>

        <!-- Body -->
        <div class="primary" align="center">
            <h3 class="text-center">Make PDF</h3><br>

            <?php
                // connection with mysql database
                include('./includes/connection.php');

                if ($_POST['description'] !== null) {
                    $_SESSION['arr'][$_SESSION['i']][0] = $_POST['description'];
                }
                if ($_POST['price'] !== null) {
                    $_SESSION['arr'][$_SESSION['i']][1] = $_POST['qty'];
                }
                if ($_POST['qty'] !== null) {
                    $_SESSION['arr'][$_SESSION['i']][2] = $_POST['price'];
                }

                if (isset($_POST['submit'])) {
                    $_SESSION['i']++;
                }

                echo '
                    
                    <form action="estimate_info.php" method="post">
                        <table border="2" width="100%">
                            <colgroup>
                                <col width="50%">
                                <col width="25%">
                                <col width="25%">
                            </colgroup>
                            <thead>
                                <tr style="border: 2px double black;" bgcolor="#c9c9c9">
                                    <td align="center"><b>Description</b></td>
                                    <td align="center"><b>Qty</b></td>
                                    <td align="center"><b>Price</b></td>
                                </tr>
                            </thead>
                            <tbody id="pdf_table">
                                <tr>
                                    <td><input type="text" name="description" size="91" required></td>
                                    <td><input type="text" name="qty" size="44"></td>
                                    <td><input type="text" name="price" size="44"></td>
                ';
                for ($i = 0; $i < sizeof($_SESSION['arr']); $i++) {
                    if ($_SESSION['arr'][$i][0] !== null) {
                        echo '<tr bgcolor="#c4daff"><td>'.$_SESSION['arr'][$i][0].'</td>';
                    }
                    if ($_SESSION['arr'][$i][1] !== null) {
                        echo '<td>'.$_SESSION['arr'][$i][1].'</td>';
                    }
                    if ($_SESSION['arr'][$i][2] !== null) {
                        echo '<td>'.$_SESSION['arr'][$i][2].'</td></tr>';
                    }
                }

                echo '
                                </tr>
                            </tbody>
                        </table>
                        <input type="submit" name="submit" value="Add">
                    </form>
                        <br><br>
                    <form action="create_estimate.php" method="post">
                        <table border="2" width="200">
                            <tr align="center" bgcolor="#c9c9c9">
	                            <td><label><b>Apartment</b></label></td>
	                            <td><label><b>Unit</b></label></td>
	                            <td><label><b>Size</b></label></td>
                                <td><label><b>Date</b></label></td>
                            </tr>
                            <tr align="center">
                            	<td><input type="text" name="apt" value="" size="20"></td>
                            	<td><input type="text" name="unit" value="" size="10"></td>
                            	<td><input type="text" name="size" value="" size="10"></td>
                                <td><input type="text" name="date" value="'.date("Y-m-d").'" size="10"></td>
                            </tr>
                        </table>
                ';
            ?>
            <br>
            <input type="submit" value="Create PDF"></input>
            <input type="button" value="Back" onclick="location.href='worksheet.php'"></input>
            </form>

        </div>

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>
