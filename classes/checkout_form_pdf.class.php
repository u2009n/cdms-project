<?php
ob_start();
require_once("../models/config.php");
require_once("../models/Classes/fpdf17/fpdf.php");
require_once("ipo_bank.class.php");
//if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("luggage.class.php");


	class checkOutForm extends FPDF
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


			function generate_checkOutForm($ipo_cp_no){
				   $ipo = new ipoBankdetails($ipo_cp_no);
				   $this->luggage= new luggageDeclaration($ipo_cp_no);
				   $xy=array();
                   $xy1=array();
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
					$w = array(10, 15, 15, 40, 40, 9, 20, 15, 20);

					// Color and font restoration
					$this->SetFillColor(224,235,255);
					$this->SetTextColor(0);
					$this->SetFont('Arial', 'I', 8);
					$this->Cell(0,10,'Note: Before commencing the Check-Out process, please read the check-out instructions properly',10,0,'C');
					// Data
					$fill = false;
				
			        $this->Ln();
					$this->SetFont('Arial', 'B', 8);
					$this->Cell(35,6,'Name:','LRTB',0,'L',$fill);
					$this->SetFont('Arial', 'I', 8);					
					$this->Cell(50,6,strtoupper($ipo->firstName),'LRTB',0,'L',$fill);
					$this->SetFont('Arial', 'I', 8);
					$this->Cell(50,6,'','LRTB',0,'L',$fill);
					$this->SetFont('Arial', 'I', 8);
					//echo "<pre>";
					//print_r($ipo->position);
					$this->Cell(50,6,strtoupper($ipo->lastName),'LRTB',0,'L',$fill);
					$this->Ln();
					
					$this->Cell(35,6,'','LRTB',0,'L',$fill);
					$this->Cell(50,6,'(First Name)','LRTB',0,'C',$fill);
					$this->Cell(50,6,'(Middle Name)','LRTB',0,'C',$fill);
					$this->Cell(50,6,'(Last Name)','LRTB',0,'C',$fill);
					$this->Ln();

					$this->SetFont('Arial', 'B', 8);
					$this->Cell(35,6,'ID No.','LRTB',0,'L',$fill);					
					$this->SetFont('Arial', 'I', 8);
					$this->Cell(25,6,strtoupper($ipo_cp_no),'LRTB',0,'L',$fill);
					$this->SetFont('Arial', 'B', 8);					
					$this->Cell(25,6,'Index:','LRTB',0,'L',$fill);	
					$this->SetFont('Arial', 'I', 8);
					$this->Cell(25,6,strtoupper($ipo->indexNo),'LRTB',0,'L',$fill);
					$this->SetFont('Arial', 'B', 8);					
					$this->Cell(35,6,'DOA','LRTB',0,'L',$fill);	
					$this->SetFont('Arial', 'I', 8);
					$this->Cell(40,6,date('d M Y', strtotime($ipo->doa)),'LRTB',0,'L',$fill);	
					$this->Ln();
					
					$this->SetFont('Arial', 'B', 8);
					$this->Cell(75,6,'Last Day/Date on Duty: COB','LRTB',0,'L',$fill);	
					$this->SetFont('Arial', 'I', 8);
					$this->Cell(35,6,date('d M Y', strtotime($ipo->eom)),'LRTB',0,'L',$fill);	
					$this->SetFont('Arial', 'B', 8);
					$this->Cell(35,6,'Date of Departure','LRTB',0,'L',$fill);
					$this->SetFont('Arial', 'I', 8);					
					$this->Cell(40,6, date('d M Y', strtotime($ipo->eom))  ,'LRTB',0,'L',$fill);	
					$this->Ln();

					$this->SetFont('Arial', 'B', 8);
					$this->Cell(55,6,'Type of Seperation','LRTB',0,'L',$fill);
					$this->SetFont('Arial', 'I', 8);					
					$this->Cell(55,6,'Check Out','LRTB',0,'L',$fill);	
					$this->SetFont('Arial', 'B', 8);
					$this->Cell(35,6,'Section/Location','LRTB',0,'L',$fill);
					$this->SetFont('Arial', 'I', 6);					
					$this->Cell(40,6,strtoupper($ipo->position->sector_name),'LRTB',0,'L',$fill);	
					$this->Ln();

					$this->SetFont('Arial', 'B', 8);
					$this->Cell(55,6,'Ext. /Dect No:','LRTB',0,'L',$fill);
					$this->SetFont('Arial', 'I', 8);					
					$this->Cell(35,6,'','LRTB',0,'L',$fill);	
					$this->SetFont('Arial', 'B', 8);
					$this->Cell(35,6,'Email:','LRTB',0,'L',$fill);	
					$this->SetFont('Arial', 'I', 8);
					$this->Cell(60,6,strtolower($ipo->email),'LRTB',0,'L',$fill);	
					$this->Ln();

					$this->SetFont('Arial', 'B', 8);
					$this->Cell(55,6,'Call Sign:','LRTB',0,'L',$fill);
					$this->SetFont('Arial', 'I', 8);					
					$this->Cell(35,6,'','LRTB',0,'L',$fill);	
					$this->SetFont('Arial', 'B', 8);
					$this->Cell(35,6,'Signature:','LRT',0,'L',$fill);
					$this->SetFont('Arial', 'I', 8);					
					$this->Cell(60,6,'','LRT',0,'L',$fill);	
					$this->Ln();

					
					$this->SetFont('Arial', 'B', 8);
					$this->Cell(55,6,'Date:','LRTB',0,'L',$fill);
					$this->SetFont('Arial', 'I', 8);					
					$this->Cell(35,6,date('d M Y', time()),'LRTB',0,'L',$fill);		
					$this->Cell(35,6,'','LRB',0,'L',$fill);
					$this->Cell(60,6,'','LRB',0,'L',$fill);
					$this->Ln();
					$this->SetFont('Arial', 'B', 8);
					$this->Cell(55,6,'Forwarding Address','LRTB',0,'L',$fill);
					$this->SetFont('Arial', 'I', 8);
					/***********************************************************************/
					$this->Cell(130,6,$this->luggage->forwarding_address,'LRTB',0,'L',$fill);			
					$this->Ln();	
					
					$this->SetFont('Arial', 'B', 8);
					$this->Cell(55,6,'Supervisor','LRT',0,'L',$fill);
					$this->SetFont('Arial', 'I', 8);					
					$this->Cell(50,6,'','LRT',0,'L',$fill);
					$this->SetFont('Arial', 'B', 8);					
					$this->Cell(35,6,'Signature','LRT',0,'L',$fill);
					$this->Cell(45,6,'', 'LRT',0,'L',$fill);					
					$this->Ln();
		
					$this->Cell(55,6,'','LRB',0,'L',$fill);					
					$this->Cell(50,6,'','LRB',0,'L',$fill);				
					$this->Cell(35,6,'','LRB',0,'L',$fill);
					$this->Cell(45,6,'......................................................','LRB',0,'L',$fill);					
					$this->Ln();
					
					$this->Cell(0,10,'(For military and police personnel signature of CMPO/ CPAO required)',0,0,'C');	
					//$this->Ln();
					$this->Ln();
					$this->SetFont('Arial', 'B', 10);					
					$this->Cell(0,10,'                PLEASE DO NOT FORGET TO CARRY YOUR HANDOVER NOTES WITH YOU.',0,0,'C');	
					$this->Ln();

					$this->SetFont('Arial', 'B', 8);
					$this->Cell(45,6,'OFFICE/SECTION/UNIT','LRTB',0,'L',$fill);					
					$this->Cell(45,6,'Description','LRTB',0,'L',$fill);	
					$this->Cell(40,6,'Remarks','LRTB',0,'L',$fill);				
					$this->Cell(35,6,'Signature','LRBT',0,'L',$fill);
					$this->Cell(20,6,'Date','LRBT',0,'L',$fill);						
					$this->Ln();

					$this->Cell(45,6,'1. Staff Member\'s Supervisor','LRT',0,'L',$fill);					
					$this->SetFont('Times', 'I', 8);
					$this->Cell(45,6,'(i) Performance Report','LR',0,'L',$fill);	
					$this->Cell(40,6,'','LRT',0,'L',$fill);				
					$this->Cell(35,6,'','LRT',0,'L',$fill);
					$this->Cell(20,6,'','LRT',0,'L',$fill);					
					$this->Ln();
					$this->Cell(45,6,'','LRB', 0,'L',$fill);					
					$this->Cell(45,6,'(ii) Hand-Over Notes','LRB',0,'L',$fill);	
					$this->Cell(40,6,'','LRB',0,'L',$fill);				
					$this->Cell(35,6,'','LRB',0,'L',$fill);
					$this->Cell(20,6,'','LRB',0,'L',$fill);
					
					$this->Ln();
					$this->SetFont('Arial', 'B', 8);
					$this->Cell(45,6,'2. Transport Section','LRT', 0,'L',$fill);
					$this->SetFont('Times', 'I', 8);					
					$this->Cell(45,6,'(i) Return of Vehicle','LRT',0,'L',$fill);	
					$this->Cell(40,6,'','LRT',0,'L',$fill);				
					$this->Cell(35,6,'','LRT',0,'L',$fill);
					$this->Cell(20,6,'','LRT',0,'L',$fill);
					$this->Ln();
					
					$this->SetFont('Times', 'I', 8);					
					$this->Cell(45,6,'(Room 7 FVIU Block, W/Shop.','LR', 0,'L',$fill);					
					$this->Cell(45,6,'(ii) Return of Drive\'s Permit','LR',0,'L',$fill);	
					$this->Cell(40,6,'','LR',0,'L',$fill);				
					$this->Cell(35,6,'','LR',0,'L',$fill);
					$this->Cell(20,6,'','LR',0,'L',$fill);
					$this->Ln();
					
					$this->SetFont('Times', 'I', 8);					
					$this->Cell(45,6,'ISS Compound.','LR', 0,'L',$fill);					
					$this->Cell(45,6,'(iiI) DDRs','LR',0,'L',$fill);	
					$this->Cell(40,6,'','LR',0,'L',$fill);				
					$this->Cell(35,6,'','LR',0,'L',$fill);
					$this->Cell(20,6,'','LR',0,'L',$fill);
					$this->Ln();
					
					$this->SetFont('Times', 'I', 8);					
					$this->Cell(45,6,'','LRB', 0,'L',$fill);					
					$this->Cell(45,6,'(iv) Liberty Mileage','LRB',0,'L',$fill);	
					$this->Cell(40,6,'','LRB',0,'L',$fill);				
					$this->Cell(35,6,'','LRB',0,'L',$fill);
					$this->Cell(20,6,'','LRB',0,'L',$fill);
					//$fill = !$fill;
					
					$this->Ln();				
					$this->SetFont('Arial', 'B', 8);
					$this->Cell(45,6,'3. Engineering Section','LRT', 0,'L',$fill);
					$this->SetFont('Times', 'I', 8);					
					$this->Cell(45,6,'(i) Return of Assets','LRT',0,'L',$fill);	
					$this->Cell(40,6,'','LRT',0,'L',$fill);				
					$this->Cell(35,6,'','LRT',0,'L',$fill);
					$this->Cell(20,6,'','LRT',0,'L',$fill);
					$this->Ln();
					
					$this->SetFont('Times', 'I', 8);					
					$this->Cell(45,6,'(Room 2, Winston Yard, Super Camp','LR', 0,'L',$fill);					
					$this->Cell(45,6,'','LR',0,'L',$fill);	
					$this->Cell(40,6,'','LR',0,'L',$fill);				
					$this->Cell(35,6,'','LR',0,'L',$fill);
					$this->Cell(20,6,'','LR',0,'L',$fill);
					$this->Ln();
					
					$this->SetFont('Times', 'I', 8);					
					$this->Cell(45,6,'Opposite Cease FIre Commission','LRB', 0,'L',$fill);					
					$this->Cell(45,6,'','LRB',0,'L',$fill);	
					$this->Cell(40,6,'','LRB',0,'L',$fill);				
					$this->Cell(35,6,'','LRB',0,'L',$fill);
					$this->Cell(20,6,'','LRB',0,'L',$fill);
		
					$this->Ln();				
					$this->SetFont('Arial', 'B', 8);
					$this->Cell(45,6,'4. Supply Section','LRT', 0,'L',$fill);
					$this->SetFont('Times', 'I', 8);					
					$this->Cell(45,6,'(i) Return of Flack Jacket/ Helmet','LRT',0,'L',$fill);	
					$this->Cell(40,6,'','LRT',0,'L',$fill);				
					$this->Cell(35,6,'','LRT',0,'L',$fill);
					$this->Cell(20,6,'','LRT',0,'L',$fill);
					$this->Ln();
					
					$this->SetFont('Times', 'I', 8);					
					$this->Cell(45,6,'Supply Warehouse, Super Camp','LR', 0,'L',$fill);					
					$this->Cell(45,6,'(ii) return of non expendable items','LR',0,'L',$fill);	
					$this->Cell(40,6,'','LR',0,'L',$fill);				
					$this->Cell(35,6,'','LR',0,'L',$fill);
					$this->Cell(20,6,'','LR',0,'L',$fill);
					$this->Ln();
					
					$this->SetFont('Times', 'I', 8);					
					$this->Cell(45,6,'Opposite Egypt Eng. Signal COY','LRB', 0,'L',$fill);					
					$this->Cell(45,6,'','LRB',0,'L',$fill);	
					$this->Cell(40,6,'','LRB',0,'L',$fill);				
					$this->Cell(35,6,'','LRB',0,'L',$fill);
					$this->Cell(20,6,'','LRB',0,'L',$fill);
					$this->Ln();				
			
					$this->SetFont('Arial', 'B', 8);
					$this->Cell(45,6,'5. Asset Management Unit','LRT', 0,'L',$fill);
					$this->SetFont('Times', 'I', 8);					
					$this->Cell(45,6,'(i) Return of CITS equipment','LRT',0,'L',$fill);	
					$this->Cell(40,6,'','LRT',0,'L',$fill);				
					$this->Cell(35,6,'','LRT',0,'L',$fill);
					$this->Cell(20,6,'','LRT',0,'L',$fill);
					$this->Ln();
					$this->SetFont('Times', 'I', 8);					
					$this->Cell(45,6,'Room A35 Super Camp','LRB', 0,'L',$fill);					
					$this->Cell(45,6,'','LRB',0,'L',$fill);	
					$this->Cell(40,6,'','LRB',0,'L',$fill);				
					$this->Cell(35,6,'','LRB',0,'L',$fill);
					$this->Cell(20,6,'','LRB',0,'L',$fill);
					

					$this->Ln();				
					$this->SetFont('Arial', 'B', 8);
					$this->Cell(45,6,'6. Best Practices Unit','LRT', 0,'L',$fill);
					$this->SetFont('Times', 'I', 8);					
					$this->Cell(45,6,'(i) Exit Interview & Survey','LRT',0,'L',$fill);	
					$this->Cell(40,6,'','LRT',0,'L',$fill);				
					$this->Cell(35,6,'','LRT',0,'L',$fill);
					$this->Cell(20,6,'','LRT',0,'L',$fill);
					$this->Ln();
					
					$this->SetFont('Times', 'I', 8);					
					$this->Cell(45,6,'Office of the Chief of Staff','LR', 0,'L',$fill);					
					$this->Cell(45,6,'(ii) End of Assignment Report','LR',0,'L',$fill);	
					$this->Cell(40,6,'','LR',0,'L',$fill);				
					$this->Cell(35,6,'','LR',0,'L',$fill);
					$this->Cell(20,6,'','LR',0,'L',$fill);
					$this->Ln();
					
					$this->SetFont('Times', 'I', 8);					
					$this->Cell(45,6,'Block 2, Floor 1 Room 4','LR', 0,'L',$fill);					
					$this->Cell(45,6,'Applicable to P-5 and Above. UNPOL/ ','LR',0,'L',$fill);	
					$this->Cell(40,6,'','LR',0,'L',$fill);				
					$this->Cell(35,6,'','LR',0,'L',$fill);
					$this->Cell(20,6,'','LR',0,'L',$fill);
					$this->Ln();
					$this->SetFont('Times', 'I', 8);					
					$this->Cell(45,6,'Super Camp','LRB', 0,'L',$fill);					
					$this->Cell(45,6,'MILOBs, Section/Unit Head & Chiefs','LRB',0,'L',$fill);	
					$this->Cell(40,6,'','LRB',0,'L',$fill);				
					$this->Cell(35,6,'','LRB',0,'L',$fill);
					$this->Cell(20,6,'','LRB',0,'L',$fill);
					$this->Ln();
					$this->SetFont('Arial', 'B', 8);					
					$this->Cell(185,6,'7. General Services Section','LRBT', 0,'L',$fill);

					$this->Ln();				
					$this->SetFont('Arial', 'B', 8);
					$this->Cell(45,6,'Facility Management Unit','LRT', 0,'L',$fill);
					$this->SetFont('Times', 'I', 8);					
					$this->Cell(45,6,'(i) Accomodation Clearance','LRT',0,'L',$fill);	
					$this->Cell(40,6,'','LRT',0,'L',$fill);				
					$this->Cell(35,6,'','LRT',0,'L',$fill);
					$this->Cell(20,6,'','LRT',0,'L',$fill);
					$this->Ln();
					
					$this->SetFont('Times', 'I', 8);					
					$this->Cell(45,6,'E1 Super Camp','LRB', 0,'L',$fill);					
					$this->Cell(45,6,'','LRB',0,'L',$fill);	
					$this->Cell(40,6,'','LRB',0,'L',$fill);				
					$this->Cell(35,6,'','LRB',0,'L',$fill);
					$this->Cell(20,6,'','LRB',0,'L',$fill);
					$this->Ln();
					$this->Ln();
					
					$this->SetFont('Arial', 'B', 8);
					$this->Cell(45,6,'PCIU Unit','LRT', 0,'L',$fill);
					$this->SetFont('Times', 'I', 8);					
					$this->Cell(45,6,'(i) Clearance of all assets','LRT',0,'L',$fill);	
					$this->Cell(40,6,'','LRT',0,'L',$fill);				
					$this->Cell(35,6,'','LRT',0,'L',$fill);
					$this->Cell(20,6,'','LRT',0,'L',$fill);
					$this->Ln();
					
					$this->SetFont('Times', 'I', 8);					
					$this->Cell(45,6,'A6, PMS Compound, Super Camp','LR', 0,'L',$fill);					
					$this->Cell(45,6,'(ii) Removal of name from GALILEO','LR',0,'L',$fill);	
					$this->Cell(40,6,'','LR',0,'L',$fill);				
					$this->Cell(35,6,'','LR',0,'L',$fill);
					$this->Cell(20,6,'','LR',0,'L',$fill);
					$this->Ln();
					
					$this->SetFont('Times', 'I', 8);					
					$this->Cell(45,6,'','LRB', 0,'L',$fill);					
					$this->Cell(45,6,'(iii) Deactivation of GALILEO roles','LRB',0,'L',$fill);	
					$this->Cell(40,6,'','LRB',0,'L',$fill);				
					$this->Cell(35,6,'','LRB',0,'L',$fill);
					$this->Cell(20,6,'','LRB',0,'L',$fill);
					$this->Ln();
					
					$this->SetFont('Arial', 'B', 8);
					$this->Cell(45,6,'LPSB Unit','LRT', 0,'L',$fill);
					$this->SetFont('Times', 'I', 8);					
					$this->Cell(45,6,'(i) Clearance of outstanding claims','LRT',0,'L',$fill);	
					$this->Cell(40,6,'','LRT',0,'L',$fill);				
					$this->Cell(35,6,'','LRT',0,'L',$fill);
					$this->Cell(20,6,'','LRT',0,'L',$fill);
					$this->Ln();
					
					$this->SetFont('Times', 'I', 8);					
					$this->Cell(45,6,'F3, Super Camp','LRB', 0,'L',$fill);					
					$this->Cell(45,6,'','LRB',0,'L',$fill);	
					$this->Cell(40,6,'','LRB',0,'L',$fill);				
					$this->Cell(35,6,'','LRB',0,'L',$fill);
					$this->Cell(20,6,'','LRB',0,'L',$fill);
					$this->Ln();
					
					$this->SetFont('Arial', 'B', 8);
					$this->Cell(45,6,'8. Security Section','LRT', 0,'L',$fill);
					$this->SetFont('Times', 'I', 8);					
					$this->Cell(45,6,'(i) Return ID Card','LRT',0,'L',$fill);	
					$this->Cell(40,6,'','LRT',0,'L',$fill);				
					$this->Cell(35,6,'','LRT',0,'L',$fill);
					$this->Cell(20,6,'','LRT',0,'L',$fill);
					$this->Ln();
					
					$this->SetFont('Times', 'I', 8);					
					$this->Cell(45,6,'ID Unit- E15, ARC Compound','LR', 0,'L',$fill);					
					$this->Cell(45,6,'(ii) Outstanding Investigations (SIU)','LR',0,'L',$fill);	
					$this->Cell(40,6,'','LR',0,'L',$fill);				
					$this->Cell(35,6,'','LR',0,'L',$fill);
					$this->Cell(20,6,'','LR',0,'L',$fill);
					$this->Ln();
					
					$this->SetFont('Times', 'I', 8);					
					$this->Cell(45,6,'Tracking Unit - L12, Super Camp','LR', 0,'L',$fill);					
					$this->Cell(45,6,'(iii) Tracking Unit','LR',0,'L',$fill);	
					$this->Cell(40,6,'','LR',0,'L',$fill);				
					$this->Cell(35,6,'','LR',0,'L',$fill);
					$this->Cell(20,6,'','LR',0,'L',$fill);
					$this->Ln();		
					
					$this->SetFont('Times', 'I', 8);					
					$this->Cell(45,6,'SIU - A9 Super Camp','LRB', 0,'L',$fill);					
					$this->Cell(45,6,'','LRB',0,'L',$fill);	
					$this->Cell(40,6,'','LRB',0,'L',$fill);				
					$this->Cell(35,6,'','LRB',0,'L',$fill);
					$this->Cell(20,6,'','LRB',0,'L',$fill);
					$this->Ln();

					$this->SetFont('Arial', 'B', 8);
					$this->Cell(45,6,'9. Military/Police Monitoring Unit','LRT', 0,'L',$fill);
					$this->SetFont('Times', 'I', 8);					
					$this->Cell(45,6,'(i) Attendance Records & Final MSA','LRT',0,'L',$fill);	
					$this->Cell(40,6,'','LRT',0,'L',$fill);				
					$this->Cell(35,6,'','LRT',0,'L',$fill);
					$this->Cell(20,6,'','LRT',0,'L',$fill);
					$this->Ln();
					
					$this->SetFont('Times', 'I', 8);					
					$this->Cell(45,6,'H7, Super  Camp','LRB', 0,'L',$fill);					
					$this->Cell(45,6,'','LRB',0,'L',$fill);	
					$this->Cell(40,6,'','LRB',0,'L',$fill);				
					$this->Cell(35,6,'','LRB',0,'L',$fill);
					$this->Cell(20,6,'','LRB',0,'L',$fill);
					$this->Ln();
					
					$this->SetFont('Arial', 'B', 8);
					$this->Cell(45,6,'10. Human Resource Section','LRT', 0,'L',$fill);
					$this->SetFont('Times', 'I', 8);					
					$this->Cell(45,6,'(i) Attendance Records & MSA','LRT',0,'L',$fill);	
					$this->Cell(40,6,'','LRT',0,'L',$fill);				
					$this->Cell(35,6,'','LRT',0,'L',$fill);
					$this->Cell(20,6,'','LRT',0,'L',$fill);
					$this->Ln();
					
					$this->SetFont('Times', 'I', 8);					
					$this->Cell(45,6,'Super Camp, Block 12, Floor 1 ','LR', 0,'L',$fill);					
					$this->Cell(45,6,'(ii) Pension Matters (if applicable)','LR',0,'L',$fill);	
					$this->Cell(40,6,'','LR',0,'L',$fill);				
					$this->Cell(35,6,'','LR',0,'L',$fill);
					$this->Cell(20,6,'','LR',0,'L',$fill);
					$this->Ln();						
					
					$this->SetFont('Times', 'I', 8);					
					$this->Cell(45,6,'- International Staff','LR', 0,'L',$fill);					
					$this->Cell(45,6,'(iii) Return of UNLP (If Applicable)','LR',0,'L',$fill);	
					$this->Cell(40,6,'','LR',0,'L',$fill);				
					$this->Cell(35,6,'','LR',0,'L',$fill);
					$this->Cell(20,6,'','LR',0,'L',$fill);
					$this->Ln();
                    
                    
					$this->SetFont('Times', 'I', 8);					
					$this->Cell(45,6,'Super Camp A3, A5, B2, B3, B5 ','LR', 0,'L',$fill);
                    
                    /**************************************************************************/
                    $xy = array($this->GetX(), $this->GetY());
                   
                    $this->Cell(45,6,'','LR',0,'L',$fill);
                    $this->Cell(40,6,'','LR',0,'L',$fill);				
					$this->Cell(35,6,'','LR',0,'L',$fill);
					$this->Cell(20,6,'','LR',0,'L',$fill);
					$this->Ln();
					$this->SetFont('Times', 'I', 8);					
					$this->Cell(45,6,'- National Staff','LR', 0,'L',$fill);
                    $this->Cell(45,6,'(iiv)Mission Service Seperation Form','LR',0,'L',$fill);	
					$this->Cell(40,6,'','LR',0,'L',$fill);
					$this->Cell(35,6,'','LR',0,'L',$fill);
                    $this->Cell(20,6,'','LR',0,'L',$fill);
					$this->Ln();	
                    $this->Cell(45,6,'','LRB',0,'L',$fill);
                    $this->Cell(45,6,'   (if applicable)','LRB',0,'L',$fill);	
					$this->Cell(40,6,'','LR',0,'L',$fill);	
                    $this->Cell(35,6,'','LR',0,'L',$fill);	
                    $this->Cell(20,6,'','LR',0,'L',$fill);	
                    $this->Ln();	
					$this->SetFont('Arial', 'B', 8);
                    
                    
                    /************************************************************************************/
                    $xy1 = array($this->GetX(), $this->GetY());
                    $this->SetY($xy[1]+2);
                    $this->SetX($xy[0]+10);
                    
                    
                    $this->Cell(4,3,'','LRTB', 0,'L',$fill);
                    $this->Cell(5,3,'YES','', 0,'L',$fill);
                    $this->Cell(10,6,'','', 0,'L',$fill);
                    $this->Cell(4,3,'','LRTB', 0,'L',$fill);
                    $this->Cell(5,3,'NO','', 0,'L',$fill);
                    
                    $this->SetY($xy1[1]);
                    $this->SetX($xy1[0]);
                    
					$this->Cell(45,6,'11. Finance Section','LRT', 0,'L',$fill);
					$this->SetFont('Times', 'I', 8);					
					$this->Cell(45,6,'(i) Bank Transfer','LRT',0,'L',$fill);	
					$this->Cell(40,6,'','LRT',0,'L',$fill);				
					$this->Cell(35,6,'','LRT',0,'L',$fill);
					$this->Cell(20,6,'','LRT',0,'L',$fill);
					$this->Ln();
					
					$this->SetFont('Times', 'I', 8);					
					$this->Cell(45,6,'Super  Camp, Block 8, Floor 1','LRB', 0,'L',$fill);					
					$this->Cell(45,6,'','LRB',0,'L',$fill);	
					$this->Cell(40,6,'','LRB',0,'L',$fill);				
					$this->Cell(35,6,'','LRB',0,'L',$fill);
					$this->Cell(20,6,'','LRB',0,'L',$fill);
					$this->Ln();	

					$this->SetFont('Arial', 'B', 10);
					$this->Cell(0,10,'BANK DETAILS',10,0,'L');
					$this->Ln();
					$this->SetFont('Arial', 'B', 10);
					$this->Cell(25,10,'Bank Name: ',10,0,'L');
					$this->SetFont('Times', 'IU', 10);
					$this->Cell(80,10,strtoupper($ipo->bank_name),0,0,'L');

					$this->SetFont('Arial', 'B', 10);
					$this->Cell(30,10,'Branch Name: ',10,0,'L');
					$this->SetFont('Times', 'IU', 10);
					$this->Cell(50,10,strtoupper($ipo->branch_name),10,0,'L');
					$this->Ln();
					
					$this->SetFont('Arial', 'B', 10);
					$this->Cell(35,10,'Branch Address: ',10,0,'L');
					$this->SetFont('Times', 'IU', 10);
					$this->Cell(150,10,strtoupper($ipo->branch_address),10,0,'L');
					$this->Ln();

					$this->SetFont('Arial', 'B', 10);
					$this->Cell(40,10,'Routing/ABN (US Banks): ',10,0,'L');
					$this->SetFont('Times', 'IU', 10);
					$this->Cell(45,10,strtoupper($ipo->iban),10,0,'L');

					$this->SetFont('Arial', 'B', 10);
					$this->Cell(55,10,'Swift Code(Non US Banks): ',10,0,'L');
					$this->SetFont('Times', 'IU', 10);
					$this->Cell(50,10,strtoupper($ipo->swiftcode),10,0,'L');
					$this->Ln();
					
					$this->SetFont('Arial', 'B', 10);
					$this->Cell(45,10,'IBAN (EU Banks): ',10,0,'L');
					$this->SetFont('Times', 'IU', 10);
					$this->Cell(50,10,strtoupper($ipo->routing_abn),10,0,'L');

					$this->SetFont('Arial', 'B', 10);
					$this->Cell(40,10,'Account Number: ',10,0,'L');
					$this->SetFont('Times', 'IU', 10);
					$this->Cell(50,10,strtoupper($ipo->account_no),10,0,'L');
					$this->Ln();
					
					$this->SetFont('Times', 'B', 8);					
					$this->Cell(185,6,'PLEASE COMPLETE BANKING DETAILS AT THE END OF '. 
									    'CHECK-OUT PRIOR TO SUBMISSION TO FINANCE UNIT ONLY. NOTE THAT','LRT', 0,'L',$fill);
					$this->Ln();
					$this->SetFont('Times', 'B', 8);					
					$this->Cell(185,6,' A COPY OF YOUR CHECKOUT FORM IS RETAINED BY EACH SECTION'. 
										' WITH WHOM BANK DETAILS MAY NOT BE RELEVANT','LRB', 0,'L',$fill);
					
					$this->Ln();
					$this->SetFont('Times', 'B', 8);					
					$this->Cell(185,6,' 	1.   Report to Finance Check-Out','LRT', 0,'L',$fill);
					$this->Ln();				
					$this->Cell(185,6,' 	2.   Return completed Check-Out Form to Human Resources Section'.
											'/CIVPOL or Military Monitoring Unit','LRB', 0,'L',$fill);						

					
					$this->Ln();
					$this->SetFont('Times', 'B', 8);					
					$this->Cell(185,6,'  NB: Please note that the completion of this check-out procedure'.
									' is without prejudice to the right of the UN to hold you financially '.
									'liable in the future','LRT', 0,'L',$fill);	
					$this->Ln();
					$this->SetFont('Times', 'B', 8);					
					$this->Cell(185,6,'for any loss, damage or any other claim attributable to your service '.
									'with the Mission. Your release is therefore conditional upon the right '.
									'of the UN to ','LR', 0,'L',$fill);										
					
					$this->Ln();
					$this->SetFont('Times', 'B', 8);					
					$this->Cell(185,6,'seek appropriate reimbursement from you or any outstanding obligations attributable to you'.
									' and not immediately ascertained or duly processed ','LR', 0,'L',$fill);	
		
					$this->Ln();
					$this->SetFont('Times', 'B', 8);					
					$this->Cell(185,6,'at the time of your departure from the Mission','LRB', 0,'L',$fill);	

					$this->Ln();
					$this->SetFont('Times', 'B', 8);					
					$this->Cell(0,6,'In order to recieve your Final MSA on-site before leaving, check-out must '.
									'be completed 3 working days (excluding weekends and UN Holidays)', 0,'L',$fill);
					$this->Ln();
					$this->SetFont('Times', 'B', 8);					
					$this->Cell(0,6,'prior to departure date', 0,'L',$fill);

					$this->Ln();
					$this->SetFont('Times', 'B', 8);					
					$this->Cell(0,6,'If you have had any accident/incident, you\'re advised to contact the Claims Unit a month prior to departure'.
									' to verify the case status', 0,'L',$fill);	


					$this->Ln();
					$this->SetFont('Arial', 'I', 8);					
					$this->Cell(0,6,'1. 	 The Check-Out form must include your forwarding address, email, '.
										' foreign bank details, phone number and your supervisor\'s signature', 0,'L',$fill);	
					$this->Ln();					
					$this->Cell(0,6,'2. 	Original CTO/AL Requests can be collected from your Human Resource Officer/Administrative Assistant', 0,'L',$fill);							

					$this->Ln();					
					$this->Cell(0,6,'3. 	Your ID card will be clipped and returned to you. It '.
									'will be recognised as valid but will however indicate that you\'re in the check-out process', 0,'L',$fill);							

					$this->Ln();					
					$this->Cell(0,6,'4. 	You will return your driving permit to Transport Unit', 0,'L',$fill);							

					$this->Ln();					
					$this->Cell(0,6,'5. 	Handover vouchers for any equipment will be forwarded to the respective issuing units. '.
										'You\'re required to provide security reports for any lost items.', 0,'L',$fill);
					$this->Ln();					
					$this->Cell(0,6,'    In the absence of the reports, you will be required to pay for the items', 0,'L',$fill);					
					
					$this->Ln();					
					$this->Cell(0,6,'6.		 Telephone Pin Codes should be deactivated altleast four days to departure'.
									' Any final bills for official/private calls must be', 0,'L',$fill);					
	
					$this->Ln();					
					$this->Cell(0,6,'      signed for by your supervisor and cleared. Your final payment will '.
										'only be processed if these bills are cleared', 0,'L',$fill);

					$this->Ln();					
					$this->Cell(0,6,'7. 	 Dect and mobile phones should be returned to CITS Section at your location', 0,'L',$fill);												

					$this->Ln();					
					$this->Cell(0,6,'8.  Vehicle hand-over vouchers must be approved by the Chief Transport Officer', 0,'L',$fill);					
					
					$this->Ln();					
					$this->Cell(0,6,'9. 	 Travel arrangements and shipment of personal effects will be made with Travel Unit'.
									' and MovCon Section. Human Resource Section will notify ', 0,'L',$fill);

					$this->Ln();					
					$this->Cell(0,6,'   	 the two units of your travel entitlements. Please coordinate with MovCon And Travel '
									.'Unit on the following extensions.', 0,'L',$fill);

					$this->Ln();					
					$this->Cell(0,6,'           Travel UNIT			     6900', 0,'L',$fill);

					$this->Ln();					
					$this->Cell(0,6,'           MovCon Section		6649', 0,'L',$fill);

					$this->Ln();					
					$this->Cell(0,6,'10. 	In order to recieve your final MSA on site, your checko-ut must be completed '.
										'atleast 3 working days prior to departure. In case of delays payment ', 0,'L',$fill);					
					$this->Ln();					
					$this->Cell(0,6,'   			   will be made on your home account given on this form. USD$500 will be withheld '.
										'for all personnel to pay potential charges recorded after ', 0,'L',$fill);	
					$this->Ln();					
					$this->Cell(0,6,'   			   departure. This withheld amount will be remitted to your home bank account within'.
								    ' 3 months after your departure. In case you do not receive this fund  ', 0,'L',$fill);
					$this->Ln();				
					$this->Cell(0,6,'    	  within the stipulated period, please contact the Chief Finance Officer for further inquiries'.
									' (Please provide your ID No. and End of Mission Date).', 0,'L',$fill);	
									
					$this->Ln();				
					$this->Cell(0,6,'      Personnel being reassigned to other missions/office within the UN '.
									'secretariat may be exempted from the witholding of this portion of MSA.', 0,'L',$fill);	
					$this->Ln();				
					$this->Cell(0,6,'11.  All personnel are required to provide handover notes prior to their departure '.
									' from the mission. Section chiefs and all staff at levels P5 and above ', 0,'L',$fill);
					$this->Ln();				
					$this->Cell(0,6,'       are required to submit End of Assignment reports. Guidelines and templates can be found'.
									' in the Best Practices Tool Box folder on the shared drive.', 0,'L',$fill);	

					$this->Ln();				
					$this->Cell(0,6,'       Please consult the Best Practices Officer for any assistance.', 0,'L',$fill);		
					$this->Ln();				
					$this->Cell(0,6,'12     All UN personnel seperating from service are encouraged to complete an intranet based '.
									'exit questionaire found at the intranet addresss:', 0,'L',$fill);							
					$this->Ln();					
					$this->Cell(0,6,"        http://157.150.196.144/helpdesk/exitsurvey or http://secap527.un.org/helpdesk/exitsurvey. ".
									"This survey is aimed help the organization better", 0,'L',$fill);
					$this->Ln();					
					$this->Cell(0,6,"        understand the reasons for staff separation and aim to improve management for the future. ".
									"This voluntary survey will ", 0,'L',$fill);									

					$this->Ln();					
					$this->Cell(0,6,"       is confidential and the identity of the respondent will remain anonymous. Staff completing " .
									"their service with UNAMID  but remaining in UN ", 0,'L',$fill);									
										
					$this->Ln();					
					$this->Cell(0,6,"      service are encouraged to meet the Best Practices Officer prior to departure.", 0,'L',$fill);	

											
			}
			
			
			
	}


	

?>
