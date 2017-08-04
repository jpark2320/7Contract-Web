<?php 
    if (!$_SESSION == null) {
        session_start(); 
    }
?>
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
            <h3 class="text-center">Edit Worksheet</h3>
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
                                    <td tableHeadData="Description"><input class="textInput" type="text" name="description" size="10"></td>
                                    <td tableHeadData="Qty"><input class="textInput" type="text" name="qty" size="10"></td>
                                    <td tableHeadData="Price"><input class="textInput" type="text" name="price" size="10"></td>
                                    <td colspan="2" align="center"><button type="submit" name="submit">Add</button></td>
                                </tr>
                ';
				if (isset($_SESSION['arr'])) {
					for ($i = 0; $i < sizeof($_SESSION['arr']); $i++) {
						if ($_SESSION['arr'][$i][0] !== null) {
							echo '<tr bgcolor="#c4daff"><td tableHeadData="Description"><div class="lineBreak_desc">'.$_SESSION['arr'][$i][0].'</div></td>';
						}
						if ($_SESSION['arr'][$i][1] !== null) {
							echo '<td tableHeadData="Qty">'.$_SESSION['arr'][$i][1].'</td>';
						}

						if ($_SESSION['arr'][$i][2] !== null) {
							echo '<td tableHeadData="Price">'.$_SESSION['arr'][$i][2].'</td>';
						}
						if ($_SESSION['arr'][$i][0] !== null) {
							echo '<td align="center"><button type="button" onclick="location.href=\'edit_invoice_detail.php?description='.$_SESSION['arr'][$i][0].' &qty='.$_SESSION['arr'][$i][1].' &price='.$_SESSION['arr'][$i][2].' &index='.$i.'\'">Edit</button></td>';
						}
						if ($_SESSION['arr'][$i][0] !== null) {
							echo '<td align="center"><button type="button" onclick="\'edit_invoice_detail.php?index_deleted='.$i.'\'">Delete</button></td></tr>';
						}
					}
				}

                echo '
                            </tbody>
                        </table>
                        <br>
                    </form>
                ';
                unset($_POST);
            ?>
            <form action="edit_process.php" method="POST">

                <table width="30%">
                    <colgroup>
                        <col width="25%">
                        <col width="5%">
                        <col width="70%">
                    </colgroup>
                        <tr>
                            <td align="right"><b>P.O.</b></td>
                            <td></td>
                            <td><input class="editInput" type="text" name="po" value="<?php echo isset($_SESSION['po']) ? $_SESSION['po'] : '' ?>"></td>
                        </tr>
                        <tr>
                            <td align="right"><b>Company</b></td>
                            <td></td>
                            <td><input class="editInput" type="text" name="company" value="<?php echo isset($_SESSION['company']) ? $_SESSION['company'] : '' ?>"></td>
                        </tr>
                        <tr>
                            <td align="right"><b>Apt</b></td>
                            <td></td>
                            <td><input class="editInput" type="text" name="apt" value="<?php echo isset($_SESSION['apt']) ? $_SESSION['apt'] : '' ?>"></td>
                        </tr>
                        <tr>
                            <td align="right"><b>Manager</b></td>
                            <td></td>
                            <td><input class="editInput" type="text" name="manager" value="<?php echo isset($_SESSION['manager']) ? $_SESSION['manager'] : '' ?>"></td>
                        </tr>
                        <tr>
                            <td align="right"><b>Unit #</b></td>
                            <td></td>
                            <td><input class="editInput" type="text" name="unit" value="<?php echo isset($_SESSION['unit']) ? $_SESSION['unit'] : '' ?>"></td>
                        </tr>
                        <tr>
                            <td align="right"><b>Size</b></td>
                            <td></td>
                            <td><input class="editInput" type="text" name="size" value="<?php echo isset($_SESSION['size']) ? $_SESSION['size'] : '' ?>"></td>
                        </tr>
                </table>
                <br>
                <button type="submit">Edit</button>
                <button type="button" onclick="location.href='worksheet.php'">Back</button>
            </form>
        </div>

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>
