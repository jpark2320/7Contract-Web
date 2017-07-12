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
            <h3 class="text-center">Description</h3><br>
                    <?php
                        // connection with mysql database
                        include('./includes/connection.php');
                        if (isset($_GET['id'])) {
                        	$id = $_GET['id'];
                        }  
                        echo '<table width="200" align="center">
                                <colgroup>
                                    <col width="50%">
                                    <col width="50%">
                                </colgroup>';
                    	echo ' <tr>
                            <td><b>Company : </b></td>
                            	<td>'.$_GET['company'].'</td>
                    		</tr>
                            <tr>
                                <td><b>Apartment : </b></td>
                                <td>'.$_GET['apt'].'</td>
                            </tr>
                            <tr>
                                <td><b>Unit # : </b></td>
                                <td>'.$_GET['unit'].'</td>
                            </tr>
                            <td><b>Size : </b></td>
                            	<td>'.$_GET['size'].'</td>
                    		</tr>
                        </table>
                        <table border="3" width="100%">
							<colgroup>
								<col width="5%">
                                <col width="10%">
                                <col width="10%">
                                <col width="75%">

                            </colgroup>
                            <thead>
                                <tr style="border: 2px double black;" bgcolor="#c9c9c9">
                                    <td align="center"><b>#</b></td>
                                    <td align="center"><b>Quantity</b></td>
                                    <td align="center"><b>Price</b></td>
                                    <td align="center"><b>Description</b></td>
                                </tr>
                            </thead>
	                        ';
                        
                        $sql = "SELECT * FROM estimate_description WHERE estimate_id='$id'";
                        
                        $result = mysqli_query($conn, $sql);
                        $isOdd = false;
                        $i = 0;
                        while($row = mysqli_fetch_array($result))
                        {	
                        	$i++;

                            echo '<tbody>';
                            if ($isOdd) {
                                $isOdd = false;
                                echo '<tr bgcolor="#e8fff1">';
                            } else {
                                $isOdd = true;
                                echo '<tr>';
                            }
                        	echo '<td align="center">'.$i.'</td>
                                        <td align="center">'.$row['quantity'].'</td>
                                        <td align="center">'.$row['price'].'</td>
                                        <td align="center">'.$row['description'].'</td>
                                    </tr>
                                </tbody>
                            ';
	
                        }
                        echo '</table>';
                    ?>
                <br>
            	<input type="button" value="Back" onclick="location.href='view_estimate.php'"></input>

        </div>
        <br><br><br><br><br>

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>