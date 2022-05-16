<?php
	require_once 'db_row.class.php';
	require_once 'placement.class.php';
	require_once 'contingent.class.php';
	
	class ipo{

		public $cp_no = '';
		public $indexNo=0;
		public $firstName='';
		public $lastName='';
		public $sex;
		public $dob;
		public $passport_no;		
		public $eom ='';
		public $doa ='';
		public $email = '';
		public $nextofkin_name ='';
		public $nextofkin_contact_no='';
		public $nextofkin_contact_address;
		public $nextofkin_relationship;
		public $post_id =0;
		public $position = NULL;
		public $unit_id = 0;
		public $unit_name = '';
		public $teamSite_id = 0;
		public $teamSite_name='';
		public $sector_id = 0;
		public $unitSupervisor_post_id=0;
		public $sectorSupervisor_post_id=0;
		public $contingent_id=0;		
		public $contingent= NULL;
		protected $conn =null;
		public $ipo_list = array();
		
		function __construct($_cp_no = ''){

			$this->conn = new db_rows();
				
			
			if($_cp_no !=='') 
					$this->getIPO($_cp_no);
			
		}
		
		function getIPO($_cp_no){
			
			$table = "ipo";
			$fields = 	array('cp_no', 
								'IndexNo', 
								'LastName', 
								'FirstName', 
								'cntr_id', 
								'post_id', 
								'Gender',
								'dob',
								'PassNo',
								'doa', 
								'eom', 
								'email_address',
								'em_contact_name',
								'em_contact_address',
								'em_contact_phone',
								'em_relationship'
							
						);
						
			$key = "cp_no = '$_cp_no'";
			$row=$this->conn->get_rows($table, $fields, $key );
			
			if(is_array($row)){
				extract($row[0]);
				$this->cp_no = $cp_no;
				$this->indexNo=$IndexNo;
				$this->firstName=$FirstName;
				$this->lastName= $LastName;
				$this->post_id =$post_id;
				$this->sex = $Gender;
				$this->dob = $dob;
				$this->passport_no = $PassNo;
				$this->eom =$eom;
				$this->doa =$doa;
				$this->email =$email_address;
				$this->nextofkin_name = $em_contact_name;
				$this->nextofkin_contact_no= $em_contact_phone;
				$this->nextofkin_relationship = $em_relationship;
				$this->nextofkin_contact_address = $em_contact_address;
				$this->contingent_id = $cntr_id;
				//$this->conn->close();
				//echo $this->contingent_id;
				$this->contingent = new mcontingent();
				$this->contingent->getContingent($this->contingent_id);
				$this->position = new position($this->post_id);
				
			}
			else
				echo 'Empty ';
		}			
		
	}

	
	class ipoList{
		public $ipo_list=array();
		protected $conn= NULL;
		
		function __construct($_filter= NULL){
			$table = "ipo";
			$fields[] = "cp_no";
			$this->conn = new db_rows();
			$key = $_filter !=NULL ? " $_filter"  : '';
			
			$rows=$this->conn->get_rows($table, $fields, $key);
			
			if(is_array($rows) && !empty($rows)){
				foreach($rows as $row)
					$this->ipo_list[] = new ipo($row['cp_no']);
			}
			
		}
      
	}
	
?>