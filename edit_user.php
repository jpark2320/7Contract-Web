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
                $_SESSION['invoice'] = $_GET['invoice'];
            }
        ?>

        <!-- Body -->
        <div class="primary" align="center">
            <h3 class="text-center">Add Comment</h3>

            <?php
                if (isset($_GET['cmt_edited_user'])) {
                    $_SESSION['arr'][$_GET['index_edited_user']] = $_GET['cmt_edited_user'];
                }

				if (isset($_POST['comment'])) {
					if ($_POST['comment'] !== null) {
						$_SESSION['arr'][$_SESSION['i']] = $_POST['comment'];
					}
				}
                if (isset($_POST['submit'])) {
                    $_SESSION['i']++;
                }

                echo '

                    <form action="edit_user.php" method="post">
                        <table id="ResponsiveTable" border="2" width="100%">
                            <colgroup>
                                <col width="90%">
                                <col width="5%">
                                <col width="5%">
                            </colgroup>
                            <thead id="HeadRow">
                                <tr style="border: 2px double black;" bgcolor="#c9c9c9">
                                    <td align="center"><b>Comment</b></td>
                                    <td colspan="2"></td>
                                </tr>
                            </thead>
                            <tbody id="pdf_table">
                                <tr>
                                    <td tableHeadData="Comment"><input class="textInput" type="text" name="comment" placeholder="Type comment" required></td>
                                    <td align="center" colspan="2"><button type="submit" name="submit">Add</button></td>
                ';
				if (isset($_SESSION['arr'])) {
					for ($i = 0; $i < sizeof($_SESSION['arr']); $i++) {
						if ($_SESSION['arr'][$i] !== null) {
							echo '<tr bgcolor="#c4daff"><td><div class="lineBreak_desc">'.$_SESSION['arr'][$i].'</div></td>';
						}
                        if ($_SESSION['arr'][$i] !== null) {
                            echo '<td align="center"><button onclick="location.href=\'edit_comment.php?comment='.$_SESSION['arr'][$i].' &index='.$i.'\'">Edit</button></td>';
                        }
                        if ($_SESSION['arr'][$i] !== null) {
                            echo '<td align="center"><button onclick="location.href=\'edit_comment.php?index_deleted='.$i.'\'">Delete</button></td></tr>';
                        }
					}
				}
                echo '
                            </tbody>
                        </table>
                    </form>
                ';
            ?>
            <br>
            <form>
                <button type="button" onclick="location.href='add_comment.php'">Submit</button>
                <button type="button" onclick="location.href='worksheet.php'">Back</button>
            </form>
        </div>

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>
