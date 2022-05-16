<?php
	
	
	class _time{
		protected $obj ;
		
		function time_box($h_name, $m_name, $default_h=NULL, $default_m = NULL){
			
			$this->obj = "<select id=\"$h_name\" size=\"1\">\n\t\t\t\t<option></option>\n\t\t\t\t"; 
			
			for($h = 0; $h<24; $h++){
				$hr = (strlen("$h") == 1) ? "0$h" : $h;
				$this->obj  .= "<option value=\"$hr\" ".$sel=(($hr==$default_h)? "selected=\"selected\"" : NULL).">$hr</option>\n\t\t\t\t";
			}
			$this->obj  .= "</select>:<select id=\"$m_name\">\n\t\t\t\t<option></option>\n\t\t\t\t"; 
			
			for($m =0; $m<60; $m++){
				$min = (strlen("$m") == 1) ? "0$m" : $m; 
				$this->obj  .= "<option value=\"$min\" ".$sel=(($min==$default_m)? "selected=\"selected\"" : NULL)."> $min </option>\n\t\t\t\t";
			}	
			return $this->obj  .= "</select>";
		}
		
		function date_box($d_name, $m_name, $y_name, $default_d=NULL, $default_m=NULL, $default_y=NULL){
			$this->obj  .= "<select id=\"$d_name\"><option></option>"; 
						
			for($d = 0; $d < 32; $d++){ 
				$day = (strlen("$d") == 1) ? "0$d" : $d;
				
				$this->obj  .= "<option value=\"$day\" ".$sel=(($day==$default_d)? "selected=\"selected\"" : NULL).">$day</option>\n\t\t\t\t";
			}
			$this->obj  .= "</select>";
			
			$this->obj  .= "<select id=\"$m_name\"> \n\t\t\t\t<option></option> \n\t\t\t\t"; 
						
			for($m = 1; $m < 13; $m++){ 
				$m = (strlen("$m") == 1) ? "0$m" : "$m";
				$this->obj  .= "<option value=\"$m\" ".$sel=(($m==$default_m)? "selected=\"selected\"" : NULL)."> ". date('F', strtotime("23-$m-1980")) ."</option>\n\t\t\t\t";
			}
			$this->obj  .= "</select>";
			
			$this->obj  .= "<select id=\"$y_name\"><option></option>"; 
			$cy = date("Y")+1;
					
			for($y = $cy; $y >  1900; $y--)				
				$this->obj  .= "<option value=\"$y\" ".$sel=(($y==$default_y)? "selected=\"selected\"" : NULL)."> $y</option>\n\t\t\t\t";
			
			return $this->obj  .= "</select>";
				
		}
		
		
	}
	
?>
