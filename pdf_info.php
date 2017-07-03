<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <!-- Header Tag -->
    <?php include('./includes/head_tag.html'); ?>
    <body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="50">

        <!-- Header -->
        <?php include('./includes/nav_bar.php'); ?>

        <!-- Body -->
        <div class="container">
            <h3 class="text-center">Make PDF</h3><br>

            <div class="row" align="center">

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
                        ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                    ';

                    if ($_POST['description'] !== null) {
                        $_SESSION['pdf_arr'][$_SESSION['i']][0] = $_POST['description'];
                    }
                    if ($_POST['price'] !== null) {
                        $_SESSION['pdf_arr'][$_SESSION['i']][1] = $_POST['price'];
                    }
                    if ($_POST['qty'] !== null) {
                        $_SESSION['pdf_arr'][$_SESSION['i']][2] = $_POST['qty'];
                    }

                    if (isset($_POST['submit'])) {
                        $_SESSION['i']++;
                    }

                    echo '
                        <form action="pdf_info.php" method="post">
                            <table border="2" width="958">
                                <colgroup>
                                    <col width="50%">
                                    <col width="25%">
                                    <col width="25%">
                                </colgroup>
                                <thead>
                                    <tr style="border: 2px double black;" bgcolor="#c9c9c9">
                                        <td align="center"><b>Description</b></td>
                                        <td align="center"><b>Price</b></td>
                                        <td align="center"><b>Qty</b></td>
                                    </tr>
                                </thead>
                                <tbody id="pdf_table">
                                    <tr>
                                        <td><input type="text" id="c1" name="description" size="77" required></td>
                                        <td><input type="text" id="c2" name="price" size="37"></td>
                                        <td><input type="text" id="c3" name="qty" size="37"></td>
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
                            <input type="submit" name="submit" value="Send">
                            <input type="button" id="addRow" value="Add">
                        </form>
                    ';
                ?>
                <br>
                <input type="button" value="Create PDF" onclick="location.href='create_pdf.php'"></input>
                <input type="button" value="Back" onclick="location.href='invoice_detail.php'"></input>
            </div>
        </div>

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>
