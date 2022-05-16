

<?php
	require_once '../models/config.php';
	require_once 'classes/notice.class.php';
	require_once 'classes/ipo.class.php';
	require_once 'classes/placement.class.php';
   // if (!securePage($_SERVER['PHP_SELF'])){die();}
    $my_details='';
	$cp_no = $loggedInUser->cpnomber;
	$my_details = unserialize($_SESSION['my_details']);	
	$my_post_id = $my_details->position->post_id;
	
	$notice = new notice();
	$noticas_id = NULL;
	$casualty=NULL;
	$originator = NULL;

	
    $temp_post_ids = array();
	//echo "<pre>";
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
		$conn = new db_rows();
		//echo $key;
		$key = " notice.id = $key";
		
		$table = "noticas  LEFT JOIN 
							noticas_incident_type  ON 
								noticas.incident_type_id = noticas_incident_type.id 
					  LEFT JOIN noticas_casualty_status 
						ON noticas.casualty_status = noticas_casualty_status.id 						
				   LEFT JOIN position_notice  AS notice
						ON noticas.notice_token = notice.notice_token";

		$fields = array(array('noticas.casualty_cp_no', 'casualty_cp_no'),
						array('noticas.casualty_post_id', 'casualty_post_id'),
						array('noticas.incident_date', 'incident_date'),
						array('noticas.noticas_date', 'noticas_date'),
						array('noticas.incident_description', 'incident_description'),
						array('noticas.incident_extra_info', 'incident_extra_info'),
						array('noticas.casualty_current_location', 'casualty_location'),
						array('noticas.incident_location', 'incident_location'),
						array('noticas.on_duty', 'on_duty'),
						array('noticas.notice_token', 'token'),
						array('noticas_casualty_status.status_title', 'casualty_status'),
						array('noticas_incident_type.incident_type', 'incident_type'),
						array('noticas.draft_by_cp_no', 'originator_cp_no'),
						array('noticas.draft_by_post_id', 'originator_post_id'),
				);
				 
		$rows = $conn->get_rows($table, $fields, $key);

		if(is_array($rows)){
			
			$footer = "</table>";
			$header = "<table> <tr></tr>";
			$item = NULL;
			
			foreach($rows as $row){
				extract($row);
				$casualty = new ipo($casualty_cp_no);
				$casualty_placement = new position($casualty_post_id);
				$originator = new ipo($originator_cp_no);
				$originator_post = new position($originator_post_id);
				
				$item .= "<tr><th colspan=\"2\"><h2>Notice of Casualty</h2></th></tr>";
				$item .= "<tr><th>CP NO.</th><td>".$casualty_cp_no."</td></tr>";
				$item .= "<tr><th>Names</th><td>".$casualty->firstName. ' '. $casualty->lastName ."</td></tr>";
				$item .= "<tr><th>Placement</th><td>".
								    $casualty_placement->sector_name.'\\'.
									$casualty_placement->teamsite_name.'\\'.
									$casualty_placement->unit_name.'\\'.
									$casualty_placement->post_name.
						     "</td>
						  </tr>";
				$item .= "<tr><th>Date of Arrival</th><td>".date('d M Y', strtotime($casualty->doa))."</td></tr>";
				$item .= "<tr><th>Current EOM</th><td>".date('d M Y',strtotime($casualty->eom))."</td></tr>";
				$item .= "<tr><th>Incident Date</th><td>".date('d M Y:h.m', strtotime($incident_date))."</td></tr>";
				$item .= "<tr><th>Casualty Status</th><td>".$casualty_status."</td></tr>";
				$item .= "<tr><th>Casualty Current Location</th><td>".$casualty_location."</td></tr>";
				$item .= "<tr><th>Incident Category</th><td>".$incident_type."</td></tr>";
				$item .= "<tr><th>Description</td><td>".$incident_description."</td></tr>";
				$item .= "<tr><th>Additional Info.</th><td>".$incident_extra_info."</td></tr>";	
				$item .= "<tr><th>Recorded By.</th><td>".$originator->firstName. ' '.$originator->lastName."</td></tr>";
				$item .= "<tr><th>Position.</td>
							  <td>".$originator_post->sector_name . '\\'.
									$originator_post->teamsite_name . '\\'.
									$originator_post->unit_name . '\\'.
									$originator_post->post_name 
							  ."</td>
						  </tr>";
				//$item .= "<tr><td>Stamp.</td><td>".$token."</td></tr>";					
			}
			
			echo $header.$item.$footer;
		}
													  
	}

?>