<?php 
	require_once '../models/config.php';
	require_once 'classes/db_row.class.php';
	require_once 'classes/ipo.class.php';
   // if (!securePage($_SERVER['PHP_SELF'])){die();}
    $my_details='';
	$my_cp_no = $loggedInUser->cpnomber;
    $my_details = unserialize($_SESSION['my_details']);	
	$my_post_id = $my_details->position->post_id;
		
	
		
	if(isset($_REQUEST['k']))
        $repatriant_cp_no = trim(decrypt($_REQUEST['k']));
		
    if(isset($_REQUEST['r']))
			$rec_cp_no = trim(decrypt($_REQUEST['r']));
        
     
       
        
        
                $sender_cp_no= $my_cp_no;
                $sender_post_id= $my_post_id;	
                $notice_title= "You Are Authorized to Make Check Out For The IPO: $repatriant_cp_no";	
                $notice_status="New";	
                $action_page = "checkout_reminder";	
                $notice_token = $repatriant_cp_no;	
               
        
        
        
        
        
        $Rows = array ();
        $conn = new db_rows();
      
        $table= "represent_repatriation";
        $filds = array(array('represent_repatriation.notice_token', 'notice_token'), );
            
        $key = "represent_repatriation.notice_token = '$repatriant_cp_no'";
        $rows = $conn->get_rows($table, $filds, $key);
            
            
            
        if(is_array($rows) && (empty($rows))){
            
                 $filds= array( 
                                array('sender_cp_no', $sender_cp_no),
                                array('sender_post_id', $sender_post_id),
                                array('rec_cp_no', $rec_cp_no),
                                array('notice_title', $notice_title),
                                array('action_page', $action_page),
                                array('notice_token', $notice_token),
                                array('notice_status', $notice_status),
                                array('notice_type', 1)
                                                            
                                       );
            
            $task = $conn->insert_row($table,$filds);                            
            
            echo"=========>>Recored Submitted ";
        }else{
              echo" ==============>>The IPO already has Check out  Authrization";
              }   
	
?>