<?php
	//require_once '../config.php';
	require_once 'classes/contingent.class.php';
   // if (!securePage($_SERVER['PHP_SELF'])){die();}

	$list = null;
	$contingent_id = $_REQUEST['c'];

	$contingent = new mcontingent();
	//$x = time();

	$destinations = array();

	$destinations = $contingent->getDestinations($contingent_id);


	foreach($destinations as $destination)
	   $list .=  $destination['town_name'] . "<p>";
	   
	echo $list . "<input type=\"text\" id=\"new_destination\"><button onclick=\"new_destination()\">+</button><br><div id=\"dest_msg\"></div>";
		
    
?>