<?php
require_once '../models/config.php';
if (!securePage($_SERVER['PHP_SELF'])){die();}
if(!isset($_SESSION['userCakeUser'])) header('Location:../login.php');
$requested_page = NULL;
$page_key = NULL;

 
if(isset($_REQUEST['p'])){
	
	if(isset($_REQUEST['k'])){
		$page_key = decrypt(trim($_REQUEST['k']));
	}
	
	$requested_page= decrypt(trim($_REQUEST['p'])). '.page.php';
  
  
 require_once $requested_page;
}

?>