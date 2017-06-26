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
            <h3 class="text-center">Join us today!</h3><br>

            <div class="row" align="center">

                <form action="register_process.php" method="POST">
                    <table width="250">
                        <colgroup>
                            <col width="50%">
                            <col width="50%">
                        </colgroup>
                            <tr>
                                <td><label>Email</label></td>
                                <td><input type="email" name="email" value="<?php echo isset($_SESSION['echeck']) ? $_SESSION['echeck'] : '' ?>"></td>
                            </tr>
                            <tr>
                                <td><label>Password</label></td>
                                <td><input type="password" name="upw"></td>
                            </tr>
                            <tr>
                                <td><label>Re-Password</label></td>
                                <td><input type="password" name="upw2"></td>
                            </tr>
                            <tr>
                                <td><label>First Name</label></td>
                                <td><input type="text" name="fname" value="<?php echo isset($_SESSION['fcheck']) ? $_SESSION['fcheck'] : '' ?>"></td>
                            </tr>
                            <tr>
                                <td><label>Last Name</label></td>
                                <td><input type="text" name="lname" value="<?php echo isset($_SESSION['lcheck']) ? $_SESSION['lcheck'] : '' ?>"></td>
                            </tr>
                    </table>
                    <br>
                    <input type="submit" value="Register">
                    <input type="button" value="Back" onclick="location.href='signin.php'">
                </form>
            </div>
        </div>

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>
