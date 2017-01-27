<?php
class Handler {

    public $con;
    // public $mysqli;

    function __construct() {
    	$path = dirname(__FILE__);
        require_once $path.'/connection.php';
        // opening db connection
        $db = new Connect();
        $this->con = $db->connect();

    }
  //   public function define_mysql(){
  //   	require_once 'configdb.php';
  //   	$config = new ConfigDB();
  //   	$config->username;
  //   	$con=mysqli_connect($config->host, $config->username, $config->password,$config->db_name);
  //   	if (mysqli_connect_errno())
		// {
		//   echo "Failed to connect to MySQL: " . mysqli_connect_error();
		// }
		
  //   }
	
}

?>