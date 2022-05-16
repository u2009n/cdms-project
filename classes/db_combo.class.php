<?php
	//require_once 'auth.php';
	//require_once 'config.php';
    require_once('db_row.class.php');
	
	class db_combo{
        public $rows; 
        function __construct(){
             $this->rows = new db_rows;
       }
		function combo($table, $list_field, $value_field, $select_attrib, 
						$filter=NULL,  $option_attrib=NULL, $default_text=NULL, 
						$default_value=NULL){
							
		     $list = NULL;
             $fields= array($list_field, $value_field); 
			if (is_array($result=$this->rows->get_rows($table, $fields, $filter))){
				$list.="<select $select_attrib><option>$default_text</option>";
			    // print_r($result);
				foreach ($result as $row) {
					$selected = (!is_null($default_value) && $row[$value_field] == $default_value) ? "selected=\"selected\"" : '';							
					$list.= "<option $option_attrib value=\"". $row[$value_field]. "\" $selected >". $row[$list_field]. "</option>";
				}
			
				$list.= "</select>";
                 return $list;
			}
			else{
				return $result;
			}
			
		}
}
?>