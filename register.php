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
            <h3 class="text-center">Sign up right now!</h3><br>

            <div class="row" align="center">
                <form action="register_process.php" method="POST">
                    <p>
                        <label>Email Address:</label>
                        <input type="email" name="email" value="<?php echo isset($_SESSION['echeck']) ? $_SESSION['echeck'] : '' ?>">
                    </p>
                    <p>
                        <label>Password:</label>
                        <input type="password" name="upw">
                    </p>
                    <p>
                        <label>Re-password:</label>
                        <input type="password" name="upw2">
                    </p>
                    <p>
                        <label>First Name:</label>
                        <input type="text" name="fname" value="<?php echo isset($_SESSION['fcheck']) ? $_SESSION['fcheck'] : '' ?>">
                    </p>
                    <p>
                        <label>Last Name:</label>
                        <input type="text" name="lname" value="<?php echo isset($_SESSION['lcheck']) ? $_SESSION['lcheck'] : '' ?>">
                    </p>
                    <input type="submit" value="Register">
                </form>
                    <br>
                    <input type="button" value="Back" onclick="location.href='signin.php'">
            </div>
        </div>

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>
