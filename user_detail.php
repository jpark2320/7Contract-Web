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
            <h3 class="text-center">User Detail</h3><br>

            <form action="pedit.php" method="post">
                <?php
                    // connection with mysql database
                    include('./includes/connection.php');

                    $_SESSION['invoice'] = $_GET['invoice'];
                    $email = $_GET['email'];
                    $_SESSION['user_email'] = $email;
                    $user_name = $_GET['user_name'];
                    $_SESSION['user_name'] = $user_name;
                    echo '
                        <table width="300">
                            <colgroup>
                                <col width="50%">
                                <col width="50%">
                            </colgroup>
                                <tr>
                                    <td align="left"><b><label>User Name : </label></b></td>
                                    <td align="right">'.$user_name.'</td>
                                </tr>
                                <tr>
                                    <td align="left"><b><label>Email : </label></b></td>
                                    <td align="right">'.$email.'</td>
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

                    echo '
                            <table border="2" width="100%">
                                <thead>
                                    <tr style="border: 2px double black;" bgcolor="#c9c9c9">
                                        <td align="center"><b><a href="?orderBy=isworkdone">Work Status</a></b></td>
                                        <td align="center"><b><a href="?orderBy=ispaidoff">Paid off</a></b></td>
                                        <td align="center"><b><a href="?orderBy=invoice">Invoice #</a></b></td>
                                        <td align="center"><b><a href="?orderBy=apt">Apt</a></b></td>
                                        <td align="center"><b><a href="?orderBy=unit">Unit</a></b></td>
                                        <td align="center"><b><a href="?orderBy=price">Price</a></b></td>
                                        <td align="center"><b><a href="?orderBy=message">Message</a></b></td>
                                        <td align="center"><b><a href="?orderBy=comment">Comment</a></b></td>
                                        <td align="center"><b><a href="?orderBy=date">Date</a></b></td>
                                    </tr>
                                </thead>';
                        $orderBy = array('A.first', 'A.last', 'A.email', 'B.date');
                        $order = 'date';
                        if (isset($_GET['orderBy']) && in_array($_GET['orderBy'], $orderBy)) {
                            $order = $_GET['orderBy'];
                        }
                        if (isset($i_detail))
                            $i_detail = substr($i_detail, 2);

                        $sql = "SELECT * FROM
                        	(SELECT users.first, users.last, users.email from users) AS A
							INNER JOIN
							(SELECT * FROM SubWorksheet WHERE email='$email') AS B
							ON A.email=B.email ORDER BY ".$order;
                        if ($_SESSION['sort']=='desc') {
                            $sql = $sql.' DESC';
                        }
                        $result = mysqli_query($conn, $sql);
                        $idOdd = false;
                        while($row = mysqli_fetch_array($result))
                        {
                            echo '<tbody>';
                            if (isset($isOdd)) {
                                if ($isOdd) {
                                    $isOdd = false;
                                    echo '<tr bgcolor="#e8fff1">';
                                } else {
                                    $isOdd = true;
                                    echo '<tr>';
                                }
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
                                        <td align="center"><a href="invoice_detail?invoice_num='.$row['invoice'].'">'."7C".$row['invoice'].'</a></td>
                                        <td align="center"><a href="invoice_detail?invoice_num='.$row['apt'].'">'.$row['apt'].'</a></td>
                                        <td align="center">'.$row['unit'].'</td>
                                        <td align="center">'.$row['price'].'</td>
                                        <td align="center">'.$row['message'].'</td>
                                        <td align="center"><button><a href="show_comment.php?id='.$row['id'].'&email='.$email.'&apt='.$row['apt'].'&unit='.$row['unit'].'&username='.urlencode($user_name).'&from_user=1">Show Comments</a></button></td>
                                        <td align="center">'.$row['date'].'</td>
                                    </tr>
                                </tbody>
                            ';
                        }
                        echo '</table>';
                    mysqli_close($conn);
                ?>
            </form>
            <br>
            <input type="button" value="Show All History" onclick="location.href='user_history.php'"></input>
            <input type="button" value="Back" onclick="location.href='invoice_detail.php'"></input>
        </div>
        <br><br><br><br><br>

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>
