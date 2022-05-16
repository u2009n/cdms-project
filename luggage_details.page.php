<?php
	require_once '../models/config.php';
	require_once 'classes/luggage.class.php';
   // if (!securePage($_SERVER['PHP_SELF'])){die();}
	$rec_id=NULL;
	$travel_date = NULL;
	$address = NULL;
	$description = NULL;
	$town_id = NULL;
	$mode = NULL;
	
	if(isset($_POST)){
		$mode = $_POST['m'];
		$lag_object = new luggageDeclaration();	
		$rec_id= $_POST['i'];
		
		$lag_object->destination_id = $_POST['t'];
		$lag_object->forwarding_address = $_POST['a'];
		$lag_object->luggage_description = $_POST['s'];
		$lag_object->travel_date = $_POST['d'];
		$lag_object->cp_no = $_POST['cp'];
        
  
		$task = $mode == 'a' ? $lag_object->addLuggageDeclaration() : 
		                 $lag_object->updateLuggageDeclaration($rec_id);
		
		echo $task ;

        
	}
	
	
?>