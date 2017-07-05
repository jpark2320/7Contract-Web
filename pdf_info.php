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

                if ($_POST['description'] !== null) {
                    $_SESSION['pdf_arr'][$_SESSION['i']][0] = $_POST['description'];
                }
                if ($_POST['price'] !== null) {
                    $_SESSION['pdf_arr'][$_SESSION['i']][1] = $_POST['qty'];
                }
                if ($_POST['qty'] !== null) {
                    $_SESSION['pdf_arr'][$_SESSION['i']][2] = $_POST['price'];
                }

                if (isset($_POST['submit'])) {
                    $_SESSION['i']++;
                }

                echo '
                    <form action="pdf_info.php" method="post">
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
                for ($i = 0; $i < sizeof($_SESSION['pdf_arr']); $i++) {
                    if ($_SESSION['pdf_arr'][$i][0] !== null) {
                        echo '<tr bgcolor="#c4daff"><td>'.$_SESSION['pdf_arr'][$i][0].'</td>';
                    }
                    if ($_SESSION['pdf_arr'][$i][1] !== null) {
                        echo '<td>'.$_SESSION['pdf_arr'][$i][1].'</td>';
                    }
                    if ($_SESSION['pdf_arr'][$i][2] !== null) {
                        echo '<td>'.$_SESSION['pdf_arr'][$i][2].'</td></tr>';
                    }
                }

                echo '
                                </tr>
                            </tbody>
                        </table>
                        <input type="submit" name="submit" value="Add">
                        <br><br>
                    </form>
                    <form action="create_pdf.php" method="post">
                        <table border="2" width="200">
                            <tr align="center" bgcolor="#c9c9c9">
                                <td><label>Set Date</label></td>
                            </tr>
                            <tr align="center">
                                <td><input type="text" name="date" value="'.$_SESSION['date_pdf'].'" size="10"></td>
                            </tr>
                        </table>
                        <br>   
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
