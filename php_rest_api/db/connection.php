<?php

class Connect {

    private $con;

    function __construct() {        
    }

    /**
     * Establishing database connection
     * @return database connection handler
     */
    function connect() {
        require_once 'configdb.php';
		
		$conf = new ConfigDB();
        // Connecting to mysql database
        $this->con = new mysqli($conf->host, $conf->username, $conf->password, $conf->db_name);

        // Check for database connection error
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        // returing connection resource
        return $this->con;
    }

}

?>