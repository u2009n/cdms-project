

<?php
	ob_start();
	require_once("../models/config.php");
	if (!securePage($_SERVER['PHP_SELF'])){die();}
	require_once("../models/header.php");
	require_once('../models/datepicker.php');
	require_once('classes/db_row.class.php');
	require_once('js/noticas.js');
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
		<td id="app_name">Notice of Casualty:</td>
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
	
	$casualty_cp_no=NULL;
	$causty_post_id=NULL;
	$pvt_notices = array();
	$post_notices = array();
	$notice_items = array();
	$table_item = NULL;
	$table_header = NULL;
	$pending = 0;
	//print_r($loggedInUser);
	$generator_cp_no = $loggedInUser->cpnomber;
	$generator_post_id = $loggedInUser->post_id;

    echo "<table width=\"100%\"><tbody>
				<tr>
					<th colspan=\"3\"></th>
				</tr>
				<tr>
					<td>Enter CP No. Or Index No. of Casualty</td>
					<td><input type=\"search\" id=\"search_key\"></td>
					<td><button onClick=\"search_casualty()\"> Search </button></td>
				</tr>
				<tr>
					<th colspan=\"3\"></th>
				</tr>
				<tr>
					<td id=\"casualty_display\" colspan=\"3\"></td>
                   
				</tr>
		 </tbody></table>";
	

?>