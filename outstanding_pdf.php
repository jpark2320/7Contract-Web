<?php
	session_start();
	date_default_timezone_set('EST');
	require('./FPDF/fpdf.php');

	if (isset($_POST['sub'])) {
		$invoices = $_POST['check'];
		if (!isset($_POST['check'])) {
			echo '<script>alert("You must select at least one checkbox to issue an invoice.")</script>';
			echo '<script>window.location.href = "worksheet_apt.php";</script>';
		}

		$apt = $_SESSION['apt'];
		$i = 0;

		include('./includes/connection.php');
		$arr = array(array());
		foreach ($invoices as $invoice) {
			$invoice = str_replace('7C', '', $invoice);
			$sql = "SELECT * FROM Worksheet WHERE invoice='$invoice';";
			$result = mysqli_query($conn, $sql);

		    while($row = mysqli_fetch_array($result)) {
				$arr[$i][0] = '7C'.$row['invoice'];
				$arr[$i][1] = $row['PO'];
				$arr[$i][2] = substr($row['date'], 5, -9)."-".substr($row['date'], 0, 4);
				$arr[$i][3] = $row['price'];
				$arr[$i][4] = $row['paid'];
			}
			$i++;
		}
		$conn->close();
 	}


	class PDF extends FPDF
	{
		function Header()
		{
			global $apt;
		    $this->Image('./img/7C_Logo.png',3,3,35,35);
		    $this->SetXY(40,6);
		    $this->SetFont('Times','B',40);
		    $this->Cell(160, 20, 'Outstanding Balance', 1, 0,'C');
		    $this->SetFont('Times','B',14);
		    $this->SetXY(70, 25);
		    $this->Cell(50, 10,'Bill to: '.$apt);
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
			$this->Cell(33, 6,'invoice #',1,0,'C');
			$this->Cell(33, 6,'P.O. #',1,0,'C');
			$this->Cell(33, 6,'Date',1,0,'C');
			$this->Cell(35, 6,'Amount',1,0,'C');
			$this->Cell(35, 6,'Total Paid',1,0,'C');
			$this->Cell(35, 6,'Outstanding',1,0,'C');
			$this->Ln();
			$this->SetFont('Times','',12);
			$amount = 0;
			$paid = 0;
			$outstanding = 0;
			for ($i = 0; $i < count($arr); $i++) {
				$this->SetX(3);
				$this->Cell(33, 6, $arr[$i][0],1,0,'C');
				$this->Cell(33, 6, $arr[$i][1],1,0,'C');
				$this->Cell(33, 6, $arr[$i][2],1,0,'C');
				$this->Cell(35, 6, "$ ".number_format((float)$arr[$i][3], 2, '.', ''),1,0,'C');
				$this->Cell(35, 6, "$ ".number_format((float)$arr[$i][4], 2, '.', ''),1,0,'C');
				$this->Cell(35, 6, "$ ".number_format((float)($arr[$i][3] - $arr[$i][4]), 2, '.', ''),1,0,'C');
				$amount += $arr[$i][3];
				$paid += $arr[$i][4];
				$outstanding += $arr[$i][3] - $arr[$i][4];
				$this->Ln();
			}
			$this->SetX(3);
			$this->Cell(99, 6, "",0,0,'C');
			$this->SetFont('Times','B',12);
			$this->Cell(35, 6,'$ '.number_format((float)$amount, 2, '.', ''),1,0,'C');
			$this->Cell(35, 6,'$ '.number_format((float)$paid, 2, '.', ''),1,0,'C');
			$this->Cell(35, 6,'$ '.number_format((float)$outstanding, 2, '.', ''),1,0,'C');
		}


		function LayOut() {
			$this->AddPage();
			$this->DrawTable();
		}
	}

	$pdf = new PDF();
	$pdf->LayOut();
	$filename = $apt."_".date("Y/m/d");
	$pdf->Output('I', $filename.'.pdf');

	unset($_SESSION['invoice']);
	unset($_SESSION['apt']);

?>
