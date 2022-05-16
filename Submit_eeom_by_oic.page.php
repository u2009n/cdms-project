<?php 
	require_once '../models/config.php';
	require_once 'classes/notice.class.php';
	require_once 'classes/placement.class.php';
	require_once 'classes/tokenizer.class.php';
    require_once 'classes/ipo.class.php'; 
   // if (!securePage($_SERVER['PHP_SELF'])){die();}
    
	if(!isset($loggedInUser)) header('Location:../login.php');
	$my_cp_no = $loggedInUser->cpnomber;
	
    $my_details='';
    $my_details = unserialize($_SESSION['my_details']);	
    $post_id = $my_details->position->post_id;
	$eom = $my_details->eom;
	
    
    
    $tokenizer = new tokenizer();
	$notice_token = $tokenizer->tokenize();
	$position = new position();
	


	$reason_id = NULL;
	$my_position=NULL;
	$approver_post_id = NULL;
	$eeom_post_id = NULL;
	$eeom_date = NULL;
	$eom = NULL;
	$note = NULL;
	$row = 0;
    $index=0;
	$day=$month=$year=NULL;
	$notice = new notice();
	
	
	if(isset($_REQUEST['d']))
		$eeom_date = trim($_REQUEST['d']);
	
	if(isset($_REQUEST['r']))
		$reason_id = trim($_REQUEST['r']);
	
	if(isset($_REQUEST['a']))
		$approver_post_id = trim($_REQUEST['a']);
	
	if(isset($_REQUEST['n']))
        $note = addslashes(trim($_REQUEST['n']));
	
	if(isset($_REQUEST['k']))
			$index = trim($_REQUEST['k']);
		
	if(isset($_REQUEST['c']))
			$applicant_cp_no = trim(decrypt($_REQUEST['c']));
		
		if(isset($_REQUEST['pi']))
			$repatriant_post_id = trim(decrypt($_REQUEST['pi']));
        
        $ipo_info = new ipo($applicant_cp_no);
        $ipo_eom= $ipo_info->eom;
        $eeom_post_id= $ipo_info->post_id;
        
        
        $datetime1 = date_create($ipo_eom);
        $datetime2 = date_create($eeom_date);
        
	/*	$datetime1 = date_create($ipo_eom);
        $eeom_date=date('Y-m-d',strtotime($eeom_date));
       $datetime2 = date_create($eeom_date);
       $datetime2 =date('Y-m-d',strtotime($eeom_date));*/
       
       
       
        $Rows = array ();
        $conn = new db_rows();
       
        
        $table= "eeom_request";
        $filds = array(array('eeom_request.applicant_cp_no', 'applicant_cp_no'),
						array('eeom_request.status', 'status'),
                       ); 
        $key = "eeom_request.applicant_cp_no = '$applicant_cp_no' AND eeom_request.status = 'Submitted'";
       // $key = " position_notice.id = $key ";
        
        
       
        if(strlen($eeom_date) > 4 && (($datetime1))>=(($datetime2))){
		
		
		
          $rows = $conn->get_rows($table, $filds, $key);
         if(is_array($rows) &&(empty($rows))){
               
             
             $row = $conn->insert_row('eeom_request', array( array('applicant_cp_no', $applicant_cp_no),
                                                            array('eeom_date', date("Y-m-d", strtotime($eeom_date))),
                                                            array('current_eeom_date', date("Y-m-d", strtotime($ipo_eom))),
                                                            array('reason_id', $reason_id),
                                                            array('Applicant_note', addslashes($note)),
                                                            array('approver_post_id', $approver_post_id),
                                                            array('status', 'Submitted'),
                                                            array('status_date', date("d-m-y")),
                                                            array('notice_token', $notice_token)
                                                          )
                                        );
            
            if ($row == 1){
                $eeom_supervisors = array();
                $position->getPosition($eeom_post_id);
                $eeom_supervisors = $position->command_chain;
                $notice->sender_cp_no=$my_cp_no;
                $notice->sender_post_id=$post_id;
                $notice->notice_title= "Application For Early Check-Out: $applicant_cp_no";
                $notice->notice_status="New";
                $notice->notice_action_page = "sup_view_eeom";
                $notice->notice_token = $notice_token;
                $notice->recipient_post_id=$approver_post_id;
                
                foreach($eeom_supervisors as $supervisor){
                    $notice->recipient_post_id=$supervisor[0];
                    $notice->addPositionNotice();				
                }

                $notice->recipient_post_id=$approver_post_id;
                $notice->addPositionNotice();
                
                echo "=================>>Record submitted";
            }
        
         }else{
             echo"============>>The Ipo already has EEOM application";
             
             exit;
         }   
        }else{
            
            echo "========>>the date of EEOM must be before  ".$ipo_info->eom;
            
        }
	
?>