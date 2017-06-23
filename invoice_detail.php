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
            <h3 class="text-center">Invoice Details</h3><br>

            <div class="row" align="center">
                <?php
                    // connection with mysql database
                    include('./includes/connection.php');

                    $i_detail = $_GET['invoice_num'];
                    echo '<b>Invoice # : '.$i_detail.'</b>';

                    if (!isset($_SESSION['sort'])) {
                        $_SESSION['sort'] = 'asc';
                    }
                    if ($_SESSION['sort']=='asc') {
                        echo '<div align="left"><h><a href="?st=desc">Show descending order</a></h><div>';
                    } else {
                        echo '<div align="left"><h><a href="?st=asc">Show ascending order</a></h><div>';
                    }
                    if (isset($_GET['st'])) {
                        $_SESSION['sort'] = $_GET['st'];
                        echo '<script>window.location.href = "invoice_detail.php";</script>';
                    }

                    echo '
                            <table border="2" width="1000">
                                <thead>
                                    <tr>
                                        <td align="center"><b><a href="?orderBy=isworkdone">Status</a></b></td>
                                        <td align="center"><b><a href="?orderBy=A.first">Name</a></b></td>
                                        <td align="center"><b>Message</b></td>
                                        <td align="center"><b>Comment</b></td>
                                        <td align="center"><b>Price</b></td>
                                        <td align="center"><b><a href="?orderBy=B.date">Date</a></b></td>
                                        <td align="center"><b>Edit</b></td>
                                    </tr>
                                </thead>';
                        $orderBy = array('A.first', 'A.last', 'A.email', 'B.date');
                        $order = 'date';
                        if (isset($_GET['orderBy']) && in_array($_GET['orderBy'], $orderBy)) {
                            $order = $_GET['orderBy'];
                        }
                        $i_detail = substr($i_detail, 2);
                        $sql = "SELECT * FROM
                        	(SELECT users.first, users.last, users.email from users) AS A
							INNER JOIN
							(SELECT * FROM SubWorksheet WHERE invoice='$i_detail') AS B
							ON A.email=B.email ORDER BY ".$order;
                        if ($_SESSION['sort']=='desc') {
                            $sql = $sql.' DESC';
                        }
                        $result = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_array($result))
                        {
                            $temp_email = $row['email'];
                            $temp_price = $row['row'];
                            echo '
                                <tbody>
                                    <tr>
                            ';
                                        if ($row['isworkdone'] == 1) {
                                            echo '<td align="center"><img src="./img/status_light_green" width="10px"></td>';
                                        } else {
                                            echo '<td align="center"><img src="./img/status_light_red" width="10px"></td>';
                                        }
                            echo '
                                        <td align="center">'.$row['first'].' '.$row['last'].'</td>
                                        <td align="center">'.$row['message'].'</td>
                                        <td align="center">'.$row['comment'].'</td>
                                        <td align="center">'.$temp_price.'</td>
                                        <td align="center">'.$row['date'].'</td>
                                        <td align="center"><a href="pedit_process.php?invoice='.$i_detail.' &email='.$temp_email.' &price='.$temp_price.'">Edit</a></td>
                                    </tr>
                                </tbody>
                            ';
                        }
                        echo '</table>';
                    mysqli_close($conn);
                ?>
                <br>
                <div align="center">
                    <input type="button" value="Back" onclick="location.href='worksheet.php'"></input>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>
