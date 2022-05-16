

<?php
	require_once '../models/config.php';
	require_once 'classes/notice.class.php';
	require_once 'classes/db_combo.class.php';
	require_once 'classes/time_combo.class.php';
    if (!securePage($_SERVER['PHP_SELF'])){die();}
	$my_cp_no = $loggedInUser->cpnomber;
    $my_details='';
	$my_details = unserialize($_SESSION['my_details']);	
	$my_post_id = $my_details->position->post_id;
	
	$combo_list = new db_combo();
	$time_combo = new _time();
	$notice = new notice();
    $page='noticas';

    
    
    
	
	if(isset($_POST['k'])){
		$ipo_index = $_POST['k'];

		//($table, $list_field, $value_field, $select_attrib, $filter=NULL,  $option_attrib=NULL, $default_text=NULL, $default_value=NULL)
		$incident_type = $combo_list->combo(
													'incident_types', 
													'incident_type', 
													'id', 
													"id= incident$ipo_index", 
													'id > 0', 
													'',
													''
											);
		
		$casualty_status= $combo_list->combo(
													'noticas_casualty_status', 
													'status_title', 
													'id', 
													"id= cas_status$ipo_index", 
													'id > 0', 
													'',
													''
											);
		//($d_name, $m_name, $y_name, $default_d=NULL, $default_m=NULL, $default_y=NULL)
		$date_combo = $time_combo->date_box(
												"d$ipo_index", 
												"m$ipo_index",
												"y$ipo_index",
												date("d", time()),
												date("m", time()),
												date("Y", time())
											);
											
		//time_box($h_name, $m_name, $default_h=NULL, $default_m = NULL)
			
		$hours_combo = $time_combo->time_box("h$ipo_index","m$ipo_index", '','');
											
		$footer = "</table>";
		$header = "<table>";
		$item = NULL;
		
	

			$item .= "<tr>
							<th>Date & Time of Incident.</th>
							<td colspan=\"3\">
								$date_combo &nbsp;
								hh:$hours_combo
							</td>
					  </tr>";
			$item .= "<tr>
							<th>Incident Type</th>
							<td>$incident_type</td>
							<th>Condition of Casualty</th>
							<td>$casualty_status</td>							
					  </tr>";
					  
			$item .= "<tr>
						<th>Place of Occurrence</th>
						<td><input type=\"text\" id=\"place$ipo_index\" size=\"50\">

					   </td>
					   <th>On Duty?</th>
					   <td>
						  <span>
								<input type=\"radio\" name=\"duty$ipo_index\" 
									onclick=\"document.getElementById('duty_status$ipo_index').value = 'Y';\" > Yes
									
								<input type=\"radio\" name=\"duty$ipo_index\" 
								  onclick=\"document.getElementById('duty_status$ipo_index').value = 'N';\"> No 
						 </span>					   
					   </td>					   
					</tr>";

					  
			$item .= "<tr>
						<th>Current Location of Victim</th>
						<td colspan=\"3\"><input type=\"text\" id=\"loc$ipo_index\" size=\"50\"></td>
					</tr>";
					
			$item .= "<tr>
							<th>Description</th>
							<td colspan=\"3\">
								<textarea cols=\"80\" rows=\"2\" id=\"desc$ipo_index\"></textarea>
							</td>
					  </tr>";

	        $item .= "<tr>
							<th>Additional Comments</th>
							<td colspan=\"3\">
								<textarea cols=\"80\" rows=\"2\" id=\"comm$ipo_index\"></textarea>
							</td>
					  </tr>";
					
			$item .= "<tr>
						<th colspan=\"4\">To Be Approved by<br>
						
							<table>
								<tr>
									<th>Full Names</th>
									<td><input type=\"text\" id=\"approver_name$ipo_index\" size=\"80\"></td>
								</tr>
								<tr>
									<th width=\"19%\">Functional Title</th>
									<td><input type=\"text\" id=\"approver_post$ipo_index\" size=\"80\"></td>
								</tr>
							</table>
						</th>
					</tr>";
					
		
					
			$item .= "<tr>
						<th colspan=\"4\">
                         <span id=\"msg$ipo_index\"></span><br>
							<button onclick=\"submit_noticas('$ipo_index', 'n')\">Submit</button>
							<button onclick=\"unload_interface('$page','$ipo_index')\">Cancel</button>
						</th>						
					</tr>";				
			
			echo $header.$item.$footer;

	
	}

?>