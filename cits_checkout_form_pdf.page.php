<?php
ob_start();
require_once('classes/cits_checkout_form_pdf.class.php');
//if (!securePage($_SERVER['PHP_SELF'])){die();}
	//echo "<pre>";
	//print_r($loggedInUser);
	//$cp_no=$loggedInUser->cpnomber;	 
if(isset($_REQUEST['i'])){
    $cp_no= decrypt($_REQUEST['i']);
	$pdf = new cits_checkOutForm();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->generate_cits_checkOutForm($cp_no);
	$pdf->Output();
}
echo "no data found";
?>
