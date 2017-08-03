<?php
	session_start();
	date_default_timezone_set('Etc/UTC');
	include('./includes/connection.php');
	require('./FPDF/fpdf.php');
	if (isset($_GET['json'])) {
		$ar = explode("\\", $_GET['json']);
		$company = $ar[0];
		$apt = $ar[1];
		$unit = $ar[2];
		$size = $ar[3];
		$date = $ar[4];
		$n = (int)((count($ar) - 5) / 3);
		$j = 5;
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
		$sql = "INSERT INTO estimate VALUES (null, '$company', '$apt', '$unit', '$size', 0, null, '$date')";
	    $conn->query($sql);
	    $sql = "SELECT MAX(id) FROM estimate";
	    $result = mysqli_query($conn, $sql);
	    $row = mysqli_fetch_array($result);
	    $maxid = $row['MAX(id)'];
	} else {
		echo "<script>alert('somethings wrong');</script>;";
		echo '<script>window.location.href = "worksheet.php";</script>';
	}
    // echo "<script>alert(\"".$maxid."\");</script>;";
    $total = 0;
    // print_r($arr);
	if (isset($arr)) {
		for ($i = 0; $i < count($arr); $i++) {
			// $s = str_replace("\"", "'", $arr[$i][0]);
			$desc = str_replace("\"", "'", $arr[$i][0]);
			if (!empty($arr[$i][1])) {
				$qty = $arr[$i][1];
			} else {
				$qty = 0;
			}
			if (!empty($arr[$i][2])) {
				$price = $arr[$i][2];
			} else {
				$price = 0;
			}
			$sql = "INSERT INTO estimate_description VALUES (null, '$maxid', '$qty', '$price', \"".$desc."\")";
			// echo "<script>alert(\"".$price."\");</script>;";
			$conn->query($sql);
			$total += $price;
		}
	}

	if (isset($arr)) {
		$sql = "UPDATE estimate SET price='$total', description=\"".$arr[0][0]."\" WHERE id='$maxid'";
	}

    $conn->query($sql);
    $conn->close();
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
		    $this->Cell(50, 10,'To: '.$apt);
		    $this->SetFont('Times','',13);
		    $this->SetXY(165,55);
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
			$this->SetXY(3,91);
			$this->SetFont('Times','',12);
			$this->Cell(22, 6, $unit,0,0,'C');
 			$this->MultiCell(25, 6, $size,0,'C');
 			$x = 50;
 			$this->SetXY($x, 91);
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
			$this->SetXY(14, 68);
			$this->SetFont('Times','',11);
			$this->MultiCell(180, 8,'SEVEN CONTRACT, LLC. Process to finish all the labor, equpiments, materials, insurance, all supervision.'
				."\n".'need in order to complete the job list following proposal.',1,'C');
			$this->Ln();
			$this->SetXY(3,85);
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
			$this->MultiCell(180, 8,'The above price, specification, and conditions are satisfactory and herby accepted.'."\n".
				'SEVEN CONTRACT, LLC is authorized to do work specified.'
				."\n".'Payment will be made as outline above.',1,'C');
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
	$filename = $apt."_".$unit;
 	$pdf->Output('I', $filename.'.pdf');

	unset($_SESSION['arr']);
	$_SESSION['i'] = 0;
?>
