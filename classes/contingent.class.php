<?php

	//object of the the IPO Contingent; 
	
	require_once 'ipo.class.php';
	
	class mcontingent{
		public $contingent = 0;
		public $cont_name ='';
		public $cont_code ='';
		public $cont_category=0;
		protected $cont_commandr_cpno=0;
		public $contingent_commander = NULL;
		public $destinations = NULL;
		protected $conn= NULL;
		
		function __construct($_contingent_id=NULL){
			$this->conn= new db_rows();
			
			//echo $_contingent_id;
			if($_contingent_id > 0) $this->getContingent($_contingent_id);
			$this->contingent_commander = new ipo();
		}
		
		function getContingent($_contingent_id){
			
			//echo $_contingent_id;
			$fields= array( array('country.cntr_name', 'cont_name'),
							array('country.cntr_code', 'cont_code'),
							array('country.cntr_type', 'cont_category')
					 );
					
			$table = "country";			
			$key = "cntr_id = $_contingent_id";
			$row=$this->conn->get_rows($table, $fields, $key);
			
			if(is_array($row) && !empty($row)){
				$this->cont_name = $row[0]['cont_name'];
				$this->cont_code = $row[0]['cont_code'];
				//$this->cont_commandr = $this->getContingentCommander($_contingent_id);
				$this->destinations = $this->getDestinations($_contingent_id);
				
			}
			
		} 
		
		function getContingentCommander($_contingent_id){
				$table= "cont_commandr";
				$fields = array('cc_cpno');
				$row=$this->conn->get_rows($table, $fields);
				if(is_array($row) && !empty($row)){
					$this->cont_commandr_cpno = $row[0]['cc_cpno'];
				  
					if(trim($this->cont_commandr_cpno) !=='')
							$this->contingent_commander = new	ipo($this->cont_commandr_cpno);
						
					  
				}
		}
		
		function get_members($_contingent_id){
			$table = "cont_commandr";
			$this->contingent_commander = new ipo($cont_commandr_cpno);
		}
		
		function getDestinations($_contingent_id){
			$table = "towns";
			$fields = array("town_name", "id");
			$key = "cntr_id = $_contingent_id";
						
			return $this->conn->get_rows($table, $fields, $key);
			
			//if(is_array($row) && !empty($row))
				//return $rows;									  
			
		}
		
		function addDestination($contingent_id, $destination_name){
			$table = 'towns';
			$fields = array( array('town_name', addslashes($destination_name)),
							 array('cntr_id', $contingent_id)
							);
							
			return $this->conn->insert_row($table, $fields);
		}
	}
?>