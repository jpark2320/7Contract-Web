<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="./css/styles.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="50">

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
        <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $db = "7Contract";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $db);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            if (isset($_GET['invoice_num'])) {
                $invoice = $_GET['invoice_num'];
                $check = "SELECT * FROM Workseet WHERE invoice = '".$invoice."';";
                $result = $conn->query($check);
                while($row = $result->fetch_assoc()) {
                    $_SESSION['invoice'] = $row['invoice'];
                    $_SESSION['po'] = $row['po'];
                    $_SESSION['apt'] = $row['apt'];
                    $_SESSION['size'] = $row['size'];
                    $_SESSION['price'] = $row['price'];
                    $_SESSION['description'] = $row['description'];
                }
            }

        ?>
        <!-- Body -->
        <div class="container">
            <h3 class="text-center">Edit</h3><br>

            <div class="row" align="center">
                <form action="edit_process.php" method="POST">
                    <p>
                        <label>P.O Number:</label>
                        <input type="text" name="po" value="<?php echo isset($_SESSION['po']) ? $_SESSION['po'] : '' ?>">
                    </p>
                    <p>
                        <label>Apt #:</label>
                        <input type="text" name="apt" value="<?php echo isset($_SESSION['apt']) ? $_SESSION['apt'] : '' ?>">
                    </p>
                    <p>
                        <label>Size:</label>
                        <input type="text" name="size" value="<?php echo isset($_SESSION['size']) ? $_SESSION['size'] : '' ?>">
                    </p>
                    <p>
                        <label>Price:</label>
                        <input type="text" name="price" value="<?php echo isset($_SESSION['price']) ? $_SESSION['price'] : '' ?>">
                    </p>
                    <p>
                        <label>Description:</label>
                        <input type="text" name="description" value="<?php echo isset($_SESSION['description']) ? $_SESSION['description'] : '' ?>">
                    </p>
                    <input type="submit" value="Register">
                </form>
                    <br>
                    <input type="button" value="Back" onclick="location.href='worksheet.php'">
            </div>
        </div>

        <!-- Footer -->
        <footer class="text-center">
            <a class="up-arrow" href="#myPage" data-toggle="tooltip" title="TO TOP">
                <span class="glyphicon glyphicon-chevron-up"></span>
            </a><br><br>
            <p>Copyright ©2017 SEVEN CONTRACT LLC. All rights reserved.</p>
        </footer>
    </body>
</html>
