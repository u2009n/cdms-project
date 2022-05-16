<?php
 require_once '../models/config.php';
 require_once 'classes/ipo_bank.class.php';
 //if (!securePage($_SERVER['PHP_SELF'])){die();}


 $bank_name = '';
 $branch_name = '';
 $branch_address='';
 $swift_code='';
 $iban='';
 $routing_abn = '';
 $account_no ='';
 $mode ='';
 $cp_no = $loggedInUser->cpnomber; 
 $task = null;
 
 	if(isset($_POST)){
		 $my_bank_details = new ipoBankdetails();
		 
		 $my_bank_details->bank_name = $_POST['n'];
		 $my_bank_details->branch_name = $_POST['b'];
		 $my_bank_details->branch_address= $_POST['a'];
		 $my_bank_details->swiftcode= $_POST['s'];
		 $my_bank_details->iban= $_POST['i'];
		 $my_bank_details->routing_abn =  $_POST['r'];
		 $my_bank_details->account_no = $_POST['c'];
		 $my_bank_details->cp_no =$_POST['cp'];
		 $mode =  $_POST['m'];
		 
         //echo $mode;
		 if($mode == 'a') {
				$task = $my_bank_details->addIPOBank_details();
              
         }
         
		 elseif($mode == 'e'){
				$task = $my_bank_details->updateBankDetails($cp_no);
	     }
		 
		 //print_r($my_bank_details);
		 echo $task;
        
         
	 }


?>