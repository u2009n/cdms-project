

<?php
	require_once '../models/config.php';
	require_once 'classes/notice.class.php';
	require_once 'classes/ipo.class.php';
  //  if (!securePage($_SERVER['PHP_SELF'])){die();}
	$my_cp_no = $loggedInUser->cpnomber;
	$my_details = unserialize($_SESSION['my_details']);	
	$my_post_id = $my_details->position->post_id;
	
	$ipo= new ipo();
	$position = new position;
	$note = NULL;
	$notice = new notice();
	$application_id = NULL;
    $approver_name = null;
    
    $temp_post_ids = array();
	$temp_obj='';
	$temp_obj = unserialize($_SESSION['my_temp_appointments']);
	//print_r($temp_obj);
	$temp_position_objects = $temp_obj->positions;
	
    if(is_array($temp_position_objects))
	    foreach($temp_position_objects as $temp_position_object)
		    $temp_post_ids[] = $temp_position_object->post_id;
	
  
    
	if(isset($_REQUEST['k'])){
		$page_key = $_REQUEST['k'];
		$key = decrypt($page_key);
        $key1 = decrypt($page_key);
		$conn = new db_rows();
		//echo $key;
		$key = " position_notice.id = $key ";
		
					  
		$table = "position_notice 
					INNER JOIN (
								repatriation_request  
								INNER JOIN 
									repatriation_reasons
								ON 
									repatriation_request.reason_id=repatriation_reasons.id
						)
						
				    ON 
						position_notice.notice_token = repatriation_request.notice_token 
                     
				 ";
					  

		$fields = array(array('repatriation_request.applicant_cp_no', 'applicant_cp_no'),
						array('repatriation_request.applicant_post_id', 'applicant_post_id'),
						array('repatriation_request.repatriant_cp_no', 'ipo_cp_no'),
						array('repatriation_request.repatriant_post_id', 'ipo_post_id'),
						array('repatriation_request.approver_post_id', 'approver_post_id'),
						array('repatriation_request.approver_cp_no', 'approver_cp_no'),
						array('repatriation_request.eeom_date', 'eeom_date'),
                        array('repatriation_request.current_eeom_date', 'current_eeom_date'),
						array('repatriation_request.application_date', 'application_date'),
						array('repatriation_request.status', 'status'),
						array('repatriation_request.applicant_note', 'justification'),
						array('repatriation_request.approver_note', 'approver_note'),
						array('repatriation_reasons.reason', 'reason'),
						array('repatriation_request.status_date', 'status_date'),
						array('repatriation_request.notice_token', 'notice_token'),
						array('repatriation_request.id', 'application_id')						
					  );
				 
		$rows = $conn->get_rows($table, $fields, $key);
									
	

		if(is_array($rows)){
           
           
			
			$item = NULL;
			foreach($rows as $row){
				extract($row);
                
                
                $header='';
                $footer = "</table>";
                $header = "<table> <tr><th colspan=\"2\"><H2>Request For Repatriation              ".$header.=($status == 'Approved')? "<a href=\"index.php?p=" .encrypt('repatriation.pdf')."&i=" 
									                                 .encrypt($key1)."\" target=\"_blank\"><img src=\"assets/downloadpdf.png\" alt=\"Download\"> </a>" :'';"</H2></th></tr>";
                
                $approved_note = $row['approver_note'];
				$ipo->getIPO($ipo_cp_no);
				$repatriant_name = $ipo->firstName. ' '. $ipo->lastName;
				$repatriant_position = $ipo->position->sector_name. "\\".
								$ipo->position->teamsite_name. "\\".
								$ipo->position->unit_name. "\\".
								$ipo->position->post_name;
				$repatriant_eom = $ipo->eom;
				
				$ipo->getIPO($applicant_cp_no);
				
				$applicant_name = $ipo->cp_no. ' '. $ipo->firstName . ' '. $ipo->lastName;
				
				$position->getPosition($applicant_post_id);
				$applicant_position  = 	$position->sector_name . "\\".
										$position->teamsite_name . "\\".
										$position->unit_name . "\\".
										$position->post_name;				

				if(!is_null($approver_cp_no)){
					$ipo->getIPO($approver_cp_no);					
					$approver_name = $ipo->firstName . ' '. $ipo->lastName;
					
					$approver_position = 	$ipo->position->sector_name . "\\".
											$ipo->position->teamsite_name . "\\".
											$ipo->position->unit_name . "\\".
											$ipo->position->post_name;	
	
				}
				else{
					$position = new position($approver_post_id);
					$approver_position = $position->sector_name . "\\".
										  $position->teamsite_name . "\\".
										  $position->unit_name . "\\".
										  $position->post_name;					
					
				}
/*								
				$status = $row['status'];
				$approver_id = $row['approver_id'];
				$application_id =  $row['application_id'];
				$applicant_cp_no = encrypt($row['cp_no']);
*/
				$eeom_date = date('d M Y', strtotime($eeom_date));
				$eom_date = date('d M Y', strtotime($current_eeom_date));
				
				$item .= "<tr><th>CP NO.</th><td>$ipo_cp_no</td></tr>";
				$item .= "<tr><th>Names</th><td>$repatriant_name</td></tr>";
				$item .= "<tr><th>Placement</th><td>$repatriant_position</td></tr>";
				$item .= "<tr><th>Current EOM</th><td>$eom_date</td></tr>";
				$item .= ($status == 'Approved')?  "<tr><th>New EOM</th><td>$eeom_date</td></tr>":"<tr><th>Requested EOM</th><td>$eeom_date</td></tr>";
				$item .= "<tr><th>Reason for EEOM</th><td>$reason</td></tr>";
				$item .= "<tr><th>Submitted by</th><td>$applicant_name<p> $applicant_position</p></td></tr>";
                $item .= "<tr><th>Submitted To </th><td>$approver_name<p> $approver_position</p></td></tr>";
				$item .= "<tr><th>Submitted date</th><td>". date('d M Y', strtotime($application_date))."</td></tr>";
				$item .= "<tr><th>Request Status</th><td>$status</td></tr>";
				//$item .= "<tr><th>Status Date</th><td>". date('d M Y', strtotime($status_date))." </td></tr>";
						 "</td></tr>";
				$item .= "<tr><th>Details</th>
							  <td>
								$justification
							    <input id=\"applicant$application_id\" type=\"hidden\" value=\"". encrypt($applicant_post_id)."\">
								<input id=\"repatriant_post_id$application_id\" type=\"hidden\" value=\"". encrypt($ipo_post_id)."\">
								<input id=\"repatriant$application_id\" type=\"hidden\" value=\"". encrypt($ipo_cp_no)."\">
								<input id=\"eeom$application_id\" type=\"hidden\" value=\"". encrypt($eeom_date)."\">
								<input id=\"token$application_id\" type=\"hidden\" value=\"". encrypt($notice_token)."\">
							  </td>
						</tr>";
                $item .=($status != 'Submitted')? "<tr><th>Approver's Comment.</th><td>$approved_note</td></tr>":'';	
				/*$item.=($status == 'Approved')? "<a href=\"index.php?p=" .encrypt('repatriation.pdf')."&i=" 
									  .encrypt($key1)."\" target=\"_blank\"><img src=\"assets/downloadpdf.png\" alt=\"Download\"> </a>" :'';*/				
				//if($approver_post_id == $my_post_id && $status == 'Submitted'){
                if(($approver_post_id == $my_post_id || in_array($approver_post_id, $temp_post_ids)) && $status == 'Submitted'){	
					$item .= "	
								<tr>
										<th style=\"vertical-align: top; background-color: silver; \"></th>
										<td style=\"vertical-align: top; background-color: silver; \">
											Comment:
											<textarea cols=\"50\" rows=\"3\" id=\"note$application_id\">$note</textarea>&nbsp&nbsp
											Approve<input type=\"radio\" id=\"approved$application_id\" name=\"approve\" value=\"Approved\">
											&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
											Reject <input type=\"radio\" id=\"rejected$application_id\" name=\"approve\" value=\"Rejected\">
											
										</td>
								</tr>
								<tr >									
									<td colspan=\"2\" style=\"vertical-align: top; background-color: red; \" id=\"msg$application_id\">
								</tr>
								<tr >
									<td style=\"vertical-align: top; background-color: silver; \"></td>
									<td style=\"vertical-align: top; background-color: silver; \" >
										<button onclick=\"approve_repatriation('$application_id', '$applicant_cp_no')\">Submit</button>
									</td>
								</tr>
							 ";
								
				}
				
				
				
				
				
				
			}
			echo $header.$item.$footer;
		}
													  
	}

?>