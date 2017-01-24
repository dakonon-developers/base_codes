<?php

class Handler {

    public $con;

    function __construct() {
        require_once 'connection.php';
        // opening db connection
        $db = new Connect();
        $this->con = $db->connect();
    }
	
}

?>