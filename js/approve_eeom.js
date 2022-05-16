	<script type="text/javascript">
	
	
	function approve_eeom(display_id, applicant_id){
		
		var approve = document.getElementById("approved" + display_id).checked;
		var reject = document.getElementById("rejected" + display_id).checked;
		var status;
		var xmlhttp;
		var args;
		var display = 'msg' + display_id;
		var note_index = 'note' +  display_id;
		var stamp_index = "stamp"  + display_id;
		var eeom_index = "eeom"  + display_id;
		var approver_index = "approver"  + display_id;
		var notice_token = document.getElementById(stamp_index).value;
		var eeom = document.getElementById(eeom_index).value;
		var approver_id = document.getElementById(approver_index).value;
		var note = document.getElementById(note_index).value;
		var errors='';
		note=note.trim();

		if(reject == true){
			status = 'Rejected';
		}
		else{
			
			if(approve == true ){
			   status = 'Approved';	
			}
			else{
				alert ("Select 'Reject' or 'Approve' to complete task!");
				return;
			}
		
		}

		
		if(note =='')
		    errors = 'Invalid Comment.';
			
		
	      
		
		if(errors!= ''){
		    document.getElementById(display).innerHTML = 'Error:<br>'+ errors;
		    return; 
		}



		url_args = "&k=" + display_id + "&n="  + note + "&s=" + status + "&a=" + 
			applicant_id + "&t=" + notice_token + "&e=" + eeom + '&ap=' + approver_id ;
	
		


		if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else{	// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		
		xmlhttp.onreadystatechange=function(){
			
			
					

			if (xmlhttp.readyState==4 && xmlhttp.status==200){				
		
				document.getElementById(display).innerHTML=xmlhttp.responseText;
					

			}
			
		}
		
		xmlhttp.open("POST","<?php echo $full_url; ?>checkout/index.php?p=<?php echo encrypt("sup_approve_eeom"); ?>" + url_args,true);
		xmlhttp.send(); 
}

	</script>	