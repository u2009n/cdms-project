

<?php
	require_once '../models/config.php';
	require_once 'classes/notice.class.php';
	require_once 'classes/ipo.class.php';
   // if (!securePage($_SERVER['PHP_SELF'])){die();}
	$cp_no = $loggedInUser->cpnomber;
	
	$approver_post_id = NULL;
	$note = NULL;
	$notice = new notice();
	$application_id = NULL;
    $rows=array();
	
	if(isset($_REQUEST['k'])){
		$key = $_REQUEST['k'];
		$note = addslashes($_REQUEST['n']);
		$status = $_REQUEST['s'];
		$applicant_cp_no = decrypt($_REQUEST['a']);
		$notice_token = decrypt($_REQUEST['t']);
		$applicant_eom = decrypt($_REQUEST['e']);
		$approver_post_id = decrypt($_REQUEST['ap']);
		
		$applicant = new ipo($applicant_cp_no);
		$applicant_supervisors = $applicant->position->command_chain;
		$conn = new db_rows();
        
		$key =  " id = $key  AND status ='Submitted'";
        $table = "eeom_request";
		$fields = array(array('status', $status),
						
				   );
        $rows = $conn->get_rows($table, $fields, $key);
       // extract($rows);
        if(!empty($rows)){
            
            $fields = array(array('status', $status),
						array('approver_note', $note),
				   );
            $update_request = $conn->update_row($table, $fields, $key);

            if($status == "Approved"){
                $table = "ipo";		
                $fields = array(array('eom', date("Y-m-d", strtotime($applicant_eom))));
                
                $update_ipo_eom = $conn->update_row($table, $fields, "cp_no='$applicant_cp_no'");
            }
            
            if ($update_request ==1){
                $notice->sender_cp_no=$cp_no;
                $notice->sender_post_id=$approver_post_id;
                $notice->notice_title= "$status: Application For Early Check-Out: $applicant_cp_no";
                $notice->notice_status="New";
                $notice->notice_token = $notice_token;
                $notice->notice_action_page = "sup_view_eeom";
                
                foreach($applicant_supervisors as $supervisor){
                    $notice->recipient_post_id=$supervisor[0];
                    $notice->addPositionNotice();
                }
                
                if($status == "Approved"){
                    $notice->notice_action_page = "checkout_reminder";
                }
                else{
                    $notice->notice_action_page = "view_eeom_status";
                }
                
                $notice->recipient_cp_no=$applicant_cp_no;
                $notice->addPrivateNotice();
                $notice->notice_action_page = "sup_view_eeom";
                $notice->recipient_post_id="2055";
                $notice->addPositionNotice();
                echo "Update Successful"; 
            }			
            
        }
    }
    
?>