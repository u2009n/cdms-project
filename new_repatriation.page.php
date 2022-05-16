

<?php
	require_once '../models/config.php';
	require_once 'classes/db_combo.class.php';
	require_once 'classes/time_combo.class.php';
   // if (!securePage($_SERVER['PHP_SELF'])){die();}
  //  require_once 'ipo.class.php';
   // $cp_no = $loggedInUser->cpnomber;
	$db_combo = new db_combo();
	$_tm= new _time();
	$page='noticas';
    
    
   
    
	
	if(isset($_POST['k']))
		$index = $_POST['k'];
	
	/*$eeom = $_tm->date_box(
							   array("eeom_day$index", 01, 31, date("d")), 
							   array("eeom_month$index", 01, 12, date("m")),
							   array("eeom_year$index", date("Y"), date("Y", time()) +1, date("Y") )
							);*/
    
    
    $eeom = $_tm->date_box(
                                               "d$index", 
                                               "m$index",
                                               "y$index",
                                               date("d", time()),
                                               date("m", time()),
                                               date("Y", time())
                                           );
    
    
								
	//echo $m;	
	$interface="<td   colspan=\"5\">
					  <table>
						<tr>
							<th>Proposed EOM Date</th>
							<th>$eeom</th>
						</tr>
						</tr>
							<th>Approving Officer</th>
							<td>".$db_combo->combo('positions', 'post_name', 'post_id', 
													"id=\"approver$index\"", 'keypost = 2', '', '', 
													'Select approver from list').
							"</td>
	
						</tr>
						<tr>
							<th>Reason for Early Check out</th>
							<td>".$db_combo->combo('repatriation_reasons', 'reason', 'id', 
													"id= reason$index", 'id > 0', '', '', 
													'Select reason from list').
							"</td>
							
						</tr>
						<tr>
							<th> Details  <span id=\"t_count$index\"><span></th>
							<td>
								<textarea id=\"note$index\" cols=\"70\" rows=\"3\" id=\"note\" 
									onchange=\"t_count('$index')\"></textarea>
							</td>
						</tr>
						<tr>							
							<th colspan=\"2\">
							    <span id=\"msg$index\"></span><br>
								<button  onclick=\"submit_repatriation('$index')\">Submit</button>
								<button onclick=\"unload_interface('$page','$index')\">Cancel</button>
							</th>
							
								
						</tr>
					</table>  
					
					
				</td>";
				
	echo $interface;			
	

?>