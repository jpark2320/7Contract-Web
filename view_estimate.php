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
            <h3 class="text-center">View Estimate</h3><br>
                <?php
                    // connection with mysql database
                    include('./includes/connection.php');

                    $sql = "SELECT * FROM estimate";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_array($result);

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
                        echo '<script>window.location.href = "view_estimate.php";</script>';
                    }

                    echo '
                        <table border="3" width="100%">
                            <thead>
                                <tr style="border: 2px double black;" bgcolor="#c9c9c9">
                                    <td align="center"><b><a href="?orderBy=id">ID</a></b></td>
                                    <td align="center"><b><a href="?orderBy=company">Company</a></b></td>
                                    <td align="center"><b><a href="?orderBy=apt">Apartment</a></b></td>
                                    <td align="center"><b><a href="?orderBy=unit">Unit</a></b></td>
                                    <td align="center"><b><a href="?orderBy=size">Size</a></b></td>
                                    <td align="center"><b><a href="?orderBy=price">Price</a></b></td>
                                    <td align="center"><b>Description</b></td>
                                    <td align="center"><b><a href="?orderBy=date">Date</a></b></td>
                                    <td align="center"><b>Option</b></td>
                    ';
                    echo '
                                </tr>
                            </thead>
                    ';
                    $orderBy = array('id', 'company', 'apt', 'unit', 'size', 'price', 'date');
                    $order = 'id';
                    if (isset($_GET['orderBy']) && in_array($_GET['orderBy'], $orderBy)) {
                        $order = $_GET['orderBy'];
                    }
                    $sql = "SELECT * FROM estimate ORDER BY ".$order;
                    if ($_SESSION['sort']=='desc') {
                        $sql = $sql.' DESC';
                    }
                    $result = mysqli_query($conn, $sql);
                    $isOdd = false;
                    while($row = mysqli_fetch_array($result))
                    {

                        echo '<tbody>';
                        if ($isOdd) {
                            $isOdd = false;
                            echo '<tr bgcolor="#e8fff1">';
                        } else {
                            $isOdd = true;
                            echo '<tr>';
                        }

                        echo '
                                    <td align="center">'.$row['id'].'</td>
                                    <td align="center"><a href="worksheet_company.php?company='.$row['company'].'">'.$row['company'].'</a></td>
                                    <td align="center"><a href="worksheet_apt.php?apt='.$row['apt'].'">'.$row['apt'].'</a></td>
                                    <td align="center">'.$row['unit'].'</td>
                                    <td align="center">'.$row['size'].'</td>
                                    <td align="center">'.$row['price'].'</td>
                                    <td align="center"><a href="estimate_description.php?id='.$row['id'].'&company='.$row['company'].'&apt='.$row['apt'].'&unit='.$row['unit'].'&size='.$row['size'].'">'.$row['description'].'</a></td>
                                    <td align="center">'.substr($row['date'], 0, 10).'</td>
                                    <td align="center">
                                        <button><a href="toWorksheet.php?id='.$row['id'].'&company='.$row['company'].'&apt='.$row['apt'].'&unit='.$row['unit'].'&size='.$row['size'].'&price='.$row['price'].'&description='.$row['description'].'">Convert</a></button>
                                        <button><a href="estimate_edit.php?id='.$row['id'].'">Edit</a></button>
                                        <button><a href="remove_estimate.php?id='.$row['id'].'">Remove</a></button>
                                    </td>
                        ';
                    }
                    echo '</table>';
                    mysqli_close($conn);
                ?>
                <br>
                <input type="button" value="Back" onclick="location.href='worksheet.php'"></input>
        </div>
        <br><br><br><br><br>

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>
