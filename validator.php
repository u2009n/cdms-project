<?php
	//require_once 'auth.php';
	
	function is_html($text=null){
		$html = FALSE;
		$htext = '<>\"=\';:';
		
		if(!is_null($text))
		    $text_length = strlen($text);
		    $h_length = strlen($htext);
		    
			for($x = 0; $x < $text_length; $x++){
				$t=$text[$x];
				
				for($y = 0; $y < $h_length; $y++)
				
				    if($htext[$y]==$t)
				    		return TRUE; 
			
			}	
		return $html;
		
	}
	function escape($string) {
		return mysql_escape_string($string);
	}
	function is_email($email) {
		$at_index = strrpos($email, "@"); //position of the @ character
		$valid = TRUE;
	
		if(is_bool($at_index) && !$at_index){
			return FALSE; 
		}
		
		$domain = substr($email, $at_index + 1);
		$e_user = substr($email, 0, $at_index);
		
         //echo $e_user;
		//echo $domain;
		
		if(strlen($e_user) < 1 || strlen($e_user) > 64 || strlen($domain) < 1 || strlen($domain) > 255){
		  echo 'invalid user/domain length'; return FALSE; 
		}  		  	
		
		if(!preg_match('/[A-Za-z0-9._]/i', $e_user) ){
				echo 'invalid character in user'; return FALSE; 
		}		
		
		
		if($e_user[0]=='.' || $e_user[strlen($e_user) - 1] == '.' || $domain[0]=='.' || $domain[strlen($domain) - 1] == '.'){ //check if domain part starts or ends with dot
				echo 'user or domain ends / starts with . '; $valid = FALSE; 
		}	
			
		elseif(preg_match('/\.\./', $e_user)){ //check if user part contains 2 consecutive dots
			echo 'dot dot in user'; $valid = FALSE;  
		}	
		elseif(!preg_match('/[^A-Za-z0-9]/', $domain)){ 
			echo 'invalid character in domain'; $valid = FALSE; 
		}	
		elseif(preg_match('/\.\./', $domain)){ //check if domain contains two consecutive dots
			echo 'dot dot'; $valid = FALSE; 
		}
		elseif(!preg_match('/\./', $domain)){ //check if domain part contains a dot
			echo 'no dot in domain'; $valid = FALSE; 
		}	
			
			
		return $valid;			
				
				
		
	}
?>