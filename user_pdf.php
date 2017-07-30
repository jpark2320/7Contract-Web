<?php
	session_start();
	date_default_timezone_set('EST');
	require('./FPDF/fpdf.php');
	if ($_POST['sub']) {
		$ids = $_POST['check'];
		if (!isset($_POST['check'])) {
			echo '<script>alert("You must select at least one checkbox to issue an invoice.")</script>';
			echo '<script>window.location.href = "worksheet_apt.php";</script>';
		}

		$i = 0;

		include('./includes/connection.php');
		$arr = array(array());
		foreach ($ids as $id) {
			$sql = "SELECT * FROM user_comment WHERE id='$id';";
			$result = mysqli_query($conn, $sql);
    		$row = mysqli_fetch_array($result);
    		$arr[$i][2] = $row['comment'];
			$arr[$i][3] = $row['salary'];
			$arr[$i][4] = $row['paid'];

			$arr[$i][5] = substr($row['date'], 5, -9)."-".substr($row['date'], 0, 4);
			$invoice = $row['invoice'];
			$sql = "SELECT apt, unit FROM worksheet WHERE invoice='$invoice';";
			$result = mysqli_query($conn, $sql);
    		$row = mysqli_fetch_array($result);
    		$arr[$i][0] = $row['apt'];
    		$arr[$i][1] = $row['unit'];
			$i++;
		}
 	}
 	$username = $_SESSION['user_name'];
	mysqli_close($conn);

	class PDF extends FPDF
	{
		function Header()
		{
			global $username;
		    $this->Image('./img/7C_Logo.png',3,3,35,35);
		    $this->SetXY(40,6);
		    $this->SetFont('Times','B',40);
		    $this->Cell(160, 20, 'Outstanding Balance', 1, 0,'C');
		    $this->SetFont('Times','B',14);
		    $this->SetXY(70, 25);
		    $this->Cell(50, 10,'To: '.$username);
		    $this->SetFont('Times','',13);
		    $this->SetXY(145,45);

		    $this->SetXY(3, 42);
		    $this->SetFont('Times','',11);
		    $this->Cell(50, 6,'2891 Cardinal Lake Dr. Duluth GA 30096');

		    $this->Ln();
		    $this->SetX(3);
		    $this->Cell(50, 6,'Cell: 678-727-3371');
		    $this->Ln();
		    $this->SetX(3);
		    $this->Cell(50, 6,'Email: sevencontract@gmail.com');

		    $this->Ln(50);
		    $this->SetLineWidth(1);
		    $this->Rect(2,2,206,64,'D');
		}

		function DrawTable() {
			global $arr;
			$this->SetXY(3,70);
			$this->SetFont('Times','UB',12);
			$this->Cell(33, 6,'Apartment',1,0,'C');
			$this->Cell(23, 6,'Unit',1,0,'C');
			$this->Cell(72, 6,'Comment',1,0,'C');
			$this->Cell(23, 6,'Salary',1,0,'C');
			$this->Cell(23, 6,'Paid',1,0,'C');
			$this->Cell(23, 6,'Outstanding',1,0,'C');
			$this->Ln();
			$this->SetFont('Times','',12);
			$amount = 0;
			$paid = 0;
			$outstanding = 0;
			for ($i = 0; $i < count($arr); $i++) {
				$this->SetX(3);
				$this->Cell(33, 6, $arr[$i][0],1,0,'C');
				$this->Cell(23, 6, $arr[$i][1],1,0,'C');
				$this->Cell(72, 6, $arr[$i][2],1,0,'C');
				$this->Cell(23, 6, "$ ".number_format($arr[$i][3]),1,0,'C');
				$this->Cell(23, 6, "$ ".number_format($arr[$i][4]),1,0,'C');
				$this->Cell(23, 6, "$ ".number_format(($arr[$i][3] - $arr[$i][4])),1,0,'C');
				$amount += $arr[$i][3];
				$paid += $arr[$i][4];
				$outstanding += $arr[$i][3] - $arr[$i][4];
				$this->Ln();
			}
			$this->SetX(3);
			$this->Cell(128, 6, "",0,0,'C');
			$this->SetFont('Times','B',12);
			$this->Cell(23, 6,'$ '.number_format($amount),1,0,'C');
			$this->Cell(23, 6,'$ '.number_format($paid),1,0,'C');
			$this->Cell(23, 6,'$ '.number_format($outstanding),1,0,'C');
		}


		function LayOut() {
			$this->AddPage();
			$this->DrawTable();
		}
	}

	$pdf = new PDF();
	$pdf->LayOut();
	$filename = $username."_".date("Y/m/d");
	$pdf->Output('I', $filename.'.pdf');

?>
