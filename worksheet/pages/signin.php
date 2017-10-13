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
                            <h3 class="panel-title">Please Sign In</h3>
                        </div>
                        <div class="panel-body">
                            <form role="form" action="signin_process.php" method="POST">
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus value="<?php echo isset($_SESSION['echeck']) ? $_SESSION['echeck'] : '' ?>">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Password" name="upw" type="password" value="">
                                    </div>
                                    <!-- <div class="checkbox">
                                        <label>
                                            <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                        </label>
                                    </div> -->
                                    <!-- Change this to a button or input when using this as a form -->
                                    <input type="submit" value="Login" class="btn btn-lg btn-success btn-block" value="Login">
                                </fieldset>
                            </form>
                        </div>

                        <div class="panel-heading">
                            <h3 class="panel-title">No Account?</h3>
                        </div>
                        <div class="panel-body">
                            <form role="form" action="signin_process.php" method="POST">
                                <fieldset>
                                    <!-- Change this to a button or input when using this as a form -->
                                    <input type="button" value="Sign Up" onclick="location.href='signup.php'" class="btn btn-danger btn-success btn-block">
                                    <input type="button" value="Back to Main" onclick="location.href='../../'" class="btn btn-block">
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