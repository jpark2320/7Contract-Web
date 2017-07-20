<!-- Header -->
<div class="header">
    <h1><a href="index.php">SEVEN <span>CONTRACT</span> LLC.</a></h1>
    <nav>
        <div align="right">
            <a href="" id="menu_icon"><img src="img/menu_button.png"></a>
        </div>
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
