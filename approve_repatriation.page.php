

<?php
	require_once '../models/config.php';
	require_once 'classes/notice.class.php';
	require_once 'classes/ipo.class.php';
	require_once 'classes/placement.class.php';
//if (!securePage($_SERVER['PHP_SELF'])){die();}
	$my_cp_no = $loggedInUser->cpnomber;
    $my_details = unserialize($_SESSION['my_details']);		
	$my_post_id = $my_details->position->post_id;	
	$note = NULL;
	$notice = new notice();
	$position = new position();
	$application_id = NULL;
	$repatriant_supervisors  = array();
	
	if(isset($_REQUEST['k'])){
		$key = $_REQUEST['k'];
		$note = $_REQUEST['n'];
		$status = $_REQUEST['s'];
		$repatriant_cp_no = decrypt($_REQUEST['r']);
		$applicant_post_id = decrypt($_REQUEST['a']);
		$repatriant_post_id = decrypt($_REQUEST['i']);
		$notice_token = decrypt($_REQUEST['t']);
		$applicant_eom = decrypt($_REQUEST['e']);
		$datetime=date("Y-m-d", time());
        $rows=array();
		$repatriant_supervisors = $position->getSupervisors($repatriant_post_id);		
		$conn = new db_rows();
		$key =  " id = $key  AND status ='Submitted'";
        
		$table = "repatriation_request";
		$fields = array(array('status', $status)
						
					
				   );
				   
     
        
        $rows = $conn->get_rows($table, $fields , $key);
        
		if(!empty($rows)){
		
            $fields = array(array('status', $status),
						array('approver_note', $note),
                        );
            $update_request = $conn->update_row($table, $fields, $key);

		if($status == "Approved"){
			$table = "ipo";		
			$fields = array(array('eom', date("Y-m-d", strtotime($applicant_eom))));
			
			$update_ipo_eom = $conn->update_row($table, $fields, "cp_no='$repatriant_cp_no'");
		}
		
			$notice->sender_cp_no=$my_cp_no;
			$notice->sender_post_id=$my_post_id;
			$notice->notice_title= "$status: Early End of Mission (Repatriation): $repatriant_cp_no";
			$notice->notice_status="New";
			$notice->notice_token = $notice_token;
			$notice->notice_action_page = "sup_view_repatriation";
			$repatriant_supervisors[] = array($applicant_post_id, '');
			
			foreach($repatriant_supervisors as $repatriant_supervisor){
				$notice->recipient_post_id = $repatriant_supervisor[0];
				$notice->addPositionNotice();
			}
		
            if($status == "Approved"){
                
                $notice->notice_action_page = "checkout_reminder";
			}
			else{
				$notice->notice_action_page = "view_eeom_status";
			}
            
			if($status=="Approved"){
				$notice->recipient_cp_no = $repatriant_cp_no;
				$notice->addPrivateNotice();
			}

			echo "Approval Successful"; 
		}			
		
		//echo $rows;
														  
	}

?>