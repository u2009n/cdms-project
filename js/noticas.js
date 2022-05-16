	<?php require_once('validate_input.js'); ?>	
	
	<script type="text/javascript">


	
	function search_casualty(){
		
		var status;
		var xmlhttp;
		var key = document.getElementById('search_key').value;
	    
		var errors='';
		key = key.trim();

		
		if(key.length < 1)
			errors =   "Invalid Search Key  ";
		
		if(errors != ''){
			document.getElementById("casualty_display").innerHTML= errors;
			return;
		}
		
		url_args = "&k=" + key;
	
		
		if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else{	// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		
		
	
		xmlhttp.onreadystatechange=function(){					

			if (xmlhttp.readyState==4 && xmlhttp.status==200){				
		
				document.getElementById("casualty_display").innerHTML=xmlhttp.responseText;
					

			}
			
		}
		
	
		xmlhttp.open("POST","<?php echo $full_url; ?>checkout/index.php" ,true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("p=<?php echo encrypt('noticas_casualty'); ?>" + url_args); 
	}

function unload_authoriztion(){
    document.getElementById("repatriated_display").innerHTML="";
}
	function search_repatriated(){
		
	    var status;
	    var xmlhttp;
	    var key1 = document.getElementById('search_key1').value;
	    var key2 = document.getElementById('search_key2').value;
	    
	    var errors='';
	    key1 = key1.trim();
	    key2 = key2.trim();
		
	    if(key1.length < 1){
	        errors =   "Invalid Search Checked Out CP NO.  ";
	    }else if(key2.length<1){
	    errors =   "Invalid Search Authriesd CP NO.  ";
	}
		
	    if(errors != ''){
	        document.getElementById("repatriated_display").innerHTML= errors;
	        return;
	    }
		
	    url_args = "&k=" + key1 + "&r=" + key2;
	
		
	    if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
	        xmlhttp=new XMLHttpRequest();
	    }
	    else{	// code for IE6, IE5
	        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	    }
		
		
	
	    xmlhttp.onreadystatechange=function(){					

	        if (xmlhttp.readyState==4 && xmlhttp.status==200){				
		
	            document.getElementById("repatriated_display").innerHTML=xmlhttp.responseText;
					

	        }
			
	    }
		
	
	    xmlhttp.open("POST","<?php echo $full_url; ?>checkout/index.php" ,true);
	    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	    xmlhttp.send("p=<?php echo encrypt('view_repatriated_authrised'); ?>" + url_args); 
	}


	function unload_interface(page,index_no){
	    
	    document.getElementById(page + index_no).innerHTML = "";
	  		
	}
	
	function load_interface(index_no, flag, page){
	    if(flag == 'c'){
	       
			document.getElementById("noticas" + index_no).innerHTML = "";
			return;
		}	
		var xmlhttp;
		var errors='';
		url_args = "&k=" + index_no;
		
		

		if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else{	// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
	
		xmlhttp.onreadystatechange=function(){					

			if (xmlhttp.readyState==4 && xmlhttp.status==200){				
		
				document.getElementById("noticas" + index_no).innerHTML=xmlhttp.responseText;
					

			}
			
		}
		
		
		
		xmlhttp.open("POST","<?php echo $full_url; ?>checkout/index.php" ,true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		
		if(flag == 'n')
			xmlhttp.send("p=" + page + url_args);

		if(flag='h'){
		   
		    url_args += "&c=" + document.getElementById("casualty_cp" + index_no).value;
		    xmlhttp.send("p=" + page + url_args);

		}else if(flag='F'){

		    url_args += "&c=" + document.getElementById(page + index_no).value;		
		    xmlhttp.send("p=" + page + url_args);
		}
	}
	
	function submit_repatriation(index_no){
	    var eeom_date;
		
		var url_args;
		//alert(document.getElementById("duty" + index_no).value);
		var errors='';
		var eeom_day = document.getElementById("d" + index_no).value;
		var eeom_month = document.getElementById("m" + index_no).value;
		var eeom_year = document.getElementById("y" + index_no).value;
		var approver_post = document.getElementById("approver" + index_no).value;
		var repatriation_reason= document.getElementById("reason" + index_no).value;
		var extra_info= document.getElementById("note" + index_no).value;
		var casualty_post_id = document.getElementById("casualty_post" + index_no).value;
		var casualty_cp_no = document.getElementById("casualty_cp" + index_no).value;
		
		approver_post = approver_post.trim();
		extra_info = extra_info.trim();
	
		
		
		//alert(repatriation_reason);
		

		
		if(eeom_day.trim() == '' || eeom_month.trim() == '' || eeom_year.trim() == ''){
			errors += "Invalid repatriation date<br>";
		}
		else{
			eeom_date = eeom_day + '-' + eeom_month + '-' + eeom_year;			
			var repatriation_date = new Date(eeom_date);
		}
		
		if(approver_post.trim() == ""){
			errors += "Please select Approving Officer from list'<br>";
		}

		if(repatriation_reason.trim() == ""){
			errors += "Please select reason for repatriation from list'<br>";
		}

		
		if(extra_info.trim() == ""){
			errors += "Missing required field 'Details'<br>";
		}
				
		if(errors !== ''){
			document.getElementById("msg" + index_no).innerHTML= errors;
			return;
		}
		
		url_args = "&k=" + index_no + "&c=" + casualty_cp_no + "&pi="+ casualty_post_id +
					"&d=" + eeom_date + "&a=" + approver_post +  "&n=" + extra_info + 
					"&r=" + repatriation_reason;

		var xmlhttp;

		if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else{	// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}

		xmlhttp.onreadystatechange=function(){					

			if (xmlhttp.readyState==4 && xmlhttp.status==200){				
		
				document.getElementById("msg" + index_no).innerHTML=xmlhttp.responseText;
			}
			
		}
		
	
		xmlhttp.open("POST","<?php echo $full_url; ?>checkout/index.php", true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("p=<?php echo encrypt('submit_repatriation'); ?>" + url_args); 
	}
	



	function submit_eeom_by_oic(index_no){
	    var eeom_date;
	    var url_args;

	   

	    var errors='';
	    var eeom_day = document.getElementById("d" + index_no).value;
	    var eeom_month = document.getElementById("m" + index_no).value;
	    var eeom_year = document.getElementById("y" + index_no).value;
	    var approver_post = document.getElementById("approver" + index_no).value;
	    var repatriation_reason= document.getElementById("reason" + index_no).value;
	    var extra_info= document.getElementById("note" + index_no).value;
	    var casualty_post_id = document.getElementById("casualty_post" + index_no).value;
	    var casualty_cp_no = document.getElementById("casualty_cp" + index_no).value;
		
	    approver_post = approver_post.trim();
	    extra_info = extra_info.trim();
	
		
		    
		
	    if(eeom_day.trim() == '' || eeom_month.trim() == '' || eeom_year.trim() == ''){
	        errors += "Invalid early check out date<br>";
	    }
	    else{
	        eeom_date = eeom_year + '-' + eeom_month + '-' + eeom_day;	
	        var repatriation_date = new Date(eeom_date);
	    }
		
	    if(approver_post.trim() == ""){
	        errors += "Please select Approving Officer from list'<br>";
	    }

	    if(repatriation_reason.trim() == ""){
	        errors += "Please select reason for early check out from list'<br>";
	    }

		
	    if(extra_info.trim() == ""){
	        errors += "Missing required field 'Details'<br>";
	    }
	   		
	    if(errors !== ''){
	        document.getElementById("msg" + index_no).innerHTML= errors;
	        return;
	    }
		
	   
	    url_args = "&k=" + index_no + "&c=" + casualty_cp_no + "&pi="+ casualty_post_id +
					"&d=" + eeom_date + "&a=" + approver_post +  "&n=" + extra_info + 
					"&r=" + repatriation_reason;

	    var xmlhttp;

	    if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
	        xmlhttp=new XMLHttpRequest();
	    }
	    else{	// code for IE6, IE5
	        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	    }

	    xmlhttp.onreadystatechange=function(){					

	        if (xmlhttp.readyState==4 && xmlhttp.status==200){				
		
	            document.getElementById("msg" + index_no).innerHTML=xmlhttp.responseText;
	        }
			
	    }
		
	
	    xmlhttp.open("POST","<?php echo $full_url; ?>checkout/index.php", true);
	    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	    xmlhttp.send("p=<?php echo encrypt('Submit_eeom_by_oic'); ?>" + url_args); 
	}





	function submit_noticas(index_no, flag){
	    var incident_date;
		var incident_time;
		var url_args;
		//alert(document.getElementById("duty" + index_no).value);
		var errors='';
		var i_day = document.getElementById("d" + index_no).value;
		var i_month = document.getElementById("m" + index_no).value;
		var i_year = document.getElementById("y" + index_no).value;
		var today = new Date();
		var i_hour = document.getElementById("h" + index_no).value;
		var i_minute = document.getElementById("m" + index_no).value;
		var incident_type= document.getElementById("incident" + index_no).value;
		var scene= document.getElementById("place" + index_no).value;
		var description= document.getElementById("desc" + index_no).value;
		var my_cp_no = document.getElementById("my_cp" + index_no).value;
		var my_post_id = document.getElementById("my_post" + index_no).value;
		var casualty_post_id = document.getElementById("casualty_post" + index_no).value;
		var casualty_cp_no = document.getElementById("casualty_cp" + index_no).value;
		var approver_name = document.getElementById("approver_name" + index_no).value;
		var approver_post = document.getElementById("approver_post" + index_no).value;
		var casualty_duty_status = document.getElementById("duty_status" + index_no).value;
		var extra_info = document.getElementById("comm" + index_no).value;
		var casualty_location = document.getElementById("loc" + index_no).value;
		var casualty_condition = document.getElementById("cas_status" + index_no).value;
		
		incident_type = incident_type.trim();
		casualty_condition = casualty_condition.trim();
		
		scene=scene.trim();
		approver_name = approver_name.trim();
		approver_post = approver_post.trim();
		extra_info = extra_info.trim();
		casualty_location = casualty_location.trim();
		
		if(i_hour == '' || i_minute == '')
			errors += "Invalid incident time (Hour). Select from drop down list.<br>";
		
		if(i_day == '' || i_month == '' || i_year == ''){
			errors += "Invalid incident date<br>";
		}
		else{
			incident_date = i_day + '-' + i_month + '-' + i_year;
			incident_time = i_hour + ":" + i_minute;
			
			//var idate = new Date(incident_date);
		}
		
		if(casualty_condition == ""){
			errors += "Please specify the condition of the casualty'<br>";
		}

		if(incident_type == ""){
			errors += "Please specify circumstances of the incident.'<br>";
		}
		
		if(scene == ""){
			errors += "Missing required field 'Place of Occurrence'<br>";
		}
				
		if(casualty_location ==''){
			errors += "Missing required field 'Current Victim Location'<br>";
		}
		
		if(casualty_duty_status ==''){
			errors += "Please specify whether victim was on duty at time of incident<br>";
		}

		if(description ==''){
			errors += "Missing required field 'Incident Description'<br>";
		}
				
		if(approver_name ==''){
			errors += "Missing required field 'Approver Full Names'<br>";
		}
				
		if(approver_post ==''){
			errors += "Missing required field 'Approver Functional Title'<br>";
		}
				
			
		if(errors !== ''){
			document.getElementById("msg" + index_no).innerHTML= errors;
			return;
		}
			
		
		url_args = "&c=" + casualty_cp_no + "&pi="+ casualty_post_id + "&i=" + incident_type +"&s=" +
					scene + "&d=" + incident_date + "&t=" + incident_time + "&n=" + description
					+ "&an=" + approver_name + "&ap=" + approver_post + "&l=" + casualty_location +
					"&ds=" + casualty_duty_status + "&ei=" + extra_info + "&cs="+ casualty_condition;
		
		
		var xmlhttp;

		if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else{	// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}

		xmlhttp.onreadystatechange=function(){					

			if (xmlhttp.readyState==4 && xmlhttp.status==200){				
		
				document.getElementById("msg" + index_no).innerHTML=xmlhttp.responseText;
			}
			
		}
		
	
		xmlhttp.open("POST","<?php echo $full_url; ?>checkout/index.php", true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("p=<?php echo encrypt('submit_noticas'); ?>" + url_args); 
	}
		
	function approve_repatriation(display_id, applicant_id){
		var approve = document.getElementById("approved" + display_id).checked;
		var reject = document.getElementById("rejected" + display_id).checked;
		var status;
		var xmlhttp;
		var errorMsg = '';
		var args;
		var url_args;
		var note='';
		var display = 'msg' + display_id;
		var notice_token = document.getElementById('token' + display_id).value;
		var eeom = document.getElementById("eeom"  + display_id).value; //this will be updated as new check-out date in IPO table
		var repatriant_id = document.getElementById('repatriant' + display_id).value;
		var repatriant_post_id = document.getElementById('repatriant_post_id' + display_id).value;
		var applicant_id = document.getElementById('applicant' + display_id).value;
		//alert(document.getElementById(eeom_index).value);
		
		note = document.getElementById('note' +  display_id).value;
		note = note.trim();
		
		//alert(note);
		if(reject == true){
			status = 'Rejected';
		}
		else{
			
			if(approve == true ){
			   status = 'Approved';	
			}
			else{
				errorMsg = "Select 'Reject' or 'Approve' to complete task!<br>";
				
			}
		
		}
		
		if(note != ''){
          if(isSentence(note) != true){
				errorMsg += "Invalid characters in field 'Comments'<br>";
		  }
		}	
	
		if(errorMsg !=''){
			document.getElementById(display).innerHTML = errorMsg;
			return;
		}
		
		url_args = "&k=" + display_id + "&n="  + note.trim() + "&s=" + status + 
		          "&a=" + applicant_id + "&t=" + notice_token + "&e=" + eeom + 
				  "&r=" + repatriant_id + "&i=" + repatriant_post_id;
	
		
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
		
		xmlhttp.open("POST", "<?php echo $full_url; ?>checkout/index.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("p=<?php echo encrypt("approve_repatriation"); ?>" + url_args); 
	}





	function approve_authrization(repatrinet_id , authrized_id){
	   
	    var xmlhttp;
	    var url_args;
	    var errorMsg ='';
	    var display = 'msg' + repatrinet_id;
	
	   
	   
	  
	    if(repatrinet_id== ''){
	       
	        errorMsg += "Invalid Repatriant_id<br>";
	    
	    }else if(authrized_id==''){
	
	        errorMsg += "Invalid Authrized_id<br>";
	    }

	    if(errorMsg !=''){
	        document.getElementById(display).innerHTML = errorMsg;
	       
	        return;
	    }
		

	     url_args = "&k=" + repatrinet_id + "&r=" + authrized_id;
	
	    

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
		
	    xmlhttp.open("POST", "<?php echo $full_url; ?>checkout/index.php",true);
	    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	    xmlhttp.send("p=<?php echo encrypt("submit_repatriated_authrzition"); ?>" + url_args); 
	}




	function search_checkout_stat_rep(){
		
	    var xmlhttp;
	    var url_args;
	    var errorMsg ='';
	    var display = 'msg'
	    var str_date;
	    var end_date;
	    str_date = document.getElementById("str_year").value + "-" + document.getElementById("str_month").value
                        + "-" + document.getElementById("str_day").value;
	    end_date = document.getElementById("end_year").value + "-" + document.getElementById("end_month").value
                       + "-" + document.getElementById("end_day").value;
	   
	   

	    if(str_date== ''){
	       
	        errorMsg += "Invalid Start Date<br>";
	    
	    }else if(end_date==''){
	
	        errorMsg += "Invalid End Date<br>";
	    }

	    if(errorMsg !=''){
	        document.getElementById(display).innerHTML = errorMsg;
	       
	        return;
	    }
		
	   
	    url_args = "&s=" + str_date + "&e=" + end_date;
	
	    

	    if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
	        xmlhttp=new XMLHttpRequest();
	    }
	    else{	// code for IE6, IE5
	        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	    }
		
	    xmlhttp.onreadystatechange=function(){		

	        if (xmlhttp.readyState==4 && xmlhttp.status==200){				
	           
	            document.getElementById('checkout_stat_rep_display').innerHTML=xmlhttp.responseText;
	        }
			
	    }
	   
	    xmlhttp.open("POST", "<?php echo $full_url; ?>checkout/index.php",true);
	    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	    xmlhttp.send("p=<?php echo encrypt("check_out_statis_rep.pdf"); ?>" + url_args); 
	}

	

	
	function PrintElem(elem, title)
    {
        Popup($(elem).html());
    }

    function Popup(data, title) 
    {
        var mywindow = window.open('', 'my div', 'height=400,width=600');
        mywindow.document.write('<html><head><title>'+ title + '</title>');
        /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10

        mywindow.print();
        mywindow.close();

        return true;
    }
	</script>	