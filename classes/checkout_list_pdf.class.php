<?php
require_once("../models/Classes/fpdf17/fpdf.php");

	class checkoutListPDF extends FPDF
	{
			public $table_header;
			public $month;
			public $year;
			
			protected $months = array ('', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 
					 'August', 'September', 'October', 'November', 'December');
					 
			// Page header
			function Header(){
				//$this->month = date("m");
				//$this->year= date("Y");
				// Logo
				$this->Image('../images/latest-build.png',30,10,150);
				// Arial bold 15
				$this->SetFont('Arial','B',15);
				// Move to the right
				$this->Cell(80);
				// Title
				$this->Ln(20);
				$this->Cell(5);
				$this->Cell(0,10,'CHECK-OUT LIST FOR THE MONTH OF '. strtoupper($this->months[$this->month]).' '.$this->year,10,0,'C');
				// Line break
				$this->Ln(20);
				// Header
				$this->SetFillColor(224,235,255);
				$this->SetFont('Arial','B',10);
				$w = array(10, 15, 15, 40, 40, 9, 20, 15, 20);
				for($i=0;$i < count($this->table_header); $i++)
					$this->Cell($w[$i],7,$this->table_header[$i],1,0,'L',true);
				$this->Ln();				
			}

			// Page footer
			function Footer(){
				// Position at 1.5 cm from bottom
				$this->SetY(-15);
				// Arial italic 8
				$this->SetFont('Arial','I',8);
				// Page number
				$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
			}


			function FancyTable($data){
				// Colors, line width and bold font
				$this->SetFillColor(255,0,0);
				$this->SetTextColor(255);
				$this->SetDrawColor(128,0,0);
				$this->SetLineWidth(.1);
				$this->SetFont('Arial','B', 10);
				// Header
				//$this->table_header = $header;
				$w = array(10, 15, 15, 40, 40, 9, 20, 15, 20);

				// Color and font restoration
				$this->SetFillColor(224,235,255);
				$this->SetTextColor(0);
				$this->SetFont('Arial', '', 8);
				// Data
				$fill = false;
				
				foreach($data as $row){
					$this->Cell($w[0],6,$row[0],'LRTB',0,'L',$fill);
					$this->Cell($w[1],6,$row[1],'LRTB',0,'L',$fill);
					$this->Cell($w[2],6,$row[2],'LRTB',0,'L',$fill);
					$this->Cell($w[3],6,$row[3],'LRTB',0,'L',$fill);
					$this->Cell($w[4],6,$row[4],'LRTB',0,'L',$fill);
					$this->Cell($w[5],6,$row[5],'LRTB',0,'L',$fill);
					$this->Cell($w[6],6,date('d-m-Y', strtotime($row[6])),'LRTB',0,'L',$fill);
					$this->Cell($w[7],6,$row[7],'LRTB',0,'L',$fill);
					$this->Cell($w[8],6, date('d-m-Y', strtotime($row[8])),'LRTB',0,'L',$fill);					
					$this->Ln();
					$fill = !$fill;
				}
				
				// Closing line
				$this->Cell(array_sum($w),0,'','T');
			}
			
	}
?>