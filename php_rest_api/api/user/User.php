<?php
class User {

	private $username;
	private $mail;
	private $password;
	private $_valid;

    function __construct($params) {
		if(isset($params['username']) and isset($params['mail']) and isset($params['password']))
		{
			$this->username = $params['username'];
			$this->mail = $params['mail'];
			$this->password = $params['password'];
			$this->_valid = True;
		}
	}
	
	public function save()
	{
		if(!$this->_valid)
		{
			return "Error, all parameter are needed";
		}
		else
		{
			require_once '/db/handler.php';
			$db = new Handler();
			$comando = 'INSERT INTO user (username,mail,password) VALUES ';
			$comando .= '("'.$this->username.'","'.$this->mail.'","'.$this->password.'")';
			$r = $db->con->query($comando) or die($db->con->error.__LINE__);
			return $r;
		}
	}
	
	
}