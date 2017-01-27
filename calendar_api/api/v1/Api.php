<?php

require 'accounts/UserController.php';
require 'events/EventsTopicsController.php';
class Api {

	private $method;
	

    function __construct($method) {
		$this->method = $method;
    }
	
	public function get_app($params)
	{

		switch($params[1])
		{
			case 'accounts':
				$user = new UserController();
				if (count($params)>2)
					$user->useMethod($params[2],$this->method);
				break;
			case 'events':
				$user = new EventsTopicsController();
				if (count($params)>2)
					$user->useMethod($params[2],$this->method);
				break;
			/*case 'POST':
				break;
				
			case 'PUT':
				break;
				
			case 'DELETE':
				break;
			
			default:
				// nada*/
		}
	}
	
}

?>
