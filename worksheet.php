<?php
    session_start();
    unset($_SESSION['unpaid']);
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
            <h3 class="text-center">Worksheet!</h3>
            <p class="text-center"><em>Check all your work process here!</em></p>

            <?php
                include('./includes/data_range.html');
                if (!isset($_SESSION['email'])) {
                    echo "<script>alert(\"You need to sign in first.\");</script>";
                    echo '<script>window.location.href = "signin.php";</script>';
                    exit();
                }
                // connection with mysql database
                include('./includes/connection.php');

                if ($_SESSION['isadmin'] > 0) {

                    echo '<div align="right"><a href="worksheet_add.php"><img src="./img/worksheet_add.png" width="42"></a></div>';

                    include('./includes/sort.php');

                    if ($_SESSION['isadmin'] == 2) {
                        echo '<div align="right"><a href="price_detail.php">Show details</a></div>';
                    }

                    echo '
                        <table border="3" width="100%">
                            <thead>
                                <tr style="border: 2px double black;" bgcolor="#c9c9c9">
                                    <td align="center"><b><a href="?orderBy=isworkdone">Status</a></b></td>
                                    <td align="center"><b><a href="?orderBy=invoice">Invoice #</a></b></td>
                                    <td align="center"><b><a href="?orderBy=po">P.O.</a></b></td>
                                    <td align="center"><b><a href="?orderBy=company">Company</a></b></td>
                                    <td align="center"><b><a href="?orderBy=apt">Apt</a></b></td>
                                    <td align="center"><b><a href="?orderBy=manager">Manager</a></b></td>
                                    <td align="center"><b><a href="?orderBy=unit">Unit #</a></b></td>
                                    <td align="center"><b><a href="?orderBy=size">Size</a></b></td>
                                    <td align="center"><b><a href="?orderBy=price">Price</a></b></td>
                                    <td align="center"><b>Description</b></td>
                                    <td align="center"><b><a href="?orderBy=date">Date</a></b></td>
                                    <td align="center"><b>Assign</b></b></td>
                                    <td align="center"><b>Edit</b></b></td>
                                </tr>
                            </thead>
                    ';
                    $orderBy = array('invoice', 'po', 'apt', 'unit', 'size', 'price', 'date', 'isworkdone');
                    $order = 'date';
                    if (isset($_GET['orderBy']) && in_array($_GET['orderBy'], $orderBy)) {
                        $order = $_GET['orderBy'];
                    }
                    $sql = 'SELECT * FROM Worksheet ';
                    if (isset($_POST['year']) && isset($_POST['month'])) {
                        $sql .= "WHERE YEAR(date)=".$_POST['year']." AND MONTH(date)=".$_POST['month']." ";
                    } else if (isset($_POST['year'])){
                        $sql .= "WHERE YEAR(date)=".$_POST['year']." ";
                    }
                    $sql .= 'ORDER BY '.$order;
                    if ($_SESSION['sort']=='desc') {
                        $sql = $sql.' DESC';
                    }
                    $result = mysqli_query($conn, $sql);

                    $isOdd = false;
                    while($row = mysqli_fetch_array($result))
                    {
                        $temp_invoice = '7C'.$row['invoice'];
                        $temp_company = $row['company'];
                        $temp_apt = $row['apt'];
                        $temp_manager = $row['manager'];
                        $temp_unit = $row['unit'];

                        echo '<tbody>';
                        if ($isOdd) {
                            $isOdd = false;
                            echo '<tr bgcolor="#e8fff1">';
                        } else {
                            $isOdd = true;
                            echo '<tr>';
                        }

                        if ($row['isworkdone'] == 2) {
                            echo '<td align="center"><img src="./img/status_light_green" width="10px"></td>';
                        } else if ($row['isworkdone'] == 1) {
                            echo '<td align="center"><img src="./img/status_light_yellow" width="10px"></td>';
                        } else {
                            echo '<td align="center"><img src="./img/status_light_red" width="10px"></td>';
                        }

                        echo '
                                    <td align="center"><a href="invoice_detail.php?invoice_num='.$temp_invoice.' &unit='.$temp_unit.'">'.$temp_invoice.'</a></td>
                                    <td align="center">'.$row['PO'].'</td>
                                    <td align="center"><a href="worksheet_company.php?company='.$temp_company.'">'.$temp_company.'</a></td>
                                    <td align="center"><a href="worksheet_apt.php?apt='.$temp_apt.'">'.$temp_apt.'</a></td>
                                    <td align="center"><a href="worksheet_manager.php?manager='.$temp_manager.'">'.$temp_manager.'</a></td>
                                    <td align="center">'.$temp_unit.'</td>
                                    <td align="center">'.$row['size'].'</td>
                                    <td align="center">'.$row['price'].'</td>
                                    <td align="center">'.$row['description'].'</td>
                                    <td align="center">'.$row['date'].'</td>
                                    <td align="center">
                                        <button><a href="assign.php?invoice_num='.$temp_invoice.' &apt='.$temp_apt.' &unit_num='.$temp_unit.'">Send</a></button>
                                    </td>
                                    <td align="center"><button><a href="edit_admin.php?invoice_num='.$temp_invoice.'">Edit</a></button></td>
                                </tr>
                            </tbody>
                        ';
                    }
                    echo '</table>';
                } else {

                    include('./includes/sort.php');

                    echo '
                        <table border="2" width="100%">
                            <thead>
                                <tr style="border: 2px double black;" bgcolor="#c9c9c9">
                                    <td align="center"><b><a href="?orderBy=isworkdone">Status</a></b></td>
                                    <td align="center"><b><a href="?orderBy=apt">Apt</a></b></td>
                                    <td align="center"><b><a href="?orderBy=unit">Unit #</a></b></td>
                                    <td align="center"><b>Message</b></td>
                                    <td align="center"><b>Comment</b></td>
                                    <td align="center"><b><a href="?orderBy=date">Date</a></b></td>
                                    <td align="center"><b>Edit</b></td>
                                    <td align="center"><b>Process</b></td>
                                </tr>
                            </thead>
                    ';

                    $orderBy = array('apt', 'unit', 'date', 'isworkdon');
                    $order = 'date';
                    if (isset($_GET['orderBy']) && in_array($_GET['orderBy'], $orderBy)) {
                        $order = $_GET['orderBy'];
                    }
                    $sql = 'SELECT * FROM SubWorksheet WHERE email =\''.$_SESSION['email'].'\' ORDER BY '.$order;
                    if ($_SESSION['sort']=='desc') {
                        $sql = $sql.' DESC';
                    }
                    $result = mysqli_query($conn, $sql);

                    $isOdd = false;
                    while($row = mysqli_fetch_array($result))
                    {
                        $temp = $row['invoice'];
                        $temp2 = $row['email'];
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

                        echo '
                                    <td align="center">'.$row['apt'].'</td>
                                    <td align="center">'.$row['unit'].'</td>
                                    <td align="center">'.$row['message'].'</td>
                                    <td align="center">'.$row['comment'].'</td>
                                    <td align="center">'.$row['date'].'</td>
                                    <td align="center"><button><a href="edit_user.php?invoice_num='.$temp.'">Edit</a></button></td>
                                    <td align="center"><button><a href="workdone_process.php?invoice_num='.urlencode($temp).' &email_user='.urlencode($temp2).' &id='.urlencode($id).'">Work Done</a></button></td>
                                </tr>
                            </tbody>';
                    }
                    echo '</table>';
                }
                mysqli_close($conn);
            ?>
        </div>
        <br><br><br><br><br>

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>
