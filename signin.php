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
            <h3 class="text-center">Join us!</h3><br>

            <div class="row" align="center">
                <form class="" action="signin_process.php" method="POST">
                    <p>
                        <label for="">Email Address:</label>
                        <input type="email" name="email" value="<?php echo isset($_SESSION['echeck']) ? $_SESSION['echeck'] : '' ?>">
                    </p>
                    <p>
                        <label for="">Password:</label>
                        <input type="password" name="upw">
                    </p>
                    <p>
                        <input type="submit" name="" value="login">
                    </p>
                </form>
                <br>
                <p>Forgot username or password?</p>
                Find <a href="#">username</a> or <a href="#">password</a><br><br><br>
                <p>No account?</p>
                <a href="register.php">Sign Up</a>
            </div>
        </div>

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>
