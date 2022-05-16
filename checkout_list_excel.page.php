<?php
	ob_start();
	require_once("../models/config.php");
	require_once("../models/Classes/PHPExcel.php");
	require_once("classes/checkout_list.class.php");
	//if (!securePage($_SERVER['PHP_SELF'])){die();}
	$checkout_month = '1';
	$checkout_year = '2015';
	$templateFile = 'assets/checkoutlist_template.xlsx';
    $months = array ('', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 
					 'August', 'September', 'October', 'November', 'December');
					 
	 $cp_no=$loggedInUser->cpnomber;
	 $encrypted = $encrypted = encrypt( $cp_no ); 
	 $checkout_list = new checkoutList();

	if(isset($_REQUEST['m'])){
		$checkout_month =  decrypt($_REQUEST['m']);
		$checkout_year =  decrypt($_REQUEST['y']);
	}
	
	 $list = $checkout_list->generateList($checkout_month, $checkout_year);
	 $db_data = array();
	 

	$php_excel = PHPExcel_IOFactory::load($templateFile);
	//$php_excel->getSheet(0);
	$title = 'CHECKOUT LIST FOR '. strtoupper($months[$checkout_month]) . ' '. $checkout_year .' AS ON '. strtoupper(date('d M Y', time()));
	$php_excel->getSheet(0)->setCellValue('A1', $title);	 
	$php_excel->getSheet(1)->setCellValue('A1', $title);
	$php_excel->getSheet(2)->setCellValue('A1', $title);
	
	if(is_array($list)){
		$x = 4;
		$serial = 1;
		$sorted_by_eom = sortmulti ($list, 'eom', 'asc');
										
		$sorted_by_destination = sortmulti ($list, 'cntr_code', 'asc');
		//echo "<pre>";
		//print_r($sorted_by_eom);
		
		foreach($list as $row){
			extract($row);
			
			$php_excel->getSheet(0)->setCellValue('A'.$x, $serial);
			$php_excel->getSheet(0)->setCellValue('B'.$x, $cp_no);
			$php_excel->getSheet(0)->setCellValue('C'.$x, $IndexNo); 
			$php_excel->getSheet(0)->setCellValue('D'.$x, $lastName);
			$php_excel->getSheet(0)->setCellValue('E'.$x, $firstName);
			$php_excel->getSheet(0)->setCellValue('F'.$x, $cntr_code);
			$php_excel->getSheet(0)->setCellValue('G'.$x, $sex);
			$php_excel->getSheet(0)->setCellValue('H'.$x, $doa	);
			$php_excel->getSheet(0)->setCellValue('I'.$x, $eom);
			$php_excel->getSheet(0)->setCellValue('J'.$x,   $MHQDate);
            $php_excel->getSheet(0)->setCellValue('k'.$x,   $destination);
			
			$serial++;
			$x++;		
		}
		
		$serial = 1;
		$x = 4;
		
	    foreach($sorted_by_eom as $row){
			extract($row);
			
			$php_excel->getSheet(1)->setCellValue('A'.$x, $serial);
			$php_excel->getSheet(1)->setCellValue('B'.$x, $cp_no);
			$php_excel->getSheet(1)->setCellValue('C'.$x, $IndexNo); 
			$php_excel->getSheet(1)->setCellValue('D'.$x, $lastName);
			$php_excel->getSheet(1)->setCellValue('E'.$x, $firstName);
			$php_excel->getSheet(1)->setCellValue('F'.$x, $cntr_code);
			$php_excel->getSheet(1)->setCellValue('G'.$x, $sex);
			$php_excel->getSheet(1)->setCellValue('H'.$x, $doa	);
			$php_excel->getSheet(1)->setCellValue('I'.$x, $eom);
			$php_excel->getSheet(0)->setCellValue('J'.$x,   $MHQDate);
            $php_excel->getSheet(0)->setCellValue('k'.$x,   $destination);
			
			$serial++;
			$x++;		
		}
		
		$serial = 1;
		$x=4;
		
		foreach($sorted_by_destination as $row){
			extract($row);
			
			$php_excel->getSheet(2)->setCellValue('A'.$x, $serial);
			$php_excel->getSheet(2)->setCellValue('B'.$x, $cp_no);
			$php_excel->getSheet(2)->setCellValue('C'.$x, $IndexNo); 
			$php_excel->getSheet(2)->setCellValue('D'.$x, $lastName);
			$php_excel->getSheet(2)->setCellValue('E'.$x, $firstName);
			$php_excel->getSheet(2)->setCellValue('F'.$x, $cntr_code);
			$php_excel->getSheet(2)->setCellValue('G'.$x, $sex);
			$php_excel->getSheet(2)->setCellValue('H'.$x, $doa);
			$php_excel->getSheet(2)->setCellValue('I'.$x, $eom);
			$php_excel->getSheet(0)->setCellValue('J'.$x,   $MHQDate);
            $php_excel->getSheet(0)->setCellValue('k'.$x,   $destination);
			
			$serial++;
			$x++;		
		}
		
		$x--;
		//cellColor(0, 'A4:J'.$x, 'FFFF');
		$php_excel->getSheet(0)->getPageSetup()->setPrintArea('A1:J'.$x);
	    $php_excel->getSheet(0)->getStyle('A4:J'.$x)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN); 
		$php_excel->getSheet(1)->getPageSetup()->setPrintArea('A1:J'.$x);
	    $php_excel->getSheet(1)->getStyle('A4:J'.$x)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN); 
		$php_excel->getSheet(2)->getPageSetup()->setPrintArea('A1:J'.$x);
	    $php_excel->getSheet(2)->getStyle('A4:J'.$x)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);        
    }
	//echo "<pre>";
	//print_r($db_data);
	// Instanciation of inherited class
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); 
	header('Content-Disposition: attachment;filename="checkout_list_'.strtoupper($months[$checkout_month]) . '_'.$checkout_year.'.xlsx"');
	header('Cache-Control: max-age=0'); 
	$objWriter = PHPExcel_IOFactory::createWriter($php_excel, 'Excel2007'); 
	$objWriter->save('php://output'); 
	//unset($objWriter);
    //$php_excel->disconnectWorksheets();
	//unset($php_excel);

	function sortmulti ($array, $index, $order, $natsort=FALSE, $case_sensitive=FALSE) {
			 if(is_array($array) && count($array)>0) {
				 foreach(array_keys($array) as $key) { 
					$temp[$key]=$array[$key][$index];
				 }
				 if(!$natsort) {
					 if ($order=='asc') {
						 asort($temp);
					 } else {    
						 arsort($temp);
					 }
				 }
				 else 
				 {
					 if ($case_sensitive===true) {
						 natsort($temp);
					 } else {
						 natcasesort($temp);
					 }
					if($order!='asc') { 
					 $temp=array_reverse($temp,TRUE);
					}
				 }
				 foreach(array_keys($temp) as $key) { 
					 if (is_numeric($key)) {
						 $sorted[]=$array[$key];
					 } else {    
						 $sorted[$key]=$array[$key];
					 }
				 }
				 return $sorted;
			 }
		 return $sorted;
	}

	function cellColor($sheet, $cells, $color){
		global $php_excel;

		$php_excel->getSheet($sheet)->getStyle($cells)->getFill()->applyFromArray(
																					array(
																							'type' => PHPExcel_Style_Fill::FILL_SOLID,
																							'startcolor' => array('rgb' => $color)
																					)
																				);
	
	}

?>