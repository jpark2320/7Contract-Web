<?php
	session_start();
	date_default_timezone_set('Etc/UTC');
	require('./FPDF/fpdf.php');
	$invoice = '7C'.$_SESSION['invoice'];
	$po = $_SESSION['po_pdf'];
	$apt = $_SESSION['apt_pdf'];
	$unit = $_SESSION['unit_pdf'];
	$size = $_SESSION['size_pdf'];
	$arr = $_SESSION['pdf_arr'];
	if (isset($_POST['date'])) {
		$_SESSION['date_pdf'] = $_POST['date'];
	}

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
		    $this->Cell(50, 10,'Date: '.substr($_SESSION['date_pdf'], 5).'-'.substr($_SESSION['date_pdf'], 0, 4));
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
			$this->Cell(22, 6, $unit,0,0,'C');
 			$this->MultiCell(25, 6, $size,0,'C');
 			$x = 50;
 			$this->SetXY($x, 76);
			for ($i = 0; $i < count($arr); $i++) {
				$y = $this->GetY();
				$this->MultiCell(104, 6, " ".$arr[$i][0],0,'L', false);
 				$this->SetXY($x + 104, $y);
 				$this->Cell(17, 6, $arr[$i][1], 0, 0, 'C');
 				$this->Cell(35, 6, '$ '.number_format($arr[$i][2]), 0, 0, 'C');
				$this->total = $arr[$i][2];
				$this->SetXY($x, $y + 6);
			}
		}
		function DrawTable() {
			$this->SetXY(3,70);
			$this->SetFont('Times','B',12);
			$this->Cell(22, 6,'Unit #',1,0,'C');
			$this->Cell(25, 6,'Size',1,0,'C');
			$this->Cell(104, 6,'Description',1,0,'C');
 			$this->Cell(17, 6,'QTY',1,0,'C');
			$this->Cell(35, 6,'Amount',1,0,'C');
			$this->Ln();
			$this->SetX(3);
			$this->Cell(22, 130,'',1,0,'T');
			$this->Cell(25, 130,'',1,0,'T');
			$this->Cell(104, 130,'',1,0,'T');
 			$this->Cell(17, 130,'',1,0,'T');
			$this->Cell(35, 130,'',1,0,'T');
			$this->Ln();
			$this->SetX(154);
 			$this->Cell(17, 6,'Total:',1,0,'C');
			$this->Cell(35, 6,'$ '.number_format($this->getTotal()),1,0,'C');
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

		function LayOut() {
			$this->AddPage();
			$this->DrawTable();
			$this->InsertInput();
		}
	}

	$pdf = new PDF();
	$pdf->LayOut();
	$filename = $apt.'_'.$invoice;
	$pdf->Output('I', substr($filename, 0, -1).'.pdf');

	unset($_SESSION['po_pdf']);
	unset($_SESSION['apt_pdf']);
	unset($_SESSION['unit_pdf']);
	unset($_SESSION['size_pdf']);
	unset($_SESSION['pdf_arr']);
	unset($_SESSION['date_pdf']);
	$_SESSION['i'] = 0;

?>
