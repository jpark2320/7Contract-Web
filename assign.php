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
            <h3 class="text-center">Assign workers!</h3><br>

            <div class="row" align="center">
                <?php
                    if (isset($_GET['invoice_num'])) {
                        $_SESSION['i_num'] = $_GET['invoice_num'];
                    }
                    if (isset($_GET['apt_num'])) {
                        $_SESSION['a_num'] = $_GET['apt_num'];
                    }
                    if (isset($_GET['unit_num'])) {
                        $_SESSION['u_num'] = $_GET['unit_num'];
                    }

                    echo '<b>Invoice # : '.$_SESSION['i_num'].'</b>';

                    // connection with mysql database
                    include('./includes/connection.php');

                    $sql = "SELECT * FROM users";
                    $result = mysqli_query($conn, $sql);

                    echo '
                        <table border="2" width="500px">
                            <thead>
                                <tr>
                                    <td align="center" width="200px"><b>Subcontractors</b></th>
                                    <td align="center" width="100px"></th>
                                    <td align="center" width="200px"><b>Added</b></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <form action="assign.php" method="post">
                                        <td align="center">
                                            <select name="workers[]" multiple="multiple" size="10">';

                        while($row = mysqli_fetch_array($result))
                        {
                            echo '<option value="'.$row['email'].'">'.$row['first'].' '.$row['last'].' ('.$row['email'].')</option>';
                        }
                        echo '
                                            </select>
                                        </td>
                                        <td align="center">
                                            <input type="submit" name="invoice_num" value="->"></input>
                                        </td>
                                        <td align="center">
                                            <select multiple="multiple" size="10">
                        ';
                        if (isset($_POST['workers'])) {
                            $_SESSION['workersArray'] = $_POST['workers'];

                            for ($i = 0; $i < sizeof($_SESSION['workersArray']); $i++) {
                                echo '<option value="">'.$_SESSION['workersArray'][$i].'</option>';
                            }
                            echo '
                                            </select>
                                        </td>
                                    </form>
                                </tr>
                            </tbody>';
                        }
                    echo '</table>';
                    echo '
                        <h5 class="text-center" font-color="red">When you need multiple choices, use "control" key.</h5>
                        <br>
                    ';
                    mysqli_close($conn);
                ?>
                <form action="assign_process.php" method="POST">
                    <textarea class="form-control" name="assign_message" placeholder="Leave a message here." rows="4" cols="10"></textarea>
                    <br>
                    <input type="submit" value="Confirm"></input>
                    <input type="button" value="Back" onclick="location.href='worksheet.php'"></input>
                </form>
            </div>
        </div>

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>
