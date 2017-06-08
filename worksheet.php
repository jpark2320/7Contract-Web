<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Theme Made By www.w3schools.com - No Copyright -->
        <title>Bootstrap Theme The Band</title>
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
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.php">SEVEN CONTRACT LLC.</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="index.php">HOME</a></li>
                        <li><a href="about.php">ABOUT</a></li>
                        <li><a href="worksheet.php">WORKSHEET</a></li>
                        <li><a href="contact.php">CONTACT</a></li>
                        <li><a href="signin.php">SIGNIN</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div id="contact" class="container">
            <h3 class="text-center">Sign up right now!</h3><br>

            <div class="row" align="center">
                <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $db = "7Contract";

                    // Create connection
                    $conn = new mysqli($servername, $username, $password, $db);

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
                    $sql = "SELECT * FROM Users";
                    $result = mysqli_query($conn, $sql);

                    echo "<table border='1'>
                    <tr>
                    <th>Username</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Is Admin?</th>
                    </tr>";

                    while($row = mysqli_fetch_array($result))
                    {
                        echo "<tr>";
                        echo "<td>" . $row['username'] . "</td>";
                        echo "<td>" . $row['first'] . "</td>";
                        echo "<td>" . $row['last'] . "</td>";
                        echo "<td>" . $row['isadmin'] . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";

                    mysqli_close($conn);
                ?>
                <p>
                    <label>Name
                    <input type="text" name="customer_name" required>
                    </label> 
                    </p>

                    <p>
                    <label>Phone 
                    <input type="tel" name="phone_number">
                    </label>
                    </p>

                    <p>
                    <label>Email 
                    <input type="email" name="email_address">
                    </label>
                </p>
                <form class="" action="signin_process.php" method="POST">
                    <p>
                        <label for="">Username:</label>
                        <input type="text" name="uid" value="<?php echo isset($_SESSION['uid']) ? $_SESSION['uid'] : '' ?>" />
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
                <p>Forgot ID or PASSWORD?</p>
                Find <a href="register.php">Id</a> or <a href="#">Password</a><br><br><br>
                <p>No account?</p>
                <a href="register.php">Sign Up</a>
            </div>
        </div>

        <!-- Footer -->
        <footer class="text-center">
            <a class="up-arrow" href="#myPage" data-toggle="tooltip" title="TO TOP">
                <span class="glyphicon glyphicon-chevron-up"></span>
            </a><br><br>
            <p>Copyright ©2017 SEVEN CONTRACT LLC. All rights reserved. <a href="https://www.w3schools.com" data-toggle="tooltip" title="Visit w3schools">www.w3schools.com</a></p>
        </footer>

        <script>
            $(document).ready(function(){
                // Initialize Tooltip
                $('[data-toggle="tooltip"]').tooltip();

                // Add smooth scrolling to all links in navbar + footer link
                $(".navbar a, footer a[href='#myPage']").on('click', function(event) {

                    // Make sure this.hash has a value before overriding default behavior
                    if (this.hash !== "") {

                        // Prevent default anchor click behavior
                        event.preventDefault();

                        // Store hash
                        var hash = this.hash;

                        // Using jQuery's animate() method to add smooth page scroll
                        // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
                        $('html, body').animate({
                            scrollTop: $(hash).offset().top
                        }, 900, function(){

                            // Add hash (#) to URL when done scrolling (default click behavior)
                            window.location.hash = hash;
                        });
                    } // End if
                });
            })
        </script>
    </body>
</html>
