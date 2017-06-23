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
            <h3 class="text-center">Fill in a new worksheet!</h3><br>
            <div class="row" align="center">
                <br><br>
                <form action="worksheet_process.php" method="POST">
                    <table width="400">
                        <colgroup>
                            <col width="50%">
                            <col width="50%">
                        </colgroup>
                            <!-- <tr>
                                <td><label for="">Invoice #</label></td>
                                <td><input type="text" name="invoice" maxlength="36" size="30"></td>
                            </tr> -->
                            <tr>
                                <td><label>P.O.</label></td>
                                <td><input type="text" name="po" maxlength="36" size="30"></td>
                            </tr>
                            <tr>
                                <td><label>Apt #</label></td>
                                <td><input type="text" name="apt" maxlength="36" size="30"></td>
                            </tr>
                            <tr>
                                <td><label>Unit #</label></td>
                                <td><input type="text" name="unit" maxlength="36" size="30"></td>
                            </tr>
                            <tr>
                                <td><label>Size</label></td>
                                <td><input type="text" name="size" maxlength="36" size="30"></td>
                            </tr>
                            <tr>
                                <td><label>Price</label></td>
                                <td><input type="text" name="price" value="0.0" maxlength="36" size="30"></td>
                            </tr>
                            <tr>
                                <td><label>Description</label></td>
                                <td><textarea name="description" rows="2" cols="200" style="width:222px;"></textarea></td>
                            </tr>
                    </table>
                    <br>
                    <input type="submit" value="Submit">
                    <input type="button" value="Back" onclick="location.href='worksheet.php'">
                </form>
            </div>
        </div>

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>
