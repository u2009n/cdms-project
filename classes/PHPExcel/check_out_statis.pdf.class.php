<?php
ob_start();
require_once("../models/config.php");
require_once("../models/Classes/fpdf17/fpdf.php");



class checkout_stat_Report extends FPDF
{
    
    
    // protected $eeom_idn;
    
    // Page footer
    function Footer(){
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }


    function generate_stat_Report(){
        
        
        
        $number=0;
        $key= '';
        $str_date =date('Y-m-d',strtotime('2014-01-01'));
        $end_date=date('Y-m-d',strtotime('2015-01-21'));
        //SELECT distinct name FROM info WHERE status = 1 ORDER BY id
        $key='WHERE eom BETWEEN str_date AND end_date';
        
		
		$sqlquery="SELECT distinct cntr_id FROM checkout_stats_rep ";//WHERE eom BETWEEN $end_date AND $end_date";
        
		
        $sql=" SELECT * FROM checkout_stats_rep";
        $results = mysql_query($sql);
        $number = mysql_num_rows ($results);
       
                    //extract($row) WHERE `ipo`.`eom`>= '2015/05/01' AND '2014/05/31'"
                    
                    
                    
                    
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
                    $this->Cell(0,10,'Check-Out Statistics for October 2015',10,0,'C');
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
                    if ($number > 0) { 
                        
                        $rows = mysql_fetch_array($results);
                        if(is_array($rows)){
                            $this->Cell(20,7,'DOA','LRTB',0,'C',$fill);    
                            $this->Cell(20,7,'ExpDOD','LRTB',0,'C',$fill);    
                            $this->Cell(12,7,'Gender','LRTB',0,'C',$fill);    
                            $this->Cell(25,7,'Total.p.Advisor','LRTB',0,'C',$fill);    
                            $this->Cell(25,7,'Months atEOM','LRTB',0,'C',$fill);  
                            $this->Cell(25,7,'Months toDate','LRTB',0,'C',$fill); 
                            $this->Cell(20,7,'Months left','LRTB',0,'C',$fill);
                            $this->Cell(35,7,'Remark','LRTB',0,'C',$fill);  
                            
                        while($row = mysql_fetch_array($results)){
                            $cntr_id=$row['cntr_id'];
                            if ($row['cntr_id']){
                                
                                $toEOM=$row['monthstoeom'];
                                $todate=$row['monthstodate'];
                                $left=$toEOM-$todate;
                                
                                $this->Ln();
                                $this->Cell(20,7,$row['doa'],'LRTB',0,'C',$fill);  
                                $this->Cell(20,7,$row['eom'],'LRTB',0,'C',$fill); 
                                $this->Cell(12,7,$row['Gender'],'LRTB',0,'C',$fill); 
                                $this->Cell(25,7,$row['total_police'],'LRTB',0,'C',$fill); 
                                $this->Cell(25,7,$row['monthstoeom'],'LRTB',0,'C',$fill);
                                $this->Cell(25,7,$row['monthstodate'],'LRTB',0,'C',$fill);
                                $this->Cell(20,7,$left,'LRTB',0,'C',$fill);
                                $this->Cell(35,7,'','LRTB',0,'C',$fill); 
                                
                            }
                    
                }
                
                
                
                
            }
            
            
        }
    }

}


?>
