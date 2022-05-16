<?php
ob_start();
require_once('classes/luggage_declaration_pdf.class.php');
//if (!securePage($_SERVER['PHP_SELF'])){die();}
	if(isset($_REQUEST['i'])){
    $cp_no= decrypt($_REQUEST['i']);
	$pdf = new luggageDeclarationPDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->generate_declaration($cp_no);
	$pdf->Output();
}
?>
