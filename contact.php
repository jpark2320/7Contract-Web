<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <!-- Header Tag -->
    <?php include('./includes/head_tag.html'); ?>
    <body class="body">

        <!-- Header -->
        <?php include('./includes/nav_bar.php'); ?>

        <!-- Body -->
        <div id="contact" class="container">
            <h1>Contact</h1>
            <p><em>Ask us if you have any question!</em></p>

            <form action="send_email.php" method="post">
                <table>
                    <colgroup>
                        <col align="left" width="32%">
                        <col width="34%">
                        <col width="34%">
                    </colgroup>
                    <tr>
                        <td align="left"><p><b>< Information ></b></p></td>
                        <td align="left"><input id="name" name="name" maxlength="50" placeholder="Enter name" type="text" size="48" required></td>
                        <td align="right"><input id="email" name="email" maxlength="50" placeholder="Enter email" type="email" size="48" required></td>
                    </tr>
                    <tr>
                        <td align="left">
                            <p><img src="./img/map_marker.png" style="width:10px;height:10px;"> Location: Duluth, GA</p>
                            <p><img src="./img/phone.png" style="width:10px;height:10px;"> Phone: (678)727-3371</p>
                            <p><img src="./img/email.png" style="width:10px;height:10px;"> Email: sevencontract@mail.com</p>
                        </td>
                        <td align="right" colspan="2">
                            <textarea id="message" name="message" placeholder="Enter message" row="5" cols="101"></textarea>
                        </td>
                    </tr>
                </table>
                <br>
                <input type="submit" value="Send"></input>
            </form>
        </div>

        <!-- Add Google Maps -->
        <div id="googleMap" style="height:1000px;">
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
