<?php
ob_start();
require_once('classes/checkout_form_pdf.class.php');
//if (!securePage($_SERVER['PHP_SELF'])){die();}
	//echo "<pre>";
	//print_r($loggedInUser);
	//$cp_no=$loggedInUser->cpnomber;
if(isset($_REQUEST['i'])){
    $cp_no= decrypt($_REQUEST['i']);
	$pdf = new checkOutForm();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->generate_checkOutForm($cp_no);
	$pdf->Output();
}
?>
