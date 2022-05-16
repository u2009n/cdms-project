

<?php
	require_once '../models/config.php';
	require_once 'classes/notice.class.php';
    //if (!securePage($_SERVER['PHP_SELF'])){die();}
	$my_cp_no = encrypt($loggedInUser->cpnomber);
	$my_post_id = encrypt($loggedInUser->post_id);
	$noticas_history_page = encrypt("noticas_history");
	$noticas_page = encrypt("new_noticas");
	$repatriation_page = encrypt("new_repatriation");
    $repatriation_history_page = encrypt("repatriation_history");
    $eeom_by_oic_page= encrypt("new_eeom_by_oic");
    $count=0;
   
    
    
    
	if(isset($_POST['k'])){
		$key = $_POST['k'];
		$conn = new db_rows();
 
//echo $key;
		$key = " ipo.cp_no LIKE '%$key%' OR ipo.IndexNo LIKE '%$key%' OR ipo.FirstName LIKE '%$key%' OR ipo.LastName LIKE '%$key%' ";
		

		$table = "country LEFT JOIN 
								ipo LEFT JOIN 
										(positions LEFT 
												JOIN full_unit_name 
											ON positions.unit_id = full_unit_name.unit_id
										)
					            ON ipo.post_id = positions.post_id
					   
					  ON ipo.cntr_id = country.cntr_id
				 ";
					  


		
		$fields = array(array('ipo.cp_no', 'cp_no'),
						array("UCASE(CONCAT (ipo.FirstName, ' ', ipo.LastName))", 'names'),
						array("UCASE (CONCAT(full_unit_name.full_name, '/',positions.post_name ))", 'position'),
						array('ipo.eom', 'eom'),
						array('ipo.doa', 'doa'),
						array('ipo.Gender', 'gender'),
						array('ipo.IndexNo', 'index_no'),
						array('ipo.post_id', 'post_id'),
						array('UCASE(country.cntr_name)', 'country')						
					  );
				 
		$rows = $conn->get_rows($table, $fields, $key);
		$count=count($rows);					
	

		if(is_array($rows)){
			
            
            $header='';
			$footer = "</table>";
			$header.= "<table>";
			
			
			foreach($rows as $row){
				$eom = strtotime($row['eom']);
				$doa = strtotime($row['doa']);
				$casualty_post_id = encrypt($row['post_id']);
				
				$today = time();
				$item = "";
				$ipo_cp_no = encrypt($row['cp_no']);
				$ipo_index = $row['index_no'];
				
				$item .= "<tr>
							<th>CP NO.</th>
							<td >"
								.$row['cp_no']."
								<input type=\"hidden\" id=\"casualty_cp$ipo_index\" value=\"$ipo_cp_no\">
								<input type=\"hidden\" id=\"casualty_post$ipo_index\" value=\"$casualty_post_id\">
								<input type=\"hidden\" id=\"my_cp$ipo_index\" value=\"$my_cp_no\">
								<input type=\"hidden\" id=\"my_post$ipo_index\" value=\"$my_post_id\">
								<input type=\"hidden\" id=\"duty_status$ipo_index\" >
							</td>
							<th>Index NO.</th><td>".$row['index_no']."</td>
							<th>Gender</th><td>".$row['gender']."</td>
						 </tr>";
						 
				$item .= "<tr><th>Names</th><td colspan=\"5\">".$row['names']."</td></tr>";
				$item .= "<tr><th>Placement</th><td colspan=\"5\">".$row['position']."</td></tr>";

				$item .= "<tr>
							<th>Contingent</th>
							<td colspan=\"5\">".$row['country']."</td>
						</tr>";
				
				if(intval(($eom) / (60*60*24)) >= intval(($today) / (60*60*24))){
					$days = intval(($eom - $today) / (60*60*24));
					$status =  $days <= 10 ? "Checking Out" : "Active";
                    $criteria =  $days <= 10 ? "Checking Out" : "Active";
					$status .= " ($days days left).";
				}
				else{
					$status = "Checked Out";
                    $criteria = "Checked Out";
                }
				$item .= "<tr>
								
							<th>Date of Arrival</th>
							<td>".date("d M Y", $doa)."</td>
							<th>Date of End of Mission</th>
							<td>".date("d M Y", $eom)."</td>
							<th>Duty Status</th>
							<td>$status</td>
						 </tr>";
			   	$new_button = (($criteria == "Checked Out") || ($criteria == "Checking Out") || ($count>1))?'':  
										" <button onclick = \"load_interface('$ipo_index', 'n', '$noticas_page')\">New NOTICAS </button>
										  <button onclick = \"load_interface('$ipo_index', 'n', '$repatriation_page')\">Request Repatriation</button>
                                          <button onclick = \"load_interface('$ipo_index', 'n', '$eeom_by_oic_page')\">Request EEOM</button>
                                          <button onclick=\"load_interface('$ipo_index','F','$repatriation_history_page')\">Repatriation History</button>
									      <button onclick=\"load_interface('$ipo_index', 'h',  '$noticas_history_page')\">Noticas History</button>"
										;
				
				$item .= "<tr>
								<th colspan=\"6\">
									$new_button 
                                    
                                    
								</th>
						  </tr>";
						  
				$item.= "<th colspan=\"6\" id=\"noticas$ipo_index\"></th></tr>";
				echo $header.$item.$footer;
              
			}

		}
		 
		else 
			echo $rows;
	}

?>