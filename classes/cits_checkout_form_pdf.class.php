<?php
ob_start();
require_once("../models/config.php");
require_once("../models/Classes/fpdf17/fpdf.php");
require_once("ipo_bank.class.php");
//if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("luggage.class.php");


	class cits_checkOutForm extends FPDF
	{
			
			public $cp_no;
	       
			protected $luggage;
		

			// Page footer
			function Footer(){
				// Position at 1.5 cm from bottom
				$this->SetY(-15);
				// Arial italic 8
				$this->SetFont('Arial','I',8);
				// Page number
				$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
			}


			function generate_cits_checkOutForm($ipo_cp_no){
				   $ipo = new ipoBankdetails($ipo_cp_no);
				   $this->luggage= new luggageDeclaration($ipo_cp_no);
				   
				// Colors, line width and bold font
					
					$this->Image('../images/latest-build.png',30,10,150);
					// Arial bold 15
					$this->SetFont('Arial','B',15);
					// Move to the right
					$this->Cell(80);
					// Title
					$this->Ln(20);
					$this->Cell(5);
					$this->Cell(0,10,'CHECK-OUT FORM ',10,0,'C');
					// Line break
					$this->Ln(8);
					$this->Cell(0,10,'Communication & Information Technology Section',10,0,'C');
					// Header
					$this->Ln(8);
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
					$w = array(10, 15, 15, 40, 40, 9, 20, 15, 20);

					// Color and font restoration
					$this->SetFillColor(224,235,255);
					$this->SetTextColor(0);
					$this->SetFont('Arial', 'I', 8);
					
					// Data
					$fill = false;
				
			        $this->Ln();
					$this->SetFont('Arial', 'B', 8);
					$this->Cell(20,6,'Names:','LRTB',0,'L',$fill);
					$this->SetFont('Arial', 'I', 8);					
					$this->Cell(90,6,strtoupper($ipo->firstName . ' ' . strtoupper($ipo->lastName)),'LRTB',0,'L',$fill);
					$this->SetFont('Arial', 'B', 8);					
					$this->Cell(35,6,'Date of Arrival','LRTB',0,'L',$fill);	
					$this->SetFont('Arial', 'I', 8);
					$this->Cell(40,6,date('d M Y', strtotime($ipo->doa)),'LRTB',0,'L',$fill);
					$this->Ln();

					$this->SetFont('Arial', 'B', 8);
					$this->Cell(20,6,'ID No.','LRTB',0,'L',$fill);					
					$this->SetFont('Arial', 'I', 8);
					$this->Cell(50,6,strtoupper($ipo_cp_no),'LRTB',0,'L',$fill);
					$this->SetFont('Arial', 'B', 8);					
					$this->Cell(20,6,'Index:','LRTB',0,'L',$fill);	
					$this->SetFont('Arial', 'I', 8);
					$this->Cell(20,6,strtoupper($ipo->indexNo),'LRTB',0,'L',$fill);
					$this->SetFont('Arial', 'B', 8);
					$this->Cell(35,6,'Date of Departure','LRTB',0,'L',$fill);
					$this->SetFont('Arial', 'I', 8);					
					$this->Cell(40,6, date('d M Y', strtotime($ipo->eom))  ,'LRTB',0,'L',$fill);	
					$this->Ln();
					
					$this->SetFont('Arial', 'B', 8);
					$this->Cell(20,6,'Region','LRTB',0,'L',$fill);	
					$this->SetFont('Arial', 'I', 8);					
					$this->Cell(50,6,strtoupper($ipo->position->sector_name),'LRTB',0,'L',$fill);	
					$this->SetFont('Arial', 'B', 8);
					$this->Cell(20,6,'Ext. /Dect No:','LRTB',0,'L',$fill);
					$this->SetFont('Arial', 'I', 8);
					$this->Cell(20,6,'','LRTB',0,'L',$fill);
					$this->SetFont('Arial', 'B', 8);
					$this->Cell(35,6,'Section','LRTB',0,'L',$fill);	
					$this->SetFont('Arial', 'I', 8);					
					$this->Cell(40,6,'CIVPOL','LRTB',0,'L',$fill);					
					$this->Ln();
					
					$this->Cell(185,6, ''  ,'LRTB',0,'L',$fill);	
					$this->Ln();

					$this->SetFont('Arial', 'B', 8);
					$this->Cell(35,6,'Mailing Address:','LRTB',0,'L',$fill);	
					$this->SetFont('Arial', 'I', 8);
					$this->Cell(150,6,$this->luggage->forwarding_address,'LRTB',0,'L',$fill);	
					$this->Ln();

					$this->SetFont('Arial', 'B', 8);
					$this->Cell(35,6,'Call Sign:','LRTB',0,'L',$fill);
					$this->SetFont('Arial', 'I', 8);					
					$this->Cell(150,6,'','LRTB',0,'L',$fill);
					$this->Ln();
					
					$this->SetFont('Arial', 'B', 8);
					$this->Cell(35,6,'Telephone:','LRT',0,'L',$fill);
					$this->SetFont('Arial', 'I', 8);					
					$this->Cell(55,6,'','LRT',0,'L',$fill);
					$this->SetFont('Arial', 'B', 8);
					$this->Cell(20,6,'Email','LRTB',0,'L',$fill);	
					$this->SetFont('Arial', 'I', 8);					
					$this->Cell(75,6,strtolower($ipo->email),'LRTB',0,'L',$fill);					
					$this->Ln();

					
					$this->SetFont('Arial', 'B', 8);
					$this->Cell(35,6,'Date:','LRTB',0,'L',$fill);
					$this->SetFont('Arial', 'I', 8);					
					$this->Cell(55,6,date('d M Y', time()),'LRTB',0,'L',$fill);
					$this->SetFont('Arial', 'B', 8);					
					$this->Cell(20,6,'Signature:','LRB',0,'L',$fill);
					$this->Cell(75,6,'............................','LRB',0,'L',$fill);
					$this->Ln();
					
					
					$this->SetFont('Times', 'BI', 8);
					$this->Cell(0,10,'Please do not forget to bring your handover vouchers.',0,0,'L',$fill);
					$this->Ln();

					$this->SetFont('Arial', 'B', 8);
					$this->Cell(45,6,'OFFICE','LRTB',0,'L',$fill);					
					$this->Cell(45,6,'ITEMS','LRTB',0,'L',$fill);	
					$this->Cell(40,6,'REMARKS','LRTB',0,'L',$fill);				
					$this->Cell(35,6,'SIGNATURE','LRBT',0,'L',$fill);
					$this->Cell(20,6,'Date','LRBT',0,'L',$fill);						
					$this->Ln();

					$this->Cell(45,10,'','LR',0,'L',$fill);					
					$this->SetFont('Times', 'I', 8);
					$this->Cell(45,10,'Disconnect PIN Code','LRBT',0,'L',$fill);	 
					$this->Cell(40,10,'','LRT',0,'L',$fill);				
					$this->Cell(35,10,'','LRT',0,'L',$fill);
					$this->Cell(20,10,'','LRT',0,'L',$fill);					
					$this->Ln();
					$this->SetFont('Arial', 'B', 8);				
					$this->Cell(45,10,'Telephone Billing Unit','LR',0,'L',$fill);					
					$this->SetFont('Times', 'I', 8);
					$this->Cell(45,10,'Outstanding Bills','LRT',0,'L',$fill);	 
					$this->Cell(40,10,'','LRT',0,'L',$fill);				
					$this->Cell(35,10,'','LRT',0,'L',$fill);
					$this->Cell(20,10,'','LRT',0,'L',$fill);					
					$this->Ln();
					
					$this->Cell(45,10,'Counter 5, A-35, Super Camp','LR',0,'L',$fill);					
					$this->SetFont('Times', 'I', 8);
					$this->Cell(45,10,'','LRB',0,'L',$fill);	 
					$this->Cell(40,10,'','LRB',0,'L',$fill);				
					$this->Cell(35,10,'','LRB',0,'L',$fill);
					$this->Cell(20,10,'','LRB',0,'L',$fill);					
					$this->Ln();
					
					$this->Cell(45,10,'','LRB',0,'L',$fill);					
					$this->SetFont('Times', 'I', 8);
					$this->Cell(45,10,'Return of SIM Card','LRBT',0,'L',$fill);	 
					$this->Cell(40,10,'','LRTB',0,'L',$fill);				
					$this->Cell(35,10,'','LRTB',0,'L',$fill);
					$this->Cell(20,10,'','LRTB',0,'L',$fill);					
					$this->Ln();
					
					$this->SetFont('Arial', 'B', 8);
					$this->Cell(45,6,'Radio Callsign','LRT',0,'L',$fill);					
					$this->SetFont('Times', 'I', 8);
					$this->Cell(45,6,'Removal of name from Callsign List','LRT',0,'L',$fill);	 
					$this->Cell(40,6,'','LRT',0,'L',$fill);				
					$this->Cell(35,6,'','LRT',0,'L',$fill);
					$this->Cell(20,6,'','LRT',0,'L',$fill);					
					$this->Ln();
					
					$this->Cell(45,6,'Counter 3, A-35, Super Camp','LRB',0,'L',$fill);
					$this->Cell(45,6,'','LRB',0,'L',$fill);	 
					$this->Cell(40,6,'','LRB',0,'L',$fill);				
					$this->Cell(35,6,'','LRB',0,'L',$fill);
					$this->Cell(20,6,'','LRB',0,'L',$fill);					
					$this->Ln();

					
					$this->SetFont('Arial', 'B', 8);
					$this->Cell(45,6,'Login Account','LRT',0,'L',$fill);					
					$this->SetFont('Times', 'I', 8);
					$this->Cell(45,6,'Windows Login disabled','LRT',0,'L',$fill);	 
					$this->Cell(40,6,'','LRT',0,'L',$fill);				
					$this->Cell(35,6,'','LRT',0,'L',$fill);
					$this->Cell(20,6,'','LRT',0,'L',$fill);					
					$this->Ln();
					
					$this->Cell(45,6,'Counter 4, A-35, Super Camp','LRB',0,'L',$fill);
					$this->Cell(45,6,'','LRB',0,'L',$fill);	 
					$this->Cell(40,6,'','LRB',0,'L',$fill);				
					$this->Cell(35,6,'','LRB',0,'L',$fill);
					$this->Cell(20,6,'','LRB',0,'L',$fill);					
					$this->Ln();

					
					$this->SetFont('Arial', 'B', 8);
					$this->Cell(45,6,'Email Account','LRT',0,'L',$fill);					
					$this->SetFont('Times', 'I', 8);
					$this->Cell(45,6,'Disable for staff leaving UN system','LRT',0,'L',$fill);	 
					$this->Cell(40,6,'','LRT',0,'L',$fill);				
					$this->Cell(35,6,'','LRT',0,'L',$fill);
					$this->Cell(20,6,'','LRT',0,'L',$fill);					
					$this->Ln();
					
					$this->Cell(45,6,'Counter 4, A-35, Super Camp','LRB',0,'L',$fill);
					$this->Cell(45,6,'Grace period - S/M in UN system','LRB',0,'L',$fill);	 
					$this->Cell(40,6,'','LRB',0,'L',$fill);				
					$this->Cell(35,6,'','LRB',0,'L',$fill);
					$this->Cell(20,6,'','LRB',0,'L',$fill);					
					$this->Ln();
					
					$this->SetFont('Arial', 'B', 8);
					$this->Cell(45,6,'Mecury Account','LRT',0,'L',$fill);					
					$this->SetFont('Times', 'I', 8);
					$this->Cell(45,6,'Access disabled','LRT',0,'L',$fill);	 
					$this->Cell(40,6,'','LRT',0,'L',$fill);				
					$this->Cell(35,6,'','LRT',0,'L',$fill);
					$this->Cell(20,6,'','LRT',0,'L',$fill);					
					$this->Ln();
					
					$this->Cell(45,6,'Counter 4, A-35, Super Camp','LRB',0,'L',$fill);
					$this->Cell(45,6,'','LRB',0,'L',$fill);	 
					$this->Cell(40,6,'','LRB',0,'L',$fill);				
					$this->Cell(35,6,'','LRB',0,'L',$fill);
					$this->Cell(20,6,'','LRB',0,'L',$fill);					
					$this->Ln();
					
					$this->SetFont('Arial', 'B', 8);
					$this->Cell(45,6,'Other Applications','LRT',0,'L',$fill);					
					$this->SetFont('Times', 'I', 8);
					$this->Cell(45,6,'Access disabled','LRT',0,'L',$fill);	 
					$this->Cell(40,6,'','LRT',0,'L',$fill);				
					$this->Cell(35,6,'','LRT',0,'L',$fill);
					$this->Cell(20,6,'','LRT',0,'L',$fill);					
					$this->Ln();
					
					$this->Cell(45,6,'Counter 4, A-35, Super Camp','LRB',0,'L',$fill);
					$this->Cell(45,6,'','LRB',0,'L',$fill);	 
					$this->Cell(40,6,'','LRB',0,'L',$fill);				
					$this->Cell(35,6,'','LRB',0,'L',$fill);
					$this->Cell(20,6,'','LRB',0,'L',$fill);					
					$this->Ln();

					
					$this->SetFont('Arial', 'B', 8);
					$this->Cell(45,6,'PABX','LRT',0,'L',$fill);					
					$this->SetFont('Times', 'I', 8);
					$this->Cell(45,6,'Update Telephone Directory','LRT',0,'L',$fill);	 
					$this->Cell(40,6,'','LRT',0,'L',$fill);				
					$this->Cell(35,6,'','LRT',0,'L',$fill);
					$this->Cell(20,6,'','LRT',0,'L',$fill);					
					$this->Ln();
					
					$this->Cell(45,6,'Counter 3, A-35, Super Camp','LRB',0,'L',$fill);
					$this->Cell(45,6,'','LRB',0,'L',$fill);	 
					$this->Cell(40,6,'','LRB',0,'L',$fill);				
					$this->Cell(35,6,'','LRB',0,'L',$fill);
					$this->Cell(20,6,'','LRB',0,'L',$fill);					
					$this->Ln();

					
					$this->SetFont('Arial', 'B', 8);
					$this->Cell(45,6,'CCO / CITU','LRT',0,'L',$fill);					
					$this->SetFont('Times', 'I', 8);
					$this->Cell(45,6,'Final Signature here & on main form','LRT',0,'L',$fill);	 
					$this->Cell(40,6,'','LRT',0,'L',$fill);				
					$this->Cell(35,6,'','LRT',0,'L',$fill);
					$this->Cell(20,6,'','LRT',0,'L',$fill);					
					$this->Ln();
					
					$this->Cell(45,6,'Counter 4, A-35, Super Camp','LRB',0,'L',$fill);
					$this->Cell(45,6,'','LRB',0,'L',$fill);	 
					$this->Cell(40,6,'','LRB',0,'L',$fill);				
					$this->Cell(35,6,'','LRB',0,'L',$fill);
					$this->Cell(20,6,'','LRB',0,'L',$fill);					
					$this->Ln();
					$this->Ln();
					$this->SetFont('Times', 'B', 8);
					$this->Cell(185,4,'NB: Please note that the completion of this check-out procedure'.
									' is without prejudice to the right of the UN to hold you financially '.
									'liable in the future','LRT', 0,'L',$fill);	
					$this->Ln();
					$this->SetFont('Times', 'B', 8);					
					$this->Cell(185,4,'for any loss, damage or any other claim attributable to your service '.
									'with the Mission. Your release is therefore conditional upon the right '.
									'of the UN to ','LR', 0,'L',$fill);										
					
					$this->Ln();
					$this->SetFont('Times', 'B', 8);					
					$this->Cell(185,4,'seek appropriate reimbursement from you or any outstanding obligations attributable to you'.
									' and not immediately ascertained or duly processed ','LR', 0,'L',$fill);	
		
					$this->Ln();
					$this->SetFont('Times', 'B', 8);					
					$this->Cell(185,4,'at the time of your departure from the Mission','LRB', 0,'L',$fill);	
			}
			
			
			
	}


	

?>
