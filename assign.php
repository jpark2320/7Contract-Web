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
            <h3 class="text-center">Assign Work</h3><br>
            <form action="assign_process.php" method="POST">
            <?php
                if (isset($_GET['invoice_num'])) $_SESSION['i_num'] = $_GET['invoice_num'];

                if (isset($_GET['apt'])) $_SESSION['a_num'] = $_GET['apt'];

                if (isset($_GET['unit_num'])) $_SESSION['u_num'] = $_GET['unit_num'];

                echo '<b>Invoice # : '.$_SESSION['i_num'].'</b>';

                // connection with mysql database
                include('./includes/connection.php');

                $sql = "SELECT * FROM users WHERE isadmin=0";
                $result = mysqli_query($conn, $sql);

                echo '
                    <table id="ResponsiveTable" border="2" width="50%">
                        <thead id="HeadRow">
                            <tr style="border: 2px double black;" bgcolor="#c9c9c9">
                                <th>Select</th>
                                <th>Name</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                ';
                
                $idOdd = false;
                while($row = mysqli_fetch_array($result)) {

                    $email = $row['email'];
                    if ($email == null) $email = '-';

                    $first = $row['first'];
                    if ($first == null) $first = '-';

                    $last = $row['last'];
                    if ($last == null) $last = '-';

                    if (isset($isOdd)) {
                        if ($isOdd) {
                            $isOdd = false;
                            echo '<tr bgcolor="#e8fff1">';
                        } else {
                            $isOdd = true;
                            echo '<tr>';
                        }
                    }

                    echo '
                            <td tableHeadData="Select" align="center">
                                <input type="checkbox" name="workersArray[]" value="'.$email.'">
                            </td>
                            <td tableHeadData="Name" align="center">'.$first.' '.$last.'</td>
                            <td tableHeadData="Email" align="center">'.$email.'</td>
                        </tr>
                    ';

                }
                echo '</tbody></table>';
                mysqli_close($conn);
            ?>
            <br>
                <textarea id="msg_assign" name="assign_message" placeholder="Leave a message here." rows="8" cols="100"></textarea>
                <br>
                <input type="submit" value="Confirm"></input>
                <input type="button" value="Back" onclick="location.href='worksheet.php'"></input>
            </form>
        </div>

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>
