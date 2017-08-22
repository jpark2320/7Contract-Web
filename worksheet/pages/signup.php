<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

    <?php include('./includes/head_tag.html'); ?>

    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="login-panel panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Please Sign Up</h3>
                        </div>
                        <div class="panel-body">
                            <form role="form" action="signup_process.php" method="POST">
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus value="<?php echo isset($_SESSION['echeck']) ? $_SESSION['echeck'] : '' ?>">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Password" name="upw" type="password" value="">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Re-Password" name="upw2" type="password" value="">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="First Name" name="fname" type="text" value="<?php echo isset($_SESSION['fcheck']) ? $_SESSION['fcheck'] : '' ?>">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Last Name" name="lname" type="text" value="<?php echo isset($_SESSION['lcheck']) ? $_SESSION['lcheck'] : '' ?>">
                                    </div>
                                    <input type="submit" value="Sign Up" class="btn btn-lg btn-success btn-block">
                                    <input type="button" value="Back" class="btn btn-block" onclick="location.href='signin.php'">
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- jQuery -->
        <script src="../vendor/jquery/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="../vendor/metisMenu/metisMenu.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="../dist/js/sb-admin-2.js"></script>
    </body>
</html>
