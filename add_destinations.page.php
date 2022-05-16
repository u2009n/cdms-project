<?php
require_once '../models/config.php';
require_once 'classes/contingent.class.php';
require_once 'js/msg.js';
if (!securePage($_SERVER['PHP_SELF'])){die();}
$result = NULL;
$contingent_id = $_REQUEST['c'];
$destination_name = $_REQUEST['d'];


$contingent = new mcontingent();
//$x = time();

if ($destination_name!==''){
    $result = $contingent->addDestination($contingent_id, $destination_name);


    if( $result == 1){
       // echo "<script> alert(\"record saved\");</script>";
        echo "record saved";
    }
    else{
        echo $result;
    }
	
}
?>

 