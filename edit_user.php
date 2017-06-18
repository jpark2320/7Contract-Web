<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <!-- Header Tag -->
    <?php include('./includes/head_tag.html'); ?>
    <body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="50">

        <!-- Header -->
        <?php include('./includes/nav_bar.php'); ?>

        <?php
            // connection with mysql database
            include('./includes/connection.php');

            if (isset($_GET['invoice_num'])) {
                $invoice = $_GET['invoice_num'];
                $check = "SELECT * FROM subworksheet WHERE invoice = '".$invoice."';";
                $result = $conn->query($check);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $_SESSION['invoice'] = $row['invoice'];
                        $_SESSION['comment'] = $row['comment'];
                    }
                }
            }
        ?>

        <!-- Body -->
        <div class="container">
            <h3 class="text-center">Edit</h3><br>

            <div class="row" align="center">
                <form action="edit_process.php" method="POST">

                    <table width="400">
                        <colgroup>
                            <col width="50%">
                            <col width="50%">
                        </colgroup>
                            <tr>
                                <td><label>Comment:</label></td>
                                <td><input type="text" name="comment" maxlength="36" size="30" value="<?php echo isset($_SESSION['comment']) ? $_SESSION['comment'] : '' ?>"></td>
                            </tr>
                    </table>
                    <br>
                    <input type="submit" value="Edit">
                    <input type="button" value="Back" onclick="location.href='worksheet.php'">
                </form>
            </div>
        </div>

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>
