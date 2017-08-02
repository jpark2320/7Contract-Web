<?php 
    if (!isset($_SESSION))
        session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <!-- Header Tag -->
    <?php include('./includes/head_tag.html'); ?>
    <body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="50">

        <!-- Header -->
        <?php include('./includes/nav_bar.php'); ?>

        <!-- Body -->
        <div class="primary" align="center">
            <h3 class="text-center">User History</h3>
            	
            <?php
				include('./includes/connection.php');

                include('./includes/data_range.html');

				$email = $_SESSION['user_email'];
				$username = $_SESSION['user_name'];
                echo '
                    <table width="25%" align="center">
                        <colgroup>
                            <col width="50%">
                            <col width="50%">
                        </colgroup> 
                        <tr>
                            <td align="left"><b>Username : </b></td>
                            <td align="right">'.$username.'</td>
                    	</tr>
                    	<tr>
                            <td align="left"><b>Email : </b></td>
                            <td align="right">'.$email.'</td>
                        </tr>
                	</table>
                ';

                include('./includes/sort.php');
                
                echo '
                    <table id="ResponsiveTable" border="3" width="100%">
						<colgroup>
							<col width="5%">
                            <col width="5%">
                            <col width="10%">
                            <col width="40%">
                            <col width="10%">
                            <col width="10%">
                            <col width="20%">
                        </colgroup>
                        <thead id="HeadRow">
                            <tr style="border: 2px double black;" bgcolor="#c9c9c9">
                            	<td align="center"><b>Select</b></td>
                                <td align="center"><b>#</b></td>
                                <td align="center"><b>Paid Off</b></td>
                                <td align="center"><b>Comment</b></td>
                                <td align="center"><b>Salary</b></td>
                                <td align="center"><b>Paid</b></td>
                                <td align="center"><b>Date</b></td>
                            </tr>
                        </thead>
                ';
                
                $sql = "SELECT * FROM user_comment WHERE email='$email' ";
                if (isset($year)) $year = $_POST['year'];
                if (isset($month)) $month = $_POST['month'];
                if (isset($week)) {
                    $week = $_POST['week'] * 7 + 1;
                    $week_end = $week + 6;
                }
                if (isset($year) && isset($month) && isset($week)) {
                    $q = "AND date BETWEEN '".$year."-".$month."-".$week." 00:00:00' AND '".$year."-".$month."-".$week_end." 23:59:59'";
                }
                if (isset($year) && isset($month) && isset($week)) {
                    if (strlen($_POST['year'])>0 && strlen($_POST['month'])>0 && strlen($_POST['week'])>0) {
                        $sql .= $q;
                    } else if (strlen($_POST['year'])>0 && strlen($_POST['month'])>0) {
                        $sql .= "AND YEAR(date)=".$_POST['year']." AND MONTH(date)=".$_POST['month']." ";
                    } else if (strlen($_POST['year'])>0){
                        $sql .= "AND YEAR(date)=".$_POST['year']." ";
                    }
                }
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

                    echo '
                        <form action="user_pdf.php" method="post">
                            <tbody>
                    ';
                    if ($isOdd) {
                        $isOdd = false;
                        echo '<tr bgcolor="#e8fff1">';
                    } else {
                        $isOdd = true;
                        echo '<tr>';
                    }
                	echo '
                    		<td tableHeadData="Select" align="center">
                                <input type="checkbox" name="check[]" value="'.$row['id'].'">
                            </td>
                            <td tableHeadData="#" align="center">'.$i.'</td>';
                    if ($row['ispaidoff'] == 1) {
                        echo '<td tableHeadData="Paid Off" align="center"><img src="./img/status_light_green" width="10px"></td>';
                    } else {
                        echo '<td tableHeadData="Paid Off" align="center"><img src="./img/status_light_red" width="10px"></td>';
                    }
                    echo '

                                <td tableHeadData="Comment" align="center">'.$comment.'</td>
                                <td tableHeadData="Salary" align="center">'.$salary.'</td>
                                <td tableHeadData="Paid" align="center">'.$paid.'</td>
                                <td tableHeadData="Date" align="center">'.$date.'</td>
                            </tr>
                        </tbody>
                    ';
                }
                echo '</table>';
            ?>
            <br>
            <button type="submit" name="sub">Make PDF</button>
            <button type="button" onclick="location.href='invoice_detail.php'">Back</button>
            </form>

        </div>
        <br><br><br><br><br>

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>