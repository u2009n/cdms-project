<?php
require_once 'db_row.class.php';


class luggageDeclaration{
	
	protected $conn = NULL;
	public $destination_name= NULL;
	public $destination_id = NULL;
	public $forwarding_address = NULL;
	public $luggage_description = NULL;
	public $travel_date = NULL;
	public $country = NULL;
	public $cp_no = NULL;
	public $declaration_id = NULL;
	protected $table = NULL;
	
	function __construct($cp_no = ''){
		$this->table = "luggage";
		$this->conn =  new db_rows();
		
		if(trim($cp_no) !== '') 
			$this->getLuggageDeclaration($cp_no);
	}
	
	function addLuggageDeclaration(){
		
		$fields = array(array('cp_no', $this->cp_no),
						array('description', addslashes($this->luggage_description)),
						array('destination_id', $this->destination_id),
						array('travel_date', $this->travel_date),
						array('forwarding_address', addslashes($this->forwarding_address))
				  );
				  
		return $this->conn->insert_row($this->table, $fields);		  
	}
	
	
	function getLuggageDeclaration($_cp_no){
		
		$table = "luggage INNER JOIN 
					 towns INNER JOIN country 
						ON towns.cntr_id = country.cntr_id
				     AND luggage.destination_id = towns.id 
				  WHERE luggage.cp_no = '$_cp_no'";
				  
		$fields = array(array('towns.town_name', 'destination_name'),
						array('luggage.description', 'luggage_description'),
						array('luggage.destination_id', 'destination_id'),
						array('luggage.travel_date', 'travel_date'),
						array('luggage.forwarding_address', 'forwarding_address'),
						array('country.cntr_name', 'country_name'),
						array('luggage.id', 'declaration_id')
					);
					
		 $row = $this->conn->get_rows($table, $fields);
		 
		 if(is_array($row) && !empty($row)){
			$this->cp_no = $_cp_no;
			$this->declaration_id = $row[0]['declaration_id'];
			$this->destination_id = $row[0]['destination_id'];
			$this->destination_name = $row[0]['destination_name'];
			$this->luggage_description = $row[0]['luggage_description'];
			$this->forwarding_address = $row[0]['forwarding_address'];
			$this->country = $row[0]['country_name'];
			$this->travel_date = $row[0]['travel_date'];
		 }
		 
	}
	
	function updateLuggageDeclaration($declaration_id){
		$d = date("Y-m-d", strtotime($this->travel_date));
		$fields = array(array('cp_no', $this->cp_no),
						array('description', addslashes($this->luggage_description)),
						array('destination_id', $this->destination_id),
						array('travel_date', $d),
						array('forwarding_address', addslashes($this->forwarding_address))
				  );
				  
		$key = " id = $declaration_id ";
       // print_r($fields);
		//echo($key);
		return $this->conn->update_row($this->table, $fields, $key);	

		
	}		
	
	
	
}

?>