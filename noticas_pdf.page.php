<?php
ob_start();
	require_once '../models/config.php';
	require_once('classes/noticas_pdf.class.php');
	//if (!securePage($_SERVER['PHP_SELF'])){die();}
	
	if(isset($_REQUEST['i'])){
		
		$noticas_id = decrypt($_REQUEST['i']); 
		$cp_no=$loggedInUser->cpnomber;	 
		$pdf = new noticasPDF();
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->generate_noticas($noticas_id);
		//print_r($_SESSION);
		$pdf->Output();

	}
	
?>
