<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <!-- Header Tag -->
    <?php include('./includes/head_tag.html'); ?>
    <body id="myPage">

        <!-- Header -->
        <?php include('./includes/nav_bar.php'); ?>

        <?php
            // connection with mysql database
            include('./includes/connection.php');

            if (isset($_GET['invoice_num'])) {
                $invoice = $_GET['invoice_num'];
                $invoice = str_replace("7C", "", $invoice);
                $sql = "SELECT * FROM Worksheet WHERE invoice ='".$invoice."';";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_array($result);
                $_SESSION['invoice'] = $row['invoice'];
                $_SESSION['po'] = $row['PO'];
                $_SESSION['company'] = $row['company'];
                $_SESSION['apt'] = $row['apt'];
                $_SESSION['manager'] = $row['manager'];
                $_SESSION['size'] = $row['size'];
                $_SESSION['unit'] = $row['unit'];
                $_SESSION['price'] = $row['price'];
                $_SESSION['description'] = $row['description'];
                $sql = "SELECT * FROM worksheet_description WHERE invoice ='$invoice';";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $_SESSION['arr'][$_SESSION['i']][0] = $row['description'];
                        $_SESSION['arr'][$_SESSION['i']][1] = $row['quantity'];
                        $_SESSION['arr'][$_SESSION['i']][2] = $row['price'];
                        $_SESSION['i']++;
                    }
                }
            }
        ?>

        <!-- Body -->
        <div class="primary" align="center">
            <h3 class="text-center">Edit Worksheet</h3><br>
            <?php
                if (isset($_GET['desc_edited_estm'])) {
                    $_SESSION['arr'][$_GET['index_edited_estm']][0] = $_GET['desc_edited_estm'];
                }
                if (isset($_GET['qty_edited_estm'])) {
                    $_SESSION['arr'][$_GET['index_edited_estm']][1] = $_GET['qty_edited_estm'];
                }
                if (isset($_GET['price_edited_estm'])) {
                    $_SESSION['arr'][$_GET['index_edited_estm']][2] = $_GET['price_edited_estm'];
                }

				if (isset($_POST['description'])) {
                    if (strlen($_POST['description']) > 0) {
  						$_SESSION['arr'][$_SESSION['i']][0] = $_POST['description'];
 					} else {
 						echo '<script>alert("Description is required");</script>';
 						echo '<script>window.location.href="edit_admin.php";</script>';
 						exit();
					}
				}
                if (isset($_POST['price'])) {
					if ($_POST['price'] !== null) {
						$_SESSION['arr'][$_SESSION['i']][1] = $_POST['qty'];
					}
				}
                if (isset($_POST['qty'])) {
					if ($_POST['qty'] !== null) {
						$_SESSION['arr'][$_SESSION['i']][2] = $_POST['price'];
					}
				}

                if (isset($_POST['submit'])) {
                    $_SESSION['i']++;
                }

                echo '
                    <form action="edit_admin.php" method="post">
                        <table id="ResponsiveTable" border="2" width="100%">
                            <colgroup>
                                <col width="70%">
                                <col width="10%">
                                <col width="10%">
                                <col width="5%">
                                <col width="5%">
                            </colgroup>
                            <thead id="HeadRow">
                                <tr style="border: 2px double black;" bgcolor="#c9c9c9">
                                    <td align="center"><b>Description</b></td>
                                    <td align="center"><b>Qty</b></td>
                                    <td align="center"><b>Price</b></td>
                                    <td colspan="2"></td>
                                </tr>
                            </thead>
                            <tbody id="pdf_table">
                                <tr>
                                    <td tableHeadData="Description"><input style="border: none; width: 100%; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;" type="text" name="description" size="10"></td>
                                    <td tableHeadData="Qty"><input style="border: none; width: 100%; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;" type="text" name="qty" size="10"></td>
                                    <td tableHeadData="Price"><input style="border: none; width: 100%; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;" type="text" name="price" size="10"></td>
                                    <td colspan="2" align="center"><input type="submit" name="submit" value="Add"></td>
                                </tr>
                ';
				if (isset($_SESSION['arr'])) {
					for ($i = 0; $i < sizeof($_SESSION['arr']); $i++) {
						if ($_SESSION['arr'][$i][0] !== null) {
							echo '<tr bgcolor="#c4daff"><td tableHeadData="Description">'.$_SESSION['arr'][$i][0].'</td>';
						}
						if ($_SESSION['arr'][$i][1] !== null) {
							echo '<td tableHeadData="Qty">'.$_SESSION['arr'][$i][1].'</td>';
						}

						if ($_SESSION['arr'][$i][2] !== null) {
							echo '<td tableHeadData="Price">'.$_SESSION['arr'][$i][2].'</td>';
						}
						if ($_SESSION['arr'][$i][0] !== null) {
							echo '<td align="center"><button><a href="edit_invoice_detail.php?description='.$_SESSION['arr'][$i][0].' &qty='.$_SESSION['arr'][$i][1].' &price='.$_SESSION['arr'][$i][2].' &index='.$i.'">Edit</a></button></td>';
						}
						if ($_SESSION['arr'][$i][0] !== null) {
							echo '<td align="center"><button><a href="edit_invoice_detail.php?index_deleted='.$i.'">Delete</a></button></td></tr>';
						}
					}
				}

                echo '
                            </tbody>
                        </table>
                        <br>
                    </form>';
            ?>
            <form action="edit_process.php" method="POST">

                <table width="400">
                    <colgroup>
                        <col width="50%">
                        <col width="50%">
                    </colgroup>
                        <tr>
                            <td><label>P.O Number</label></td>
                            <td><input type="text" name="po" maxlength="36" size="30" value="<?php echo isset($_SESSION['po']) ? $_SESSION['po'] : '' ?>"></td>
                        </tr>
                        <tr>
                            <td><label>Company</label></td>
                            <td><input type="text" name="company" maxlength="36" size="30" value="<?php echo isset($_SESSION['company']) ? $_SESSION['company'] : '' ?>"></td>
                        </tr>
                        <tr>
                            <td><label>Apt</label></td>
                            <td><input type="text" name="apt" maxlength="36" size="30" value="<?php echo isset($_SESSION['apt']) ? $_SESSION['apt'] : '' ?>"></td>
                        </tr>
                        <tr>
                            <td><label>Manager</label></td>
                            <td><input type="text" name="manager" maxlength="36" size="30" value="<?php echo isset($_SESSION['manager']) ? $_SESSION['manager'] : '' ?>"></td>
                        </tr>
                        <tr>
                            <td><label>Unit #</label></td>
                            <td><input type="text" name="unit" maxlength="36" size="30" value="<?php echo isset($_SESSION['unit']) ? $_SESSION['unit'] : '' ?>"></td>
                        </tr>
                        <tr>
                            <td><label>Size</label></td>
                            <td><input type="text" name="size" maxlength="36" size="30" value="<?php echo isset($_SESSION['size']) ? $_SESSION['size'] : '' ?>"></td>
                        </tr>
                </table>
                <br>
                <input type="submit" value="Edit">
                <input type="button" value="Back" onclick="location.href='worksheet.php'">
            </form>
        </div>

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>
