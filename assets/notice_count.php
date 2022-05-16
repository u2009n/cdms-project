<?php
	$protocol  = empty($_SERVER['HTTPS']) ? 'http' : 'https';
	$domain    = $_SERVER['SERVER_NAME'];
	$full_url  = "$protocol://{$domain}"."/cdms/"; 
	$require_url = '../checkout/classes/';

	require_once '/config.php';
	require_once $require_url .'notice.class.php';
	$cp_no= $loggedInUser->cpnomber;
	$logged_in_user_details = unserialize($_SESSION['my_details']);
	$temporary_placement = unserialize($_SESSION['my_temp_appointments']);
	$temp_positions = $temporary_placement->positions;


	$post_id = $logged_in_user_details->position->post_id;


			
	//echo "<pre>";
	//print_r($logged_in_user_details);

	$notice = new notice();
	//$x = time();
	$notice_count = $notice->MessageCount('pvt', $cp_no, 1, 'New');
    $notice_count += $notice->MessageCount('rep', $cp_no, 1, 'New');
	$notice_count +=  $notice->MessageCount('pst', $post_id, 1, 'New');
	$notice_count += $notice->MessageCount('sys_pst', $post_id, 1, 'New');
	$notice_count += $notice->MessageCount('sys_pvt', $cp_no, 1, 'New');

	if(!empty($temp_positions))
		foreach($temp_positions as $position){
			$notice_count +=  $notice->MessageCount('sys_pst', $position->post_id, 1, 'New');
			$notice_count +=  $notice->MessageCount('sys_pst', $position->post_id, 1, 'New');
		}
		
	echo "<div id=\"p_notice_count\" onlclick=\"get_task_list()\"> <h2>You Have <a href=\"$full_url" . "checkout/index.php?p="
				.encrypt("task_list") ."\">$notice_count </a>pending Check-Out activities<h2>
			</div>
		<br>" ;
		
		//print_r($_SERVER);
?>