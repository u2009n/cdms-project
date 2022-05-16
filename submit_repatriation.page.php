<?php 
	require_once '../models/config.php';
	require_once 'classes/notice.class.php';
	require_once 'classes/placement.class.php';
	require_once 'classes/tokenizer.class.php';
	//if(!isset($loggedInUser)) header('Location:../login.php');
	$my_cp_no = $loggedInUser->cpnomber;
	$my_details = unserialize($_SESSION['my_details']);	
	$my_post_id = $my_details->position->post_id;
	$tokenizer = new tokenizer();
	$notice_token = $tokenizer->tokenize();
	$position = new position();
	
//	$db_date = new DateTime($loggedInUser->eom);	
//	$e = strtotime($loggedInUser->eom);	
//	$eom = "$e";

	$reason_id = NULL;
	$my_position=NULL;
	$approver_post_id = NULL;
	$repatriant_cp_no=NULL;
	$repatriant_post_id = NULL;
	$eeom_date = NULL;
	$eom = NULL;
	$note = NULL;
	$row = 0;
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
			$repatriant_cp_no = trim(decrypt($_REQUEST['c']));
		
		if(isset($_REQUEST['pi']))
			$repatriant_post_id = trim(decrypt($_REQUEST['pi']));
        
        $ipo_info = new ipo($repatriant_cp_no);
        $ipo_eom=$ipo_info->eom;
        
		$datetime1 = date_create($ipo_eom);
        $datetime2 = date_create($eeom_date);
        
        $Rows = array ();
        $conn = new db_rows();
       
        
        $table= "repatriation_request";
        $filds = array(array('repatriation_request.repatriant_cp_no', 'repatriant_cp_no'),
						array('repatriation_request.status', 'status'),
                       ); 
        $key = "repatriation_request.repatriant_cp_no = '$repatriant_cp_no' AND repatriation_request.status = 'Submitted'";
       // $key = " position_notice.id = $key ";
        
        
       
        if(strlen($eeom_date) > 4 && (($datetime1))>=(($datetime2))){
		
		
		//print_r ($_REQUEST);
           
            
            //$rows = $conn1->get_rows($table,$fildes,$key); 
            $rows = $conn->get_rows($table, $filds, $key);
            if(is_array($rows) &&(empty($rows))){
             
               
            $row = $conn->insert_row('repatriation_request', array( array('applicant_cp_no', $my_cp_no),
                                                            array('applicant_post_id', $my_post_id),
                                                            array('eeom_date', $eeom_date),
                                                            array('current_eeom_date', $ipo_eom),
                                                            array('reason_id', $reason_id),
                                                            array('applicant_note', $note),
                                                            array('repatriant_cp_no', $repatriant_cp_no),
                                                            array('repatriant_post_id', $repatriant_post_id),
                                                            array('approver_post_id', $approver_post_id),
                                                            array('status', 'Submitted'),
                                                            array('status_date', date("d-m-y")),
                                                            array('notice_token', $notice_token)
                                                          )
                                        );
            
            if ($row == 1){
                $repatriant_supervisors = array();
                $position->getPosition($repatriant_post_id);
                $repatriant_supervisors = $position->command_chain;
                $notice->sender_cp_no= $my_cp_no;
                $notice->sender_post_id= $my_post_id;	
                $notice->notice_title= "Request For Repatriation: $repatriant_cp_no";	
                $notice->notice_status="New";	
                $notice->notice_action_page = "sup_view_repatriation";	
                $notice->notice_token = $notice_token;	
                $notice->recipient_post_id=$approver_post_id;
                
                foreach($repatriant_supervisors as $supervisor){				
                    $notice->recipient_post_id=$supervisor[0];
                    $notice->addPositionNotice();			 
                }
                
                $notice->recipient_post_id=$approver_post_id;
                $notice->addPositionNotice();
                
                echo "================>>Record submitted";
                
            }  
             
       }else{
            echo"===================>>The Ipo already has Repatraition application";
           
        exit;
        }   
	}else{
        
        echo "===========>>the date of repatriation must be before  :".$ipo_info->eom;
        
        }
	
?>