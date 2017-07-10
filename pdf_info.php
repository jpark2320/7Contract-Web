<?php session_start(); ?>
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

                // This is for values passed from invoice_detail.php
                if (isset($_GET['invoice_num'])) {
                    $i_detail = $_GET['invoice_num'];
                    $_SESSION['invoice'] = str_replace('7C', '', $i_detail);
                } else {
                    $i_detail = '7C'.$_SESSION['invoice'];
                }
                $po = $_SESSION['po_pdf'];
                $company = $_SESSION['company_pdf'];
                $apt = $_SESSION['apt_pdf'];
                $unit = $_SESSION['unit_pdf'];
                $size = $_SESSION['size_pdf'];
                // till here

                echo '
                    <table width="800">
                        <colgroup>
                            <col width="25%">
                            <col width="25%">
                            <col width="25%">
                            <col width="25%">
                        </colgroup>
                        <tr>
                            <td><label>Invoice # : </label></td>
                            <td>'.$i_detail.'</td>
                            <td><label>Apt : </label></td>
                            <td>'.$apt.'</td>
                        </tr>
                        <tr>
                            <td><label>P.O. : </label></td>
                            <td>'.$po.'</td>
                            <td><label>Unit # : </label></td>
                            <td>'.$unit.'</td>
                        </tr>
                        <tr>
                            <td><label>Company : </label></td>
                            <td>'.$company.'</td>
                            <td><label>Size : </label></td>
                            <td>'.$size.'</td>
                        </tr>
                    </table>
                    <br>
                ';

                // This comes from edit_pdf when admin wants to edit values on pdf.
                if (isset($_GET['desc_edited_pdf'])) {
                    $_SESSION['pdf_arr'][$_GET['index_edited_pdf']][0] = $_GET['desc_edited_pdf'];
                }
                if (isset($_GET['qty_edited_pdf'])) {
                    $_SESSION['pdf_arr'][$_GET['index_edited_pdf']][1] = $_GET['qty_edited_pdf'];
                }
                if (isset($_GET['price_edited_pdf'])) {
                    $_SESSION['pdf_arr'][$_GET['index_edited_pdf']][2] = $_GET['price_edited_pdf'];
                }
                // till here

                // This keep updating contents for description, unit, price for pdf
                if ($_POST['description'] !== null) {
                    $_SESSION['description_pdf'] = $_POST['description'];
                    $_SESSION['pdf_arr'][$_SESSION['i_pdf']][0] = $_SESSION['description_pdf'];
                }
                if ($_POST['qty'] !== null) {
                    $_SESSION['qty_pdf'] = $_POST['qty'];
                    $_SESSION['pdf_arr'][$_SESSION['i_pdf']][1] = $_SESSION['qty_pdf'];
                }
                if ($_POST['price'] !== null) {
                    $_SESSION['price_pdf'] = $_POST['price'];
                    $_SESSION['pdf_arr'][$_SESSION['i_pdf']][2] = $_SESSION['price_pdf'];
                }
                // till here

                if (isset($_POST['submit'])) {
                    $_SESSION['i_pdf']++;
                }

                echo '
                    <form action="pdf_info.php" method="POST">
                        <table border="2" width="100%">
                            <colgroup>
                                <col width="70%">
                                <col width="10%">
                                <col width="10%">
                                <col width="5%">
                                <col width="5%">
                            </colgroup>
                            <thead>
                                <tr style="border: 2px double black;" bgcolor="#c9c9c9">
                                    <td align="center"><b>Description</b></td>
                                    <td align="center"><b>Qty</b></td>
                                    <td align="center"><b>Price</b></td>
                                    <td colspan="2"></td>
                                </tr>
                            </thead>
                            <tbody id="pdf_table">
                                <tr>
                                    <td><input style="border: none; width: 100%; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;" type="text" name="description" size="50" required></td>
                                    <td><input style="border: none; width: 100%; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;" type="text" name="qty" size="44"></td>
                                    <td><input style="border: none; width: 100%; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;" type="text" name="price" size="44"></td>
                                    <td colspan="2" align="center"><input type="submit" name="submit" value="Add"></td>
                                </tr>
                ';
                for ($i = 0; $i < sizeof($_SESSION['pdf_arr']); $i++) {
                    if ($_SESSION['pdf_arr'][$i][0] !== null) {
                        echo '<tr bgcolor="#c4daff"><td>'.$_SESSION['pdf_arr'][$i][0].'</td>';
                    }
                    if ($_SESSION['pdf_arr'][$i][1] !== null) {
                        echo '<td>'.$_SESSION['pdf_arr'][$i][1].'</td>';
                    }
                    if ($_SESSION['pdf_arr'][$i][2] !== null) {
                        echo '<td>'.$_SESSION['pdf_arr'][$i][2].'</td>';
                    }
                    if ($_SESSION['pdf_arr'][$i][0] !== null) {
                        echo '<td align="center"><button><a href="edit_pdf.php?description='.$_SESSION['pdf_arr'][$i][0].' &qty='.$_SESSION['pdf_arr'][$i][1].' &price='.$_SESSION['pdf_arr'][$i][2].' &index='.$i.'">Edit</a></button></td>';
                    }
                    if ($_SESSION['pdf_arr'][$i][0] !== null) {
                        echo '<td align="center"><button><a href="edit_pdf.php?index_deleted='.$i.'">Delete</a></button></td></tr>';
                    }
                }

                echo '
                            </tbody>
                        </table>
                        <br>
                    </form>
                    <form action="create_pdf.php" method="post">
                        <table border="2" width="8%">
                            <tr align="center" bgcolor="#c9c9c9">
                                <td><label><b>Date</b></label></td>
                            </tr>
                            <tr align="center">
                                <td><input style="border: none; width: 100%; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;" type="date" name="date" id="theDate" value="" size="8"></td>
                            </tr>
                        </table>
                ';
            ?>
            <br>
            <input type="submit" value="Create PDF"></input>
            <input type="button" value="Back" onclick="location.href='invoice_detail.php'"></input>
            </form>
        </div>

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>
