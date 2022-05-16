	<script type="text/javascript">

	
	function bank_details(display_id, mode){
		
		var status;
		var xmlhttp;
		var args;
		//var display = document.getElementById('msg' + display_id).value;
		var bank_name =  document.getElementById('bankname' +  display_id).value;
		var branch_name = document.getElementById("branchname"  + display_id).value;
		var branch_address = document.getElementById("address"  + display_id).value;
		var routing = document.getElementById("routing" + display_id).value;
		var iban = document.getElementById("iban" + display_id).value;
		var swift_code = document.getElementById("swiftcode" + display_id).value;
		var account = document.getElementById("account" + display_id).value;
		var errors='';
		bank_name = bank_name.trim();
		branch_name= branch_name.trim();
		branch_address = branch_address.trim();
		routing= routing.trim();
		iban= iban.trim();
		swift_code= swift_code.trim();
		account = account.trim();
		
		if(bank_name.length < 1)
			errors =  errors + "<br>Blank field 'Bank Name' [required field] ";
		
		if(isAlphaNumeric(bank_name) == false)
			errors =  errors + "<br>Invalid Characters in 'Bank Name' ";
		
		if(branch_name.length < 1)
			errors =  errors + "<br>Blank field 'Branch Name' [required field] ";
		
		if(isAlphaNumeric(branch_name)  == false)
			errors =  errors + "<br>Invalid Characters in 'Branch Name' ";
		

		if(isSentence(branch_address)  == false)
			errors =  errors + "<br>Invalid Characters in 'Mailing Address' ";
		

			
		if(routing.length > 0 ){
			if(isAlphaNumeric(routing) == false)
				errors =  errors + "<br>Invalid Characters in 'Routing/ABN' ";
			
			if(routing.length != 9)
				errors =  errors + "<br>Invalid 'Routing/ABN'; needs to be 9 digits.";
		}
		
		if(iban.length > 0 ){
			if(isAlphaNumeric(iban) == false)
				errors =  errors + "<br>Invalid Characters in 'IBAN' ";
			
			if(iban.length < 16)
				errors =  errors + "<br>Invalid 'Routing/ABN'; needs to be atleast 16 characters.";
		}
		
		if(swift_code.length > 0){
			
			if(swift_code.length < 8 || swift_code.length > 11)
				errors =  errors + "<br>Invalid 'SWIFT Code'; needs to be 8 to 11 characters.";
			
			if(isAlphaNumeric(swift_code)  == false )
				errors =  errors + "<br>Invalid Characters in 'Swift Code'.";
		}
		
		if(isNumeric(account) == false)
			errors =  errors + "<br>Invalid Characters in 'Account No.' Only numeric digits expected ";
		
		
		if(errors != ''){
			document.getElementById("msg"+display_id).innerHTML= errors;
			return;
		}
		
		url_args = "&n=" +bank_name + "&b="  + branch_name + "&a=" + branch_address + 
					"&r=" + routing + "&i=" + iban + "&s=" + swift_code + "&c=" + account + "&m=" + mode;
	
		
		if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else{	// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		
		
	
		xmlhttp.onreadystatechange=function(){					

			if (xmlhttp.readyState==4 && xmlhttp.status==200){				
		
				document.getElementById("msg"+display_id).innerHTML=xmlhttp.responseText;
					

			}
			
		}
		
	
		xmlhttp.open("POST","<?php echo $full_url; ?>checkout/index.php" ,true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("p=<?php echo encrypt('bank_details'); ?>" + url_args); 
	}
	

	</script>	