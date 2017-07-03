<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <!-- Header Tag -->
    <?php include('./includes/head_tag.html'); ?>
    <body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="50">

        <!-- Header -->
        <?php include('./includes/nav_bar.php'); ?>

        <!-- Body -->
        <div id="contact" class="container">
            <h3 class="text-center">Sign in!</h3>
            <p class="text-center"><em>or sign up if don't have an account</em></p><br><br>

            <div class="row" align="center">
                <form class="" action="signin_process.php" method="POST">
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
                    </table>
                    <br>
                    <input type="submit" value="login">
                    <input type="button" value="Back" onclick="location.href='worksheet.php'">
                </form>
                <br><br>
                <p>Forgot username or password?</p>
                Find <a href="#">username</a> or <a href="#">password</a><br><br><br>
                <p>No account?</p>
                <input type="button" value="Sign Up" onclick="location.href='register.php'">
            </div>
        </div>

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>
