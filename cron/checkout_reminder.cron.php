<?php
	require_once 'c:/www/htdocs/cdms/models/db-settings.php';
	require_once 'c:/www/htdocs/cdms/checkout/classes/checkout_list.class.php';
	require_once 'c:/www/htdocs/cdms/checkout/classes/ipo.class.php';
	
	$date = date("d");
	$list_month = date('m', strtotime("+2 months", time()));
	$year = date('Y', strtotime("+2 months", time()));
	$months = array ('January', 'February', 'March', 'April', 'May', 'June', 'July', 
					 'August', 'September', 'October', 'November', 'December');
					 
	
		$checkout_list = new checkoutList();
		$conn=new db_rows();
		
		$list = $checkout_list->generateList($list_month, $year);
		
		
		if(is_array($list) && !empty($list)){
			
			$item_count =  count($list);
			$pvt_field_array = array();
			$pst_field_array = array();
			$notice_token = time() ;
			$list_month_name = $months[$list_month - 1];
			
			foreach($list as $list_item){
				$fields[0] = array('rec_cp_no', $list_item['cp_no']);
				$fields[1]= array('notice_title', " $list_month_name $year Check Out Reminder");
				$fields[2] = array('action_page', 'checkout_reminder');
				$fields[3] = array('notice_type', 1);
				$fields[4] = array('notice_status', 'New');
				$fields[5] = array('notice_token', $notice_token . rand(1000, 9999));
				$pvt_field_array[] = $fields;
				//sleep(1);
			} 
			//echo "<pre>";
			//print_r($pvt_field_array);
			
			
			
			foreach($pvt_field_array as $fields){
				echo $action = $conn->insert_row('sys_private_notice', $fields);	
			}	
			

			
		}
		

	

?>