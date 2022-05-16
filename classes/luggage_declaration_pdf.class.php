<?php
ob_start();
require_once("../models/config.php");
require_once("../models/Classes/fpdf17/fpdf.php");
require_once("ipo.class.php");
//if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("luggage.class.php");


	class luggageDeclarationPDF extends FPDF
	{
			
      
			protected $luggage;
		    protected $ipo;
			protected $description_array;
			// Page footer
			function Footer(){
				// Position at 1.5 cm from bottom
				$this->SetY(-15);
				// Arial italic 8
				$this->SetFont('Arial','I',8);
				// Page number
				$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
			}


			function generate_declaration($ipo_cp_no){
				   $this->luggage= new luggageDeclaration($ipo_cp_no);
				   $this->ipo = new ipo($ipo_cp_no);
				   $this->description_array = array();
				  //echo "<pre>";
				  //print_r($this->ipo);
				// Colors, line width and bold font
					$declaration = "I hereby declare that the luggage so described above is my property". 
									" and does not contain any contraband,";
                    $declaration2="illegal or prohibited items.";
					$this->Image('../images/latest-build.png',30,10,150);
					// Arial bold 15
					$this->SetFont('Arial','B',15);
					// Move to the right
					$this->Cell(80);
					// Title
					$this->Ln(20);
					$this->Cell(5);
					$this->Cell(0,10,'LUGGAGE DECLARATION FORM',10,0,'C');
					// Line break
					$this->Ln(8);
					// Header
					$this->SetFillColor(224,235,255);
					$this->SetFont('Arial','B',10);
					
					$this->Ln();						
					$this->SetFillColor(255,0,0);
					$this->SetTextColor(255);
					$this->SetDrawColor(128,0,0);
					$this->SetLineWidth(.5);
					$this->SetFont('Arial','B', 10);
					// Header
					//$this->table_header = $header;
		     		// Color and font restoration
					$this->SetFillColor(224,235,255);
					$this->SetTextColor(0);
					$fill = false;
			        $this->Ln();
					$this->SetFont('Arial', 'B', 10);
					$this->Cell(35,6,'Name:','LRTB',0,'L',$fill);
					$this->SetFont('Times', 'I', 10);					
					$this->Cell(80,6,strtoupper($this->ipo->firstName. ' ' . $this->ipo->lastName),'LRTB',0,'L',$fill);
					$this->SetFont('Arial', 'B', 10);
					$this->Cell(35,6,'Index Number:','LRTB',0,'L',$fill);					
					$this->SetFont('Times', 'I', 10);
					$this->Cell(35,6,$this->ipo->indexNo,'LRTB',0,'L',$fill);					
					$this->Ln();

					$this->SetFont('Arial', 'B', 10);
					$this->Cell(35,6,'Duty Station:','LRTB',0,'L',$fill);
					$this->SetFont('Times', 'I', 10);
					//echo "<pre>";
					//print_r($this->ipo->position);
					$this->Cell(50,6,$this->ipo->position->sector_name,'LRTB',0,'L',$fill);
					$this->SetFont('Arial', 'B', 10);
					$this->Cell(35,6,'CP Number','LRTB',0,'L',$fill);					
					$this->SetFont('Times', 'I', 10);
					$this->Cell(65,6,strtoupper($ipo_cp_no),'LRTB',0,'L',$fill);					
					$this->Ln();	

					$this->SetFont('Arial', 'B', 10);
					$this->Cell(35,6,'Travel From:','LRTB',0,'L',$fill);
					$this->SetFont('Times', 'I', 10);					
					$this->Cell(50,6,'KHARTOUM','LRTB',0,'L',$fill);
					$this->SetFont('Arial', 'B', 10);
					$this->Cell(35,6,'To:','LRTB',0,'L',$fill);					
					$this->SetFont('Times', 'I', 10);
					$this->Cell(65,6,strtoupper($this->luggage->destination_name),'LRTB',0,'L',$fill);					
					$this->Ln();					

					$this->SetFont('Arial', 'B', 10);
					$this->Cell(35,6,'Date of Travel:','LRTB',0,'L',$fill);
					$this->SetFont('Times', 'I', 10);					
					$this->Cell(80,6,date("d M Y", strtotime($this->luggage->travel_date)),'LRTB',0,'L',$fill);
					$this->SetFont('Arial', 'B', 10);
					$this->Cell(35,6,'Country:','LRTB',0,'L',$fill);					
					$this->SetFont('Times', 'I', 8);
					$this->Cell(35,6,strtoupper($this->luggage->country),'LRTB',0,'L',$fill);					
					$this->Ln();

					$this->SetFont('Arial', 'B', 10);
					$this->Cell(185,6,'Brief Luggage Description:','LRT',0,'L',$fill);
					$this->Ln();
					
					$this->SetFont('Times', 'I', 10);
					$length = strlen($this->luggage->luggage_description);
					
					
					$lines = ( $length > 91) ? 
								(intval($length/91) >  $length/91) ?  ($length/91) + 1 : $length/91
							 : 1;
					$start = 0;
					
					for($x = 0; $x <= $lines; $x++){
						$this->description_array[] =  substr($this->luggage->luggage_description, $start, 91);
						$start += 91;
					}
					
					$this->Cell(185,6,'','LR',0,'L',$fill);
					$this->Ln();
					
					foreach($this->description_array as $description){
						$this->Cell(185,6,strtoupper($description),'LR',0,'L',$fill);
						$this->Ln();
					}
			
					$this->Cell(185,6,'','LRB',0,'L',$fill);
					$this->Ln();
					$this->SetFont('Arial', 'B', 10);
					$this->Cell(185,6,'','LRT',0,'L',$fill);					
					$this->Ln();
					$this->Cell(185,6,$declaration,'LR',0,'L',$fill);					
					$this->Ln();
					$this->Cell(185,6,$declaration2,'LR',0,'L',$fill);					
					$this->Ln();
					$this->Cell(185,6,'','LRB',0,'L',$fill);					
					$this->Ln();
					$this->Cell(185,6,'','LRT',0,'L',$fill);					
					$this->Ln();
					$this->Cell(185,6,'Signature: ........................................................','LR',0,'L',$fill);					
					$this->Ln();
					$this->SetFont('Times', 'I', 10);
					$this->Cell(185,6,'                          ' . date("d F Y", time()),'LRB',0,'L',$fill);
					
					$this->Ln();
									
					$this->SetFont('Arial', 'B', 10);
					$this->Cell(185,6,'Contact Information After Departure:','LRT',0,'L',$fill);					
					$this->Ln();
					$this->Cell(185,6,'','LR',0,'L',$fill);					
					$this->Ln();
					$this->SetFont('Times', 'BI', 10);
					$this->Cell(15,6,'Phone: ','L',0,'L',$fill);
					$this->SetFont('Times', 'I', 10);
					$this->Cell(75,6,'+260968449830 ','',0,'L',$fill);

					$this->SetFont('Times', 'BI', 10);
					$this->Cell(10,6,'Fax: ','',0,'L',$fill);
					$this->SetFont('Times', 'I', 10);
					$this->Cell(85,6,'+260968449830 ','R',0,'L',$fill);	
					
					$this->Ln();
					$this->SetFont('Times', 'BI', 10);
					$this->Cell(15,6,'Email: ','L',0,'L',$fill);
					$this->SetFont('Times', 'I', 10);
					$this->Cell(170,6,'+260968449830 ','R',0,'L',$fill);
					$this->Ln();
					$this->Cell(185,6,'','LRB',0,'L',$fill);
					$this->Ln();
					$this->SetFont('Times', 'I', 8);
					$this->Cell(170,6,'Note: This form must always be attached to your MOP while on travel.','',0,'L',$fill);
					
			}
			
			
			
	}


	

?>
