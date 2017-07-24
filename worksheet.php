<?php
    if(!isset($_SESSION)) {
        session_start();
    }
    $_SESSION['i_pdf'] = 0;
    $_SESSION['i_estm'] = 0;
    $_SESSION['i'] = 0;
    unset($_SESSION['unpaid']);
    unset($_SESSION['arr']);
    unset($_SESSION['estm_arr']);
    unset($_SESSION['edit_arr']);
    unset($_SESSION['pdf_arr']);
?>
<!DOCTYPE html>
<html lang="en">
    <!-- Header Tag -->
    <?php include('./includes/head_tag.html'); ?>
    <body id="myPage">

        <!-- Header -->
        <?php include('./includes/nav_bar.php'); ?>

        <!-- Body -->
        <div class="primary" align="center">
            <h3 class="text-center">Worksheet</h3>

            <?php
				// connection with mysql database
                include('./includes/connection.php');

                include('./includes/data_range.html');

                if (!isset($_SESSION['email'])) {
                    echo "<script>alert(\"You need to sign in first.\");</script>";
                    echo '<script>window.location.href = "signin.php";</script>';
                    exit();
                } else {
					if (isset($_SESSION['isadmin'])) {
						if ($_SESSION['isadmin'] > 0) {
							echo '<div id="btn_worksheet" align="right"><button><a href="view_estimate.php">View Estimate</a></button>
							<button><a href="estimate_info.php">Make Estimate</a></button>
							<button><a href="worksheet_add.php">Add to Worksheet</a></button></div>';

                            echo '<div align="left" text-decoration:none; color:#ff0000;">';

                            if (!isset($_SESSION['sort'])) {
                                $_SESSION['sort'] = 'asc';
                            }
                            if ($_SESSION['sort']=='asc') {
                                echo '<a href="?st=desc">Show descending order</a>';
                            } else {
                                echo '<a href="?st=asc">Show ascending order</a>';
                            }
                            if (isset($_GET['st'])) {
                                $_SESSION['sort'] = $_GET['st'];
                                echo '<script>window.location.href = "worksheet.php";</script>';
                            }

							if ($_SESSION['isadmin'] == 2) {
								echo '<a style="float: right;"href="price_detail.php">Show details</a>';
							}

                            echo '</div>';

							echo '
								<table id="ResponsiveTable" border="3" width="100%">
									<thead id="HeadRow">
										<tr style="border: 2px double black;" bgcolor="#c9c9c9">
											<td align="center"><b><a href="?orderBy=isworkdone">Status</a></b></td>
											<td align="center"><b><a href="?orderBy=invoice">Invoice #</a></b></td>
											<td align="center"><b><a href="?orderBy=po">P.O.</a></b></td>
											<td align="center"><b><a href="?orderBy=company">Company</a></b></td>
											<td align="center"><b><a href="?orderBy=apt">Apt</a></b></td>
											<td align="center"><b><a href="?orderBy=manager">Manager</a></b></td>
											<td align="center"><b><a href="?orderBy=unit">Unit #</a></b></td>
											<td align="center"><b><a href="?orderBy=size">Size</a></b></td>
											<td align="center"><b><a href="?orderBy=price">Price</a></b></td>
											<td align="center"><b>Description</b></td>
											<td align="center"><b><a href="?orderBy=date">Date</a></b></td>
											<td align="center"><b>Assign</b></b></td>
											<td align="center"><b>Edit</b></b></td>
										</tr>
									</thead>
							';
							$orderBy = array('invoice', 'po', 'apt', 'unit', 'size', 'price', 'date', 'isworkdone');
							$order = 'date';
							if (isset($_GET['orderBy']) && in_array($_GET['orderBy'], $orderBy)) {
								$order = $_GET['orderBy'];
							}
							$sql = 'SELECT * FROM Worksheet ';
							if (isset($_POST['year']) && isset($_POST['month'])) {
								if (strlen($_POST['year'])>0 && strlen($_POST['month'])>0) {
									$sql .= "WHERE YEAR(date)=".$_POST['year']." AND MONTH(date)=".$_POST['month']." ";
								} else if (strlen($_POST['year'])>0){
									$sql .= "WHERE YEAR(date)=".$_POST['year']." ";
								}
							}

							$sql .= 'ORDER BY '.$order;
							if ($_SESSION['sort']=='desc') {
								$sql = $sql.' DESC';
							}
							$result = mysqli_query($conn, $sql);

							$isOdd = false;
							while($row = mysqli_fetch_array($result))
							{
								$temp_invoice = '7C'.$row['invoice'];

                                $temp_po = $row['PO'];
                                if ($temp_po == null) $temp_po = '-';

								$temp_company = $row['company'];
                                if ($temp_company == null) $temp_company = '-';

								$temp_apt = $row['apt'];
                                if ($temp_apt == null) $temp_apt = '-';

								$temp_manager = $row['manager'];
                                if ($temp_manager == null) $temp_manager = '-';

								$temp_unit = $row['unit'];
                                if ($temp_unit == null) $temp_unit = '-';

                                $temp_size = $row['size'];
                                if ($temp_size == null) $temp_size = '-';

                                $temp_price = $row['price'];
                                if ($temp_price == null) $temp_price = '-';

                                $temp_description = $row['description'];
                                if ($temp_description == null) $temp_description = '-';

                                $temp_date = $row['date'];
                                if ($temp_date == null) $temp_date = '-';

								echo '<tbody>';
								if ($isOdd) {
									$isOdd = false;
									echo '<tr bgcolor="#e8fff1">';
								} else {
									$isOdd = true;
									echo '<tr>';
								}

								if ($row['isworkdone'] == 2) {
									echo '<td tableHeadData="Status" align="center"><img src="./img/status_light_green" width="10px"></td>';
								} else if ($row['isworkdone'] == 1) {
									echo '<td tableHeadData="Status" align="center"><img src="./img/status_light_yellow" width="10px"></td>';
								} else {
									echo '<td tableHeadData="Status" align="center"><img src="./img/status_light_red" width="10px"></td>';
								}

								echo '
											<td tableHeadData="Invoice #" align="center"><a href="invoice_detail.php?invoice_num='.$temp_invoice.'">'.$temp_invoice.'</a></td>
											<td tableHeadData="P.O." align="center">'.$temp_po.'</td>
											<td tableHeadData="Company" align="center"><a href="worksheet_company.php?company='.$temp_company.'">'.$temp_company.'</a></td>
											<td tableHeadData="Apt" align="center"><a href="worksheet_apt.php?apt='.$temp_apt.'&company='.$row['company'].'">'.$temp_apt.'</a></td>
											<td tableHeadData="Manager" align="center"><a href="worksheet_manager.php?manager='.$temp_manager.'">'.$temp_manager.'</a></td>
											<td tableHeadData="Unit" align="center">'.$temp_unit.'</td>
											<td tableHeadData="Size" align="center">'.$temp_size.'</td>
											<td tableHeadData="Price" align="center">'.$temp_price.'</td>
											<td tableHeadData="Description" align="center"><a href="worksheet_description.php?invoice='.$temp_invoice.'&apt='.$temp_apt.'&unit='.$temp_unit.'&size='.$temp_size.'">'.$temp_description.'</a></td>
											<td tableHeadData="Date" align="center">'.$temp_date.'</td>
											<td tableHeadData="Assign" align="center">
												<button><a href="assign.php?invoice_num='.$temp_invoice.' &apt='.$temp_apt.' &unit_num='.$temp_unit.'">Send</a></button>
											</td>
											<td tableHeadData="Edit" align="center"><button><a href="edit_admin.php?invoice_num='.$temp_invoice.'">Edit</a></button></td>
										</tr>
									</tbody>
								';
							}
							echo '</table>';
						} else {

							include('./includes/sort.php');

							echo '
								<table id="ResponsiveTable" border="2" width="100%">
									<thead id="HeadRow">
										<tr style="border: 2px double black;" bgcolor="#c9c9c9">
											<td align="center"><b><a href="?orderBy=isworkdone">Status</a></b></td>
											<td align="center"><b><a href="?orderBy=apt">Apt</a></b></td>
											<td align="center"><b><a href="?orderBy=unit">Unit #</a></b></td>
											<td align="center"><b>Message</b></td>
											<td align="center"><b><a href="?orderBy=date">Date</a></b></td>
											<td align="center"><b>Comment</b></td>
											<td align="center"><b>Process</b></td>
										</tr>
									</thead>
							';

							$orderBy = array('apt', 'unit', 'date', 'isworkdone');
							$order = 'date';
							if (isset($_GET['orderBy']) && in_array($_GET['orderBy'], $orderBy)) {
								$order = $_GET['orderBy'];
							}
							$sql = 'SELECT * FROM SubWorksheet WHERE email =\''.$_SESSION['email'].'\' ORDER BY '.$order;
							if ($_SESSION['sort']=='desc') {
								$sql = $sql.' DESC';
							}
							$result = mysqli_query($conn, $sql);

							$isOdd = false;
							while($row = mysqli_fetch_array($result))
							{
								$temp2_invoice = $row['invoice'];
								$temp2_email = $row['email'];
								$temp2_id = $row['id'];

                                $temp2_apt = $row['apt'];
                                if ($temp2_apt == null) $temp2_apt = '-';

                                $temp2_unit = $row['unit'];
                                if ($temp2_apt == null) $temp2_apt = '-';

                                $temp2_message = $row['message'];
                                if ($temp2_message == null) $temp2_message = '-';

                                $temp2_date = $row['date'];
                                if ($temp2_date == null) $temp2_date = '-';

								echo '<tbody>';
								if ($isOdd) {
									$isOdd = false;
									echo '<tr bgcolor="#e8fff1">';
								} else {
									$isOdd = true;
									echo '<tr>';
								}

								if ($row['isworkdone'] == 1) {
									echo '<td tableHeadData="Status" lign="center"><img src="./img/status_light_green" width="10px"></td>';
								} else {
									echo '<td tableHeadData="Status" align="center"><img src="./img/status_light_red" width="10px"></td>';
								}

								echo '
											<td tableHeadData="Apt" align="center">'.$temp2_apt.'</td>
											<td tableHeadData="Unit #" align="center">'.$temp2_unit.'</td>
											<td tableHeadData="Message" align="center">'.$temp2_message.'</td>
											<td tableHeadData="Date" align="center">'.$temp2_date.'</td>
											<td tableHeadData="Comment" align="center"><button><a href="show_comment.php?id='.$temp2_id.'&apt='.$temp2_apt.'&unit='.$temp2_unit.'">Show</a></button><button><a href="edit_user.php?id='.$temp2_id.'&invoice='.$temp2_invoice.'">Add</a></button></td>
											<td tableHeadData="Process" align="center"><button id="btn_workdone"><a href="workdone_process.php?invoice_num='.urlencode($temp2_invoice).' &email_user='.urlencode($temp2_email).' &id='.urlencode($temp2_id).'">Work Done</a></button></td>
										</tr>
									</tbody>';
							}
							echo '</table>';
						}
					}
                }
                mysqli_close($conn);
            ?>
        </div>
        <br><br><br><br><br>

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>
