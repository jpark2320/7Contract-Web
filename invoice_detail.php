<?php
    session_start();
    $_SESSION['i_pdf'] = 0;
    $_SESSION['i_estm'] = 0;
    $_SESSION['i'] = 0;
    unset($_SESSION['unpaid']);
    unset($_SESSION['arr']);
    unset($_SESSION['estm_arr']);
    unset($_SESSION['edit_arr']);
    unset($_SESSION['pdf_arr']);
?>
<!DOCTYPE html>
<html lang="en">
    <!-- Header Tag -->
    <?php include('./includes/head_tag.html'); ?>
    <body id="myPage">

        <!-- Header -->
        <?php include('./includes/nav_bar.php'); ?>

        <!-- Body -->
        <div class="primary" align="center">
            <h3 class="text-center">Invoice Details</h3>

                <form action="pedit.php" method="post">
                    <?php
                        // connection with mysql database
                        include('./includes/connection.php');

                        // $i_detail = $_GET['invoice_num'];
                        if (isset($_GET['invoice_num'])) {
                            $i_detail = $_GET['invoice_num'];
                            $_SESSION['invoice'] = str_replace('7C', '', $i_detail);
                        } else {
                            $i_detail = '7C'.str_replace('7C', '', $_SESSION['invoice']);
                        }
                        $sql = "SELECT * FROM Worksheet WHERE invoice='".$_SESSION['invoice']."'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_array($result);
                        $_SESSION['po_pdf'] = $row['PO'];
                        $_SESSION['company_pdf'] = $row['company'];
                        $_SESSION['apt_pdf'] = $row['apt'];
                        $_SESSION['unit_pdf'] = $row['unit'];
                        $_SESSION['size_pdf'] = $row['size'];
                        date_default_timezone_set('Etc/UTC');
                        $_SESSION['date_pdf'] = date("Y-m-d");


                        echo '
                            <table width="200" align="center">
                                <colgroup>
                                    <col width="50%">
                                    <col width="50%">
                                </colgroup>
                                <tr>
                                    <td align="left"><b>Invoice # : </b></td>
                                    <td align="right">'."7C".$_SESSION['invoice'].'</td>
                                </tr>
                                <tr>
                                    <td align="left"><b>Apartment : </b></td>
                                    <td align="right">'.$_SESSION['apt_pdf'].'</td>
                                </tr>
                                <tr>
                                    <td align="left"><b>Unit # : </b></td>
                                    <td align="right">'.$_SESSION['unit_pdf'].'</td>
                                </tr>
                            </table>

                        ';

                        include('./includes/sort.php');
                        if (isset($_GET['st'])) {
                            echo '<script>window.location.href = "invoice_detail.php";</script>';
                        }
                        $i_detail = str_replace('7C', '', $i_detail);
                        $_SESSION['invoice'] = $i_detail;

                        echo '
                            <table id="ResponsiveTable" border="3" width="100%">
                                <thead id="HeadRow">
                                    <tr style="border: 2px double black;" bgcolor="#c9c9c9">
                                        <td align="center"><b><a href="?orderBy=isworkdone">Status</a></b></td>
                                        <td align="center"><b><a href="?orderBy=ispaidoff">Paid Off</a></b></td>
                                        <td align="center"><b><a href="?orderBy=A.first">Name</a></b></td>
                                        <td align="center"><b>Message</b></td>
                                        <td align="center"><b>Comment</b></td>
                        ';
                        if ($_SESSION['isadmin'] == 2) {
                            echo '
                                <td align="center"><b>Salary</b></td>
                                <td align="center"><b>Paid</b></td>
                            ';
                        }
                        echo '
                            <td align="center"><b><a href="?orderBy=B.date">Date</a></b></td>
                        ';
                        echo '
                                    </tr>
                                </thead>
                        ';
                        $orderBy = array('A.first', 'A.email', 'B.date', 'B.isworkdone', 'B.ispaidoff');
                        $order = 'B.date';
                        if (isset($_GET['orderBy']) && in_array($_GET['orderBy'], $orderBy)) {
                            $order = $_GET['orderBy'];
                        }
                        $sql = "SELECT * FROM
                            (SELECT users.first, users.last, users.email from users) AS A
                            INNER JOIN
                            (SELECT * FROM SubWorksheet WHERE invoice='$i_detail') AS B
                            ON A.email=B.email ORDER BY ".$order;
                        if ($_SESSION['sort']=='desc') {
                            $sql = $sql.' DESC';
                        }
                        $result = mysqli_query($conn, $sql);
                        $isOdd = false;
                        while($row = mysqli_fetch_array($result))
                        {
                            $id = $row['id'];

                            $user_name = $row['first'].' '.$row['last'];
                            if ($user_name == null) $user_name = '-';

                            $message = $row['message'];
                            if ($message == null) $message = '-';

                            $price = number_format($row['price']);
                            if ($price == null) $price = '-';

                            $paid = number_format($row['paid']);
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

                            if ($row['isworkdone'] == 1) {
                                echo '<td tableHeadData="Work Status" align="center"><img src="./img/status_light_green" width="10px"></td>';
                            } else {
                                echo '<td tableHeadData="Work Status" align="center"><img src="./img/status_light_red" width="10px"></td>';
                            }
                            if ($row['ispaidoff'] == 1) {
                                echo '<td tableHeadData="Paid Off" align="center"><img src="./img/status_light_green" width="10px"></td>';
                            } else {
                                echo '<td tableHeadData="Paid Off" align="center"><img src="./img/status_light_red" width="10px"></td>';
                            }

                            echo '
                                        <td tableHeadData="Name" align="center"><a href="user_detail.php?invoice='.urlencode($i_detail).' &email='.urlencode($row['email']).' &user_name='.urlencode($user_name).'">'.$user_name.'</a></td>
                                        <td tableHeadData="Message"><div class="lineBreak_msg">'.$row['message'].'</div></td>
                                        <td tableHeadData="Comment" align="center"><button id="btn_showComment" type="button" onclick="location.href=\'show_comment.php?id='.$id.'&email='.$row['email'].'&apt='.$_SESSION['apt_pdf'].'&unit='.$_SESSION['unit_pdf'].'&username='.urlencode($user_name).'\'">Show Comment</button></td>
                            ';
                            if ($_SESSION['isadmin'] == 2) {
                                echo '
                                    <td tableHeadData="Salary" align="center">'.$price.'</td>
                                    <td tableHeadData="Paid" align="center">'.$paid.'</td>
                                ';
                            }
                            echo '
                                        <td tableHeadData="Date" align="center">'.$date.'</td>
                                    </tr>
                                </tbody>
                            ';
                        }
                        echo '</table>';
                        mysqli_close($conn);
                    ?>
                </form>
                <br>
                <div id="btn_invoiceDetail">
                    <?php
                        if (isset($_SESSION['po_pdf']) && isset($_SESSION['company_pdf']) && isset($_SESSION['apt_pdf']) && isset($_SESSION['unit_pdf']) && isset($_SESSION['size_pdf'])) {
                            echo '<button id="btn_makePDF" onclick="location.href=\'pdf_info.php?invoice='.urlencode($i_detail).' &po='.$_SESSION['po_pdf'].' &company='.$_SESSION['company_pdf'].' &apt='.$_SESSION['apt_pdf'].' &unit='.$_SESSION['unit_pdf']. ' &size='.$_SESSION['size_pdf'].'\'">Make PDF</button>';
                        }
                    ?>
                    <button type="button" onclick="location.href='worksheet.php'">Back</button>
                </div>
        </div>

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>
