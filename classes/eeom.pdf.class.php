<?php
ob_start();
require_once("../models/config.php");
require_once("../models/Classes/fpdf17/fpdf.php");
require_once 'classes/ipo.class.php';


$ipo= new ipo();
$position = new position;
$application_id = NULL;
$approver_name = null;



class eeomPDF extends FPDF
{
    
    
    protected $eeom_idn;
    
    // Page footer
    function Footer(){
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }


    function generate_eeom($key){
        
        
        
        $conn = new db_rows();
        $ipo=new ipo();
        $ipo_authriztion= new ipo();
        $position = new position;
        $key1 = $key;
		
		
        
		
		$key = " notice.id = $key";
        
		$application = "eeom_request AS application LEFT JOIN 
							eeom_request_reasons as reason ON 
											application.reason_id=reason.id ";
		
		//$approver = " positions AS approver_post ";
       
        $approver="ipo  AS approver_name LEFT JOIN
                       positions AS approver_post ON
                       approver_name.post_id=approver_post.post_id";
        
		$applicant = "ipo AS applicant LEFT JOIN (positions AS ipo_post 
							LEFT JOIN full_unit_name ON ipo_post.unit_id = full_unit_name.unit_id)
					  ON applicant.post_id = ipo_post.post_id";
        
		$_notice = "position_notice as notice";
        
		$table = "$_notice LEFT JOIN $application ON notice.notice_token = application.notice_token
					LEFT JOIN $approver ON application.approver_post_id = approver_post.post_id 
					LEFT JOIN $applicant ON applicant.cp_no = application.applicant_cp_no";
		
		$fields = array(array('applicant.cp_no', 'cp_no'),
                        array('applicant.indexNo', 'indexNo'),
						array("CONCAT (applicant.FirstName, ' ', applicant.LastName)", 'names'),
						array("CONCAT(full_unit_name.full_name, '/',ipo_post.post_name )", 'ipo_post'),
               			array('applicant.eom', 'eom'),
						array('application.applicant_note', 'note'),
						array('application.eeom_date', 'eeom'),
                        array('application.current_eeom_date', 'current_eeom_date'),
						array('reason.reason', 'reason'),						
						array('approver_post.post_name', 'approver'),
                        array("CONCAT(approver_name.FirstName, ' ', approver_name.LastName)", 'approverName'),
						array('approver_post.post_id', 'approver_id'),
						array('application.application_date', 'submitted_date'),
						array('application.id', 'application_id'),	
						array('application.notice_token', 'stamp'),
						array('application.status', 'status'),
                        array('application.approver_note', 'approver_note')
					  );
        
		$rows = $conn->get_rows($table, $fields, $key);
        
        

		if(is_array($rows)){
            
            
            
            
			foreach($rows as $row){
				extract($row);
                $ipo->getIPO($cp_no);
              
                
                
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
                $this->Cell(0,8,''.'Ref: UNAMID/POL/PER/MONI/04/VOL.7/'.$key1,'',0,'L',$fill);
                $this->Ln();
                $this->Ln();
                $this->Cell(15,5,'Submitted BY :'. $names,'',0,'L',$fill);
                $this->Ln();
                $this->Cell(15,10,$ipo_post, '',0,'L',$fill);
                
                $this->Ln();
                $this->Cell(15,5,'Approved By  :'.$approverName, '',0,'L',$fill);
                $this->Ln();
                $this->Cell(15,10,$approver, '',0,'L',$fill);
                $this->Ln();
                $this->Cell(15,10,'SUBJECT', '',0,'L',$fill);
                $this->Cell(15,10,'   ', '',0,'L',$fill);
                $this->SetFont('Arial', 'B', 12);
                $this->Cell(61,10, ': Early End of Mission Application  One (1) Police Advisor ('.$ipo->contingent->cont_name.')','',0,'L',$fill); 
                
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
                $this->Cell(15,5,$cp_no,'LRTB',0,'C',$fill);
                $this->Cell(25,5,$ipo->indexNo,'LRTB',0,'C',$fill);
                $this->Cell(30,5, $ipo->lastName,'LRTB',0,'C',$fill);
                $this->Cell(30,5,$ipo->firstName,'LRTB',0,'C',$fill);
                $this->Cell(27,5,$ipo->doa,'LRTB',0,'C',$fill);
                $this->Cell(27,5,$current_eeom_date,'LRTB',0,'C',$fill);
                $this->Cell(27,5,$ipo->eom,'LRTB',0,'C',$fill);
                $this->Ln();
                $this->Ln();
                $this->SetFont('Arial', '', 9);

                $length = strlen($note);
                
                
                $lines = ( $length > 85 )? (intval($length/85) >  $length/85) ?  ($length/85) + 1 : $length/85 : 1;
                
                $start = 0;
                
                for($x = 0; $x <= $lines; $x++){
                    $this->extra_info_array[] =  substr($note, $start, 85);
                    
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
