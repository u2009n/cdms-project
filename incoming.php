<?php
ob_start();
require_once("../models/config.php");
//if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("../models/header.php");
require_once('../models/datepicker.php');	
?>
	<!--<meta charset="utf-8">-->
        
        <link rel='stylesheet' type='text/css' href='../style/menu.css'>
        <link href='../style/tablecloth.css' rel='stylesheet' type='text/css' media='screen' />
        <script type='text/javascript' src='../style/tablecloth.js'></script>
<script language="javascript" type="text/javascript">
    $(function() {
        $( "#datepicker" ).datepicker( "option", "maxDate","Today"    );
        $( "#datepicker1" ).datepicker( "option", "maxDate","Today"    );
    });
 </script>
<table width=100%>
    <tr>
    <th >CENTRAL DATABASE MANAGEMENT SYSTEM</th>
  </tr>
    <tr>
     <td>My Tasks:   &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <a href="#"> You Have Five(05) Pending Tasks</a></td>
  </tr>
</table> 
 
</div>
<div id='main'> 
 
<?php
//include('../config.php');
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
                                                            $aa=$loggedInUser->displayname; echo $aa; ?> </th>
    <th width="757" height="10"  scope="col"></th>
    <th width="112" scope="col"><p><a href="../account.php"> Back </a></p></th>
  </tr>
</table>

<?php

 $cp_no=$loggedInUser->cpnomber;
 $encrypted = $encrypted = encrypt( $cp_no ); 
 /*
 if (isset($_GET['ids'])) {$cp_no1=$_GET['ids'];
  $cp_no2 = str_replace(' ', '+', $cp_no1); 
$cp_no = decrypt( $cp_no2 );
$encrypted = encrypt( $cp_no );
}*/ 
?>
<?php
$sql = "select *\n"
    . " from `ranks`,`units`,`teamsites`,`sectors`,`positions`,`country`,`ipo` where `ipo`.`cp_no`='$cp_no' and `ipo`.`Cntr_id`=`country`.`Cntr_id` and `positions`.`post_id`=`ipo`.`post_id` and `positions`.`unit_id`= `units`.`unit_id`\n"
    . "and `units`.`ts_id`=`teamsites`.`ts_id` and `teamsites`.`sec_id`=`sectors`.`sec_id` and ipo.rank_id=ranks.rank_id  ";
$result1 = mysql_query( $sql);
$number = mysql_num_rows ($result1);
$result=mysql_fetch_array($result1);
?>
<table border="1" bordercolor="black" width="100%">
<tr>
<td width="90%">
<table width = "100%" border="0">
<tr>
   
    <th width="5%" nowrap >Serial</th>
    <th width="60%" nowrap  ><a href="#">Subject </a></td>
     <th width="10%" nowrap  >Referer</td>
    <th width="10%" nowrap  >Time</th>
	
</tr>
<tr>
   
    <td width="5%" nowrap >1.</th>
    <td width="60%" nowrap  ><a href="#">Normination for Third Party Check-Out (Approved) </a></td>
     <td width="10%" nowrap  >MHQ Personnel</td>
    <td width="10%" nowrap  >1-12-2014 16:05</th>
	
  </tr>
  <tr>
   
    <td width="5%" nowrap >2.</th>
    <td width="60%" nowrap  ><a href="#">Request for EEOM (Approved) </a></td>
     <td width="10%" nowrap  >CoS</td>
    <td width="10%" nowrap  >10-12-2014 10:05</th>
	
  </tr>
  <tr>
    
    <td width="5%" nowrap >3.</th>
    <td width="60%" nowrap  ><a href="#">Notice of Check-out</a></td>
     <td width="10%" nowrap  >CDMS</td>
    <td width="10%" nowrap  >15-12-2014 12:05</th>
	<td width="5%" nowrap >&nbsp;</th>
  </tr>
  <tr>
		
		<td width="5%" nowrap >3.</th>
		<td width="60%" nowrap  ><a href="#">Team Site Check-out List</a></td>
		 <td width="10%" nowrap  >CDMS</td>
		<td width="10%" nowrap  >15-12-2014 12:05</th>
		<td width="5%" nowrap >&nbsp;</th>
  </tr>
   <tr>
    
    <th colspan="5" nowrap >&nbsp;</th>
  </tr>
</table>

<form  method="post" name="frm" >

</form>
</body>

</html>
