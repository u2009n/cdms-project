

<?php
	require_once '../models/config.php';
	require_once 'classes/notice.class.php';
	require_once 'classes/placement.class.php';
	require_once 'classes/tokenizer.class.php';
    require_once 'classes/noticas.class.php';
	// if (!securePage($_SERVER['PHP_SELF'])){die();}
    $my_details='';
	$my_cp_no = $loggedInUser->cpnomber;
	$my_details = unserialize($_SESSION['my_details']);	
	$my_post_id = $my_details->position->post_id;
	$my_supervisors = $my_details->position->command_chain;
	
	$casualty_cp_no = NULL;
	$casualty_post_id = NULL;
	$incident_date = NULL;
	$incident_time = NULL;
	$incident_scene = NULL;
	$incident_type = NULL;
	$incident_description = NULL;
	$approver_name = NULL;
	$approver_post = NULL;
	$casualty_supervisors = array();

	$notice = new notice();
    $noticas=new noticas();
	$position = new position();
	


	
	if(isset($_POST)){
		$conn = new db_rows();
		$casualty_cp_no = decrypt($_POST['c']);
		$casualty_post_id = decrypt($_POST['pi']);
		$casualty_condition_id = $_POST['cs'];
		$casualty_duty_status = $_POST['ds'];
		$casualty_location = addslashes($_POST['l']);
		$incident_extra_info = addslashes($_POST['ei']);
		$incident_date = $_POST['d'];
		$incident_time = $_POST['t'];
		$incident_scene = addslashes($_POST['s']);
		$incident_description = addslashes($_POST['n']);
		$incident_type_id = $_POST['i'];
		$approver_name = addslashes($_POST['an']);
		$approver_post = addslashes($_POST['ap']);
    
		$noticas_date = date("Y-m-d h:m:s");
	    $incident_date_time = date("Y-m-d h:m", strtotime("$incident_date $incident_time"));
		$table='noticas';
		$tokenizer = new tokenizer();
		$notice->notice_token = $tokenizer->tokenize();		
		//echo "<pre>";
				
        
     
        $key = "noticas.casualty_cp_no = '$casualty_cp_no' AND noticas.status = 'Submitted'";
        
        $filds = array(array('noticas.casualty_cp_no', 'casualty_cp_no'),
						array('noticas.status', 'status'),
                        );
       
        $rows = $conn->get_rows($table,$filds,$key);
        
        
		
         if(is_array($rows) && (empty($rows))){   
             
            $fields = array(
                           // array('noticas_date',  $noticas_date),
                            array('casualty_cp_no',  $casualty_cp_no),
                            array('casualty_post_id', $casualty_post_id),
                            array('incident_type_id', $incident_type_id),
                            array('incident_date', $incident_date_time),
                            array('incident_location', $incident_scene),
                            array('incident_description', $incident_description),
                            array('draft_by_cp_no', $my_cp_no),
                            array('draft_by_post_id', $my_post_id), 
                            array('casualty_status', $casualty_condition_id),
                            array('casualty_current_location', $casualty_location),
                            array('incident_extra_info', $incident_extra_info),
                            array('on_duty', $casualty_duty_status),
                            array('noticas.status', 'Submitted'),
                            array('authorised_by_names', $approver_name),
                            array('authorised_by_title', $approver_post),
                            array('notice_token', $notice->notice_token)
                      );
            
            $task = $conn->insert_row($table, $fields);
            
            
            
            $position->getPosition($casualty_post_id);
            $casualty_supervisors = $position->command_chain;
            $notice->sender_cp_no=$my_cp_no;
            $notice->sender_post_id=$my_post_id;
            $notice->notice_title= "Notice of Casualty: $casualty_cp_no";
            $notice->notice_action_page = "sup_view_noticas";	
            $notice->notice_status="New";	
            
            foreach($casualty_supervisors as $casualty_supervisor){
                $notice->recipient_post_id=$casualty_supervisor[0];
                $notice->addPositionNotice();
            }
            
            echo ($task ==1) ? "==================>>Record Saved": $task;
        }else{
            
            echo("===================>>The noticas Record already saved");
        } 

    }

?>