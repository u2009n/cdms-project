

<?php
	require_once '../models/config.php';
	require_once 'classes/db_combo.class.php';
	require_once 'classes/time_combo.class.php';
	require_once 'classes/notice.class.php';
    require_once("../models/datepicker.php");
    require_once 'Classes/DateCalc.php';
   if (!securePage($_SERVER['PHP_SELF'])){die();}
	$cp_no = $loggedInUser->cpnomber;
	$my_details='';
?>	
	<script type="text/javascript" language="javascript">
	    $(function () {
	        $("#datepicker").datepicker("option", "minDate", "Today");

	    });
	    </script> 
   
<?php	
    //$db_date = new DateTime($loggedInUser->eom);
    $my_details = unserialize($_SESSION['my_details']);		
	$eom = $my_details->eom;
    $ipo_index = $my_details->indexNo;
	$supervisors = $my_details->position->command_chain;
	$post_id = $my_details->position->post_id;	
	$db_combo = new db_combo();
    $notice = new notice();
	$reason_id = NULL;
	$position=NULL;
	$approver_post_id = NULL;
	$eeom_date = NULL;
	$note = NULL;
	$row = 0;
	$day=$month=$year=NULL;
	$_tm=new _time();
    
    if(isset($_REQUEST['d']))
		$eeom_date = trim($_REQUEST['d']);
	
	if(isset($_REQUEST['r']))
		$reason_id = trim($_REQUEST['r']);
	
	if(isset($_REQUEST['a']))
		$approver_post_id = trim($_REQUEST['a']);
	
	if(isset($_REQUEST['n']))
        $note = trim($_REQUEST['n']);
    
    
   
      if(strlen($eeom_date) > 4) {
            
            //print_r ($_REQUEST);
            $conn = new db_rows();
            $notice_token = time(). rand(10000, 99999);
            $row = $conn->insert_row('eeom_request', array( array('applicant_cp_no', $cp_no),
                                                            array('eeom_date', $eeom_date),
                                                            array('current_eeom_date', $eom),
                                                            array('reason_id', $reason_id),
                                                            array('applicant_note', addslashes($note)),
                                                            array('approver_post_id', $approver_post_id),
                                                            array('status', 'Submitted'),
                                                            array('status_date', date("Y-m-d")),
                                                            array('notice_token', $notice_token)
                                                          )
                                        );
            
            if ($row == 1){
                $notice->sender_cp_no=$cp_no;
                $notice->sender_post_id=$post_id;
                $notice->notice_title= "Application For Early Check-Out: $cp_no";
                $notice->notice_status="New";
                $notice->notice_action_page = "sup_view_eeom";
                $notice->notice_token = $notice_token;
                $notice->recipient_post_id = $approver_post_id;
                $notice->addPositionNotice();			
                
                foreach($supervisors as $supervisor){
                    $notice->recipient_post_id=$supervisor[0];
                    $notice->addPositionNotice();				
                }


            }
        
        }											  
	
        
        
        
/*$m= date("m", strtotime($eom));
   
	$eeom = $_tm->date_box(
							   array('eeom_day', 01,31,date("d")), 
							   array('eeom_month',01, 12, date("m")),
							   array('eeom_year', date("Y"), date("Y", strtotime($eom)), date("Y"))
							);*/
    
    


    
    $eeom = $_tm->date_box(
												"d$ipo_index", 
												"m$ipo_index",
												"y$ipo_index",
												date("d", time()),
												date("m", time()),
												date("Y", time())
											);

								
//<td>$eeom</td>	
   
   
   
   ?>

<script language="javascript" type="text/javascript">
    var MinCalcDate = new Date('<?php echo $MinCalculationDate;  ?>');
</script>   
<?php
	$interface="
					  <table>
						<tr>
							<th>Proposed EOM Date</th>
							<th>Reason for Early Check-Out</th>
							<th>Approving Officer</th>
							<th>Additional Details</th>
							
						</tr>
						<tr>
                         <td>$eeom</td>
							
							<td>".$db_combo->combo('eeom_request_reasons', 'reason', 'id', 'id="reason"', 'id > 0', '', '', $reason_id)."</td> 
                            
							<td>".$db_combo->combo('positions', 'post_name', 'post_id', 'id="approver"', 'keypost = 2', '', '' )."</td>
							<td><textarea id=\"note\" cols=\"40\" rows=\"3\" id=\"note\">$note</textarea></td>
							
						</tr>
						<tr>
							<td colspan=\"4\"><button  onclick=\"sub_new_eeom('$eom','$ipo_index')\">Submit</button>
                            <button onclick=\"new_eeom('Cancel')\">Cancel</button></td>
							
								
						</tr>
					</table> "; 
					
     //Select reason from list
    //---[Select approver from list]--
				
				
	echo $interface;			
       
	
?>