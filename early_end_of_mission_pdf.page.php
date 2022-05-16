<?php
ob_start();
	require_once '../models/config.php';
	require_once('classes/eeom.pdf.class.php');
	//if (!securePage($_SERVER['PHP_SELF'])){die();}
	
	if(isset($_REQUEST['i'])){
		
		$Key = decrypt($_REQUEST['i']); 
		$cp_no=$loggedInUser->cpnomber;	 
		$pdf = new eeomPDF();
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->generate_eeom($Key);
		$pdf->Output();

	}
	
?>
