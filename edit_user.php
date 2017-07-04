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

            if (isset($_GET['id'])) {
                $_SESSION['id'] = $_GET['id'];
                $check = "SELECT * FROM subworksheet WHERE id=".$_SESSION['id'].";";
                $result = $conn->query($check);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $_SESSION['comment'] = $row['comment'];
                    }
                }
            }
        ?>

        <!-- Body -->
        <div class="primary" align="center">
            <h3 class="text-center">Edit comment!</h3><br>

            <form action="edit_process.php" method="POST">

                <table width="200">
                    <tr>
                        <td align="center"><label>Comment</label></td>
                    </tr>
                    <tr>
                        <td><textarea type="text" name="comment" rows="8" cols="60" value="<?php echo isset($_SESSION['comment']) ? $_SESSION['comment'] : '' ?>"></textarea></td>
                    </tr>
                </table>
                <br>
                <input type="submit" value="Edit">
                <input type="button" value="Back" onclick="location.href='worksheet.php'">
            </form>
        </div>

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>
