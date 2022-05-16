<?php
	require_once '../models/config.php';
	require_once 'classes/db_row.class.php';
   // if (!securePage($_SERVER['PHP_SELF'])){die();}
	$cp_no = $loggedInUser->cpnomber;
	$reason_id = NULL;
	$position=NULL;
	$approver_post_id = NULL;
	$eeom_date = NULL;
	$note = NULL;
	$row = 0;
	$interface = NULL;
	$conn= new db_rows();
	
	
	if(isset($_REQUEST['k'])){
		$request_id = decrypt($_REQUEST['k']);
			
		
		$table = "eeom_request 
					INNER JOIN positions ON eeom_request.approver_post_id = positions.post_id
					INNER JOIN private_notice ON private_notice.notice_token = eeom_request.notice_token 
					AND private_notice.id = $request_id LIMIT 1";
		
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
			
							
			echo $header.$interface."</table>";
		}
	}
?>