<?php
	//This class models the IPO bank details as required in the Check-Out forms
	
	require_once "ipo.class.php";
	require_once 'validator.php';
	
	class ipoBankdetails extends ipo{
	    public $bank_name='';
		public $branch_address='';
		public $branch_name='';
		public $iban = '';
		public $routing_abn='';
		public $swiftcode='';
		public $account_no='';
		public $rec_id = '';
	    protected $table = "ipo_bank_details";

		
		function __construct($_cp_no = ''){
			$this->conn = new db_rows();	
			
			if($_cp_no !==''){ 
					$this->getIPO($_cp_no);
					
					if($this->indexNo > 0)
						$this->getBankdetails($_cp_no);
			}
			
		}
		
				
		function getBankdetails($_cp_no){
			
			$this->bank_name='';
			 $this->branch_address='';
			 $this->branch_name='';
			 $this->iban = '';
			 $this->routing_abn='';
			 $this->swiftcode='';
			 $this->account_no='';
			 
             $fields = array('id', 'bank_name', 'branch_address', 'branch_name', 'iban', 'routing_abn', 'swiftcode', 'account_no');
			$key = "cp_no = '$_cp_no'";
			
			$row=$this->conn->get_rows($this->table, $fields, $key);
			
			if(is_array($row) && !empty($row)){
				//echo "<pre>";
				//print_r($row);
				$this->bank_name= $row[0]['bank_name'];
				$this->branch_address= $row[0]['branch_address'];
				$this->branch_name=$row[0]['branch_name'];
				$this->iban = $row[0]['iban'];
				$this->routing_abn=$row[0]['routing_abn'];
				$this->swiftcode=$row[0]['swiftcode'];
				$this->account_no=$row[0]['account_no'];
				$this->rec_id=$row[0]['id'];
			}
			
		}
		
		function addIPOBank_details(){
			return $this->conn->insert_row($this->table, $fields = 	$this->field_values());
		
		}
		
		function updateBankDetails($_cp_no){
			$key = "cp_no = '$_cp_no'";
			return $this->conn->update_row($this->table, $this->field_values(), $key);
		}
		
		private function field_values(){
			$values = array();
			$values = array(
							array( 'bank_name', addslashes($this->bank_name)),
							array('branch_address', addslashes($this->branch_address)),
							array('branch_name', addslashes($this->branch_name)),
							array('iban', $this->iban),
							array('routing_abn', $this->routing_abn),
							array('swiftcode', $this->swiftcode),
							array('account_no', $this->account_no),
							array('cp_no', $this->cp_no)
						  );
                    
			return $values;
		}
		
		
	}
?>