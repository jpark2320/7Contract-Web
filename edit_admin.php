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

            if (isset($_GET['invoice_num'])) {
                $invoice = $_GET['invoice_num'];
                $invoice = substr($invoice, 2);
                $check = "SELECT * FROM Worksheet WHERE invoice ='".$invoice."';";
                $result = $conn->query($check);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $_SESSION['invoice'] = $row['invoice'];
                        $_SESSION['po'] = $row['PO'];
                        $_SESSION['company'] = $row['company'];
                        $_SESSION['apt'] = $row['apt'];
                        $_SESSION['manager'] = $row['manager'];
                        $_SESSION['size'] = $row['size'];
                        $_SESSION['unit'] = $row['unit'];
                        $_SESSION['price'] = $row['price'];
                        $_SESSION['salary'] = $row['salary'];
                        $_SESSION['profit'] = $row['profit'];
                        $_SESSION['description'] = $row['description'];
                    }
                }
            }
        ?>

        <!-- Body -->
        <div class="container">
            <h3 class="text-center">Edit</h3><br>

            <div class="row" align="center">
                <form action="edit_process.php" method="POST">

                    <table width="400">
                        <colgroup>
                            <col width="50%">
                            <col width="50%">
                        </colgroup>
                            <tr>
                                <td><label>P.O Number:</label></td>
                                <td><input type="text" name="po" maxlength="36" size="30" value="<?php echo isset($_SESSION['po']) ? $_SESSION['po'] : '' ?>"></td>
                            </tr>
                            <tr>
                                <td><label>Company:</label></td>
                                <td><input type="text" name="company" maxlength="36" size="30" value="<?php echo isset($_SESSION['company']) ? $_SESSION['company'] : '' ?>"></td>
                            </tr>
                            <tr>
                                <td><label>Apt #:</label></td>
                                <td><input type="text" name="apt" maxlength="36" size="30" value="<?php echo isset($_SESSION['apt']) ? $_SESSION['apt'] : '' ?>"></td>
                            </tr>
                            <tr>
                                <td><label>Manager:</label></td>
                                <td><input type="text" name="manager" maxlength="36" size="30" value="<?php echo isset($_SESSION['manager']) ? $_SESSION['manager'] : '' ?>"></td>
                            </tr>
                            <tr>
                                <td><label>Unit #</label></td>
                                <td><input type="text" name="unit" maxlength="36" size="30" value="<?php echo isset($_SESSION['unit']) ? $_SESSION['unit'] : '' ?>"></td>
                            </tr>
                            <tr>
                                <td><label>Size:</label></td>
                                <td><input type="text" name="size" maxlength="36" size="30" value="<?php echo isset($_SESSION['size']) ? $_SESSION['size'] : '' ?>"></td>
                            </tr>
                            <tr>
                                <td><label>Price:</label></td>
                                <td><input type="text" name="price" maxlength="36" size="30" value="<?php echo isset($_SESSION['price']) ? $_SESSION['price'] : '' ?>"></td>
                            </tr>
                            <tr>
                                <td><label>Salary:</label></td>
                                <td><input type="text" name="salary" maxlength="36" size="30" value="<?php echo isset($_SESSION['salary']) ? $_SESSION['salary'] : '' ?>"></td>
                            </tr>
                            <tr>
                                <td><label>Profit:</label></td>
                                <td><input type="text" name="profit" maxlength="36" size="30" value="<?php echo isset($_SESSION['profit']) ? $_SESSION['profit'] : '' ?>"></td>
                            </tr>
                            <tr>
                                <td><label>Description:</label></td>
                                <td><input type="text" name="description" maxlength="36" size="30" value="<?php echo isset($_SESSION['description']) ? $_SESSION['description'] : '' ?>"></td>
                            </tr>
                    </table>
                    <br>
                    <input type="submit" value="Edit">
                    <input type="button" value="Back" onclick="location.href='worksheet.php'">
                </form>
            </div>
        </div>

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>
