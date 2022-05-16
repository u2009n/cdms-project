
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
    $rec_id='';
    $notice_token='';
    $page ='noticas';
    $row = 0;
    $rows=array();
    $request_id = 0;
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
    
    $repatriant_cp_no = (!empty($_POST['c']))? decrypt($_POST['c']): decrypt($_REQUEST['c']);
    $notice_token = (!empty($_REQUEST['t']))? decrypt($_REQUEST['t']):'';
    
    $ipo_index = $_POST['k'];
    if(isset($_REQUEST['k'])){
        
        
		
		
        
        
        
        if(isset($_REQUEST['f']) && $_REQUEST['f'] == 'r'){
			
            
            $request_id = decrypt($_REQUEST['k']);	
            $status='Recalled';
            $table = "repatriation_request"; 
            $fields =array(array('repatriation_request.status',$status));
            $key = "repatriation_request.repatriant_cp_no = '$repatriant_cp_no' AND repatriation_request.status = 'Submitted'";
            
            
            $rows = $conn->get_rows($table, $fields, $key);
            $row = $conn->update_row($table, $fields, $key);
			
            
            
			if (($row == 1) && (!empty($rows))){
                
        		$notice->sender_cp_no=$my_cp_no;
				$notice->sender_post_id=$loggedInUser->post_id;
				$notice->notice_title= "Recalled: Request For Repatriation:$repatriant_cp_no";
				$notice->notice_status="New";
				$notice->notice_token=$notice_token;
				$notice->notice_action_page = "sup_view_repatriation";
				
				foreach($logged_in_user_supervisors as $logged_in_user_supervisor){
					$notice->recipient_post_id=$logged_in_user_supervisor[0];
					$notice->addPositionNotice();
				}
			}		
			
			
		}
        
        
        
        
        
        
        
		$table ="repatriation_request INNER JOIN repatriation_reasons ON repatriation_request.reason_id = repatriation_reasons.id
        INNER JOIN positions ON positions.post_id = repatriation_request.approver_post_id";
		$fields = array(
						array('repatriation_request.id', 'repatriation_id'),
						array('repatriation_request.eeom_date', 'eeom_date'),
						array('repatriation_request.Applicant_note', 'Applicant_note'),
                        array('repatriation_request.repatriant_cp_no', 'repatriant_cp_no'),
						array('repatriation_request.status', 'status'),
                        array('repatriation_request.notice_token', 'notice_token'),
						array('repatriation_reasons.reason', 'reason_type'),
                        array('positions.post_name', 'approver_postion'),
                       
				  );
		$key = ($request_id==0)?"repatriation_request.repatriant_cp_no = '$repatriant_cp_no' AND repatriation_request.status = 'Submitted'":"repatriation_request.id='$request_id'";
		
		$rows = $conn->get_rows($table, $fields, $key);
		
		if((is_array($rows)) && (!empty($rows))){
            
            
            
            
            foreach($rows as $row){
                extract($row);
                $rec_id = ($row['repatriation_id']);
                $notice_token = encrypt($row['notice_token']);
                $repatriant_cp_no=encrypt($repatriant_cp_no);
            }
            /////////////////////////////////////////////   
            
            
            
            $footer = "<tr>
								
                                  
                                <th colspan=\"4\">".
                                $x= ($row['status']!=="Submitted") ?'': 
                                    "<button onclick=\"view_repatriation_recall('$repatriant_cp_no', 
											'$rec_id', 'Recall','$notice_token')\";>Recall</button> " 

                        ."<button onclick=\"unload_interface('$page','$ipo_index')\">Close</button>
                                
                             </th>   
						  </tr>
					  </table>";
            
			$header = "<table>";
			$item = NULL;
			$item .= "<tr>
                                
							<th width=\"15%\">Proposed EOM Date
                            </th>
							<th>   Approving Officer
							</th>
							<th width=\"15%\">Reason for Repatriation
							</th>
                            
                            <th width=\"45%\">Applicant Note
							
                            
                            	
															
					</tr>";
            
			foreach($rows as $row){
				extract($row);
                
				$item .= "<tr>
								<td>". date("d M Y h:m", strtotime($eeom_date)). "</td>
                                <td>$approver_postion</td>
								<td>$reason_type</td>
                                <td>$Applicant_note</td>
                               
								
                                </tr>";
                
			}	
			
			echo $header.$item.$footer;
            
		}
    }
	

?>