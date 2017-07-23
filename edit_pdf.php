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

            if (isset($_GET['index_deleted'])) {
                echo '<script>window.location.href="pdf_info.php";</script>';
                array_splice($_SESSION['pdf_arr'], $_GET['index_deleted'], 1);
                $_SESSION['i_pdf']--;
                exit();
            }
            if (isset($_GET['description'])) {
                $description = $_GET['description'];

            }

            if (isset($_GET['qty'])) {
                $qty = $_GET['qty'];
            }
            if (isset($_GET['price'])) {
                $price = $_GET['price'];
            }
            if (isset($_GET['index'])) {
                $index = $_GET['index'];
            }
        ?>

        <!-- Body -->
        <div class="primary" align="center">
            <h3 class="text-center">Edit PDF Information</h3><br>

            <form action="pdf_info.php" method="GET">

                <table width="400">
                    <colgroup>
                        <col width="50%">
                        <col width="50%">
                    </colgroup>
                    <tr>
                         <td><label>Description</label></td>
                         <td><input type="text" name="desc_edited_pdf" maxlength="36" size="30" value="<?php echo isset($description) ? $description : '' ?>"></td>
                     </tr>
                     <tr>
                         <td><label>Qty</label></td>
                         <td><input type="text" name="qty_edited_pdf" maxlength="36" size="30" value="<?php echo isset($qty) ? $qty : '' ?>"></td>
                     </tr>
                     <tr>
                         <td><label>Price</label></td>
                         <td><input type="text" name="price_edited_pdf" maxlength="36" size="30" value="<?php echo isset($price) ? $price : '' ?>"></td>
                     </tr>
                     <tr hidden>
                         <td><label>Index</label></td>
                         <td><input type="text" name="index_edited_pdf" value="<?php echo $index ?>"></td>
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