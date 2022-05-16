<?php

	require_once 'db_row.class.php';
			
	class sector extends db_rows{
		public $sector_id = 0;
		public $sector_name ='';
		public $errors=array();
		//public $supervisors = array();
		protected $conn=null;
		
		function __construct($_sector_id=0){

			//$this->conn = new db_rows();
			
			if($_sector_id > 0) $this->getSector($_sector_id);
			
		}
	
		function getSector($_sector_id){
			$table = "sectors";
			$fields = array("sec_id", 'sec_name'); 
			$key = "sec_id=$_sector_id";

			if(is_array($row=$this->get_rows($table, $fields, $key))){
				$this->sector_id = $_sector_id;
				$this->sector_name=$row[0]['sec_name'];
				
				//echo "<p>".$this->sector_name."</p>";
				
			}
			
		}
		
		public function getSector_teamsites($_sector_id){
			$table = 'units';
			$fields = array('ts_id', 'ts_name');
			$key= "sec_id=$_sector_id";
			
			if(is_array($rows=$this->get_rows($table, $fields, $key))){
				return $rows;
				
			}	
			else
				return NULL;
			
			
		}
	}
	
	/*********************************************************************************************/
    
	class teamsite extends sector{
		public $teamsite_id=0;
		public $teamsite_name = '';	
		
		function __construct($_teamsite_id=0){
			//$this->conn = new db_rows();
			if($_teamsite_id > 0) $this->getTeamsite($_teamsite_id);
			
		}
		
		public function geTeamsite($_teamsite_id){
			$table = "teamsites";
			$fields = array('ts_id', 'ts_name', 'sec_id');
			$key= "ts_id = $_teamsite_id ";
			
			if(is_array($row=$this->get_rows($table, $fields, $key))){
				$this->teamsite_id = $row[0]['ts_id'];
				$this->teamsite_name=$row[0]['ts_name'];
				$this->sector_id = $row[0]['sec_id'];
				$this->getSector($this->sector_id);
				
			}	
			
		}
		
		public function getTeamsitUnits(){
		}
		
	}
	
	
	class unit extends teamsite{
		public $teamsite_id=0;
		public $unit_id = 0;
		public $unit_name = '';
		public $unit_supvsr_post_id =0;
		public $section_supvsr_post_id=0;
		
		function __construct($_unit_id=0){
			//$this->conn = new db_rows();
			if($_unit_id > 0) $this->getUnit($_unit_id);
			
		}	
		
		public function getUnit($_unit_id){ //search db for specific position
			$table = 'units';
			$key = "unit_id = $_unit_id";
			$fields = array('unit_name', 
							array('unit_supervisor', 'supvsr_post_id'), 
							array('ts_id', 'teamsite_id'),							
							array('section_supervisor', 'section_supvsr_post_id'),
					);
			$row=$this->get_rows($table, $fields, $key);
        
			if(is_array($row) && !empty($row)){
				$this->unit_id= $_unit_id;
				$this->unit_name= $row[0]['unit_name'];
				$this->unit_supvsr_post_id= $row[0]['supvsr_post_id'];
				$this->section_supvsr_post_id=$row[0]['section_supvsr_post_id'];
				$this->geTeamsite($row[0]['teamsite_id']);
			}
		}
		
		public function getUnit_Positions($_unit_id){ //returns array of positions in unit 
			
			$table = 'positions';
			$fields = array('post_id', 'post_name', 'keypost', 'supervisor');
			$key = "unit_id = $_unit_id";
			
			if(is_array($row=$this->get_rows($table, $fields, $key)))
				return $row;
			
		}
	}
	
	class position extends unit{
		public $post_id=0;
		public $post_name = '';
		
		protected $position_unit_id;
		public $post_plan = 0;
		public $post_category_id = 0;
		public $post_category_name ='';
		public $command_chain = array();
		
		//protected $conn=NULL;
		//protected $unit_id = 0;
			
		public function __construct($_post_id=0){			
			//$this->conn = new unit();			
			if($_post_id > 0) $this->getPosition($_post_id);
		}
		
		public function getPosition($_post_id){
		   $table = 'positions INNER JOIN categories on 
						positions.category = categories.id AND  
							positions.post_id = '. $_post_id;
							
		   $fields = array(array('positions.post_name', 'post'), 
						   array('positions.unit_id', 'unit_id'), 
						   array('positions.planned', 'planned'),
						   array('positions.supervisor', 'supvsr'),
						   array('categories.ID', 'category_id'),
						   array('categories.Category', 'category_name') 
					 );
						   
		   
		   
		    if(is_array($row=$this->get_rows($table, $fields))){
				$this->post_id = $_post_id;
				$this->post_name=$row[0]['post'];
				$this->position_unit_id = $row[0]['unit_id'];
				//$this->supvsr_post_id =$row[0]['supvsr'];
				$this->post_category_id= $row[0]['category_id'];
				$this->post_category_name=$row[0]['category_name'];				
				$this->getUnit($this->position_unit_id);
				$this->command_chain = $this->getSupervisors($_post_id);
			}	
		
				
		}
		
		public function getSupervisors($_post_id){
			$table = "positions AS p INNER JOIN positions AS s  ON p.supervisor = s.post_id";
			
			$fields = array(array('s.post_id', 'sup_id'),
							array('s.post_name', 'sup_title'),
							array('p.post_id', 'sub_id')
						); 
						
	
			$supervisors = array();
			
			while($_post_id > 0){
				$key = "p.post_id = $_post_id";
				
				$rows = $this->get_rows($table, $fields, $key);
				
				if(is_array($rows)){
					
					foreach($rows as $row){
						extract($row);
						$_post_id = $sup_id == $sub_id ? 0 : $sup_id;
						if($_post_id > 0) $supervisors[] = array($sup_id, $sup_title);
						
					}
				}
				else 
					$_post_id = 0;
			}
			
			return $supervisors;
		}
		
			
	}
	
	class tempAppointments extends db_rows{ //returns array of all active temporary appointments assumed by a particular user
	     public $positions;
		 
		function __construct($cp_no){
			$table = "replacements";
			$fields = array("post_id");
			$filter = " rep_ofcr= '$cp_no' AND DATEDIFF(end_date, CURDATE()) >= 0";
			$temp_post_ids = array();
			 
			$rows = $this->get_rows($table, $fields, $filter);
				
			if(is_array($rows) && !empty($rows)){
				
				foreach($rows as $row){
					extract($row);
					$temp_post_ids[] = $post_id;
					
				}
				
				foreach($temp_post_ids as $temp_post_id){
					$this->positions[] = new position($temp_post_id);
					
				}
				
			}
		}	
		
	}
	
?>