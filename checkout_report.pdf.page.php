<?php
require_once("../models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("../models/Classes/fpdf17/fpdf.php");
require_once("classes/check_out_statis.pdf.class.php");

if(isset($_REQUEST['do'])){
    $str=($_REQUEST['str_date']);
    $end=($_REQUEST['end_date']);
        $pdf = new checkout_stat_Report();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->generate_stat_Report($str,$end);
        $pdf->Output();
    
}
    
?>