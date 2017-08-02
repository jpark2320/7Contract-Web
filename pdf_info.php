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

                if (isset($_GET['invoice'])) {
                    $i_detail = $_GET['invoice'];
                    $_SESSION['invoice'] = str_replace('7C', '', $i_detail);
                    $invoice = $_SESSION['invoice'];
                    $sql = "SELECT * FROM save_progress WHERE invoice ='$invoice';";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $_SESSION['pdf_arr'][$_SESSION['i_pdf']][0] = $row['description'];
                            $_SESSION['pdf_arr'][$_SESSION['i_pdf']][1] = $row['quantity'];
                            $_SESSION['pdf_arr'][$_SESSION['i_pdf']][2] = $row['price'];
                            $_SESSION['i_pdf']++;
                        }
                    }
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
                            <td><label><b>Invoice # : </label></b></td>
                            <td>'.'7C'.$_SESSION['invoice'].'</td>
                            <td><label><b>Apt : </label></b></td>
                            <td>'.$apt.'</td>
                        </tr>
                        <tr>
                            <td><b><label>P.O. : </label></b></td>
                            <td>'.$po.'</td>
                            <td><b><label>Unit # : </label></b></td>
                            <td>'.$unit.'</td>
                        </tr>
                        <tr>
                            <td><b><label>Company : </label></b></td>
                            <td>'.$company.'</td>
                            <td><b><label>Size : </label></b></td>
                            <td>'.$size.'</td>
                        </tr>
                    </table>
                    <br>
                ';
                if (isset($_GET['desc_edited_pdf'])) {
                    $_SESSION['pdf_arr'][$_GET['index_edited_pdf']][0] = $_GET['desc_edited_pdf'];
                }
                if (isset($_GET['qty_edited_pdf'])) {
                    $_SESSION['pdf_arr'][$_GET['index_edited_pdf']][1] = $_GET['qty_edited_pdf'];
                }
                if (isset($_GET['price_edited_pdf'])) {
                    $_SESSION['pdf_arr'][$_GET['index_edited_pdf']][2] = $_GET['price_edited_pdf'];
                }
                $sql = "SELECT * FROM user_comment WHERE invoice=".$_SESSION['invoice'];
                $result = mysqli_query($conn, $sql);
                $isOdd = false;
                $i = 0;
                echo '
                    <table id="ResponsiveTable" border="3" width="100%">
                        <colgroup>
                            <col width="5%">
                            <col width="10%">
                            <col width="45%">
                            <col width="10%">
                            <col width="10%">
                            <col width="20%">
                            <col width="10%">
                            <col width="10%">
                        </colgroup>
                        <thead id="HeadRow">
                            <tr style="border: 2px double black;" bgcolor="#c9c9c9">
                                <td align="center"><b>#</b></td>
                                <td align="center"><b>Paid Off</b></td>
                                <td align="center"><b>Comment</b></td>
                                <td align="center"><b>Salary</b></td>
                                <td align="center"><b>Paid</b></td>
                                <td align="center"><b>Date</b></td>
                            </tr>
                        </thead>
                ';
                while($row = mysqli_fetch_array($result))
                {
                    $i++;

                    $comment = $row['comment'];
                    if ($comment == null) $comment = '-';

                    $salary = $row['salary'];
                    if ($salary == null) $salary = '-';

                    $paid = $row['paid'];
                    if ($paid == null) $paid = '-';

                    $date = $row['date'];
                    if ($date == null) $date = '-';

                    echo '<tbody>';
                    if ($isOdd) {
                        $isOdd = false;
                        echo '<tr bgcolor="#e8fff1">';
                    } else {
                        $isOdd = true;
                        echo '<tr>';
                    }
                    echo '<td tableHeadData="#" align="center">'.$i.'</td>';
                    if ($row['ispaidoff'] == 1) {
                        echo '<td tableHeadData="Paid Off" align="center"><img src="./img/status_light_green" width="10px"></td>';
                    } else {
                        echo '<td tableHeadData="Paid Off" align="center"><img src="./img/status_light_red" width="10px"></td>';
                    }
                    echo '
                                <td tableHeadData="Comment" align="center">'.$comment.'</td>
                                <td tableHeadData="Salary" align="center">'.number_format($salary).'</td>
                                <td tableHeadData="Paid" align="center">'.number_format($paid).'</td>
                                <td tableHeadData="Date" align="center">'.$date.'</td>
                            </tr>
                        </tbody>
                    ';

                }
                echo '</table><br>';
                if (isset($_POST['description'])) {
                    if ($_POST['description'] !== null) {
                        $_SESSION['description_pdf'] = $_POST['description'];
                        $_SESSION['pdf_arr'][$_SESSION['i_pdf']][0] = $_SESSION['description_pdf'];
                    }
                }
                if (isset($_POST['qty'])) {
                    if ($_POST['qty'] !== null) {
                        $_SESSION['qty_pdf'] = $_POST['qty'];
                        $_SESSION['pdf_arr'][$_SESSION['i_pdf']][1] = $_SESSION['qty_pdf'];
                    }
                }
                if (isset($_POST['price'])) {
                    if ($_POST['price'] !== null) {
                        $_SESSION['price_pdf'] = $_POST['price'];
                        $_SESSION['pdf_arr'][$_SESSION['i_pdf']][2] = $_SESSION['price_pdf'];
                    }
                }


                if (isset($_POST['submit'])) {
                    $_SESSION['i_pdf']++;
                }

                echo '
                    <form action="pdf_info.php" method="post">
                        <table id="ResponsiveTable" border="2" width="100%">
                            <colgroup>
                                <col width="70%">
                                <col width="10%">
                                <col width="10%">
                                <col width="5%">
                                <col width="5%">
                            </colgroup>
                            <thead id="HeadRow">
                                <tr style="border: 2px double black;" bgcolor="#c9c9c9">
                                    <td align="center"><b>Description</b></td>
                                    <td align="center"><b>Qty</b></td>
                                    <td align="center"><b>Price</b></td>
                                    <td colspan="2"></td>
                                </tr>
                            </thead>
                            <tbody id="pdf_table">
                                <tr>
                                    <td tableHeadData="Description"><input class="textInput" type="text" name="description" size="50"></td>
                                    <td tableHeadData="Qty"><input class="textInput" type="text" name="qty" size="44"></td>
                                    <td tableHeadData="Price"><input class="textInput" type="text" name="price" size="44"></td>
                                    <td colspan="2" align="center"><input type="submit" name="submit" value="Add"></td>
                                </tr>
                ';
                if (isset($_SESSION['pdf_arr'])) {
                    for ($i = 0; $i < sizeof($_SESSION['pdf_arr']); $i++) {
                        if ($_SESSION['pdf_arr'][$i][0] !== null) {
                            echo '<tr bgcolor="#c4daff"><td>'.$_SESSION['pdf_arr'][$i][0].'</td>';
                        }
                        if ($_SESSION['pdf_arr'][$i][1] !== null) {
                            echo '<td>'.$_SESSION['pdf_arr'][$i][1].'</td>';
                        }
                        if ($_SESSION['pdf_arr'][$i][2] !== null) {
                            echo '<td align="center">'.$_SESSION['pdf_arr'][$i][2].'</td>';
                        }
                        if ($_SESSION['pdf_arr'][$i][0] !== null) {
                            echo '<td align="center"><button><a href="edit_pdf.php?description='.$_SESSION['pdf_arr'][$i][0].' &qty='.$_SESSION['pdf_arr'][$i][1].' &price='.$_SESSION['pdf_arr'][$i][2].' &index='.$i.'">Edit</a></button></td>';
                        }
                        if ($_SESSION['pdf_arr'][$i][0] !== null) {
                            echo '<td align="center"><button><a href="edit_pdf.php?index_deleted='.$i.'">Delete</a></button></td></tr>';
                        }
                    }
                }

                echo '
                            </tbody>
                        </table>
                        <br>
                    </form>
                    <form action="create_pdf.php" method="post">
                        <table id="ResponsiveTable" border="2" width="8%">
                            <tr id="HeadRow" align="center" bgcolor="#c9c9c9">
                                <td><label><b>Date</b></label></td>
                            </tr>
                            <tr align="center">
                                <td tableHeadData="Date"><input class="textInput" type="date" name="date" id="theDate" value="" size="8"></td>
                            </tr>
                        </table>
                ';
            ?>
            <br>
            <?php if(isset($_SESSION['pdf_arr'])): ?>
                <input type="submit" value="Create PDF"></input>
            <?php else: ?>
                <input type="button" value="Create PDF" onclick="alert('You need to add more than 1 description');"></input>
            <?php endif; ?>
            <input type="button" value="Save Progress" onclick="location.href='save_progress.php'"></input>
            <input type="button" value="Back" onclick="location.href='invoice_detail.php'"></input>
            </form>
        </div>
        <br><br><br><br>

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>
