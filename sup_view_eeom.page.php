

<?php
	require_once '../models/config.php';
	require_once 'classes/notice.class.php';
   // if (!securePage($_SERVER['PHP_SELF'])){die();}
	$cp_no = $loggedInUser->cpnomber;
	$my_details = unserialize($_SESSION['my_details']);
	$post_id = $my_details->position->post_id;
	$temp_post_ids = array();
	//echo "<pre>";
    $temp_obj='';
	$temp_obj = unserialize($_SESSION['my_temp_appointments']);
	//print_r($temp_obj);
	$temp_position_objects = $temp_obj->positions;
	
    if(is_array($temp_position_objects))
	    foreach($temp_position_objects as $temp_position_object)
		    $temp_post_ids[] = $temp_position_object->post_id;
		

	$temp_obj = 
	$note = NULL;
	$notice = new notice();
	$application_id = NULL;

	
	if(isset($_REQUEST['k'])){
		$page_key = $_REQUEST['k'];
		$key = decrypt($page_key);
		$conn = new db_rows();
		//echo $key;
        $key1=$key;
		$key = " notice.id = $key";
		
		$application = "eeom_request AS application LEFT JOIN 
							eeom_request_reasons as reason ON 
											application.reason_id=reason.id ";
		
		$approver = "positions AS approver_post ";
							
		$applicant = "ipo AS applicant LEFT JOIN (positions AS ipo_post 
							LEFT JOIN full_unit_name ON ipo_post.unit_id = full_unit_name.unit_id)
					  ON applicant.post_id = ipo_post.post_id";
					  
		$_notice = "position_notice as notice";
					  
		$table = "$_notice LEFT JOIN $application ON notice.notice_token = application.notice_token
					LEFT JOIN $approver ON application.approver_post_id = approver_post.post_id 
					LEFT JOIN $applicant ON applicant.cp_no = application.applicant_cp_no";
		
		$fields = array(array('applicant.cp_no', 'cp_no'),
						array("CONCAT (applicant.FirstName, ' ', applicant.LastName)", 'names'),
						array("CONCAT(full_unit_name.full_name, '/',ipo_post.post_name )", 'ipo_post'),
               			array('applicant.eom', 'eom'),
						array('application.applicant_note', 'note'),
						array('application.eeom_date', 'eeom'),
                        array('application.current_eeom_date', 'current_eeom_date'),
						array('reason.reason', 'reason'),						
						array('approver_post.post_name', 'approver'),
						array('approver_post.post_id', 'approver_id'),
						array('application.application_date', 'submitted_date'),
						array('application.status_date', 'status_date'),
						array('application.id', 'application_id'),	
						array('application.notice_token', 'stamp'),
						array('application.status', 'status'),
                        array('application.approver_note', 'approver_note')
					  );
				 
		$rows = $conn->get_rows($table, $fields, $key);
									
	

		if(is_array($rows)){
			
			$header=null;
			$item = NULL;
            $status=null;
			foreach($rows as $row){
                
                $status = $row['status'];
                $footer = "</table>";
                $header = "<table> <tr><th colspan=\"2\"><H2>Request For EEOM                ".$header.=($status == 'Approved')? "<a href=\"index.php?p=" .encrypt('early_end_of_mission_pdf')."&i=" 
                                     .encrypt($key1)."\" target=\"_blank\"><img src=\"assets/downloadpdf.png\" alt=\"Download\"> </a>" :'';"</H2></tr>";
                
				
				$approver_id = $row['approver_id'];
				$application_id =  $row['application_id'];
				$applicant_cp_no = encrypt($row['cp_no']);
				
				$item .= "<tr><th>CP NO.</th><td>".$row['cp_no']."</td></tr>";
				$item .= "<tr><th>Names</th><td>".$row['names']."</td></tr>";
				$item .= "<tr><th>Placement</th><td>".$row['ipo_post']."</td></tr>";
				$item .= "<tr><th>Current EOM</th><td>".date('d-m-Y',strtotime($row['current_eeom_date']))."</td></tr>";
				$item .=($status == 'Approved')?  "<tr><th>New EOM</th><td>".date('d-m-Y',strtotime($row['eeom']))."</td></tr>":
                        "<tr><th>Requested EOM</th><td>".date('d-m-Y',strtotime($row['eeom']))."</td></tr>";
				$item .= "<tr><th>Reason for EEOM</th><td>".$row['reason']."</td></tr>";
               // $item .= "<tr><th>Submitted by</th><td>".$row['approver']."</td></tr>";
				$item .= "<tr><th>Submitted to</th><td>".$row['approver']."</td></tr>";
				$item .= "<tr><th>Submitted date</th><td>".date('d-m-Y',strtotime($row['submitted_date']))."</td></tr>";
				$item .= "<tr><th>Request Status</th><td>$status</td></tr>";
               //	$item .= "<tr><th>Status Date</th><td>".date('d-m-Y',strtotime($row['status_date']))." </td></tr>";
                $item .= "	<tr><th>Applicant Notes</th><td>".$row['note']." </td></tr>";
                $item .=($status != 'Submitted')? "<tr><th>Approver's Comment</th><td>".$row['approver_note']."</td></tr>":'';
						 "</td></tr>";
				
				if(($approver_id == $post_id || in_array($approver_id, $temp_post_ids)) && $status == 'Submitted'){
					
					$item .= "<input type=\"hidden\" id=\"stamp$application_id\" value=\"". encrypt($row['stamp'])."\">
										 <input type=\"hidden\" id=\"eeom$application_id\" value=\"". encrypt($row['eeom'])."\">
										 <input type=\"hidden\" id=\"approver$application_id\" value=\"". encrypt($approver_id)."\">
									</td>
								</tr>
								<tr>
										<th style=\"vertical-align: top;  \"></th>
										<th style=\"vertical-align: top; \">
											Comment:
											<textarea cols=\"50\" rows=\"3\" id=\"note$application_id\">$note</textarea>&nbsp&nbsp
											Approve<input type=\"radio\" id=\"approved$application_id\" name=\"approve\" value=\"Approved\">
											&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
											Reject <input type=\"radio\" id=\"rejected$application_id\" name=\"approve\" value=\"Rejected\">
											
										</th>
								</tr>
																</tr>
								<tr >									
									<td colspan=\"2\" style=\"vertical-align: top; \" id=\"msg$application_id\">
								</tr>
								<tr >
									<th style=\"vertical-align: top; \"></td>
									<th style=\"vertical-align: top;  \" >
										<button onclick=\"approve_eeom('$application_id', '$applicant_cp_no')\">Submit</button>
									</th>
								</tr>
							 ";
								
				}
				
				
			}
			echo $header.$item.$footer;
		}
													  
	}

?>