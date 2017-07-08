<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <!-- Header Tag -->
    <?php include('./includes/head_tag.html'); ?>
    <body id="myPage">

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
                        $_SESSION['description'] = $row['description'];
                    }
                }
            }
            echo '<script>alert("'.$_SESSION['description_pdf'].'")</script>';

            if (isset($_GET['description'])) {
                $description = $_GET['description'];

            } else {
                echo '<script>alert("NO")</script>';
            }

            if (isset($_GET['qty'])) {
                $qty = $_GET['qty'];
            }
            echo '<script>alert("'.$qty.'")</script>';
            if (isset($_GET['price'])) {
                $price = $_GET['price'];
            }
            echo '<script>alert("'.$price.'")</script>';
        ?>

        <!-- Body -->
        <div class="primary" align="center">
            <h3 class="text-center">Edit PDF Information</h3><br>

            <form action="pdf_info.php" method="POST">

                <table width="400">
                    <colgroup>
                        <col width="50%">
                        <col width="50%">
                    </colgroup>
                        <tr>
                            <td><label>Description</label></td>
                            <td><input type="text" name="po" maxlength="36" size="30" value="<?php echo isset($_SESSION['description_pdf']) ? $_SESSION['description_pdf'] : '' ?>"></td>
                        </tr>
                        <tr>
                            <td><label>Qty</label></td>
                            <td><input type="text" name="company" maxlength="36" size="30" value="<?php echo isset($_SESSION['qty_pdf']) ? $_SESSION['qty_pdf'] : '' ?>"></td>
                        </tr>
                        <tr>
                            <td><label>Price</label></td>
                            <td><input type="text" name="apt" maxlength="36" size="30" value="<?php echo isset($_SESSION['price_pdf']) ? $_SESSION['price_pdf'] : '' ?>"></td>
                        </tr>
                </table>
                <br>
                <input type="submit" value="Edit">
                <input type="button" value="Back" onclick="location.href='pdf_info.php'">
            </form>
        </div>

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>
