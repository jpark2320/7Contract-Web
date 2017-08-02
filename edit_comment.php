<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <!-- Header Tag -->
    <?php include('./includes/head_tag.html'); ?>
    <body id="myPage">

        <!-- Header -->
        <?php include('./includes/nav_bar.php'); ?>

        <?php
            // connection with mysql database
            include('./includes/connection.php');

            if (isset($_GET['index_deleted'])) {
                echo '<script>window.location.href="edit_user.php";</script>';
                array_splice($_SESSION['arr'], $_GET['index_deleted'], 1);
                $_SESSION['i']--;
                exit();
            }
            if (isset($_GET['comment'])) {
                $comment = $_GET['comment'];
            }
            if (isset($_GET['index'])) {
                $index = $_GET['index'];
            }
        ?>

        <!-- Body -->
        <div class="primary" align="center">
            <h3 class="text-center">Edit Comment</h3>

            <form action="edit_user.php" method="GET">
                <table width="30%">
                    <colgroup>
                        <col width="18%">
                        <col width="2%">
                        <col width="80%">
                    </colgroup>
                    <tr>
                         <td align="right"><b>Comment</b></td>
                         <td></td>
                         <td><input class="editInput" type="text" name="cmt_edited_user" value="<?php echo isset($comment) ? rtrim($comment, " ") : '' ?>"></td>
                     </tr>
                     <tr hidden>
                         <td><b>Index</b></td>
                         <td></td>
                         <td><input class="editInput" type="text" name="index_edited_user" value="<?php echo $index ?>"></td>
                     </tr>
                </table>
                <br>
                <button type="submit">Edit</button>
                <button type="button" onclick="location.href='edit_user.php'">Back</button>
            </form>
        </div>

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>
