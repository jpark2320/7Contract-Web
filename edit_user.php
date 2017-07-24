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
            <h3 class="text-center">Add Comments!</h3><br>

            <?php
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
                        <table id="ResponsiveTable" border="2" width="80%">
                            <colgroup>
                                <col width="50%">
                                <col width="25%">
                                <col width="25%">
                            </colgroup>
                            <thead id="HeadRow">
                                <tr style="border: 2px double black;" bgcolor="#c9c9c9">
                                    <td align="center"><b>Comment</b></td>
                                </tr>
                            </thead>
                            <tbody id="pdf_table">
                                <tr>
                                    <td tableHeadData="Comment"><input style="border: none; width: 100%; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;" type="text" name="comment" placeholder="Add comment here.." size="165" required></td>
                ';
				if (isset($_SESSION['arr'])) {
					for ($i = 0; $i < sizeof($_SESSION['arr']); $i++) {
						if ($_SESSION['arr'][$i] !== null) {
							echo '<tr bgcolor="#c4daff"><td>'.$_SESSION['arr'][$i].'</td>';
						}
					}
				}

                echo '
                                </tr>
                            </tbody>
                        </table>
                        <input type="submit" name="submit" value="Add">
                    </form>
                        <br>

                ';
            ?>
            <br>
            <form>
                <input type="button" value="Submit" onclick="location.href='add_comment.php'"></input>
                <input type="button" value="Back" onclick="location.href='worksheet.php'"></input>
            </form>
        </div>

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>
