<?php
ob_start();
require_once("../models/config.php");
require_once("../models/Classes/fpdf17/fpdf.php");
require_once("noticas.class.php");
//if (!securePage($_SERVER['PHP_SELF'])){die();}



	class noticasPDF extends FPDF
	{
			
      
		    protected $noticas;
			
			// Page footer
			function Footer(){
				// Position at 1.5 cm from bottom
				$this->SetY(-15);
				// Arial italic 8
				$this->SetFont('Arial','I',8);
				// Page number
				$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
			}


			function generate_noticas($noticas_id){
				   $this->noticas = new noticas($noticas_id);
					$this->Image('../images/latest-build.png',30,10,150);
					// Arial bold 15
					$this->SetFont('Arial','B',15);
					// Move to the right
					$this->Cell(80);
					// Title
					$this->Ln(15);
					$this->Cell(5);
					$this->Cell(0,10,'NOTICE OF CASUALTY',10,0,'C');
					// Line break
					$this->Ln();
					// Header
					$this->SetFillColor(224,235,255);
					$this->SetFont('Arial','B',10);
									
					$this->SetFillColor(255,0,0);
					$this->SetTextColor(255);
					$this->SetDrawColor(128,0,0);
					$this->SetLineWidth(0);
					$this->SetFont('Arial','B', 10);
					// Header
					//$this->table_header = $header;
		     		// Color and font restoration
					$this->SetFillColor(224,235,255);
					$this->SetTextColor(0);
					$fill = false;
					$this->SetFont('Arial', 'B', 9);
					$this->Cell(61.6,5,'Ref.: UNAMID/POL/NOT/'.$noticas_id,'LRTB',0,'L',$fill);
					$this->Cell(61.6,5,'MISSION: UNAMID','LRTB',0,'L',$fill);
					$this->Cell(61.6,5,'DATE SENT: '. date('d M Y', time()),'LRTB',0,'L',$fill);
					$this->Ln();
					$this->Cell(185,2,'','BT',0,'L',$fill);
					$this->Ln();
					$this->Cell(10,5,'To:','LRT',0,'L',$fill);
					$this->SetFont('Arial', '', 9);
					$this->Cell(70,5,'Military Advisor (Military Personnel Only)','LRTB',0,'L',$fill);	
					$this->Cell(15,5,'3-9070','LRTB',0,'L',$fill);
					$this->SetFont('Arial', 'B', 9);
					$this->Cell(10,5,'Info:','LRT',0,'L',$fill);
					$this->SetFont('Arial', '', 9);
					$this->Cell(65,5,'Situation Centre','LRTB',0,'L',$fill);
					$this->Cell(15,5,'3-9053','LRTB',0,'L',$fill);
					
					$this->Ln();					
					$this->Cell(10,5,'','LR',0,'L',$fill);
					$this->SetFont('Arial', '', 9);
					$this->Cell(70,5,'Police Advisor (Police Personnel Only)','LRTB',0,'L',$fill);	
					$this->Cell(15,5,'7-2222','LRTB',0,'L',$fill);
					$this->Cell(10,5,'','LR',0,'L',$fill);
					$this->Cell(65,5,'PMSS/OMS/DPKO','LRTB',0,'L',$fill);
					$this->Cell(15,5,'3-0664','LRTB',0,'L',$fill);

										
					$this->Ln();					
					$this->Cell(10,5,'','LR',0,'L',$fill);
					$this->Cell(70,5,'Chief, Criminal Law and Judicial Advisory','LRT',0,'L',$fill);	
					$this->Cell(15,5,'7-2103','LRT',0,'L',$fill);
					$this->Cell(10,5,'','LR',0,'L',$fill);
					$this->Cell(65,5,'Medical Support Section/LSD/DPKO','LRT',0,'L',$fill);
					$this->Cell(15,5,'7-2333','LRT',0,'L',$fill);

					$this->Ln();					
					$this->Cell(10,5,'','LR',0,'L',$fill);
					$this->Cell(70,5,' Unit (Corrections Personnel Only)','LRB',0,'L',$fill);	
					$this->Cell(15,5,'','LRB',0,'L',$fill);
					$this->Cell(10,5,'','LR',0,'L',$fill);
					$this->Cell(65,5,'','LRB',0,'L',$fill);
					$this->Cell(15,5,'','LRB',0,'L',$fill);
					
					$this->Ln();					
					$this->Cell(10,5,'','LR',0,'L',$fill);
					$this->Cell(70,5,'PMSS(Civilian Personnel Only)','LRBT',0,'L',$fill);	
					$this->Cell(15,5,'3-0664','LRBT',0,'L',$fill);
					$this->Cell(10,5,'','LR',0,'L',$fill);
					$this->Cell(65,5,'Medical Service Division/OHRM/DM','LRB',0,'L',$fill);
					$this->Cell(15,5,'3-4925','LRB',0,'L',$fill);

					$this->Ln();					
					$this->Cell(10,5,'','LR',0,'L',$fill);
					$this->Cell(70,5,'','LRBT',0,'L',$fill);	
					$this->Cell(15,5,'','LRBT',0,'L',$fill);
					$this->Cell(10,5,'','LR',0,'L',$fill);
					$this->Cell(65,5,'Office of The Spokesperson For the SG','LRB',0,'L',$fill);
					$this->Cell(15,5,'3-1921','LRB',0,'L',$fill);

					$this->Ln();
					$this->SetFont('Arial', 'B', 9);
					$this->Cell(10,5,'CC:','LRTB',0,'L',$fill);
					$this->SetFont('Arial', '', 9);
					$this->Cell(70,5,'USG DPA (DPA-led Missions Personnel only)','LRBT',0,'L',$fill);	
					$this->Cell(15,5,'3-5065','LRBT',0,'L',$fill);
					$this->Cell(10,5,'','LRTB',0,'L',$fill);
					$this->Cell(65,5,'','LRBT',0,'L',$fill);
					$this->Cell(15,5,'','LRBT',0,'L',$fill);
					//echo "x";
					$this->Ln();
					$this->Cell(185,2,'','TB',0,'L',$fill);
					$this->Ln();
					$this->SetFont('Arial', 'B', 9);
					$this->Cell(10,5,'A','LRTB',0,'L',$fill);
					$this->Cell(175,5,'DATA ON INDIVIDUAL','LRTB',0,'L',$fill);
					$this->Ln();
					
					$this->SetFont('Arial', '', 9);
					$this->Cell(10,5,'1','LRBT',0,'L',$fill);	
					$this->Cell(70,5,'Last Name','LRBT',0,'L',$fill);
					$this->SetFont('Arial', 'B', 9);
					$this->Cell(105,5,strtoupper($this->noticas->casualty->lastName),'LRTB',0,'L',$fill);
					$this->Ln();
					$this->SetFont('Arial', '', 9);
					$this->Cell(10,5,'2','LRBT',0,'L',$fill);	
					$this->Cell(70,5,'First & Middle Names','LRBT',0,'L',$fill);
					$this->SetFont('Arial', 'B', 9);
					$this->Cell(105,5,strtoupper($this->noticas->casualty->firstName),'LRTB',0,'L',$fill);

					$this->Ln();
					$this->SetFont('Arial', '', 9);
					$this->Cell(10,5,'3','LRBT',0,'L',$fill);	
					$this->Cell(70,5,'Nationality','LRBT',0,'L',$fill);
					$this->SetFont('Arial', 'B', 9);
					$this->Cell(105,5,strtoupper($this->noticas->casualty->contingent->cont_name)
									,'LRTB',0,'L',$fill);	

					$this->Ln();
					$this->SetFont('Arial', '', 9);
					$this->Cell(10,5,'4','LRBT',0,'L',$fill);	
					$this->Cell(70,5,'Gender','LRBT',0,'L',$fill);
					$this->SetFont('Arial', 'B', 9);
					$this->Cell(105,5,strtoupper($this->noticas->casualty->sex),'LRTB',0,'L',$fill);

					$this->Ln();
					$this->SetFont('Arial', '', 9);
					$this->Cell(10,5,'5','LRBT',0,'L',$fill);	
					$this->Cell(70,5,'Military Rank/Civilian Equivalent','LRBT',0,'L',$fill);
					$this->SetFont('Arial', 'B', 9);
					$this->Cell(105,5,'CIVPOL','LRTB',0,'L',$fill);

					$this->Ln();
					$this->SetFont('Arial', '', 9);
					$this->Cell(10,5,'6','LRBT',0,'L',$fill);	
					$this->Cell(70,5,'Service No./ ID Card No. ','LRBT',0,'L',$fill);
					$this->SetFont('Arial', 'B', 9);
					$this->Cell(105,5,strtoupper($this->noticas->casualty->cp_no),'LRTB',0,'L',$fill);

					$this->Ln();
					$this->SetFont('Arial', '', 9);
					$this->Cell(10,5,'7','LRBT',0,'L',$fill);	
					$this->Cell(70,5,'Passport Number','LRBT',0,'L',$fill);
					$this->SetFont('Arial', 'B', 9);
					$this->Cell(105,5,strtoupper($this->noticas->casualty->passport_no),'LRTB',0,'L',$fill);

					$this->Ln();
					$this->SetFont('Arial', '', 9);
					$this->Cell(10,5,'8','LRBT',0,'L',$fill);	
					$this->Cell(70,5,'Date of Birth','LRBT',0,'L',$fill);
					$this->SetFont('Arial', 'B', 9);
					$this->Cell(105,5,strtoupper(date("d M Y", strtotime($this->noticas->casualty->dob))),'LRTB',0,'L',$fill);

					$this->Ln();
					$this->SetFont('Arial', '', 9);
					$this->Cell(10,5,'9','LRBT',0,'L',$fill);	
					$this->Cell(70,5,'Type of Casualty','LRBT',0,'L',$fill);
					$this->SetFont('Arial', 'B', 9);
					$this->Cell(105,5,strtoupper($this->noticas->casualty_status_title),'LRTB',0,'L',$fill);

					$this->Ln();
					$this->SetFont('Arial', '', 9);
					$this->Cell(10,5,'10','LRBT',0,'L',$fill);	
					$this->Cell(70,5,'Place where victim is located','LRBT',0,'L',$fill);
					$this->SetFont('Arial', 'B', 9);
					$this->Cell(105,5,strtoupper($this->noticas->casualty_current_location),'LRTB',0,'L',$fill);	

					$this->Ln();
					$this->Cell(185,2,'','LRBT',0,'L',$fill);
					$this->Ln();
					
					
					$this->SetFont('Arial', 'B', 9);
					$this->Cell(10,5,'B','LRBT',0,'L',$fill);	
					$this->Cell(175,5,'UNITED NATIONS DATA','LRBT',0,'L',$fill);
					$this->Ln();

					$this->SetFont('Arial', '', 9);
					$this->Cell(10,5,'1','LRBT',0,'L',$fill);	
					$this->Cell(70,5,'Name of Mission','LRBT',0,'L',$fill);
					$this->SetFont('Arial', 'B', 9);
					$this->Cell(105,5,'UNAMID','LRTB',0,'L',$fill);

					$this->Ln();
					$this->SetFont('Arial', '', 9);
					$this->Cell(10,5,'2','LRBT',0,'L',$fill);	
					$this->Cell(70,5,'UN ID Card Number','LRBT',0,'L',$fill);
					$this->SetFont('Arial', 'B', 9);
					$this->Cell(105,5,strtoupper($this->noticas->casualty_cp_no),'LRTB',0,'L',$fill);

					$this->Ln();
					$this->SetFont('Arial', '', 9);
					$this->Cell(10,5,'3','LRBT',0,'L',$fill);	
					$this->Cell(70,5,'Appointment Type','LRBT',0,'L',$fill);
					$this->SetFont('Arial', 'B', 9);
					$this->Cell(105,5,'POLICE','LRTB',0,'L',$fill);

					$this->Ln();
					$this->SetFont('Arial', '', 9);
					$this->Cell(10,5,'4','LRBT',0,'L',$fill);	
					$this->Cell(70,5,'On duty at time of incident?','LRBT',0,'L',$fill);
					$this->SetFont('Arial', 'B', 9);
					$this->Cell(105,5,$this->noticas->casualty_duty_status == 'Y' ? "YES" : "NO",'LRTB',0,'L',$fill);

					$this->Ln();
					$this->SetFont('Arial', '', 9);
					$this->Cell(10,5,'5','LRBT',0,'L',$fill);	
					$this->Cell(70,5,'Date of Arrival in Mission','LRBT',0,'L',$fill);
					$this->SetFont('Arial', 'B', 9);
					$this->Cell(105,5,strtoupper(date("d M Y", strtotime($this->noticas->casualty->doa))),'LRTB',0,'L',$fill);

					$this->Ln();
					$this->SetFont('Arial', '', 9);
					$this->Cell(10,5,'10','LRBT',0,'L',$fill);	
					$this->Cell(70,5,'Function in Mission','LRBT',0,'L',$fill);
					$this->SetFont('Arial', 'B', 9);
					$this->Cell(105,5,strtoupper($this->noticas->casualty->position->post_name),'LRTB',0,'L',$fill);

					$this->Ln();
					$this->Cell(185,2,'','LRBT',0,'L',$fill);
					$this->Ln();
					$this->SetFont('Arial', 'B', 9);
					$this->Cell(10,5,'C','LRBT',0,'L',$fill);
					$this->Cell(175,5,'NEXT OF KIN DATA','LRBT',0,'L',$fill);					
					$this->Ln();
					
					$this->SetFont('Arial', '', 9);
					$this->Cell(10,5,'1','LRBT',0,'L',$fill);	
					$this->Cell(70,5,'Names','LRBT',0,'L',$fill);
					$this->SetFont('Arial', 'B', 9);
					$this->Cell(105,5,strtoupper($this->noticas->casualty->nextofkin_name),'LRTB',0,'L',$fill);
					
					$this->Ln();
					$this->SetFont('Arial', '', 9);
					$this->Cell(10,5,'2','LRBT',0,'L',$fill);	
					$this->Cell(70,5,'Address','LRBT',0,'L',$fill);
					$this->SetFont('Arial', 'B', 9);
					$this->Cell(105,5,strtoupper($this->noticas->casualty->nextofkin_contact_address),'LRTB',0,'L',$fill);
					
					$this->Ln();
					$this->SetFont('Arial', '', 9);
					$this->Cell(10,5,'3','LRBT',0,'L',$fill);	
					$this->Cell(70,5,'Telephone','LRBT',0,'L',$fill);
					$this->SetFont('Arial', 'B', 9);
					$this->Cell(105,5,strtoupper($this->noticas->casualty->nextofkin_contact_no),'LRTB',0,'L',$fill);
					
					$this->Ln();
					$this->SetFont('Arial', '', 9);
					$this->Cell(10,5,'4','LRBT',0,'L',$fill);	
					$this->Cell(70,5,'Relationship','LRBT',0,'L',$fill);
					$this->SetFont('Arial', 'B', 9);
					$this->Cell(105,5,strtoupper($this->noticas->casualty->nextofkin_relationship),'LRTB',0,'L',$fill);
					
					$this->Ln();
					$this->Cell(185,2,'','LRBT',0,'L',$fill);
					$this->Ln();
					$this->SetFont('Arial', 'B', 9);
					$this->Cell(10,5,'D','LRBT',0,'L',$fill);
					$this->Cell(175,5,'DATA ON INCIDENT','LRBT',0,'L',$fill);					
					
					$this->Ln();
					$this->SetFont('Arial', '', 9);
					$this->Cell(10,5,'1','LRBT',0,'L',$fill);	
					$this->Cell(70,5,'Date/Time of Incident','LRBT',0,'L',$fill);
					$this->SetFont('Arial', 'B', 9);
					$this->Cell(105,5,strtoupper(date("d M Y h:m", strtotime($this->noticas->incident_date))),
									'LRTB',0,'L',$fill);
					
					
					$this->Ln();
					$this->SetFont('Arial', '', 9);
					$this->Cell(10,5,'2','LRBT',0,'L',$fill);	
					$this->Cell(70,5,'Incident Location','LRBT',0,'L',$fill);
					$this->SetFont('Arial', 'B', 9);
					$this->Cell(105,5,strtoupper($this->noticas->incident_location)
									,'LRTB',0,'L',$fill);
					
										
					
					$this->Ln();
					$this->SetFont('Arial', '', 9);
					$this->Cell(10,5,'3','LRBT',0,'L',$fill);	
					$this->Cell(70,5,'Type of Incident/Circumstances','LRBT',0,'L',$fill);
					$this->SetFont('Arial', 'B', 9);
					$this->Cell(105,5,strtoupper($this->noticas->incident_type),'LRTB',0,'L',$fill);
					
					
					$this->Ln();
					$this->SetFont('Arial', '', 9);				
					
					
					$length = strlen($this->noticas->incident_description);
					
					
					$lines = ( $length > 51) ? 
								(intval($length/51) >  $length/51) ?  ($length/51) + 1 : $length/51
							 : 1;
					$start = 0;
					
					for($x = 0; $x <= $lines; $x++){
						$this->description_array[] =  substr($this->noticas->incident_description, $start, 51);
						
						$start += 51;
					}
					
					$line_count = 1;
					
					foreach($this->description_array as $description){
						$this->Cell(10,4,$line_count==1 ? '4': '','LR',0,'L',$fill);
						$this->Cell(70,4,$line_count==1 ? 'Description of Incident': '','LR',0,'L',$fill);	
						$this->SetFont('Arial', 'B', 8);
						$this->Cell(105,4,strtoupper($description),'LR',0,'L',$fill);
						$this->Ln();
						$line_count++;
					}
					
					$this->Cell(10,1,'','LRB',0,'L',$fill);
					$this->Cell(70,1,'','LRB',0,'L',$fill);						
					$this->Cell(105,1,'','LRB',0,'L',$fill);					
	
					
					$this->Ln();
					$this->SetFont('Arial', '', 9);

					$length = strlen($this->noticas->incident_extra_info);
					
					
					$lines = ( $length > 51) ? (intval($length/51) >  $length/51) ?  ($length/51) + 1 : $length/51 : 1;
					
					$start = 0;
					
					for($x = 0; $x <= $lines; $x++){
						$this->extra_info_array[] =  substr($this->noticas->incident_extra_info, $start, 51);
						
						$start += 51;
					}
					
					$line_count = 1;
					
					foreach($this->extra_info_array as $extra_info){
						$this->Cell(10,4,$line_count==1 ? '5': '','LR',0,'L',$fill);
						$this->Cell(70,4,$line_count==1 ? 'Additional Comments': '','LR',0,'L',$fill);	
						$this->SetFont('Arial', 'B', 8);
						$this->Cell(105,4,strtoupper($extra_info),'LR',0,'L',$fill);
						$this->Ln();
						$line_count++;
					}
					
				    $this->Cell(10,1,'','LRB',0,'L',$fill);
					$this->Cell(70,1,'','LRB',0,'L',$fill);
					$this->Cell(105,1,'','LRB',0,'L',$fill);
					//$this->Cell(105,5,strtoupper($this->noticas->incident_extra_info),'LRTB',0,'L',$fill);
					$this->Ln();
					$this->Ln();
					$this->SetFont('Arial', 'B', 9);
					$this->Cell(25,5,'','',0,'L',$fill);
					$this->Cell(80,5,'Authorised By:','',0,'L',$fill);	
					$this->Cell(80,5,'Drafted By:','',0,'L',$fill);
					
					$this->Ln();
					$this->SetFont('Arial', '', 9);
					$this->Cell(25,5,'Title','LRBT',0,'L',$fill);
					$this->SetFont('Arial', 'B', 9);
					$this->Cell(80,5,strtoupper($this->noticas->authorised_by_post),'LRBT',0,'L',$fill);
					$this->SetFont('Arial', 'B', 9);
					$this->Cell(80,5,strtoupper($this->noticas->drafted_by_position->post_name),'LRTB',0,'L',$fill);
					$this->Ln();
					
					$this->SetFont('Arial', '', 9);
					$this->Cell(25,5,'Name','LRBT',0,'L',$fill);
					$this->SetFont('Arial', 'B', 9);
					$this->Cell(80,5,strtoupper($this->noticas->authorised_by_name),'LRBT',0,'L',$fill);
					$this->SetFont('Arial', 'B', 9);
					$this->Cell(80,5,strtoupper($this->noticas->drafted_by->firstName . "  ".
					                            $this->noticas->drafted_by->lastName),'LRTB',0,'L',$fill);
					$this->Ln();
					
					$this->SetFont('Arial', '', 9);
					$this->Cell(25,7,'Signature','LRBT',0,'L',$fill);	
					$this->Cell(80,7,'..............................................................................','LRBT',0,'L',$fill);
					$this->SetFont('Arial', '', 9);
					$this->Cell(80,7,'...............................................................................','LRTB',0,'L',$fill);											
										
			}
			
			
			
	}


	

?>
