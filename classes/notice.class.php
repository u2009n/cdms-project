<?php
require_once('db_row.class.php');
require_once('ipo.class.php');

class  notice{
    public $sender = NULL;
	public $sender_position=NULL;
	public $recipient = NULL;
	public $recipient_position = NULL;
	public $notice_title = NULL;
	public $notice_time = NULL;
	public $notice_status = NULL;
	public $notice_action_page = NULL;
	public $notice_type = NULL;
	public $sender_cp_no = NULL;
	public $sender_post_id = NULL;
	public $recipient_cp_no = NULL;
	public $recipient_post_id = NULL;
	public $notice_token = NULL;
	protected $conn = NULL;
	
	function __construct($cp_no=NULL, $post_id=NULL){
		 $this->conn = new db_rows();
			 
	}
	
	public function readPositionNotice($notice_id){
	   $feilds = array('sender_cp_no','id', 'sender_post_id',
						'rec_post_id', 'notice_title', 'action_page',
						'notice_status', 'sent_time', 'notice_type'
 
					  );
					  
		$table  = "position_notice";				  
		$filter = " id = $notice_id ";
						
		$row = $this->$conn->get_rows($table, $fields, $filter);
		
		if(is_array($row) && !empty($row)){
			$this->sender_cp_no = $row[0]['sender_cp_no'];
			$this->sender_position_id = $row[0]['sender_post_id'];
			$this->recipient_post_id = $row[0]['rec_post_id'];
			$this->notice_time = $row[0]['sent_time'];
			$this->notice_title = $row[0]['notice_title'];
			$this->notice_status = $row[0]['notice_status'];
			$this->action_page = $row[0]['action_page'];
			$this->notice_token = $row[0]['notice_token'];
			$this->notice_type = $row[0]['notice_type'];
			$this->sender =  new ipo($this->sender_cp_no);
			$this->recipient_position = new position($this->recipient_post_id);
		}
		

	}
	
	public function readPrivateNotice($notice_id){
		$feilds = array('sender_cp_no','id', 'sender_post_id',
							'rec_cp_no', 'notice_title', 'action_page',
							'notice_status', 'sent_time', 'notice_type'
					  );
					  
		$table = "private_notice";				  
		$filter = "id = $notice_id";
						
		$row = $this->$conn->get_rows($table, $fields, $filter);
		
		if(is_array($row) && !empty($row)){
			$this->sender_cp_no = $row[0]['sender_cp_no'];
			$this->sender_post_id = $row[0]['sender_post_id'];
			$this->rec_cp_no = $row[0]['rec_cp_no'];
			$this->notice_time = $row[0]['sent_time'];
			$this->notice_title = $row[0]['notice_title'];
			$this->notice_status = $row[0]['notice_status'];
			$this->action_page = $row[0]['action_page'];
			$this->notice_token = $row[0]['notice_token'];
			$this->notice_type = $row[0]['notice_type'];
			$this->sender =  new ipo($this->sender_cp_no);
			$this->sender_position =  new position($this->sender_post_id);

		}
		
	}
	
	function incomingPositionList($recipient_post_id){
		
		$table = "position_notice inner join 
					positions on position_notice.sender_post_id = positions.post_id 
				    AND position_notice.rec_post_id = $recipient_post_id ORDER BY 
					position_notice.notice_time ASC";
		
		$fields = 	array( 	array("position_notice.notice_title", "title"),
							array("position_notice.notice_time", "time"),
							array("CONCAT(position_notice.sender_cp_no, ' - ', positions.post_name)", "sender"),
							array("position_notice.id", "id"),
							array("position_notice.action_page", "action_page"),
							array("position_notice.notice_status", "status"),
							array("position_notice.notice_token", "notice_token")
					);
		
		return $this->conn->get_rows($table, $fields);
	}

	function incomingSysPositionList($recipient_post_id){
		
		$table = "sys_position_notice WHERE sys_position_notice.rec_post_id =  $recipient_post_id ORDER BY 
					sys_position_notice.notice_time ASC";
		
		$fields = 	array( 	array("sys_position_notice.notice_title", "title"),
							array("sys_position_notice.notice_time", "time"),
							array("'CDMS'", "sender"),
							array("sys_position_notice.id", "id"),
							array("sys_position_notice.action_page", "action_page"),
							array("sys_position_notice.notice_status", "status"),
							array("sys_position_notice.notice_token", "notice_token")							
					);
		
		return $this->conn->get_rows($table, $fields);
	}	
	
	function incomingPrivateList($recipient_cp_no){
		
		$table = "private_notice inner join 
					positions on private_notice.sender_post_id = positions.post_id 
				    AND private_notice.rec_cp_no = '$recipient_cp_no' ORDER BY 
					private_notice.notice_time ASC";
		
		$fields = 	array( 	array("private_notice.notice_title", "title"),
							array("private_notice.notice_time", "time"),
							array("CONCAT(private_notice.sender_cp_no, ' - ', positions.post_name)", "sender"),
							array("private_notice.id", "id"),
							array("private_notice.action_page", "action_page"),
							array("private_notice.notice_token", "notice_token"),
							array("private_notice.notice_status", "status")
					);
		
		return $this->conn->get_rows($table, $fields);
        
        
        
    }
        
     function incomingRepresentList($recipient_cp_no){
		
		$table = "represent_repatriation inner join 
					positions on represent_repatriation.sender_post_id = positions.post_id 
				    AND represent_repatriation.rec_cp_no = '$recipient_cp_no' ORDER BY 
					represent_repatriation.notice_time ASC";
		
		$fields = 	array( 	array("represent_repatriation.notice_title", "title"),
							array("represent_repatriation.notice_time", "time"),
							array("CONCAT(represent_repatriation.sender_cp_no, ' - ', positions.post_name)", "sender"),
							array("represent_repatriation.id", "id"),
							array("represent_repatriation.action_page", "action_page"),
							array("represent_repatriation.notice_token", "notice_token"),
							array("represent_repatriation.notice_status", "status"),
                           
					);
		
		return $this->conn->get_rows($table, $fields);
           
        
        
	}

	function incomingSysPrivateList($recipient_cp_no){
		
		$table = "sys_private_notice WHERE sys_private_notice.rec_cp_no = '$recipient_cp_no'  ORDER BY 
					sys_private_notice.notice_time ASC";
		
		$fields = 	array( 	array("sys_private_notice.notice_title", "title"),
							array("sys_private_notice.notice_time", "time"),
							array("'CDMS'", "sender"),
							array("sys_private_notice.id", "id"),
							array("sys_private_notice.action_page", "action_page"),
							array("sys_private_notice.notice_status", "status"),
							array("sys_private_notice.notice_token", "notice_token")							
					);
		
		return $this->conn->get_rows($table, $fields);
	}
	
	function addPrivateNotice(){
		
		$table = "private_notice";
		$fields = array(
						array("sender_cp_no", $this->sender_cp_no),
						array("sender_post_id", $this->sender_post_id),
						array("rec_cp_no", $this->recipient_cp_no),
						array("notice_title", $this->notice_title),
						array("notice_status", $this->notice_status),
						array("action_page", $this->notice_action_page),
						array("notice_token", $this->notice_token),
						array("notice_type", 1)
				  );
				  
		return $this->conn->insert_row($table, $fields);
				
	}

	function addPositionNotice(){
			
			$table = "position_notice";
			
			$fields = array(
							array("sender_cp_no", $this->sender_cp_no),
							array("sender_post_id", $this->sender_post_id),
							array("rec_post_id", $this->recipient_post_id),
							array("notice_title", $this->notice_title),
							array("notice_status", $this->notice_status),
							array("action_page", $this->notice_action_page),
							array("notice_token", $this->notice_token),
							array("notice_type", 1)
					  );
					  
			return $this->conn->insert_row($table, $fields);
	}
	
	function MessageCount($msg_source, $recipient, $notice_type=NULL, $notice_status=NULL){
		
		if ($msg_source == 'pvt'){ 
			$table = "private_notice";
			$recipient = "rec_cp_no='$recipient'";
		}
        elseif($msg_source == 'rep'){
		    $table = "represent_repatriation";
			$recipient = "rec_cp_no='$recipient'";
		}	
		elseif($msg_source == 'pst'){
		    $table = "position_notice";
			$recipient = "rec_post_id = $recipient";
		}	
		elseif($msg_source == 'sys_pvt'){
		    $table = "sys_private_notice";
			$recipient = "rec_cp_no='$recipient'";
		}	
		elseif($msg_source == 'sys_pst'){
		    $table = "sys_position_notice";
			$recipient = "rec_post_id = $recipient";	
		}
		
		if($notice_type!== NULL)
			$notice_type = "AND notice_type= $notice_type ";
		
		if($notice_status !== NULL)
			$notice_status = "AND notice_status = '$notice_status'";
		
		
		$fields = array(array('COUNT(id)', 'row_count') );
		$filter = "$recipient $notice_type $notice_status";
		$count = 0;
		$row = $this->conn->get_rows($table, $fields, $filter);
		
		if(is_array($row) && !empty($row)){
			$count = $row[0]['row_count'];
		}
		
		return $count;
	}
	
}

?>