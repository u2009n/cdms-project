<script type="text/javascript">

	function isAlphabetic(input_txt){   
		  var letters = /^[A-Za-z]+$/; 
		  return letters.test(input_txt); 
	}  
		  
	function isNumeric(input_txt){   
		  var digits = /^[0-9]\d*$/;
		  return digits.test(input_txt);

	}  
	
	function isAlphaNumeric(input_txt){   
		  var text = /^[a-zA-z0-9\s]+$/;
		  return text.test(input_txt);

	}  

	function isSentence(input_txt){   
		  var text = /^[a-zA-z0-9\.,\'\:\;\!\-\s]+$/; 
		  return text.test(input_txt);

	}
	
</script>