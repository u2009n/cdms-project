<?php
require_once("../models/config.php");
//if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("../models/Classes/fpdf17/fpdf.php");
require_once("classes/check_out_statis.pdf.class.php");

if(isset($_REQUEST['k'])){
    $str=''; //strtotime($_REQUEST['s']);
    $end=''; //strtotime($_REQUEST['e']);
	$pdf = new checkout_stat_Report();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->generate_stat_Report($str,$end);
	$pdf->Output();
}
?>