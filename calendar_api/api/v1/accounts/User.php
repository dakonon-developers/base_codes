<?php
$path = dirname(__FILE__);
require_once 'UserEventsTopicColors.php';
include_once $path."/../../../config.php";
require_once $path.'/../../../db/handler.php';

class User {

	private $table_name;
	private $email;
	private $username;
	private $password;
	private $first_name;
	private $last_name;
	private $auth_token;
	private $address;
	private $genre;
	private $_valid;
	private $errors;
	private $db;

    function __construct($params=[]) {
    	$this->table_name = "user";
    	$this->errors = [];
    	$this->db = new Handler();
    	$genre = isset($params['genre']) ? $params['genre'] : '';
		// validating required fields
		if(isset($params['username']) and isset($params['email']) and isset($params['password'])
			and (filter_var($params["email"], FILTER_VALIDATE_EMAIL)) // if has a valid email
			and $this->has_valid_genre($genre) )
		{
			$password = mysql_escape_mimic($params['password']);
			$this->password = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
			$this->username = mysql_escape_mimic($params['username']);
			$this->email = mysql_escape_mimic($params['email']);
			$this->first_name = isset($params['first_name']) ? mysql_escape_mimic($params['first_name']) : '';
			$this->last_name = isset($params['last_name']) ? mysql_escape_mimic($params['last_name']) : '';
			$this->address = isset($params['address']) ?  mysql_escape_mimic($params['address']) : '';
			$this->genre = isset($params['genre']) ? mysql_escape_mimic($params['genre']) : '';
			$this->_valid = True;
		}
	}

	public function find_by_token($token){
		$sql = "SELECT * FROM $this->table_name WHERE auth_token = '$token' ";
		$result = $this->db->con->query($sql);
        $row = $result->fetch_array(MYSQLI_ASSOC);
        return $row;
	}


	private function clean_errors(){
		$this->errors = [];
	}
	private function get_user_data(){
		$db = new Handler();
		$sql = "SELECT * FROM $this->table_name WHERE username = '$this->username' AND email='$this->email'";
        $result = $db->con->query($sql);
        $row = $result->fetch_array(MYSQLI_ASSOC);
        return $row;
	}
	public function login($params){
		$success = false;
		$this->password = mysql_escape_mimic($params['password']);
		$this->username = mysql_escape_mimic($params['username']);
		$this->email = mysql_escape_mimic($params['email']);
		$db = new Handler();
		$sql = "SELECT * FROM ".$this->table_name;
		$sql .= " WHERE email='$this->email' OR username='$this->username'";
		$result = $db->con->query($sql);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$hash = substr($row["password"], 0, 60 );
		$verified = password_verify($params['password'], $hash);
		if ($verified){
			$this->username = mysql_escape_mimic($row['username']);
			$this->email = mysql_escape_mimic($row['email']);
			$this->first_name = mysql_escape_mimic($row['first_name']);
			$this->last_name = mysql_escape_mimic($row['last_name']);
			$this->address = mysql_escape_mimic($row['address']);
			$this->genre = mysql_escape_mimic($row['genre']);
			unset($row["password"]);
			$success = true;
		}
		else {
			array_push($this->errors, "Invalid credentials");
		}
		return json_encode(
			array(
			    "success" => $success,
			    "error" => $this->errors,
			    "user" => $row,
			    "access_token" => $row['auth_token'])
		);
	}

	public function has_valid_genre($genre){
		// Validation Genre
		if ($genre != ""){  // if is not empty
		  $valid_genre = false;
		  foreach ($GLOBALS["GENRE_OPTIONS"] as $key => $value) {
		    if ($genre == $value){
			  $valid_genre = true;
			  break;
			} 
	      }
		}
		else{
			$valid_genre = true;
		}
		return $valid_genre;
	}

	public function exist_email($email){
		$db = new Handler();
		$sql = "SELECT COUNT(*) FROM ".$this->table_name." WHERE email='$email' ";
		$result = $db->con->query($sql);
		$row = $result->fetch_array(MYSQLI_NUM);
		if ((int) $row[0] > 0){
			return true;
		}
		return false;
	}
	public function exist_username($username){
		$db = new Handler();
		$sql = "SELECT COUNT(*) FROM ".$this->table_name." WHERE username='$username' ";
		$result = $db->con->query($sql);
		$row = $result->fetch_array(MYSQLI_NUM);
		if ((int) $row[0] > 0){
			return true;
		}
		return false;
	}

	private function get_errors_before_create() {
		$this->clean_errors();
		if (!$this->has_valid_genre($this->genre)){
			$error = "genre option is not valid, valid options => ";
			$error .= implode(",", $GLOBALS['GENRE_OPTIONS']).".";
			array_push($this->errors, $error);
		}
		if ($this->exist_email($this->email)){
			$error = "email already exists.";
			array_push($this->errors, $error);
		}
		if ($this->exist_username($this->username)){
			$error = "username already exists.";
			array_push($this->errors, $error);
		}
	}
	public function create()
	{
		if(!$this->_valid)
		{
			return false;
		}
		else
		{
			$db = new Handler();
			$success = false;
			$access_token = "";
			$this->get_errors_before_create();
			if (count($this->errors) == 0){
				$access_token = bin2hex(openssl_random_pseudo_bytes(16));
				$this->auth_token = $access_token;
				$command = 'INSERT INTO '.$this->table_name.' (username, email, password, first_name, last_name, auth_token, address, genre) VALUES ';
				$command .= '("'.$this->username.'","';
				$command .= $this->email.'","';
				$command .= $this->password.'","';
				$command .= $this->first_name.'","';
				$command .= $this->last_name.'","';
				$command .= $this->auth_token.'","';
				$command .= $this->address.'","';
				$command .= $this->genre.'")';

				$r = $db->con->query($command) or die($db->con->error.__LINE__);
				if($r == 1){
					$success = true;
					//$this->clean_errors();
					// Creating configuration for this user.
					$UserEventsTopicColors = new UserEventsTopicColors();
					$events = $this->get_user_data();
					
					$created = $UserEventsTopicColors->generate_events_for_user($events);
					if (!$created)
						array_push($this->errors, "Some errors in event configuration.");
				}
				else{
					$success = false;
					$access_token = "";
				}
			}
			$result = array('success' => $success, 'errors' => $this->errors, 
				'access_token' => $access_token);
			return json_encode($result);
		}
	}
	
	
}
