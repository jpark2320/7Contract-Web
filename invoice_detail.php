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
            <h3 class="text-center">Invoice Details</h3><br>

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
                        $_SESSION['pdf_arr'] = array(array());
                        $_SESSION['i'] = 0;
                        date_default_timezone_set('Etc/UTC');
                        $_SESSION['date_pdf'] = date("Y-m-d");

                        echo '
                            <table width="200" align="center">
                                <colgroup>
                                    <col width="50%">
                                    <col width="50%">
                                </colgroup>
                                <tr>
                                    <td><b>Invoice # : </b></td>
                                    <td>'.$i_detail.'</td>
                                </tr>
                                <tr>
                                    <td><b>Apartment : </b></td>
                                    <td>'.$_SESSION['apt_pdf'].'</td>
                                </tr>
                                <tr>
                                    <td><b>Unit # : </b></td>
                                    <td>'.$_SESSION['unit_pdf'].'</td>
                                </tr>
                            </table>

                        ';

                        if (!isset($_SESSION['sort'])) {
                            $_SESSION['sort'] = 'asc';
                        }
                        if ($_SESSION['sort']=='asc') {
                            echo '<div align="left"><h><a href="?st=desc">Show descending order</a></h></div>';
                        } else {
                            echo '<div align="left"><h><a href="?st=asc">Show ascending order</a></h></div>';
                        }
                        if (isset($_GET['st'])) {
                            $_SESSION['sort'] = $_GET['st'];
                            echo '<script>window.location.href = "invoice_detail.php";</script>';
                        }
                        $i_detail = str_replace('7C', '', $i_detail);
                        $_SESSION['invoice'] = $i_detail;

                        echo '
                            <table border="3" width="100%">
                                <thead>
                                    <tr style="border: 2px double black;" bgcolor="#c9c9c9">
                                        <td align="center"><b><a href="?orderBy=isworkdone">Work Status</a></b></td>
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
                        if ($_SESSION['isadmin'] == 2) {
                            echo '
                                <td align="center"><b>Edit</b></td>
                                <td align="center"><b>Pay</b></td>
                            ';
                        }
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
                        while($row = mysqli_fetch_array($result)) {
                            $message = $row['message'];
                            $email = $row['email'];
                            $price = $row['price'];
                            $user_name = $row['first'].' '.$row['last'];
                            $id = $row['id'];

                            echo '<tbody>';
                            if ($isOdd) {
                                $isOdd = false;
                                echo '<tr bgcolor="#e8fff1">';
                            } else {
                                $isOdd = true;
                                echo '<tr>';
                            }

                            if ($row['isworkdone'] == 1) {
                                echo '<td align="center"><img src="./img/status_light_green" width="10px"></td>';
                            } else {
                                echo '<td align="center"><img src="./img/status_light_red" width="10px"></td>';
                            }
                            if ($row['ispaidoff'] == 1) {
                                echo '<td align="center"><img src="./img/status_light_green" width="10px"></td>';
                            } else {
                                echo '<td align="center"><img src="./img/status_light_red" width="10px"></td>';
                            }

                            echo '
                                        <td align="center"><a href="user_detail.php?invoice='.urlencode($i_detail).' &email='.urlencode($email).' &user_name='.urlencode($user_name).'">'.$user_name.'</a></td>
                                        <td align="center">'.$row['message'].'</td>
                                        <td align="center"><button><a href="show_comment.php?id='.$id.'&email='.$email.'&apt='.$_SESSION['apt_pdf'].'&unit='.$_SESSION['unit_pdf'].'&username='.urlencode($user_name).'">Show Comments</a></button></td>
                            ';
                            if ($_SESSION['isadmin'] == 2) {
                                echo '
                                    <td align="center">'.$row['price'].'</td>
                                    <td align="center">'.$row['paid'].'</td>
                                ';
                            }
                            echo '
                                        <td align="center">'.$row['date'].'</td>
                            ';
                            if ($_SESSION['isadmin'] == 2) {
                                echo '
                                    <td align="center"><button><a href="pedit.php?invoice='.urlencode($i_detail).' &id='.urlencode($id).' &price='.urlencode($price).' &comment='.urlencode($comment). ' &message='.urlencode($message).'&username='.urlencode($user_name).'">Edit</a></button></td>
                                    <td align="center"><button><a href="pay.php?invoice='.urlencode($i_detail).' &id='.urlencode($id).' &price='.urlencode($price).' &comment='.urlencode($comment). ' &message='.urlencode($message).'&username='.urlencode($user_name).'">Pay</a></button></td>
                                ';
                            }
                            echo '
                                    </tr>
                                </tbody>
                            ';
                        }
                        echo '</table>';
                        $sql = "SELECT * FROM Worksheet WHERE invoice=$i_detail";;
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_array($result);
                        $_SESSION['po_pdf'] = $row['PO'];
                        $_SESSION['company_pdf'] = $row['company'];
                        $_SESSION['apt_pdf'] = $row['apt'];
                        $_SESSION['unit_pdf'] = $row['unit'];
                        $_SESSION['size_pdf'] = $row['size'];
                        $_SESSION['pdf_arr'] = array(array());
                        $_SESSION['i'] = 0;
                        date_default_timezone_set('EST');
                        $_SESSION['date_pdf'] = date("m-d-Y");
                        mysqli_close($conn);
                    ?>
                </form>
                <br>
                <?php
                    echo '<button><a href="pdf_info.php?invoice='.urlencode($i_detail).' &po='.urlencode($po).' &company='.urlencode($company).' &apt='.urlencode($apt).' &unit='.urlencode($unit). ' &size='.urlencode($size).'">Make PDF</a></button>';
                ?>
                <input type="button" value="Back" onclick="location.href='worksheet.php'"></input>
        </div>
        <br><br><br><br><br>

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>
