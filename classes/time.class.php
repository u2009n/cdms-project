<?php
	
	
	class _time{
		
		function time_box($h_name, $m_name, $default_h=NULL, $default_m = NULL){
			echo "<select name=\"$h_name\" size=\"1\"><option></option>"; 
			
			for($h = 0; $h<24; $h++){
				$hr = (strlen("$h") == 1) ? "0$h" : $h;
				echo "<option value=\"$hr\" ".$sel=(($hr==$default_h)? "selected=\"selected\"" : NULL).">$hr</option>";
			}
			echo "</select><select name=\"$m_name\"><option></option>"; 
			
			for($m =0; $m<60; $m++){
				$min = (strlen("$m") == 1) ? "0$m" : $m; 
				echo "<option value=\"$min\" ".$sel=(($min==$default_m)? "selected=\"selected\"" : NULL)."> $min </option>";
			}	
			echo "</select>";
		}
		
		function date_box($day=array(), $month = array(), $year=array()){
			$d_name = $day[0];
			$d_lbound = $day[1];
			$d_ubound = $day[2];
			$d_default = $day[3];

			$m_name = $month[0];
			$m_lbound = $month[1];
			$m_ubound = $month[2];
			$m_default = $month[3];
			
			$y_name = $year[0];
			$y_lbound = $year[1];
			$y_ubound = $year[2];
			$y_default = $year[3];
			$date = NULL;
			
			$date= "<select id=\"$d_name\">"; 
						
			for($d = $d_lbound; $d <= $d_ubound; $d++){ 
				$dy = (strlen($d) == 1) ? "0$d" : $d;
				$date.= "<option value=\"$dy\" ".$sel=(($dy==$d_default)? "selected=\"selected\"" : NULL).">$dy</option>";
			}
			$date.= "</select>";
			
			$date.= "<select id=\"$m_name\"> "; 
						
			for($m = $m_lbound; $m <= $m_ubound; $m++){ 
				$m = (strlen($m) == 1) ? "0$m" : $m;
				$date.= "<option value=\"$m\" ".$sel=(($m==$m_default)? "selected=\"selected\"" : NULL)."> ". date('F', strtotime("30-$m-2000")) ."</option>";
			}
			$date.= "</select>";
			
			$date.= "<select id=\"$y_name\">"; 
			$cy = date("Y");
					
			for($y = $y_lbound; $y <=  $y_ubound; $y++)				
				$date.= "<option value=\"$y\" ".$sel=(($y==$y_default)? "selected=\"selected\"" : NULL)."> $y</option>";
			
			return $date. "</select>";
				
		}
		
		
	}
	
?>
