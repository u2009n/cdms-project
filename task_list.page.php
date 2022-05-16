

<?php
	ob_start();
	require_once("../models/config.php");
    require_once("../models/funcs.php");
	//if (!securePage($_SERVER['PHP_SELF'])){die();}
	require_once '/classes/notice.class.php';
	require_once("../models/header.php");
	require_once("/js/approve_eeom.js");
	require_once("/js/validate_input.js");	
	require_once("/js/bank_details.js");
	require_once("/js/luggage.js");
	require_once("/js/noticas.js");
	//require_once('../models/datepicker.php');	
	require_once '/classes/m_array_sort.class.php';	
?>
	<!--<meta charset="utf-8">-->
        
<link rel='stylesheet' type='text/css' href='../style/menu.css'>
<link href='../style/tablecloth.css' rel='stylesheet' type='text/css' media='screen' />
<script type='text/javascript' src='../style/tablecloth.js'></script>

<table width=100%>
    <tr>
    <th >CENTRAL DATABASE MANAGEMENT SYSTEM</th>
  </tr>
    
</table> 
 
</div>
<div id='main'> 
 
<?php
//include('/config.php');
if(isset($_GET['id'])){$nopage=$_GET['id'];}
?>

<link rel="stylesheet" href="../style/example.css" TYPE="text/css" MEDIA="screen">
<link rel="stylesheet" href="../style/example-print.css" TYPE="text/css" MEDIA="print">

<script type="text/javascript" src="../style/tabber.js"></script>
<script language="javascript" type="text/javascript">
    function show(deg_id,field_id,maj_id) {
        document.frm.submit();
		
    }
    </script>


<!---->
<link href="../Style/Styles_app.css" rel="stylesheet" type="text/css">

</head>

<table width="100%" border="0">
  <tr >
    <th width="274" align="left" scope="col">logged in as: <?php 
                                                            $aa=$loggedInUser->displayname; echo $aa; ?> </th>
    <th width="757" height="10"  scope="col"></th>
    <th width="112" scope="col"><p><a href="../account.php"> Back </a></p></th>
  </tr>
</table>

<?php

	//require_once '../models/header.php';
	
	$cp_no=NULL;
	$post_id=NULL;
	$pvt_notices = array();
	$post_notices = array();
	$notice_items = array();
    $rep_notice = array();
    $x=array();
	$table_item = NULL;
	$table_header = NULL;
	$temp_positions= array();
	$logged_in_user_details='';
    $temporary_placement='';
	
	$logged_in_user_details = unserialize($_SESSION['my_details']);
	$temporary_placement = unserialize($_SESSION['my_temp_appointments']);
	$temp_positions = $temporary_placement->positions;
    $post_id = $logged_in_user_details->position->post_id;	
	$cp_no = $loggedInUser->cpnomber;



	
	$notice = new notice();

	if($cp_no !== ''){
		$pvt_notices = $notice->incomingPrivateList($cp_no);
		
		if(!empty($pvt_notices)){
			
			foreach($pvt_notices as $notice_item){
				$notice_items[] = $notice_item;
			}
		}
		
      
    
       $rep_notice = $notice->incomingRepresentList($cp_no);
		
       if(!empty($rep_notice)){
			
            foreach($rep_notice as $notice_item){
				$notice_items[] = $notice_item;
                $x[]= $notice_item;
			}
		}
        
        
        
        
        
		$sys_pvt_notices = $notice->incomingSysPrivateList($cp_no);
		
		if(!empty($sys_pvt_notices)){
			
			foreach($sys_pvt_notices as $notice_item){
				$notice_items[] = $notice_item;
			}
		}		
	}
	
	if($post_id !== '') { 
		$post_notices = $notice->incomingPositionList($post_id);
	
		if(!empty($post_notices)){ 
		   
			foreach($post_notices as $notice_item){
				$notice_items[] = $notice_item;
			}
				
		}
		
		$sys_post_notices = $notice->incomingSysPositionList($post_id);
		//print_r($sys_post_notices);
		if(!empty($sys_post_notices)){ 
		   
			foreach($sys_post_notices as $notice_item){
				$notice_items[] = $notice_item;
			}
				
		}
	}

	if(!empty($temp_positions)){
		
		foreach($temp_positions as $position){
		
			$post_notices = $notice->incomingPositionList($position->post_id);
		
			if(!empty($post_notices)){ 
			   
				foreach($post_notices as $notice_item){
					$notice_items[] = $notice_item;
				}
					
			}
			
			$sys_post_notices = $notice->incomingSysPositionList($position->post_id);
			//print_r($sys_post_notices);
			if(!empty($sys_post_notices)){ 
			   
				foreach($sys_post_notices as $notice_item){
					$notice_items[] = $notice_item;
				}
					
			}
		}
	}
    //print_r($notice_items);

	$table_header = "  <style>
                      <script>
					
							.disp {
									overflow: scroll;
									resize: both;
									max-width: 1000px;
									max-height: 460px;
							}
							
							.list_item_new:hover, .list_item:hover {
								border: 2px solid #36F;
								border-radius: 8px;
								background: #95CFEF;
								color: blue;
								font-size: 14px;
								font-weight: bold;
								padding:10px;
								
							}
							.list_item_new:lostfocus, .list_item:lostfocus{
									border: 0;
									border-radius: 0;
									background: silver;
							}
							

							.list_item_new {
								color: green;
								font-size: 15px;
								font-weight: bold;
								
							}							
							
					   </style>
					   
					   <div style=\"float:left; width:100%; align: middle;\" > 
						
					    <div style=\"float:left; width:40%;\" ><h3>Sender</h3></div>
						<div style=\"float:left; width:40%;\" ><h3>Task</h3></div>
						<div style=\"float:left; width:10%;\" ><h3>Sent Time</h3></div>
						<div style=\"float:left; width:10%;\" ></div>    
					    <div style=\" float:left; cursor: pointer; width:100%; overflow:scroll; height:400px;\">
									
						
					
				";

	if(!empty($notice_items)){
		 $array_sort = new m_array_sort();
		 $notice_items = $array_sort->msort($notice_items, 'time');
	  		 
		for( $count = count($notice_items) - 1; $count >=0; $count--){
			$page = encrypt($notice_items[$count]['action_page']);
			$notice_token = ($notice_items[$count]['notice_token']);
			$key = encrypt($notice_items[$count]['id']);
          //  $key1 = encrypt($x[$count]['rep_cp_no']);
			$class = $notice_items[$count]['status']== 'New' ? 'list_item_new' : 'list_item';
			
			$table_item .= 	"  
							    	<div class=\"$class\" id=\"list_item$count\" style=\"margin:auto auto;  background-color: #95CFEF; float:left; cursor: pointer; width:100%;\">
									<div style=\"float:left; cursor: pointer; width:40%\" onclick=\"notice_item('item$count','$page', '$key','$notice_token')\">". $notice_items[$count]['sender']."</div>
									<div style=\"float:left; cursor: pointer; width:40%\" onclick=\"notice_item('item$count','$page', '$key','$notice_token')\"> ". $notice_items[$count]['title']."</div>
									<div style=\"float:left; cursor: pointer;  width:15%\" onclick=\"notice_item('item$count','$page', '$key','$notice_token')\"> ". $notice_items[$count]['time']."</div>
									<div style=\"float:left; cursor: pointer; width:5%\">
										<button onclick=\"notice_item('item$count','$page', '$key','$notice_token')\" 
											id=\"toggle_item$count\">+</button>										
										
									</div>
									
									
							    </div>";
								
		}
		
		$table_item .= 		  "
								<div class=\"disp\" draggable=\"true\" id=\"itemDisp\" 
									style=\" margin:30px auto; border-radius: 15px; z-index:70; 
									 padding: 10px;  
									vertical-align: middle; top: 200; position:absolute; 
									float:center;\">
								</div>
							   ";

	}

    echo $table_header . $table_item . "</div>";


?>
</body></html>	