<?php

$path=($_SERVER['DOCUMENT_ROOT']);
require_once($path.'\cdms\checkout\classes\ipo.class.php');
$cp_no= encrypt($loggedInUser->cpnomber);
$post_id=encrypt($loggedInUser->post_id);
$notifier_url = $full_url."models/notice_count.php";
$_SESSION['my_details'] = serialize(new ipo($loggedInUser->cpnomber));
$_SESSION['my_temp_appointments'] = serialize(new tempAppointments($loggedInUser->cpnomber));


?>


<script type="text/javascript">

	var myTimer = setInterval(function () {get_notice_count()}, 3000);
	var timer_flag = 0;
		
	function get_notice_count(){
		//var cp_no = document.getElementById("cp_no").innerHTML
		//var post_id = document.getElementById("post_id").innerHTML
		
		var xmlhttp;
		
		if(timer_flag == 0){
			
			clearInterval(myTimer);
			myTimer = setInterval(function () {get_notice_count()}, 100000);
			timer_flag = 1;
		}
		
		if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
			
		}
		else{	// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		
		xmlhttp.onreadystatechange=function(){
			//document.getElementById("notice_count").innerHTML= xmlhttp.status;
			
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
					document.getElementById("notice_count").innerHTML=xmlhttp.responseText;
					//document.getElementById("demo").innerHTML = "Testing 1234";
			}
		} 
		
		xmlhttp.open("POST", "<?php echo $notifier_url; ?>" ,true);
		xmlhttp.send();
	}

	function notice_item(display_id, page, page_key, key){
		var toggle = 'toggle_' + display_id;
	  
		if(document.getElementById(toggle).innerHTML == '-'){
			document.getElementById('itemDisp').innerHTML = '';
			document.getElementById('itemDisp').style.background = '0';
			document.getElementById('itemDisp').style.border = '0';
			document.getElementById(toggle).innerHTML = '+';
			return;
		}
		//alert(page_key);
		if (window.XMLHttpRequest){  // code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else{	// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		
		xmlhttp.onreadystatechange=function(){

			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				var cancel_btn = "<span onclick=\"notice_item(\'" + display_id +"\', \'" + page + 
									 "\', \'" + page_key + "\',\'" + key +"\')\"><h2>&nbsp;&nbsp; Close X</h2></span>";
				document.getElementById('itemDisp').style.background = '#5AC007';
				document.getElementById('itemDisp').innerHTML=  xmlhttp.responseText + cancel_btn;											
															
				document.getElementById(toggle).innerHTML = '-';

			}
			
		}
		
		var url = "<?php echo $full_url; ?>checkout/index.php?p=" + page + "&k=" + page_key + "&C="+ key;
		//alert(url);
		xmlhttp.open("POST",url,true);
		xmlhttp.send();		
	}
	

	function new_eeom(button){
		var xmlhttp;
		var button;
		var eeom_date;
		var reason;
		var approver;
		var note;
		var url_args='';
		
		if (button == 'Cancel') {
		   
		    document.getElementById("new_button").innerHTML= "<th colspan=\"5\"><button onclick=\"new_eeom('New')\">New Request</button></th>";
		    document.getElementById("neweeom").innerHTML = "";
		   	return;
		}
		
		if(button == 'save'){
			eeom_date=document.getElementById("eeom_day").value + "-" + document.getElementById("eeom_month").value
					   + "-" + document.getElementById("eeom_year").value;
					  
			reason = document.getElementById("reason").value;
			approver = document.getElementById("approver").value;
			note = document.getElementById("note").value;
			
			if (eeom_date == '' || reason == '' || approver == '' || note == '') {
				alert('Enter valid data');
				return;
			}
			else{
				url_args = "&d=" + eeom_date  + "&r=" + reason + "&a=" + approver + "&n=" + note;
			}
			
		}
		
		
		if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else{	// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		
		xmlhttp.onreadystatechange=function(){					

			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				
				if(url_args !== ''){
					location.reload();
				}	
				
				document.getElementById("neweeom").innerHTML=xmlhttp.responseText;
					

			}
			
		}
		
		
		xmlhttp.open("POST","<?php echo $full_url; ?>checkout/index.php?p=<?php echo encrypt("new_eeom"); ?>" + url_args,true);
		xmlhttp.send();
		
	}


    function view_eeom(display_id, rec_id, button, token) {



        
		var xmlhttp;
		var url= "<?php echo $full_url.'checkout/index.php?p='. encrypt('view_eeom'); ?>&k=" + rec_id + "&t=" + token; 
		//document.write(url);
		var flag = '';

		
		if(button == 'Recall'){
			if (confirm('The request will be cancelled\n Click [Ok] to proceed or [Cancel] to abort')){
				flag = '&f=r';
				url = url + flag;
			}
		}
		
		
		if(button == 'x')
				if(document.getElementById("toggle" + display_id).innerHTML=='--'){
					document.getElementById("tr" + display_id).innerHTML= "";
					 document.getElementById("toggle" + display_id).innerHTML= "+"
					return;
				}		
				
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
					 document.getElementById("tr" + display_id).innerHTML= "<td colspan=\"5\">" + xmlhttp.responseText + "</td>";
					 document.getElementById("toggle" + display_id).innerHTML= "--"
					//if(flag !== ''){
						//location.reload();
					//}
			}
		} 
		
		xmlhttp.open("POST", url ,true);
		xmlhttp.send(); 
	}
	



    
    function view_repatriation_recall(display_id, rec_id, button, token) {



       
		var xmlhttp;
		var url = "<?php echo $full_url.'checkout/index.php?p='. encrypt('repatriation_history'); ?>&k=" + rec_id + "&t=" + token + "&c=" +display_id;
        //document.write(url);
		var flag = '';

		
		if (button == 'Recall') {
		    if (confirm('The request will be cancelled\n Click [Ok] to proceed or [Cancel] to abort')) {
		        flag = '&f=r';
		        url = url + flag;
		    }
		}




        //alert(url);	
		if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
		    xmlhttp = new XMLHttpRequest();

		}
		else {	// code for IE6, IE5
		    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}

		xmlhttp.onreadystatechange = function () {
		    //document.getElementById("notice_count").innerHTML= xmlhttp.status;

		    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
		       // document.getElementById('noticas' + 'rec_id').innerHTML = "";
		        //document.getElementById("noticas").innerHTML = "";
		        //  location.reload();
		      
		       
		    }
		}
		
		xmlhttp.open("POST", url, true);
		xmlhttp.send();
    }

function view_noticas_recall(display_id, rec_id, button, token) {



       
		var xmlhttp;
		var url = "<?php echo $full_url.'checkout/index.php?p='. encrypt('noticas_history'); ?>&k=" + rec_id + "&t=" + token + "&c=" + display_id;
    //document.write(url);
		var flag = '';


		if (button == 'Recall') {
		    if (confirm('The request will be cancelled\n Click [Ok] to proceed or [Cancel] to abort')) {
		        flag = '&f=r';
		        url = url + flag;
		    }
		}




    //alert(url);	
		if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
		    xmlhttp = new XMLHttpRequest();

		}
		else {	// code for IE6, IE5
		    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}

		xmlhttp.onreadystatechange = function () {
		    //document.getElementById("notice_count").innerHTML= xmlhttp.status;

		    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
		        document.getElementById("tr" + display_id).innerHTML = "<td colspan=\"5\">" + xmlhttp.responseText + "</td>";
		        document.getElementById("toggle" + display_id).innerHTML = "--"
		        //if(flag !== ''){
		        //location.reload();
		        //}
		    }
		}

		xmlhttp.open("POST", url, true);
		xmlhttp.send();
    }



    	function sub_new_eeom(date1){
		var xmlhttp;
		var button;
		var eeom_date;
		var reason;
		var approver;
		var note;
		var url_args = '';


		var eom =date1;//=new (date1);

		
		eeom_date = document.getElementById("eeom_year").value + "-" + document.getElementById("eeom_month").value
					   + "-" + document.getElementById("eeom_day").value;
			
			reason = document.getElementById("reason").value;
			approver = document.getElementById("approver").value;
			note = document.getElementById("note").value;

			

			if (eeom_date == '' || reason == '' || approver == '' || note == '') {
				alert('Enter valid data');
				return;
			}
			else{
				url_args = "&d=" + eeom_date  + "&r=" + reason + "&a=" + approver + "&n=" + note;
			}
			
		
		
		if (eeom_date > eom) {

		    alert("the date early EOM must be before" + eom);
		    return;
		}
		
		if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else{	// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		
		xmlhttp.onreadystatechange=function(){					

			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				
				if(url_args !== ''){
					location.reload();
				}	
				
				document.getElementById("neweeom").innerHTML=xmlhttp.responseText;
					

			}
			
		}
		
		
		xmlhttp.open("POST", "<?php echo $full_url; ?>checkout/index.php?p=<?php echo encrypt("new_eeom"); ?>" + url_args, true);
		xmlhttp.send();

    	}

</script>
        <div>
          <span id="notice_count"> </span>
	    </div>

