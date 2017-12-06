<?php
	session_start();
	date_default_timezone_set('Etc/UTC');
	include('./includes/connection.php');
	// define('./FPDF/font','./font/');
	require('./FPDF/fpdf.php');
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
		$sql = "INSERT INTO estimate VALUES (0, null, \"".$company."\", \"".$apt."\", '$po', \"".$unit."\", \"".$size."\", 0, null, '$date')";
	    $conn->query($sql);
	    $sql = "SELECT MAX(id) FROM estimate";
	    $result = mysqli_query($conn, $sql);
	    $row = mysqli_fetch_array($result);
	    $maxid = $row['MAX(id)'];
	    $sort = $maxid * -1;
	    $sql = "UPDATE estimate SET sort = '$sort' WHERE id = '$maxid'";
	    $conn->query($sql);
	} else {
		echo "<script>alert('somethings wrong');</script>;";
		echo '<script>window.location.href = "worksheet.php";</script>';
	}
	
    $total = 0;
	if (isset($arr)) {
		for ($i = 0; $i < count($arr); $i++) {
			// $s = str_replace("\"", "'", $arr[$i][0]);
			$desc = str_replace("\"", "'", $arr[$i][0]);
			// $arr[$i][0] = substr($arr[$i][0], 28, -6);
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
			global $po;
		    $this->Image('./img/7C_Logo.png',3,3,35,35);
		    $this->SetXY(70,6);
		    $this->SetFont('Times','B',34);
		    $this->Cell(80, 20, 'Estimate', 0, 0,'C');
		    $this->SetFont('Times','B',15);
		    $this->SetXY(70, 25);
		    $this->Cell(50, 10,'Bill to: '.$apt);
		    $this->SetXY(165,46);
		    $this->SetFont('Times','',13);
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
			$this->SetXY(2,93);
			$this->SetFont('Calibri','',12);
			$this->Cell(22, 6, $unit,0,0,'C');
 			$this->MultiCell(25, 6, $size,0,'C');
 			$x = 49;
 			$this->SetXY($x, 93);
 			$ny = 0;
 			$h = 93;
			for ($i = 0; $i < count($arr); $i++) {
				$py = $this->GetY();
				$this->MultiCell(107, 6, $arr[$i][0],0,'L', false);
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
 			$this->SetFont('Times','',11);
 			$this->MultiCell(206, 8,'SEVEN CONTRACT, LLC. Process to finish all the labor, equpiments, materials, insurance, all supervision'
 				."\n".'need in order to complete the job list following proposal.',1,'C');
 			$this->Ln();
 			$this->SetXY(2,86);
			$this->SetFont('Times','B',12);
			$this->Cell(22, 6,'Unit #',1,0,'C');
			$this->Cell(25, 6,'Size',1,0,'C');
			$this->Cell(107, 6,'Description',1,0,'C');
 			$this->Cell(17, 6,'QTY',1,0,'C');
			$this->Cell(35, 6,'Amount',1,0,'C');
			$this->Ln();
			$this->SetX(2);
			$this->Cell(22, 130,'',1,0,'T');
			$this->Cell(25, 130,'',1,0,'T');
			$this->Cell(107, 130,'',1,0,'T');
 			$this->Cell(17, 130,'',1,0,'T');
			$this->Cell(35, 130,'',1,0,'T');
			$this->Ln();
			$this->SetX(156);
 			$this->Cell(17, 6,'Total:',1,0,'C');
			$this->Cell(35, 6,'$ '.number_format($this->getTotal(), 2),1,0,'C');
			$this->Ln();
 			$this->Ln();
 			$this->SetX(2);
 			$this->SetFont('Times','',12);
 			$this->MultiCell(206, 8,'The above price, specification, and conditions are satisfactory and herby accepted.
 				SEVEN CONTRACT, LLC is authorized to do work specified.'
 				."\n".'Payment will be made as outline above.',1,'C');
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
	$filename = $apt."_".$unit;
 	$pdf->Output('I', $filename.'.pdf');

	unset($_SESSION['arr']);
	$_SESSION['i'] = 0;
?>
