

<?php
	require_once '../models/config.php';
	require_once 'classes/notice.class.php';
   // if (!securePage($_SERVER['PHP_SELF'])){die();}
	$cp_no = $loggedInUser->cpnomber;
	$post_id = $loggedInUser->post_id;
	
	
	$db_date = new DateTime($loggedInUser->eom);	
	$notice = new notice();
	
	
	if(isset($_REQUEST['k'])){
		$key = decrypt($_REQUEST['k']);
		$conn = new db_rows();
		$key = $key > 0 ? " notice.token = $key AND notice.rec_post_id = $post_id " : "";
		
		$application = "eeom_request AS application LEFT JOIN 
							eeom_request_reasons as reason ON 
											application.reason_id=reason.id ";
		
		$approver = "positions AS approver_post ";
							
		$applicant = "ipo AS applicant LEFT JOIN (positions AS ipo_post 
							LEFT JOIN full_unit_name ON ipo_post.unit_id = full_unit_name.unit_id)
					  ON applicant.post_id = ipo_post.post_id";
					  
		$_notice = "position_notice as notice";
					  
		$table = "$application LEFT JOIN $applicant ON application.applicant_cp_no= applicant.cp_no
					LEFT JOIN $approver ON application.approver_post_id = approver_post.post_id
						LEFT JOIN $_notice ON application.notice_token=notice.token";
		
		$fields = array(array('applicant.cp_no', 'cp_no'),
						array("CONCAT (applicant.FirstName, ' ', applicant.LastName)", 'names'),
						array("CONCAT(full_unit_name.full_name, '/',ipo_post.post_name )", 'ipo_post'),
						array('applicant.eom', 'eom'),
						array('application.applicant_note', 'note'),
						array('application.eeom_date', 'eeom'),
						array('reason.reason', 'reason'),						
						array('approver_post.post_name', 'approver'),
						array('approver_post.post_id', 'approver_post_id'),
						array('application.application_date', 'submitted_date'),
						array('application.status_date', 'status_date')
						
					  );
				 
		$rows = $conn->get_rows($table, $fields, $key);
									
	

		if(is_array($rows)){
			
			$footer = "</table>";
			$header = "<table> <tr><th colspan = \"2\">EEOM-Request Cancellation</th></tr>";
			$item = NULL;
			foreach($rows as $row){
				$item .= "<tr><td>CP NO.</td><td>".$row['cp_no']."</td></tr>";
				$item .= "<tr><td>Names</td><td>".$row['names']."</td></tr>";
				$item .= "<tr><td>Placement</td><td>".$row['ipo_post']."</td></tr>";
				$item .= "<tr><td>CUrrent EOM</td><td>".date('d-m-Y',strtotime(['eom']))."</td></tr>";
				$item .= "<tr><td>Requested EOM</td><td>".date('d-m-Y',strtotime($row['eeom']))."</td></tr>";
				$item .= "<tr><td>Reason for EEOM</td><td>".$row['reason']."</td></tr>";
				$item .= "<tr><td>Submitted to</td><td>".$row['approver']."</td></tr>";
				$item .= "<tr><td>Submitted date</td><td>".date('d-m-Y',strtotime($row['submitted_date']))."</td></tr>";
				$item .= "<tr><td>Cancelled date</td><td>".date('d-m-Y',strtotime($row['status_date']))."</td></tr>";
				
			}
			echo $header.$item.$footer;
		}
													  
	}

?>