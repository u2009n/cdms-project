

<?php
	ob_start();
	require_once("../models/config.php");
	if (!securePage($_SERVER['PHP_SELF'])){die();}
	require_once("../models/header.php");
	require_once("../models/notifier.php");
	require_once('classes/db_combo.class.php');
	

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
		<td id="app_name">IPO Check Out Destinations:</td>
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


function get_destinations(country_id){
		var xmlhttp;
		var url= "<?php echo $full_url.'checkout/index.php?p='. encrypt('get_destinations'); ?>&c=" + country_id; 

		
		//alert(url);	
		if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
			
		}
		else{	// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		
		xmlhttp.onreadystatechange=function(){
			//document.getElementById("notice_count").innerHTML= xmlhttp.status;
			
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
					 document.getElementById('destinations').innerHTML=  xmlhttp.responseText;
					 
			}
		} 
		
		xmlhttp.open("POST", url ,true);
		xmlhttp.send(); 
}


    function new_destination(){
        var xmlhttp;
        var country_id = document.getElementById('country').value;
        var destination_name = document.getElementById('new_destination').value;
        var url = "<?php echo $full_url.'checkout/index.php'; ?>";
        var url_args= "&c=" + country_id + "&d=" + destination_name; 
       
       
       
       
        if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
			
        }
        else{	// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
		
        xmlhttp.onreadystatechange=function(){
            //document.getElementById("notice_count").innerHTML= xmlhttp.status;
			
            if (xmlhttp.readyState==4 && xmlhttp.status==200){
                document.getElementById('dest_msg').innerHTML=  xmlhttp.responseText;
                get_destinations(country_id);
            }
        } 
		
        xmlhttp.open("POST",url,true);
        xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  		xmlhttp.send("p=<?php echo encrypt('add_destinations'); ?>" + url_args); 
    }
</script>

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

	//require_once '../models/header.php';
	
	$cp_no=NULL;
	$post_id=NULL;
	$country_list = new db_combo;
	$country_combo = $country_list->combo('country', "cntr_name", 'cntr_id', "id='country' onchange='get_destinations(value);'",
											'cntr_id > 0 ORDER BY cntr_name ASC','',"Select Country");
	
	//print_r($loggedInUser);
	$cp_no = $loggedInUser->cpnomber;
	$post_id = $loggedInUser->post_id;
 
			
 		
    echo "<div style=\"float:left; width: 20%;\">
			<table><tr><th>Country</th></tr></table>
			$country_combo
		  </div>
		  <div style=\"float:left; width:80%;\">
		     <table><tr><th>Destination Name</th></tr></table>
			 <div id=\"destinations\" style=\"border: 1px;\"></div>
		  </div>";
	

?>