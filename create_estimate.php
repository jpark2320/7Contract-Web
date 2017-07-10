<?php
	session_start();
	require('./FPDF/fpdf.php');

	$apt = $_POST['apt'];
	$unit = $_POST['unit'];
	$size = $_POST['size'];
	$date = $_POST['date'];
	$arr = $_SESSION['estm_arr'];

	class PDF extends FPDF
	{
		function Header()
		{
			global $date;
			global $apt;
		    $this->Image('./img/7C_Logo.png',3,3,35,35);
		    $this->SetXY(70,6);
		    $this->SetFont('Times','B',40);
		    $this->Cell(80, 20, 'Estimate', 1, 0,'C');
		    $this->SetFont('Times','B',14);
		    $this->SetXY(70, 25);
		    $this->Cell(50, 10,'Bill to: '.$apt);
		    $this->SetFont('Times','',13);
		    $this->SetXY(145,35);
		    $this->Cell(50, 10,'Date: '.$date);
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
		function getTotal() {
			global $arr;
			$total = 0;
			for ($i = 0; $i < count($arr); $i++) {
				$total += $arr[$i][2];
			}
			return $total;
		}
		function InsertInput() {
			global $unit;
			global $size;
			global $arr;
			$this->SetXY(3,76);
			$this->SetFont('Times','',12);
			$this->Cell(25, 6, $unit,0,0,'C');
			$this->Cell(25, 6, $size,0,0,'C');
			$x = 53;
			for ($i = 0; $i < count($arr); $i++) {
				$y = $this->GetY();
				$this->MultiCell(98, 6, $arr[$i][0],0,'C');
				$this->SetXY($x + 98, $y);
				$this->Cell(20, 6, $arr[$i][1], 0, 0, 'C');
				$this->Cell(35, 6, '$ '.number_format((float)$arr[$i][2], 2, '.', ''), 0, 0, 'C');
				$this->total = $arr[$i][2];
				$this->SetXY($x, $y + 12);
			}
		}
		function DrawTable() {
			$this->SetXY(3,70);
			$this->SetFont('Times','B',12);
			$this->Cell(25, 6,'Unit #',1,0,'C');
			$this->Cell(25, 6,'Size',1,0,'C');
			$this->Cell(98, 6,'Description',1,0,'C');
			$this->Cell(20, 6,'QTY',1,0,'C');
			$this->Cell(35, 6,'Amount',1,0,'C');
			$this->Ln();
			$this->SetX(3);
			$this->Cell(25, 130,'',1,0,'T');
			$this->Cell(25, 130,'',1,0,'T');
			$this->Cell(98, 130,'',1,0,'T');
			$this->Cell(20, 130,'',1,0,'T');
			$this->Cell(35, 130,'',1,0,'T');
			$this->Ln();
			$this->SetX(151);
			$this->Cell(20, 6,'Total:',1,0,'C');
			$this->Cell(35, 6,'$ '.number_format((float)$this->getTotal(), 2, '.', ''),1,0,'C');


		}

		function LayOut() {
			$this->AddPage();
			$this->DrawTable();
			$this->InsertInput();
		}
	}

	$pdf = new PDF();
	$pdf->LayOut();
	$filename = "Estimate_".$apt;
	$pdf->Output('I', substr($filename, 0, -1).'.pdf');

	unset($_SESSION['arr']);
	$_SESSION['i'] = 0;
?>
