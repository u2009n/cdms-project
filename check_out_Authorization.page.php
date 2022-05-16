<?php
	ob_start();
	require_once("../models/config.php");
	require_once("../models/header.php");
	require_once('../models/datepicker.php');
	require_once('classes/db_row.class.php');
	require_once('js/noticas.js');
    if (!securePage($_SERVER['PHP_SELF'])){die();}
	if(!isset($_SESSION['userCakeUser'])) header('Location:../login.php');

?>
	<!--<meta charset="utf-8">-->
<div id='wrapper'>
<div id='content'><br>
        <link rel='stylesheet' type='text/css' href='../style/menu.css'>
        <link href='../style/tablecloth.css' rel='stylesheet' type='text/css' media='screen' />
        <script type='text/javascript' src='../style/tablecloth.js'></script>
<table>
    <tr>
    <th >CENTRAL DATABASE MANAGEMENT SYSTEM</th>
  </tr>
    <tr>
   <td id="app_name">IPO Check Out Authorization:</td>
  </tr>
</table> 
 
 
<div id='main'> 
<p>



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


    <!-- Include the tabber code -->
    <script type="text/javascript" src="../style/tabber.js"></script>
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

$generator_cp_no = $loggedInUser->cpnomber;
$generator_post_id = $loggedInUser->post_id;

echo "<table width=\"100%\"><tbody>
				<tr>
					<th colspan=\"6\"></th>
				</tr>
				<tr>
					<td>Enter CP No. of Checked Out  Officer</td>
					<td><input type=\"search\" id=\"search_key1\"></td>
					<td><button onClick=\"search_repatriated()\"> Search </button></td>
                    <td>Enter CP No. of An Authorized Officer</td>
                    <td><input type=\"search\" id=\"search_key2\"></td>
					
				
				</tr>
				<tr>
					<th colspan=\"6\"></th>
				</tr>
				<tr><td id=\"repatriated_display\" colspan=\"6\"> </td>
                </tr>
		</tbody> </table>";

?> 