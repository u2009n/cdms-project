<?php
	require_once('db_row.class.php');
	require_once ('notice.class.php');


	class checkoutList{

		protected  $conn;  			 
		function __construct($chkOutMonth= NULL, $chkOutYear = NULL){
			$this->conn= new db_rows();
			if ($chkOutMonth !== NULL && $chkOutYear !== NULL)
				return $this->generateList($chkOutMonth, $chkOutYear);
			
		}
		
		function generateList($chkOutMonth, $chkOutYear){
			$fields = array( 	array('ipo.cp_no', 'cp_no'), 
								array('ipo.IndexNo', 'IndexNo'),
								array('ipo.FirstName', 'firstName'),
								array('UCASE(ipo.LastName)', 'lastName'),
								array('ipo.doa', 'doa'),
								array('ipo.eom', 'eom'),
								array('ipo.Gender', 'sex'),
								array('ADDDATE(ipo.eom, -10)', 'MHQDate'),
								array('country.cntr_code', 'cntr_code'),
								array('towns.town_name', 'destination')
			 
							);
							
			$table = 'ipo LEFT JOIN (luggage LEFT JOIN towns ON luggage.destination_id = towns.id ) ON ipo.cp_no = luggage.cp_no INNER JOIN country ON ipo.cntr_id = country.cntr_id ';
			$filter= "YEAR(ipo.eom) = $chkOutYear AND MONTH(ipo.eom) = $chkOutMonth ORDER BY ipo.cp_no ASC";
			
			
			
			$rows= $this->conn->get_rows($table, $fields, $filter);
			
			if(is_array($rows) && !empty($rows))
				return $rows;
			else
				echo "Error";
			
		}
		

		
		function getListCount($chkOutMonth, $chkOutYear){
			$table = "ipo";
			$filter = "YEAR(ipo.eom) = $chkOutYear AND MONTH(ipo.eom) = $chkOutMonth";
			$fields = array(array('COUNT(ipo.cp_no)', 'chk_count'));
			
			$rowcount= $this->conn->get_rows($table, $fields, $filter);
			
			if(is_array($rowcount) && !empty($rowcount)){
				return $rowcount[0]['chk_count'];
			}
			else{
				echo "Error";
				return 0;
			}
		}
		
		
	}
?>