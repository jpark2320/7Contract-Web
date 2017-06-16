<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <!-- Header Tag -->
    <?php include('./includes/head_tag.html'); ?>
    <body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="50">

        <!-- Header -->
        <?php
            include('./includes/nav_bar.php');
        ?>

        <!-- Body -->
        <div id="contact" class="container">
            <h3 class="text-center">Contact</h3>
            <p class="text-center"><em>Ask us if you have any question!</em></p>

            <div class="row">
                <div class="col-md-4">
                    <p><b>< Information ></b></p>
                    <p><span class="glyphicon glyphicon-map-marker"></span>Location: Duluth, GA</p>
                    <p><span class="glyphicon glyphicon-phone"></span>Phone: (678)727-3371</p>
                    <p><span class="glyphicon glyphicon-envelope"></span>Email: sevencontract@mail.com</p>
                </div>
                <div class="col-md-8">
                    <form action="contact_process.php" method="post">
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <input class="form-control" id="name" name="name" placeholder="Name" type="text" required>
                            </div>
                            <div class="col-sm-6 form-group">
                                <input class="form-control" id="email" name="email" placeholder="Email" type="email" required>
                            </div>
                        </div>
                        <textarea class="form-control" id="comments" name="message" placeholder="Message" rows="5"></textarea>
                        <br>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <input class="btn pull-right" type="submit" value="Send"></input>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Add Google Maps -->
        <div id="googleMap" style="height:400px;" class="w3-grayscale-max">
            <iframe width="100%" height="300px" frameborder="0" style="border:0" allowfullscreen
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d56215.33619123207!2d-84.11975401170005!3d33.976884886649046!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x88f5a2c2e7b25e09%3A0xc8c21d4071e95ecd!2s2891+Cardinal+Lake+Dr+NW%2C+Duluth%2C+GA+30096!5e0!3m2!1sen!2sus!4v1497624869693">
            </iframe>
        </div>

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>
