<?php
	session_start();
	date_default_timezone_set('Etc/UTC');
	require('./FPDF/fpdf.php');
	// $invoice = $_GET['invoice'];
	// $po = $_GET['po'];
	// $apt = $_GET['apt'];
	// $arr = $_GET['arr'];
	// $unit = $_GET['unit'];
	// $size = $_GET['size'];
	// $arr = $_GET['arr'];
	$invoice = '7C1122';
	$po = '1011527';
	$apt = 'Jasmine Winters';
	$unit = '121';
	$size = '2x2';
	$arr = array(array());
	$arr[0][0] = "This is going to be long line because I need to test how it is going to perform hahahahaha I don't think so.";
	$arr[0][1] = 1;
	$arr[0][2] = 1000;
	$arr[1][0] = "This is going to be lorform hahahahaha I don't think so.";
	$arr[1][1] = 12;
	$arr[1][2] = 120;
	$arr[2][0] = "This is going to be long line because I need to test how it is going to perform hahahahaha I don't think so.";
	$arr[2][2] = 10000;
	class PDF extends FPDF
	{
		function Header()
		{
			global $invoice;
			global $po;
			global $apt;
		    $this->Image('./img/7C_Logo.png',3,3,35,35);
		    $this->SetXY(70,6);
		    $this->SetFont('Times','B',40);
		    $this->Cell(80, 20, 'INVOICE', 1, 0,'C');
		    $this->SetFont('Times','B',14);
		    $this->SetXY(70, 25);
		    $this->Cell(50, 10,'Bill to: '.$apt);
		    $this->SetFont('Times','',13);
		    $this->SetXY(145,35);
		    $this->Cell(50, 10,'Date: '.date("Y-m-d"));
		    $this->Ln();
		    $this->SetX(137);
		    $this->Cell(50, 10,'Invoice #: '.$invoice);
		    $this->Ln();
		    $this->SetX(145);
		    $this->Cell(50, 10,'PO #: '.$po);
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
				$this->SetXY($x, $y + 24);
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
			$this->Ln();
			$this->Ln();
			$this->SetX(14);
			$this->SetFont('Times','',12);
			$this->MultiCell(180, 8,'All payment should be made in 30 days.'."\n".
				'Any balance over 30 days will result in additional late fees or finance charge whichever greater.'
				."\n".'Any past due balance over 60 days will result in legal action including a lien on the property',1,'C');
			$this->Ln();
			$this->Ln();
			$this->SetFont('Times','U', 12);
			$this->SetX(30);
			$this->Cell(80, 5,'                                                              ',0,0,'C');
			$this->Cell(80, 5,'                                 ',0,0,'C');
			$this->Ln();
			$this->SetX(30);
			$this->SetFont('Times','', 12);
			$this->Cell(80, 5,'Authorized Signature',0,0,'C');
			$this->Cell(80, 5,'Date',0,0,'C');



		} 

		// Page footer
		function Footer()
		{
		    $this->SetY(-15);
		    $this->SetFont('Arial','I',8);
		    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
		}

		function LayOut() {
			$this->AddPage();
			$this->DrawTable();
			$this->InsertInput();
		}
	}

	$pdf = new PDF();
	$pdf->LayOut();
	$pdf->Output();
?>