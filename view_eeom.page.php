

<?php
	require_once '../models/config.php';
	require_once 'classes/db_row.class.php';
	require_once 'classes/notice.class.php';
  //  if (!securePage($_SERVER['PHP_SELF'])){die();}
	$notice = new notice();
	$conn= new db_rows();
	$logged_in_user_details='';
	$cp_no = $loggedInUser->cpnomber;
	$logged_in_user_details = unserialize($_SESSION['my_details']);
	$logged_in_user_supervisors = $logged_in_user_details->position->command_chain;
    //echo "<pre>";
	//print_r($logged_in_user_details->position);
	
	
	$reason_id = NULL;
	$position=NULL;
	$approver_post_id = NULL;
	$eeom_date = NULL;
	$note = NULL;
	$row = 0;
    $flag= NULL;
	$interface=NULL;
	
	
	if(isset($_REQUEST['k'])){
		$request_id = decrypt($_REQUEST['k']);
		$notice_token= decrypt($_REQUEST['t']);
		
		if(isset($_REQUEST['f']) && $_REQUEST['f'] == 'r'){
			
			$fields = array(array("status", "Recalled"),
							array("status_date", date("Y-m-d"))
						);
						
			$row = $conn->update_row('eeom_request',$fields, "id = $request_id");
			
			if ($row == 1){
				$notice->sender_cp_no=$cp_no;
				$notice->sender_post_id=$loggedInUser->post_id;
				$notice->notice_title= "Recalled: Application For Early Check-Out: $cp_no";
				$notice->notice_status="New";
				$notice->notice_token=$notice_token;
				$notice->notice_action_page = "sup_view_eeom";
				
				foreach($logged_in_user_supervisors as $logged_in_user_supervisor){
					$notice->recipient_post_id=$logged_in_user_supervisor[0];
					$notice->addPositionNotice();
				}
			}			
			
			
		}
			
		
		$table = "eeom_request 
					INNER JOIN positions ON eeom_request.approver_post_id = positions.post_id
					AND eeom_request.id = $request_id LIMIT 1";
		
		$fields =  array(
						 array('eeom_request.applicant_note', 'note'),
						 array('positions.post_name', 'approver'),
						 array('eeom_request.status_date', 'status_date'),
						 array('eeom_request.status', 'status'),
						 array('eeom_request.notice_token', 'notice_token'),
						 array('eeom_request.approver_note', 'approver_note'),
					  );
									
									
		$rows = $conn->get_rows($table, $fields);
													  
	
		if(is_array($rows)){
			$header = "<table>";
							  
							
						
			foreach($rows as $row){
					$rec_id = encrypt($request_id);
					$approver_note = $row['approver_note'];
					$notice_token= encrypt($row['notice_token']);
					
					$show_approver_note = ($approver_note !=='') ? 
								"<p><b>Approver's Comment:</b><br> $approver_note" : '';
								
					$interface="<tr>
									
									<td width=\"15%\"><b>Last Action: </b> ".$row['status_date']."</td>
									<td width=\"25%\"><b>Submitted to: </b> ".$row['approver']."</td>
									<td width=\"50%\">
											<b>Applicant Additional Info.: </b><br>".$row['note']. " $show_approver_note
											<input type=\"hidden\" value=\"".$row['notice_token']."\" id=\"token\">
									</td>
																		
								</tr>";
			}
			
			$interface .="<tr>
							 <td colspan=\"4\">".
									$x= ($row['status']=="Submitted") ? 
										"<button onclick=\"view_eeom('$request_id', 
											'$rec_id', 'Recall', '$notice_token')\";>Recall</button> " : ''

							."</td>
						  </tr>";
							
			echo $header.$interface."</table>";
            
		}
	}
?>