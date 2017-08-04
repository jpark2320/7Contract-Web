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
            <h3 class="text-center">Description</h3>
                <?php
                    // connection with mysql database
                    include('./includes/connection.php');
                    if (isset($_GET['id'])) {
                    	$id = $_GET['id'];
                    }  
                    echo '<table width="25%" align="center">
                            <colgroup>
                                <col width="50%">
                                <col width="50%">
                            </colgroup>';
                	echo '
                            <tr>
                                <td align="left"><b>Company : </b></td>
                            	<td align="right">'.$_GET['company'].'</td>
                    		</tr>
                            <tr>
                                <td align="left"><b>Apartment : </b></td>
                                <td align="right">'.$_GET['apt'].'</td>
                            </tr>
                            <tr>
                                <td align="left"><b>Unit # : </b></td>
                                <td align="right">'.$_GET['unit'].'</td>
                            </tr>
                                <td align="left"><b>Size : </b></td>
                            	<td align="right">'.$_GET['size'].'</td>
                    		</tr>
                        </table>
                    ';
                    echo '
                        <table id="ResponsiveTable" border="3" width="100%">
							<colgroup>
								<col width="5%">
                                <col width="10%">
                                <col width="10%">
                                <col width="75%">
                            </colgroup>
                            <thead id="HeadRow">
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

                        $qty = $row['quantity'];
                        if ($qty == null) $qty = '-';

                        $price = $row['price'];
                        if ($price == null) $price = '-';

                        $desc = $row['description'];
                        if ($desc == null) $desc = '-';

                        echo '<tbody>';
                        if ($isOdd) {
                            $isOdd = false;
                            echo '<tr bgcolor="#e8fff1">';
                        } else {
                            $isOdd = true;
                            echo '<tr>';
                        }
                    	echo '        
                                    <td tableHeadData="#" align="center">'.$i.'</td>
                                    <td tableHeadData="Qty" align="center">'.$qty.'</td>
                                    <td tableHeadData="Price" align="center">'.$price.'</td>
                                    <td tableHeadData="Description" align="center"><div class="lineBreak_desc">'.$desc.'</div></td>
                                </tr>
                            </tbody>
                        ';

                    }
                    echo '</table>';
                ?>
                <br>
                <button type="button" onclick="location.href='view_estimate.php'">Back</button>
        </div>

        <!-- Footer -->
        <?php include('./includes/footer.html'); ?>

        <!-- Functions -->
        <?php include('./includes/functions.html'); ?>
    </body>
</html>