

<?php
	ob_start();
/*	echo '<pre>';
    print_r($_SERVER);*/
	require_once("../models/config.php");
	require_once("../models/header.php");
    require_once("../models/notifier.php");
	require_once('../models/datepicker.php');
	require_once('classes/db_row.class.php');
    require_once('classes/ipo.class.php');
    if (!securePage($_SERVER['PHP_SELF'])){die();}
	if(!isset($_SESSION['userCakeUser'])) header('Location:../login.php');

?>
	<!--<meta charset="utf-8">-->
        
<link rel='stylesheet' type='text/css' href='../style/menu.css'>
<link href='../style/tablecloth.css' rel='stylesheet' type='text/css' media='screen' />
<script type='text/javascript' src='../style/tablecloth.js'></script>
<table width=100%>
    <tr>
		<th >CENTRAL DATABASE MANAGEMENT SYSTEM</th>
  </tr>
    <tr>
		<td id="app_name">Application For Initiate Early End of Mission:</td>
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

<script type="text/javascript">

/* Optional: Temporarily hide the "tabber" class so it does not "flash"
   on the page as plain HTML. After tabber runs, the class is changed
   to "tabberlive" and it will appear. */


/*==================================================
  Set the tabber options (must do this before including tabber.js)
  ==================================================*/
var tabberOptions = {

  'cookie':"tabber", /* Name to use for the cookie */

  'onLoad': function(argsObj)
  {
    var t = argsObj.tabber;
    var i;

    /* Optional: Add the id of the tabber to the cookie name to allow
       for multiple tabber interfaces on the site.  If you have
       multiple tabber interfaces (even on different pages) I suggest
       setting a unique id on each one, to avoid having the cookie set
       the wrong tab.
    */
    if (t.id) {
      t.cookie = t.id + t.cookie;
    }

    /* If a cookie was previously set, restore the active tab */
    i = parseInt(getCookie(t.cookie));
    if (isNaN(i)) { return; }
    t.tabShow(i);
   
  },

  'onClick':function(argsObj)
  {
    var c = argsObj.tabber.cookie;
    var i = argsObj.index;
    
    setCookie(c, i);
  }
};

/*==================================================
  Cookie functions
  ==================================================*/
function setCookie(name, value, expires, path, domain, secure) {
    document.cookie= name + "=" + escape(value) +
        ((expires) ? "; expires=" + expires.toGMTString() : "") +
        ((path) ? "; path=" + path : "") +
        ((domain) ? "; domain=" + domain : "") +
        ((secure) ? "; secure" : "");
}

function getCookie(name) {
    var dc = document.cookie;
    var prefix = name + "=";
    var begin = dc.indexOf("; " + prefix);
    if (begin == -1) {
        begin = dc.indexOf(prefix);
        if (begin != 0) return null;
    } else {
        begin += 2;
    }
    var end = document.cookie.indexOf(";", begin);
    if (end == -1) {
        end = dc.length;
    }
    return unescape(dc.substring(begin + prefix.length, end));
}
function deleteCookie(name, path, domain) {
    if (getCookie(name)) {
        document.cookie = name + "=" +
            ((path) ? "; path=" + path : "") +
            ((domain) ? "; domain=" + domain : "") +
            "; expires=Thu, 01-Jan-70 00:00:01 GMT";
    }
}


function newEEOM(){
	
}
</script>

<!-- Include the tabber code -->
<script type="text/javascript" src="../style/tabber.js"></script>
<script language="javascript" type="text/javascript">
    function show(deg_id,field_id,maj_id) {
        document.frm.submit();
		
    }
    </script>
	<script type="text/javascript" language="javascript">
	function openPopup(winname,url){    
		var popwidth=screen.availWidth-100;
		var popheight=screen.availHeight-100;
		var popleft = Math.round((screen.availWidth - popwidth) / 2);
		var poptop = Math.round((screen.availHeight - popheight) / 2);
		var args = 'toolbar=no,status=no,menubar=no,location=no,directories=no,resizable=yes,scrollbars=yes,width='+ popwidth+',height='+ popheight+',left='+ popleft+',top='+ poptop;	
		var nw = window.open(url, winname, args);	
		return nw;
	}
</script>
<!---->

<link href="../Style/Styles_app.css" rel="stylesheet" type="text/css">

</head>

<table width="100%" border="0">
  <tr >
    <th width="274" align="left" scope="col">logged in as: <?php 
                                                            $aa=$loggedInUser->displayname; echo $aa;?> </th>
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
	$table_item = NULL;
	$table_header = NULL;
	$pending = 0;
    $today=0;
    $status='';
    $my_details='';
    
	//print_r($loggedInUser);
	$cp_no = $loggedInUser->cpnomber;
     
	$my_details=unserialize($_SESSION['my_details']);
    $post_id = $my_details->position->post_id;
	
    $ipo = new ipo($cp_no);
    $IPO_eom_date = strtotime($ipo->eom);
    
    $table_header =
				"<table width=\"100%\">";
				
	$item_header= "	<tr>
						<th>Application Date</th>
						<th>Proposed Date of EOM</th>
						<th>Reason</th>
						<th>Status</th>
						<th></th>
					</tr>
				";

	$conn = new db_rows(); 
	
	$table ="eeom_request INNER JOIN eeom_request_reasons ON eeom_request.reason_id = eeom_request_reasons.id 
				AND eeom_request.applicant_cp_no='$cp_no'";
				
	$fields = array(	array('eeom_request.application_date', 'application_date'),
						array('eeom_request.eeom_date', 'eeom_date'),
						array('eeom_request_reasons.reason', 'reason'),
						array('eeom_request.status', 'status'),
						array('eeom_request.id', 'id'),
						array('eeom_request.notice_token', 'notice_token')
					);
	
$rows = $conn->get_rows($table, $fields);
	
	if(is_array($rows) && !empty($rows)){
	    $count=0;
		
		foreach( $rows as $row){
            $eom=$row['eeom_date'];
            $today = time();
			$page = "view_eeom";
			$key = $row['id'];
			$encrypted_key = encrypt($key);
			$notice_token = encrypt($row['notice_token']);
			
			$pending = ($row['status'] == 'Submitted') ? $pending + 1 : $pending;
			
			$link = "<a href=\"index.php?p=".encrypt($page)."&k=".encrypt($key)."\" style=\"text-decoration:none\">";
			
			$table_item .= 	" 	<tr>	
									<td>". $row['application_date']."</td>
									<td>". $row['eeom_date']."</td>
									<td>". $row['reason']."</td>
									<td>". $row['status']."</td>
									<td><button id=\"toggle$key\" onclick=\"view_eeom('$key','$encrypted_key', 'x', '$notice_token')\" >+</button></td>
								</tr>
						  
								<tr ><td id=\"tr$key\" colspan=\"5\"></td></tr>";
		}
	}
   
                if(intval(($IPO_eom_date) / (60*60*24)) >= intval(($today) / (60*60*24))){
					$days = intval(($IPO_eom_date - $today) / (60*60*24));
					$status =  $days <= 10 ? "Checking Out" : '';
                    
					}
                $new_item = (($pending > 0 ) || ($status == "Checking Out"))?  "You Are In Checking Out  OR  You Have EEOM Application Submmited":
      
		  	 "
				<tr> 
					<th id=\"new_button\" colspan=\"5\"><button onclick=\"new_eeom('New')\">New Request</button></th>
					
				</tr>				
				<tr >
					<td   colspan=\"5\" id=\"neweeom\"></td>
				</tr>	
			";
			
 		
    echo $table_header . $new_item . $item_header. $table_item . "</table>";
	

?>