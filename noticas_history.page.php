

<?php
	require_once '../models/config.php';
	require_once 'classes/db_row.class.php';
	require_once 'classes/notice.class.php';
    //if (!securePage($_SERVER['PHP_SELF'])){die();}
	$my_cp_no = $loggedInUser->cpnomber;
	$my_post_id = $loggedInUser->post_id;
	$table = NULL;
	$fields = NULL;
	$key = NULL;
	$request_id=0;
    $rows=array();
    $row = array();
    $conn=new db_rows();
    $notice = new notice();
    ?>



<!--<meta charset="utf-8">-->
        
<link rel='stylesheet' type='text/css' href='../style/menu.css'>
<link href='../style/tablecloth.css' rel='stylesheet' type='text/css' media='screen' />
<script type='text/javascript' src='../style/tablecloth.js'></script>


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

        'cookie': "tabber", /* Name to use for the cookie */

        'onLoad': function (argsObj) {
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

        'onClick': function (argsObj) {
            var c = argsObj.tabber.cookie;
            var i = argsObj.index;

            setCookie(c, i);
        }
    };

    /*==================================================
      Cookie functions
      ==================================================*/
    function setCookie(name, value, expires, path, domain, secure) {
        document.cookie = name + "=" + escape(value) +
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
    function show(deg_id, field_id, maj_id) {
        document.frm.submit();

    }
    </script>
	<script type="text/javascript" language="javascript">
	    function openPopup(winname, url) {
	        var popwidth = screen.availWidth - 100;
	        var popheight = screen.availHeight - 100;
	        var popleft = Math.round((screen.availWidth - popwidth) / 2);
	        var poptop = Math.round((screen.availHeight - popheight) / 2);
	        var args = 'toolbar=no,status=no,menubar=no,location=no,directories=no,resizable=yes,scrollbars=yes,width=' + popwidth + ',height=' + popheight + ',left=' + popleft + ',top=' + poptop;
	        var nw = window.open(url, winname, args);
	        return nw;
	    }
</script>
<!---->

<link href="../Style/Styles_app.css" rel="stylesheet" type="text/css">

</head>


<?php
    $logged_in_user_details='';
    $logged_in_user_details = unserialize($_SESSION['my_details']);
	$logged_in_user_supervisors = $logged_in_user_details->position->command_chain;
    $ipo_cp = (!empty($_POST['c']))? decrypt($_POST['c']): decrypt($_REQUEST['c']);
    
	
	//////////////////////////////////////////////////////////////////
    
        if(isset($_REQUEST['f']) && $_REQUEST['f'] == 'r'){
			
            
            $request_id = decrypt($_REQUEST['k']);	
            $status='Recalled';
            $table = "noticas"; 
           
           
            
            $fields =array(array('noticas.status',$status),
                           array('noticas.notice_token','notice_token'),                            
                                );
                  
            $key ="noticas.casualty_cp_no = '$ipo_cp' AND noticas.status = 'Submitted'";
            
            
            $rows = $conn->get_rows($table, $fields, $key);
            foreach($rows as $row){
                extract($row);
                $notice->notice_token=$notice_token;
            }
            
            
            $field =array(array('noticas.status',$status),
                          array('noticas.notice_token',$notice_token), 
                          );
            $row = $conn->update_row($table, $field, $key);
            
            
        	if (($row == 1) && (!empty($rows))){
               
               
                
        		$notice->sender_cp_no=$my_cp_no;
				$notice->sender_post_id=$loggedInUser->post_id;
                $key ="noticas.casualty_cp_no = '$ipo_cp' AND noticas.status = 'Submitted'";
                $notice->notice_title= "Recalled: Request For Notias:$ipo_cp";
				$notice->notice_status="New";
                
				$notice->notice_action_page = "sup_view_noticas";
				
				foreach($logged_in_user_supervisors as $logged_in_user_supervisor){
					$notice->recipient_post_id=$logged_in_user_supervisor[0];
					$notice->addPositionNotice();
				}
			}	
			
        
		/////////////////////////////////////////////////////////////////////////////
        
        }
        
        
        
		$index_no = $_POST['k'];
		$page ='noticas';
		$table = "noticas INNER JOIN incident_types ON noticas.incident_type_id = incident_types.id";
		$fields = array(
						array('noticas.id', 'incident_id'),
						array('noticas.incident_date', 'incident_date'),
						array('noticas.noticas_date', 'record_date'),
                        array('noticas.notice_token', 'notice_token'),
						array('incident_types.incident_type', 'incident_type')
				  );
				  
        $key ="noticas.casualty_cp_no = '$ipo_cp' AND noticas.status = 'Submitted'";
		//$key = "noticas.casualty_cp_no = '$ipo_cp' ";
        
		
		$rows = $conn->get_rows($table, $fields, $key);
		
		if((is_array($rows)) && (!empty($rows))){
          
            
            //temperroy for use
            
               foreach($rows as $row){
                       extract($row);
                       $rec_id = $row['incident_id'];
                       $notice_token=$row['notice_token'];
                       $ipo_cp = encrypt($ipo_cp);
               }
            /////////////////////////////////////////////   
               
            
				$footer = "<tr>
								
									<th colspan=\"4\">
									
									<button onclick=\"view_noticas_recall('$ipo_cp', '$rec_id', 'Recall', '$notice_token')\";>Recall</button>  
                                                                                 
                                    <button onclick=\"unload_interface('$page','$index_no')\">Close</button>
                                     
								</th>
						  </tr>
					  </table>";
					  
			$header = "<table>";
			$item = NULL;
			$item .= "<tr>
							<th width=\"17%\">Date & Time of Incident.</th>
							<th>
								Incident
							</th>
							<th width=\"17%\">
								Date Recorded
							</th>
							<th width=\"15%\">
								
							</th>									
					</tr>";
					
			foreach($rows as $row){
				extract($row);
		 
				$item .= "<tr>
								<td>". date("d M Y h:m", strtotime($incident_date)). "</td>
								<td>$incident_type</td>
								<td>". date("d M Y h:m", strtotime($record_date)). "</td>
								<td>
									<a href=\"index.php?p=" .encrypt('noticas_pdf')."&i=" 
									  .encrypt($incident_id)."\" target=\"_blank\"> PDF </a> 
                                </td>
                                 </tr>";
						  
			}	
			
			echo $header.$item.$footer;
		}
		 

?>