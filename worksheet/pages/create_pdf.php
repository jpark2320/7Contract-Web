<?php
	session_start();
	date_default_timezone_set('Etc/UTC');
	require('./FPDF/fpdf.php');
	$invoice = '7C'.$_SESSION['invoice'];
	if (isset($_GET['json'])) {
		$ar = explode("\\", $_GET['json']);
		if ($ar[0] != '-') {
            $po = $ar[0];
        } else {
            $po = null;
        }
        if ($ar[1] != '-') {
            $company = $ar[1];
        } else {
            $company = null;
        }
        if ($ar[2] != '-') {
            $apt = $ar[2];
        } else {
            $apt = null;
        }
        if ($ar[3] != '-') {
            $unit = $ar[3];
        } else {
            $unit = null;
        }
        if ($ar[4] != '-') {
            $size = $ar[4];
        } else {
            $size = null;
        }

		$date = $ar[5];
		$n = (int)((count($ar) - 6) / 3);
		$j = 6;
		for ($i = 0; $i < $n; $i++) {
			$arr[$i][0] = $ar[$j];
            $j++;
            if ($ar[$j] != '-') {
                $arr[$i][1] = $ar[$j];
            } else {
                $arr[$i][1] = 0;
            }
            $j++;
            if ($ar[$j] != '-') {
                $arr[$i][2] = $ar[$j];
            } else {
                $arr[$i][2] = 0;
            }
            $j++;
		}
	}
	
	class PDF extends FPDF
	{
		function Header()
		{
			global $invoice;
			global $date;
			global $apt;
			global $po;
		    $this->Image('./img/7C_Logo.png',3,3,35,35);
		    $this->SetXY(70,6);
		    $this->SetFont('Times','B',34);
		    $this->Cell(80, 20, 'Invoice', 0, 0,'C');
		    $this->SetFont('Times','B',15);
		    $this->SetXY(70, 25);
		    $this->Cell(50, 10,'Bill to: '.$apt);
		    $this->SetFont('Times','',13);
		    $this->SetXY(165,40);
		    $this->Cell(50, 10,'Invoice: '.$invoice);
		    $this->SetXY(165,46);
		    $this->Cell(50, 10,'P.O: '.$po);
		    $this->SetXY(165,52);
		    $this->Cell(50, 10,'Date: '.substr($date, 5).'-'.substr($date, 0, 4));
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
		    $this->SetLineWidth(.4);
		    $this->Rect(2,2,206,64,'');
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
			$this->SetXY(2,75);
			$this->SetFont('Calibri','',12);
			$this->Cell(22, 6, $unit,0,0,'C');
 			$this->MultiCell(25, 6, $size,0,'C');
 			$x = 49;
 			$this->SetXY($x, 75);
 			$ny = 0;
 			$h = 75;
			for ($i = 0; $i < count($arr); $i++) {
				$py = $this->GetY();
				$this->MultiCell(107, 6, " ".$arr[$i][0],0,'L', false);
 				$y = $this->GetY();
 				$h += $ny;
 				$this->SetXY($x + 107, $h);
 				if ($arr[$i][1] > 0)
 					$this->Cell(17, 6, $arr[$i][1], 0, 0, 'C');
 				else
 					$this->Cell(17, 6, '', 0, 0, 'C');
 				$this->SetXY($x + 124, $h);
 				if ($arr[$i][2] > 0)
 					$this->Cell(35, 6, '$ '.number_format($arr[$i][2], 2), 0, 0, 'C');
 				else
 					$this->Cell(17, 6, '', 0, 0, 'C');
 				$ny = $y - $py;
				$this->total = $arr[$i][2];
				$this->SetXY($x, $y);
			}
		}
		function DrawTable() {
			$this->SetXY(2, 68);

			$this->SetFont('Times','B',12);
			$this->Cell(22, 6,'Unit #',1,0,'C');
			$this->Cell(25, 6,'Size',1,0,'C');
			$this->Cell(107, 6,'Description',1,0,'C');
 			$this->Cell(17, 6,'QTY',1,0,'C');
			$this->Cell(35, 6,'Amount',1,0,'C');
			$this->Ln();
			$this->SetX(2);
			$this->Cell(22, 145,'',1,0,'T');
			$this->Cell(25, 145,'',1,0,'T');
			$this->Cell(107, 145,'',1,0,'T');
 			$this->Cell(17, 145,'',1,0,'T');
			$this->Cell(35, 145,'',1,0,'T');
			$this->Ln();
			$this->SetX(156);
 			$this->Cell(17, 6,'Total:',1,0,'C');
			$this->Cell(35, 6,'$ '.number_format($this->getTotal(), 2),1,0,'C');
			$this->Ln();
 			$this->Ln();
 			$this->SetX(2);
 			$this->SetFont('Times','',12);
 			$this->MultiCell(206, 8,'All payment should be made in 30 days.'."\n".
				'Any balance over 30 days will result in additional late fees or finance charge whichever greater.'
				."\n".'Any past due balance over 60 days will result in legal action including a lien on the property',1,'C');
 			$this->SetXY(2, 265);
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
	$pdf->AddFont('Calibri', '', 'calibri.php');
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
