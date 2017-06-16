<!-- Header -->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php">SEVEN CONTRACT LLC.</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="index.php">HOME</a></li>
                <li><a href="about.php">ABOUT</a></li>
                <li><a href="contact.php">CONTACT</a></li>
                <li><a href="worksheet.php">WORKSHEET</a></li>
                <?php if (isset($_SESSION['email'])): ?>
                    <li id="abc"><a href="signout.php">SIGNOUT</a></li>
                <?php  else: ?>
                    <li id="abc"><a href="signin.php">SIGNIN</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
