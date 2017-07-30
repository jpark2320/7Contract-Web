<?php
    session_start();
    unset($_SESSION['edit_arr']);
    $_SESSION['i'] = 0;
?>
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
                        <table id="ResponsiveTable" border="3" width="100%">
                            <thead id="HeadRow">
                                <tr style="border: 2px double black;" bgcolor="#c9c9c9">
                                    <td align="center"><b><a href="?orderBy=id">ID</a></b></td>
                                    <td align="center"><b><a href="?orderBy=apt">Apartment</a></b></td>
                                    <td align="center"><b><a href="?orderBy=unit">Unit</a></b></td>
                                    <td align="center"><b><a href="?orderBy=size">Size</a></b></td>
                                    <td align="center"><b><a href="?orderBy=price">Price</a></b></td>
                                    <td align="center"><b>Description</b></td>
                                    <td align="center"><b><a href="?orderBy=date">Date</a></b></td>';
                    if ($_SESSION['isadmin'] == 2) {                
                        echo '<td align="center"><b>Option</b></td>
                        ';
                    }
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
                        $company = $row['company'];
                        if ($company == null) $company = "-";

                        $apt = $row['apt'];
                        if ($apt == null) $apt = "-";

                        $unit = $row['unit'];
                        if ($unit == null) $unit = "-";

                        $size = $row['size'];
                        if ($size == null) $size = "-";

                        $price = $row['price'];
                        if ($price == null) $price = "-";
                        $price = str_replace(".00", "", $price);
                        $description = $row['description'];
                        if ($description == null) $description = "-";

                        $date = $row['date'];
                        if ($date == null) $date = "-";

                        echo '<tbody>';
                        if ($isOdd) {
                            $isOdd = false;
                            echo '<tr bgcolor="#e8fff1">';
                        } else {
                            $isOdd = true;
                            echo '<tr>';
                        }

                        echo '
                                    <td tableHeadData="ID" align="center">'.$row['id'].'</td>
                                    
                                    <td tableHeadData="Apartment" align="center"><a href="worksheet_apt.php?apt='.$apt.'">'.$apt.'</a></td>
                                    <td tableHeadData="Unit" align="center">'.$unit.'</td>
                                    <td tableHeadData="Size" align="center">'.$size.'</td>
                                    <td tableHeadData="Price" align="center">'.number_format($price).'</td>
                                    <td tableHeadData="Description" align="left"><a href="estimate_description.php?id='.$row['id'].'&company='.$company.'&apt='.$apt.'&unit='.$unit.'&size='.$size.'">'.$description.'</a></td>
                                    <td tableHeadData="Date" align="center">'.substr($date, 0, 10).'</td>';
                        if ($_SESSION['isadmin']) {
                            echo '<td align="center">
                                    <button><a href="toWorksheet.php?id='.$row['id'].'&company='.$company.'&apt='.$apt.'&unit='.$unit.'&size='.$size.'&price='.$price.'&description='.$description.'">Convert</a></button>
                                    <button><a href="estimate_edit.php?id='.$row['id'].'">Edit</a></button>
                                    <button><a href="remove_estimate.php?id='.$row['id'].'" onclick="return confirm(\'Are you sure you want to remove this item?\');">Remove</a></button>
                                </td>
                            ';
                        }
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
