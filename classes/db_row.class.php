<?php
//creates a database connections using and instance og the MySQLI object 
//returns table fields as array
//
//require_once 'auth.php';
//require_once 'config.php';
   
        
class db_rows{ 
       
	protected $_dbselect = array();
       
	 function __construct(){ 
	    
		$this->_dbselect =  $GLOBALS['mysqli'];
		/*$_db='cdms';
		$_dbhost='localhost';
		$_dbpassword='root123';
		$_dbusername='root';        
		$this->_dbselect = new mysqli($_dbhost, $_dbusername, $_dbpassword, $_db);
		
		if($this->_dbselect->connect_errno > 0){
					die('Unable to connect to database [' . $_dbselect->connect_error . ']');
		}  */ 
	 }

	function dbcommit($query){ //perform SQL query on database
		//echo $query;
		if ($this->_dbselect->query($query)==TRUE){
			return 1;
		}
		else{
			
			echo $this->_dbselect->error .  "--". $this->_dbselect->errno;
			return 0 ; 
		}
	}
   
	function del_rows($table, $key_feild, $key){         //performs the row delete 
		return $this->dbcommit("delete from $table where $key_feild='$key' " );
	}
	
	function insert_row($table, $field_values=array()){
		$values = $fields=$result=NULL; $index=1;
		$field_count = count($field_values);
	  // print_r($field_values);
		
		foreach($field_values as $field){  
			$comma = ($index== $field_count) ? "" : ", ";
			$fields .= $field[0] . $comma;
			$values .= "'".$field[1]."'". $comma;
			$index++;
		}
   
		$sql =  "INSERT INTO $table($fields) VALUES ($values) ";
		
		//echo $sql;
		if(strlen(trim($values)) > 0){
			return $this->dbcommit( $sql);
		}
		else{
				return " Invalid parsed fields or field values";
		} 
	}

	function update_row($table, $field_values=array(), $key){
		$values = $comma = $fields=$result=NULL; $index=1;
		$field_count = count($field_values);
		
		foreach($field_values as $field){    
			$comma = ($index== $field_count) ? "" : ", ";
			$fields .= $field[0] . " = '". $field[1]."'" . $comma;           
			$index++;
		}
		
		//echo $fields;
		if(strlen(trim($fields)) > 0){
			   // echo $fields;
				return $this->dbcommit( "UPDATE $table SET $fields WHERE $key ");
		}
		else{
			return " Invalid parsed fields or field values";
		}
	}
	
	function get_rows($table, $feilds=array(), $key=NULL) {
		//init();
		if(empty ($this->_dbselect)) $this->_dbselect  = $GLOBALS['mysqli'];
		
		$where = (!is_null($key)) ? "WHERE $key" : '';
		$count = count($feilds); $comma =', '; $index = 0;
		$_feilds = NULL;
		
		foreach($feilds as $feild){
			$_feilds .= (is_array($feild))? $feild[0].' AS '.$feild[1] : $feild;
						
			if($index < $count -1)
				$_feilds .= $comma; //add commas to feild list
				$index++;
			}
						
			$query = "SELECT $_feilds FROM $table $where";
			//echo "<p><br>".$query;
										
			if ($result=$this->_dbselect->query($query)){		
				$rows = array();
					  
				while ($row = $result->fetch_assoc()) {
					extract($row);
					$_row = array();
							
					foreach($feilds as $feild){
						$r_feild = (is_array($feild)) ? $feild[1] : $feild;  //name of parsed field, if array its alias
						$_row[$r_feild]= $$r_feild;
					}   
					
					$rows[]=$_row;
				}
						
				return $rows;
			}
			else{
				echo $this->_dbselect->error;
			}
			
	}
			


	function get_rowsPrepared($table, $feilds=array(),  $bind_params=array(),$place_holder_key=NULL) {
		
		    $place_holder_count=$counter = $rows=NULL;
		
				/* Bind parameters. Types: s = string, i = integer, d = double,  b = blob */

			 
			/* with call_user_func_array, array params must be passed by reference */
			$place_holder_count = count($bind_params);
			 //print_r($bind_params);
			 
			for($counter = 0; $counter < $place_holder_count ; $counter++) {
			  /* with call_user_func_array, array params must be passed by reference */
			  $a_params[] = & $bind_params[$counter];
			}
			
			print_r($a_params);
			$where = (!is_null($place_holder_key)) ? "WHERE $place_holder_key" : '';
			
			$count = count($feilds); $comma =', '; $index = 0;
			$_feilds = NULL;
						
			foreach($feilds as $feild){
				$_feilds .= (is_array($feild))? $feild[0].' AS '.$feild[1] : $feild;
							
				if($index < $count -1)
					$_feilds .= $comma; //add commas to feild list
					$index++;
			}
							
			$query = "SELECT $_feilds FROM $table $where";
				echo "<p><br>".$query;
				
			 
			/* Prepare statement */
			$stmt = $this->_dbselect->prepare($query);
			if($stmt === false) {
			  return 'Wrong SQL: ' . $query . ' Error: ' . $conn->errno . ' ' . $conn->error;
			}
			else{
				/* use call_user_func_array, as $stmt->bind_param('s', $param); does not accept params array */
				call_user_func_array(array($stmt, 'bind_param'), $a_params);
				 
				/* Execute statement */
				$stmt->execute();
				 
				/* Fetch result to array */
				$res = $stmt->get_result();
				
				while($row = $res->fetch_array(MYSQLI_ASSOC)) {
					extract($row);
					$_row = array();
								
					foreach($feilds as $feild){
						$r_feild = (is_array($feild)) ? $feild[1] : $feild;  //name of parsed field, if array its alias
							$_row[$r_feild]= $$r_feild;
					}   
						
					$rows[]=$_row;
								//print_r ($rows);
				}
							
				return $rows;	  //array_push($a_data, $row);
			}
	}
    function update_repatiration_status($key){
        
        
        $this->update_row($table, $fields, $key);
        
    }			
}			
			
		
?>
