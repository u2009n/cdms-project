<?php
	require_once 'c:/www/htdocs/cdms/models/db-settings.php';
	require_once 'c:/www/htdocs/cdms/checkout/classes/checkout_list.class.php';
	require_once 'c:/www/htdocs/cdms/checkout/classes/ipo.class.php';
	
	$date = date("d");
	$month = date("m");
	$year = date("Y");
	$months = array ('January', 'February', 'March', 'April', 'May', 'June', 'July', 
					 'August', 'September', 'October', 'November', 'December');
	$conn = new db_rows();
	

		$checkout_list = new  checkoutList();
		$list_month = $month < 12 ? $month + 1 : 1 ;
		$year = $month < 12 ? $year : $year + 1;
		$list_count =0;
		$list_month_name = $months[$list_month -1];
		
		
		$list_count = $checkout_list->getListCount($list_month + 1, $year);
		
		
		if($list_count > 0){
	
			$pst_field_array = array();
			$notice_token = time(); 
			
			$supervisors = $conn->get_rows('positions', array(array('supervisor', 'rec_post_id')));
			
			if(is_array($supervisors) && !empty($supervisors)){
			
				foreach($supervisors as $supervisor){
					$fields[0] = array('rec_post_id', $supervisor['rec_post_id']);
					$fields[1]= array('notice_title', " $list_month_name $year Check Out List");
					$fields[2] = array('action_page', 'checkout_list');
					$fields[3] = array('notice_type', 1);
					$fields[4] = array('notice_status', 'New');
					$fields[5] = array('notice_token', $notice_token . rand(1000, 9999));
					$pst_field_array[] = $fields;
					//sleep(1);
					
				}
					
				foreach($pst_field_array as $fields){
					echo $action = $conn->insert_row('sys_position_notice', $fields);	
				}				
			} 
			
		}
		
?>