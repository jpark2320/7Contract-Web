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
            <h3 class="text-center">User History</h3><br>
            	<form action="" method="post">
			<p>
		        Select Year/Month
		        <select id="year" name="year">
		            <option value="">Year</option>
		            <option value="2017">2017</option>
		            <option value="2018">2018</option>
		            <option value="2019">2019</option>
		            <option value="2020">2020</option>
		            <option value="2021">2021</option>
		            <option value="2022">2022</option>
		        </select>
		        <select id="month" name="month">
		            <option value="">Month</option>
		            <option value="01">Jan</option>
		            <option value="02">Feb</option>
		            <option value="03">Mar</option>
		            <option value="04">Apr</option>
		            <option value="05">May</option>
		            <option value="06">June</option>
		            <option value="07">July</option>
		            <option value="08">Aug</option>
		            <option value="09">Sep</option>
		            <option value="10">Oct</option>
		            <option value="11">Nov</option>
		            <option value="12">Dec</option>
		        </select>
		        <select id="week" name="week">
		            <option value="">Week</option>
		            <option value="00">1st</option>
		            <option value="01">2nd</option>
		            <option value="02">3rd</option>
		            <option value="03">4th</option>
		            <option value="04">5th</option>
		        </select>
				<input type="submit" value="Go!"/>
		    </p>
		</form>
                    <?php
						include("./includes/connection.php");
						$email = $_SESSION['user_email'];
						$username = $_SESSION['user_name'];
                        echo '<table width="250" align="center">
                                <colgroup>
                                    <col width="50%">
                                    <col width="50%">
                                </colgroup> 
	                            <tr>
		                            <td><b>Username : </b></td>
		                            <td>'.$username.'</td>
	                        	</tr>
	                        	<tr>
                                    <td><b>Email : </b></td>
                                    <td>'.$email.'</td>
                                </tr>
                        	</table>
                            <table border="3" width="100%">
								<colgroup>
									<col width="5%">
                                    <col width="5%">
                                    <col width="10%">
                                    <col width="40%">
                                    <col width="10%">
                                    <col width="10%">
                                    <col width="20%">
                                </colgroup>
                                <thead>
                                    <tr style="border: 2px double black;" bgcolor="#c9c9c9">
                                    	<td align="center"><b></b></td>
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
                        // echo "<script>alert(\"".$sql."\");</script>";
                        while($row = mysqli_fetch_array($result))
                        {	
                        	$i++;

                            echo '
                            <form action="user_pdf.php" method="post"><tbody>';
                            if ($isOdd) {
                                $isOdd = false;
                                echo '<tr bgcolor="#e8fff1">';
                            } else {
                                $isOdd = true;
                                echo '<tr>';
                            }
                        	echo '
                    
	                        		<td align="center">
		                                <input type="checkbox" name="check[]" value="'.$row['id'].'">
		                            </td>
		                            <td align="center">'.$i.'</td>';
                            if ($row['ispaidoff'] == 1) {
                                echo '<td align="center"><img src="./img/status_light_green" width="10px"></td>';
                            } else {
                                echo '<td align="center"><img src="./img/status_light_red" width="10px"></td>';
                            }
                            echo '

                                        <td align="center">'.$row['comment'].'</td>
                                        <td align="center">'.$row['salary'].'</td>
                                        <td align="center">'.$row['paid'].'</td>
                                        <td align="center">'.$row['date'].'</td>
                                    </tr>
                                </tbody>
                            ';
                        }
                        echo '</table>';
                    ?>
                <br>
                <input type="submit" name="sub" value="Make PDF"></input>
                <input type="button" value="Back" onclick="location.href='invoice_detail.php'"></input>
                </form>

        </div>
        <br><br><br><br><br>

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>