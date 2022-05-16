
<script type="text/javascript">

	function  luggage_details(display_id,lmode){
	    var cp_no = document.getElementById('IPO_CP' + display_id).value;	
		  var tday = document.getElementById('lday' + display_id).value;	
		  var tmonth = document.getElementById('lmonth' + display_id).value;
		  var tyear = document.getElementById('lyear' + display_id).value;
		  var destination = document.getElementById('town' + display_id).value;
		  var address = document.getElementById('laddress' + display_id).value;
		  var description = document.getElementById('ldescription' + display_id).value;
		  var lmode = document.getElementById('lmode' + display_id).value;
		  var rec_id = document.getElementById('l_id' + display_id).value;
		  var eom = new Date(document.getElementById('l_eom' + display_id).value);
		  var today = new Date();
		  var errors='';

		  
		
		  if(destination=='')
				errors = 'Invalid desitination. Select from list<br>';
			
		 // if(isAlphaNumeric(address)==false)
			// errors +=  "Invalid characters in 'Forwarding Address'<br>"; 
		  
		 // if(isAlphaNumeric(description)==false)
			//  errors += "Invalid characters in 'Luggage Description'<br>";  
		  
		  if(tday=='' || tmonth=='' || tyear == ''){
			  errors += "Invalid 'Travel Date'<br>";
		  }
		  else{
			var parsed_date = tyear + '-' + tmonth + '-' + tday;
			var travel_date = new Date(parsed_date); 
			var t_eom = eom.getTime();
			var t_travel_date = travel_date.getTime();
			var t_eom = eom.getTime();
			
			
			if(t_eom >= t_travel_date){
				errors = errors + "Invalid 'Travel Date': must be later that your EOM<br>";
			}
			
		  }
		  
		  if(errors!= ''){
			  document.getElementById('lmsg' + display_id).innerHTML = 'Error:<br>'+ errors;
			  return; 
		  }
		  var url_args = '&d=' + parsed_date + '&a='+ address + '&s='+description
					+ '&t='+ destination + '&m=' + lmode + '&i='+ rec_id + '&cp=' + cp_no;
		  
			if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
			}
			else{	// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			
			
		
			xmlhttp.onreadystatechange=function(){					

			
			
		   if (xmlhttp.readyState==4 && xmlhttp.status==200){				
			        var response = xmlhttp.responseText;
			        
			        if(response == 1){ 
			            document.getElementById("lmode"+display_id).value = 'e';
			            document.getElementById("lmsg"+display_id).innerHTML= "Saved";
			            
			        }	
			        else{
			            document.getElementById("lmsg"+display_id).innerHTML= "Saved";
			            // document.getElementById("lmsg"+display_id).innerHTML= response;
			            
			        }

			    }
			}
			  	/*if (xmlhttp.readyState==4 && xmlhttp.status==200){				
			
					document.getElementById("lmsg"+display_id).innerHTML=xmlhttp.responseText;
						

				}*/

			
			xmlhttp.open("POST","<?php echo $full_url; ?>checkout/index.php" ,true);
			xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			xmlhttp.send("p=<?php echo encrypt('luggage_details'); ?>" + url_args); 
		  
			//alert(url_args);
	}

</script>