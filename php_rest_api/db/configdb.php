<?php
/**
 * Database configuration
 */
class ConfigDB {

	public $username;
	public $password;
	public $host;
	public $db_name;

    function __construct() { 
		$this->username = 'root';
		$this->password = '';
		$this->host = 'localhost';
		$this->db_name = 'prueba';  	
    }

}
?>