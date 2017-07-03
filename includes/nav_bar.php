<!-- Header -->
<div class="header">
    <h1>SEVEN <span>CONTRACT</span> LLC.</h1>
    <nav>
        <a href="" id="menu_icon"><img src="img/menu_button.png" width="20px" height="20px"></a>
        <ul>
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
    </nav>
</div>
