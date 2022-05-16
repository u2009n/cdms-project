<?php
ob_start();
require_once("../models/config.php");
require_once "classes/db_row.class.php";
date_default_timezone_set('Africa/Nairobi');
//if (!securePage($_SERVER['PHP_SELF'])){die();}

if(isset($_REQUEST['k'])){
	$key = "id = ". decrypt($_REQUEST['k']);
	$table = "sys_position_notice";
	$fields = array(array('MONTH(notice_time)', 'report_month'),
					array('YEAR(notice_time)', 'report_year')
					);
    $conn= new db_rows();
	$rows = $conn->get_rows($table, $fields, $key);
	
	if(is_array($rows)){
		$item = NULL;
		
		foreach($rows as $row){
			$report_month = $row['report_month'];
			$report_year = $row['report_year'];
			
			$checkout_month = $report_month == 12 ? 1 : $report_month + 1;
			$checkout_year = $report_month == 12 ? $report_year + 1 : $report_year;
			
			$item .= "							
						<a target=\"_blank\" href=\"index.php?p=" . encrypt('checkout_list_pdf'). "&m=".
								encrypt($checkout_month). "&y=".encrypt($checkout_year). "\"> 
								<img src=\"assets/download_pdf.png\" alt=\"Download\"> </a>
						<a target=\"_blank\" href=\"index.php?p=" . encrypt('checkout_list_excel'). "&m=".
									encrypt($checkout_month). "&y=".encrypt($checkout_year). "\"> 
									<img src=\"assets/download_excel2.png\" alt=\"Download\"> 
						</a><br>". date("H:i:s");

		}
		
		echo  $item;
	}

}
	

?>
