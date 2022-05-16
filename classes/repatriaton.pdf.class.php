<?php
ob_start();
require_once("../models/config.php");
require_once("../models/Classes/fpdf17/fpdf.php");
require_once 'classes/ipo.class.php';


    $ipo= new ipo();
	$position = new position;
	$note = NULL;
	$application_id = NULL;
    $approver_name = null;



class RepatriationPDF extends FPDF
{
    
    
    protected $repatriation;
    
    // Page footer
    function Footer(){
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }


    function generate_repatriation($key){
        
        
        
        $conn = new db_rows();
        $ipo=new ipo();
        $ipo_authriztion= new ipo();
        $position = new position;
        $ipo_submitted;
		$key1 = " position_notice.id = $key ";
		
        
		$table = "position_notice 
					INNER JOIN (
								repatriation_request  
								INNER JOIN 
									repatriation_reasons
								ON 
									repatriation_request.reason_id=repatriation_reasons.id
						)
						
				    ON 
						position_notice.notice_token = repatriation_request.notice_token 
                     
				 ";
        

		$fields = array(array('repatriation_request.applicant_cp_no', 'applicant_cp_no'),
						array('repatriation_request.applicant_post_id', 'applicant_post_id'),
						array('repatriation_request.repatriant_cp_no', 'ipo_cp_no'),
						array('repatriation_request.repatriant_post_id', 'ipo_post_id'),
						array('repatriation_request.approver_post_id', 'approver_post_id'),
						array('repatriation_request.approver_cp_no', 'approver_cp_no'),
						array('repatriation_request.eeom_date', 'eeom_date'),
                        array('repatriation_request.current_eeom_date', 'current_eeom_date'),
						array('repatriation_request.application_date', 'application_date'),
						array('repatriation_request.status', 'status'),
						array('repatriation_request.applicant_note', 'justification'),
						array('repatriation_request.approver_note', 'approver_note'),
						array('repatriation_reasons.reason', 'reason'),
						array('repatriation_request.status_date', 'status_date'),
						array('repatriation_request.notice_token', 'notice_token'),
						array('repatriation_request.id', 'application_id')						
					  );
       
        
		$rows = $conn->get_rows($table, $fields, $key1);
        
        

		if(is_array($rows)){
            
           
            
            
			foreach($rows as $row){
				extract($row);
                $ipo->getIPO($ipo_cp_no);
                $ipo_authriztion->getIPO($applicant_cp_no);
                $sumitted_name=$ipo_authriztion->firstName . ' '.$ipo_authriztion->lastName;
                $position->getPosition($applicant_post_id);
                $submit_position=$position->post_name;
               // $ipo_authriztion->getIPO($approver_cp_no);
              //  $Approver_name=$ipo_authriztion->cp_no. ' '. $ipo_authriztion->firstName . ' '.$ipo_authriztion->lastName;
                $position->getPosition($approver_post_id);
                $Approver_postion=$position->post_name;    
                
                $key2="ipo.post_id=$approver_post_id";
                $table="ipo";
                $fields = array(array('ipo.firstName', 'firstName'),
						array('ipo.lastName', 'lastName')
                        );
                
                $rows = $conn->get_rows($table, $fields, $key2);
                if(is_array($rows)){
                    
                    foreach($rows as $row){
                        extract($row);
                        
                        
                    }
                } 
                
        $this->Image('../images/latest-build.png',30,10,150);
        // Arial bold 15
        $this->SetFont('Arial','U',15);
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Ln(15);
        $this->Cell(5);
        $this->Cell(0,10,'INTER OFFICE MEMORANDUM',10,0,'C');
        
        // Line break
        $this->Ln();
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
        $this->Cell(0,8,''.'DATE : '. date('d M Y', time()),'','0','L',$fill);
        $this->Ln();
        $this->Cell(0,8,''.'Ref: UNAMID/POL/PER/MONI/04/VOL.7/'.$key,'',0,'L',$fill);
        $this->Ln();
        $this->Ln();
        $this->Cell(15,5,'Submitted BY :'. $sumitted_name, '',0,'L',$fill);
        $this->Ln();
        $this->Cell(15,10, $submit_position, '',0,'L',$fill);
        $this->Ln();
        $this->Cell(15,5,'Approved By  :'.$firstName.'  '.$lastName , '',0,'L',$fill);
        $this->Ln();
        $this->Cell(15,10, $Approver_postion, '',0,'L',$fill);
        $this->Ln();
        $this->Cell(15,10,'SUBJECT', '',0,'L',$fill);
        $this->Cell(15,10,'   ', '',0,'L',$fill);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(61,10, ': Early End of Mission (Repatriation) One (1) Police Advisor ('.$ipo->contingent->cont_name.')','',0,'L',$fill); 
        
        $this->Ln();
        $this->Cell(185,4,'','BT',0,'L',$fill);
        $this->Ln();  
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(10,5,'S/No','LRTB',0,'C',$fill);
        $this->Cell(15,5,'UN ID','LRTB',0,'C',$fill);	
        $this->Cell(25,5,'INDEX NO','LRTB',0,'C',$fill);
        $this->Cell(30,5,'Last Name','LRTB',0,'C',$fill);
        $this->Cell(30,5,'First Name','LRTB',0,'C',$fill);
        $this->Cell(27,5,'DOA','LRTB',0,'C',$fill);
        $this->Cell(27,5,'Current EOM','LRTB',0,'C',$fill);
        $this->Cell(27,5,'NEW EOM','LRTB',0,'C',$fill);
        $this->Ln();
        
        
				
				
				
				
				
                
                
                
                $this->Cell(10,5,'1','LRTB',0,'C',$fill);
                $this->Cell(15,5,$ipo_cp_no,'LRTB',0,'C',$fill);
                $this->Cell(25,5,$ipo->indexNo,'LRTB',0,'C',$fill);
                $this->Cell(30,5, $ipo->lastName,'LRTB',0,'C',$fill);
                $this->Cell(30,5,$ipo->firstName,'LRTB',0,'C',$fill);
                $this->Cell(27,5,$ipo->doa,'LRTB',0,'C',$fill);
                $this->Cell(27,5,$current_eeom_date,'LRTB',0,'C',$fill);
                $this->Cell(27,5,$ipo->eom,'LRTB',0,'C',$fill);
                $this->Ln();
                $this->Ln();
                $this->SetFont('Arial', '', 9);

                $length = strlen($justification);
                
                
                $lines = ( $length > 85 )? (intval($length/85) >  $length/85) ?  ($length/85) + 1 : $length/85 : 1;
                
                $start = 0;
                
                for($x = 0; $x <= $lines; $x++){
                    $this->extra_info_array[] =  substr($justification, $start, 85);
                    
                    $start += 85;
                }
                
                $line_count = 1;
                
                foreach($this->extra_info_array as $extra_info){
                    $this->SetFont('Arial', 'B', 8);
                    $this->Cell(33,4,$line_count==1 ? 'Additional Comments :': '','',0,'L',$fill);	
                    $this->SetFont('Arial', '', 8);
                    $this->Cell(190,4,strtoupper($extra_info),'',0,'L',$fill);
                    $this->Ln();
                    $line_count++;
                }
                
                
               
            }
            
            
            
            
        }
        
        
    }
}




?>
