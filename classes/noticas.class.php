<?php
	require_once 'db_row.class.php';
	require_once 'ipo.class.php';
	
	class noticas{
		protected $conn = NULL;
		protected $table = NULL;
		public $casualty = NULL;
		public $casualty_position = NULL;
		public $casualty_location = NULL;
		public $incident_date = '';
		public $incident_location='';
		public $casualty_duty_status = NULL;
		public $incident_type_id=NULL;
		public $incident_type = NULL;
		public $incident_description= NULL;
		public $incident_extra_info= NULL;
		public $authorised_by_post = NULL;
		public $authorised_by_name= NULL;
		public $casualty_status_id = NULL;
		public $casualty_status_title= NULL;
		public $drafted_by= NULL;
		public $dafted_by_position= NULL;

		

		public function __construct($noticas_id=NULL){	
			$this->conn= new db_rows();
			$this->table = 'noticas';
			$this->casualty = new ipo();
			$this->casualty_position = new position();
			$drafted_by= new ipo();
			$dafted_by_position= new position();
			
			if($noticas_id > 0)	
				$this->generateNOTICAS($noticas_id); 
		
		}
		
		public function addNOTICAS(){
			
			$fields = array(array('casualty_cp_no', $this->casualty->cp_no),
							array('casualty_post_id',$this->casualty->post_id),
							array('incident_date', $this->incident_date),
							array('incident_type_id', $this->incident_type_id),
							array('incident_location',$this->incident_location),
							array('incident_description', $this->incident_description),
							array('incident_extra_info', $this->incident_extra_info),
							array('authorised_by_name', $this->authorised_by_name),
							array('authorised_by_post', $this->authorised_by_post),
							array('draft_by_cp_no', $this->drated_by->cp_no),
							array('draft_by_post_id', $this->drafted_by->post_id)
							
							);
			
			return $this->conn->insert_row($this->table, $fields);
		}
		
		public function deleteNOTICAS($noticas_id){
			return $this->conn->del_rows($this->table, "id", $noticas_id);
		}
		
		function generateNOTICAS($noticas_id){
			$fields = array('casualty_cp_no', 'casualty_post_id', 'incident_date', 'status_title',
							'incident_type_id',	'incident_type', 'incident_location', 'incident_description', 
							'incident_extra_info', 'authorised_by_names', 'authorised_by_title', 
							'draft_by_cp_no', 'draft_by_post_id', 'casualty_current_location',	'on_duty'						
							);
			$table_join=" INNER JOIN noticas_casualty_status ON noticas_casualty_status.id = noticas.casualty_status
						  INNER JOIN incident_types ON noticas.incident_type_id = incident_types.id AND noticas.id=$noticas_id";
					
			$row = $this->conn->get_rows($this->table. $table_join, $fields);
			
			if(is_array($row) && !empty($row)){
		 		$this->casualty_cp_no = $row[0]['casualty_cp_no'];
				$this->casualty_post_id= $row[0]['casualty_post_id'];
				$this->incident_date =$row[0]['incident_date'];
				$this->incident_location=$row[0]['incident_location'];
				$this->casualty_current_location=$row[0]['casualty_current_location'];
				$this->incident_type_id=$row[0]['incident_type_id'];
				$this->incident_type=$row[0]['incident_type'];
				$this->casualty_duty_status=$row[0]['on_duty'];
				$this->casualty_status_title= $row[0]['status_title'];
				$this->incident_description= $row[0]['incident_description'];
				$this->incident_extra_info= $row[0]['incident_extra_info'];
				$this->authorised_by_post =$row[0]['authorised_by_title'];
				$this->authorised_by_name= $row[0]['authorised_by_names'];
				$this->drafted_by_cp_no= $row[0]['draft_by_cp_no'];
				$this->dafted_by_post_id= $row[0]['draft_by_post_id'];
				$this->casualty= new ipo($this->casualty_cp_no);
				$this->casualty_position = new position($this->casualty_post_id);
				$this->drafted_by= new ipo($this->drafted_by_cp_no);
				$this->drafted_by_position = new position($this->dafted_by_post_id);	
			}
			
		}
					
	}
?>