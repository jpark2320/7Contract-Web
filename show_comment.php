<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <!-- Header Tag -->
    <?php include('./includes/head_tag.html'); ?>
    <body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="50">

        <!-- Header -->
        <?php include('./includes/nav_bar.php'); ?>

        <!-- Body -->
        <div class="primary" align="center">
            <h3 class="text-center">Comment</h3><br>
                    <?php
                        // connection with mysql database
                        include('./includes/connection.php');
                        if (isset($_GET['id'])) {
                        	$id = $_GET['id'];
                        	if ($_SESSION['isadmin'] > 0) {
	                        	$email = $_GET['email'];
	                        } else {
	                        	$email = $_SESSION['email'];
	                        }
							if (isset($_GET['username'])) {
								$username = $_GET['username'];
							}
                        }

						if (isset($_SESSION['invoice'])) {
							$invoice = $_SESSION['invoice'];
						}

                        echo '<table width="200" align="center">
                                <colgroup>
                                    <col width="50%">
                                    <col width="50%">
                                </colgroup>';
                        if ($_SESSION['isadmin'] > 0) {
                        	echo ' <tr>
	                            <td><b>Username : </b></td>
	                            <td>'.$username.'</td>
                        	</tr>';
                        	echo ' <tr>
                                    <td><b>Invoice # : </b></td>
                                    <td>'."7C".$_SESSION['invoice'].'</td>
                                </tr>';
                        }
                        echo ' <tr>
                                    <td><b>Apartment : </b></td>
                                    <td>'.$_GET['apt'].'</td>
                                </tr>
                                <tr>
                                    <td><b>Unit # : </b></td>
                                    <td>'.$_GET['unit'].'</td>
                                </tr>
                            </table>';


                        if ($_SESSION['isadmin'] == 2) {
                        	echo '
	                            <table id="ResponsiveTable" border="3" width="100%">
									<colgroup>
	                                    <col width="5%">
	                                    <col width="10%">
	                                    <col width="45%">
	                                    <col width="10%">
	                                    <col width="10%">
	                                    <col width="20%">
	                                    <col width="10%">
	                                    <col width="10%">
	                                </colgroup>
	                                <thead id="HeadRow">
	                                    <tr style="border: 2px double black;" bgcolor="#c9c9c9">
	                                        <td align="center"><b>#</b></td>
	                                        <td align="center"><b>Paid Off</b></td>
	                                        <td align="center"><b>Comment</b></td>
	                                        <td align="center"><b>Salary</b></td>
	                                        <td align="center"><b>Paid</b></td>
	                                        <td align="center"><b>Date</b></td>
	                                        <td align="center"><b>Edit</b></td>
			                                <td align="center"><b>Pay</b></td>
	                                    </tr>
	                                </thead>
	                        ';
                        } else {
	                        echo '
	                            <table id="ResponsiveTable" border="3" width="100%">
	                            	<colgroup>
	                                    <col width="10%">
	                                    <col width="60%">
	                                    <col width="30%">
	                                </colgroup>
	                                <thead id="HeadRow">
	                                    <tr style="border: 2px double black;" bgcolor="#c9c9c9">
	                                        <td align="center"><b>#</b></td>
	                                        <td align="center"><b>Comment</b></td>
	                                        <td align="center"><b>Date</b></td>
	                                    </tr>
	                                </thead>
	                        ';
	                    }

                        $sql = "SELECT * FROM user_comment WHERE sub_id='$id' AND email='$email'";

                        $result = mysqli_query($conn, $sql);
                        $isOdd = false;
                        $i = 0;
                        while($row = mysqli_fetch_array($result))
                        {
                        	$i++;

                            $comment = $row['comment'];
                            if ($comment == null) $comment = '-';

                            $salary = $row['salary'];
                            if ($salary == null) $salary = '-';

                            $paid = $row['paid'];
                            if ($paid == null) $paid = '-';

                            $date = $row['date'];
                            if ($date == null) $date = '-';

                            echo '<tbody>';
                            if ($isOdd) {
                                $isOdd = false;
                                echo '<tr bgcolor="#e8fff1">';
                            } else {
                                $isOdd = true;
                                echo '<tr>';
                            }
                            if ($_SESSION['isadmin'] == 2) {
                            	echo '<td tableHeadData="#" align="center">'.$i.'</td>';
	                            if ($row['ispaidoff'] == 1) {
	                                echo '<td tableHeadData="Status" align="center"><img src="./img/status_light_green" width="10px"></td>';
	                            } else {
	                                echo '<td tableHeadData="Status" align="center"><img src="./img/status_light_red" width="10px"></td>';
	                            }
	                            echo '
	                                        <td tableHeadData="Comment" align="center">'.$comment.'</td>
	                                        <td tableHeadData="Salary" align="center">'.$salary.'</td>
	                                        <td tableHeadData="Paid" align="center">'.$paid.'</td>
	                                        <td tableHeadData="Date" align="center">'.$date.'</td>
			                                <td tableHeadData="Edit" align="center"><button><a href="pedit.php?id='.$row['id'].' &comment='.urlencode($comment).'&username='.$username.'">Edit</a></button></td>
                                ';
                                
								echo '<td tableHeadData="Pay" align="center"><button><a href="pay.php?id='.$row['id'].'&salary='.$salary.' &comment='.urlencode($comment).'&username='.urlencode($username).'&paid='.$paid.'">Pay</a></button></td>';

								echo '
	                                    </tr>
	                                </tbody>
	                            ';
	                        } else {
	                            echo '
	                            			<td tableHeadData="#" align="center">'.$i.'</td>
	                                        <td tableHeadData="Comment" align="center">'.$comment.'</td>
	                                        <td tableHeadData="Date" align="center">'.$date.'</td>
	                                    </tr>
	                                </tbody>
	                            ';
	                        }
                        }
                        echo '</table>';
                    ?>
                <br>
                <?php if($_SESSION['isadmin'] > 0): ?>
                    <input type="button" value="Back" onclick="location.href='invoice_detail.php'"></input>
                <?php else: ?>
                	<input type="button" value="Back" onclick="location.href='worksheet.php'"></input>
                <?php endif ?>
        </div>
        <br><br><br><br><br>

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>
