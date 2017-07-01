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

                <form action="pedit.php" method="post">
                    <?php
                        // connection with mysql database
                        include('./includes/connection.php');

                        if (isset($_GET['invoice_num'])) {
                            $i_detail = $_GET['invoice_num'];
                            $_SESSION['invoice'] = str_replace('7C', '', $i_detail);
                        } else {
                            $i_detail = '7C'.$_SESSION['invoice'];
                        }
                        $po = $_GET['po'];
                        $company = $_GET['company'];
                        $apt = $_GET['apt'];
                        $unit = $_GET['unit'];
                        $size = $_GET['size'];

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

                        // if (isset($_GET['st'])) {
                        //     $_SESSION['sort'] = $_GET['st'];
                        //     echo '<script>window.location.href = "invoice_detail.php";</script>';
                        // }
                        // $i_detail = str_replace('7C', '', $i_detail);
                        // $_SESSION['invoice'] = $i_detail;

                        $description = $_GET['description'];
                        $price = $_GET['price'];
                        $qty = $_GET['qty'];
                        $temp = array($description, $price, $qty);

                        print_r(array_merge($_SESSION['pdf_arr'], $temp));

                        echo '
                            <form action="pdf_info2.php" method="post">
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
                                            <td><input type="text" name="description" size="77"></td>
                                            <td><input type="text" name="price" size="37"></td>
                                            <td><input type="text" name="qty" size="37"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <input type="submit" value="Send">
                            </form>
                        ';
                        // $orderBy = array('A.first', 'A.email', 'B.date', 'B.isworkdone');
                        // $order = 'B.date';
                        // if (isset($_GET['orderBy']) && in_array($_GET['orderBy'], $orderBy)) {
                        //     $order = $_GET['orderBy'];
                        // }
                        // $sql = "SELECT * FROM
                        // 	(SELECT users.first, users.last, users.email from users) AS A
						// 	INNER JOIN
						// 	(SELECT * FROM SubWorksheet WHERE invoice='$i_detail') AS B
						// 	ON A.email=B.email ORDER BY ".$order;
                        // if ($_SESSION['sort']=='desc') {
                        //     $sql = $sql.' DESC';
                        // }
                        // $result = mysqli_query($conn, $sql);
                        // $isOdd = false;
                        // while($row = mysqli_fetch_array($result))
                        // {
                        //     $message = $row['message'];
                        //     $comment = $row['comment'];
                        //     $email = $row['email'];
                        //     $price = $row['price'];
                        //     $user_name = $row['first'].' '.$row['last'];
                        //     $id = $row['id'];
                        //     $po = $row['PO'];
                        //
                        //     echo '<tbody>';
                        //     if ($isOdd) {
                        //         $isOdd = false;
                        //         echo '<tr bgcolor="#ffeed3">';
                        //     } else {
                        //         $isOdd = true;
                        //         echo '<tr>';
                        //     }
                        //
                        //     if ($row['isworkdone'] == 1) {
                        //         echo '<td align="center"><img src="./img/status_light_green" width="10px"></td>';
                        //     } else {
                        //         echo '<td align="center"><img src="./img/status_light_red" width="10px"></td>';
                        //     }
                        //
                        //     echo '
                        //                 <td align="center"><a href="user_detail.php?invoice='.urlencode($i_detail).' &email='.urlencode($email).' &user_name='.urlencode($user_name).'">'.$user_name.'</a></td>
                        //                 <td align="center">'.$row['message'].'</td>
                        //                 <td align="center">'.$row['comment'].'</td>
                        //                 <td align="center">'.$row['price'].'</td>
                        //                 <td align="center">'.$row['date'].'</td>
                        //                 <td align="center"><a href="pedit.php?invoice='.urlencode($i_detail).' &email='.urlencode($email).' &id='.urlencode($id).' &price='.urlencode($price).' &comment='.urlencode($comment). ' &message='.urlencode($message).'">Edit</a></td>
                        //             </tr>
                        //         </tbody>
                        //     ';
                        // }
                        // echo '</table>';
                        // mysqli_close($conn);
                    ?>
                </form>
                <br>
                <input type="button" value="Create PDF" onclick=""></input>
                <input type="button" value="Back" onclick="location.href='invoice_detail.php'"></input>
                <div align="right">
                    <?php echo '<input type="button" value="Add" onclick="$num_row=addTableRow('.$_SESSION['num_row'].');"></input>'; ?>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>
