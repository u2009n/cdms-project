<?php
ob_start();
require_once("../models/config.php");
require_once("../models/Classes/fpdf17/fpdf.php");
require_once('db_row.class.php');
require_once ('notice.class.php');



class checkout_stat_Report extends FPDF
{
    
    
    
    
    // Page footer
    function Footer(){
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }


    function generate_stat_Report($str_date,$end_date){
        
        
        
        $number=0;
        
        
        
		
		
        
        
        
        
        
        $this->Image('../images/latest-build.png',30,10,150);
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Ln(15);
        $this->Cell(5);
        $this->Cell(0,10,'MHQ Personnel',10,0,'C');
        
        // Line break
        $this->SetFont('Arial','B',15);
        $this->Ln();
        $this->Cell(0,10,'Check-Out Statistics from  '.$str_date.'  to  '.$end_date,10,0,'C');
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
        $this->Ln();
        
        $total=0;
        
       
        $sqlquery="select country.cntr_name, count(ipo.cp_no) as total,ipo.cntr_id
                   from ipo,country
                    where ipo.cntr_id=country.cntr_id and 
                    ipo.eom between '$str_date' AND '$end_date' AND ipo.eom >= CURDATE()
                     group by ipo.cntr_id
                    having total > 0";
                  
                $country = mysql_query($sqlquery);    
                while($counarry = mysql_fetch_array($country)){
                $this->Cell(30,7,$counarry['cntr_name'].' = '.$counarry['total'],'',0,'L',$fill); 
                $total=$total+$counarry['total'];
               
               
              
           
            $sql=" SELECT * FROM checkout_stats_rep WHERE cntr_id= '".$counarry['cntr_id']."'";// AND eom BETWEEN $str_date AND $end_date";
            $sql=$sql." AND checkout_stats_rep.eom BETWEEN '$str_date' AND '$end_date'"; 
            $results = mysql_query($sql);
            
            
           
            $this->Ln();
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(20,7,'DOA','LRTB',0,'C',$fill);    
            $this->Cell(20,7,'ExpDOD','LRTB',0,'C',$fill);    
            $this->Cell(15,7,'Gender','LRTB',0,'C',$fill);    
            $this->Cell(25,7,'Total.p.Advisor','LRTB',0,'C',$fill);    
            $this->Cell(25,7,'Months atEOM','LRTB',0,'C',$fill);  
            $this->Cell(25,7,'Months toDate','LRTB',0,'C',$fill); 
            $this->Cell(25,7,'Months left','LRTB',0,'C',$fill);
            $this->Cell(35,7,'Remarks','LRTB',0,'C',$fill);
           
            
            while($row = mysql_fetch_array($results)){                 
                $this->Ln();
                $this->Cell(20,7,$row['doa'],'LRTB',0,'C',$fill);  
                $this->Cell(20,7,$row['eom'],'LRTB',0,'C',$fill); 
                $this->Cell(15,7,$row['Gender'],'LRTB',0,'C',$fill); 
                $this->Cell(25,7,$row['total_police'],'LRTB',0,'C',$fill); 
                $this->Cell(25,7,$row['monthstoeom'],'LRTB',0,'C',$fill);
                $this->Cell(25,7,$row['monthstodate'],'LRTB',0,'C',$fill);
                $this->Cell(25,7,$row['monthstoeom']-$row['monthstodate'],'LRTB',0,'C',$fill);
                $this->Cell(35,7,'','LRTB',0,'C',$fill);
               
                            
            }
            $this->Ln(); 
           
        }
        
        
        
       if($total>0){
        $this->SetFont('Arial', 'B', 12);
        $this->Ln();
        $this->Cell(43,7,'Total police Advisors ','',0,'C',$fill); 
        $this->Cell(3,7,':','',0,'L',$fill); 
     
          $this->Cell(10,7,$total,'',0,'R',$fill);
      }else{
          $this->Cell(50,7,'NO Data found during this peroid','',0,'R',$fill);
      }   
    }
}




?>
