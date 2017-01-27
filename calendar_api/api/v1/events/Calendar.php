<?php
$path = dirname(__FILE__);
include_once $path."/../../../config.php";
require_once $path.'/../../../db/handler.php';
require_once $path.'/../accounts/User.php';

class Calendar {

    private $table_name;

    private $_valid;
    private $errors;
    private $db;

    function __construct($params=[]) {
        $this->table_name = "calendar";
        $this->errors = [];
        $this->db = new Handler();
    }

    public function create_event($user_id, $events_topic_id, $description, $date){
        $sql = "INSERT INTO $this->table_name 
        	(user_id, events_topic_id, description, date)
        	VALUES ($user_id, $events_topic_id, '$description', '$date')";
        $r = $this->db->con->query($sql) or die($this->db->con->error.__LINE__);
		if($r == 1){
			$success = true;
		}
		else{
			$success = false;
			array_push($this->errors, "Some errors adding the event.");
		}
		$result = array('success' => $success, 'errors' => $this->errors);
		return $result;
	}


    
}
