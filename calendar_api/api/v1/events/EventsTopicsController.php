<?php
require_once 'EventsTopics.php';
require_once 'Calendar.php';
$path = dirname(__FILE__);
include_once $path."/../../../config.php";

class EventsTopicsController {


    function __construct() {
	}
	
	public function useMethod($name,$method)
	{
		switch($name)
		{
			case 'get_events_by_date':
				$this->get_events_by_date($method);
				break;
			case 'create_event':  
				// $params: access_token(GET), event_topic(name), description, date(YYYY-mm-dd hh:mm:ss)
				$this->create_event($method);
				break;
					
			default:
				//none
		}
	}
	
	private function create_event($method){
		$token = mysql_escape_mimic($_GET["access_token"]);
		if(!isset($token)){
			echo json_encode(array('success' => false, 'errors'=> ["Token required."]));
		}
		$user = new User();
        $user = $user->find_by_token($token);
        if (!$user){
        	echo json_encode(array('success' => false, 'errors'=> ["User invalid."]));
        	die();
        }
        $valid = $this->valid($method,$method == 'GET' ? True:False);
        $i=0;
        foreach ($GLOBALS["CALENDAR_TOPIC_COLORS"] as $key => $value) {
        	$i += 1;
		    if ( $i == count($GLOBALS["CALENDAR_TOPIC_COLORS"])){
        		$default_name = $key;
			} 
	      }
        
		$events = new EventsTopics();
        $events_topic_id = $events->find_by_name($default_name);
		$default_events_topic_id = $events_topic_id['id'];
		if($valid=='')
		{
			$params = json_decode(file_get_contents('php://input'), true);
			$calendar = new Calendar();
			if ($_GET['event_topic'] == ""){
				$events_topic_id = $default_events_topic_id;
			}else{
				$event = $events->find_by_name($_GET['event_topic']);
				if($event['id']){
					$events_topic_id = $event['id'];
				}else{
					$events_topic_id = $default_events_topic_id;
				}
			}

			$response = $calendar->create_event(
				$user['id'], $events_topic_id, 
				mysql_escape_mimic($_GET['description']),
				mysql_escape_mimic($_GET['date']) );
			echo json_encode($response);
		}
		else
		{
			echo $valid;
		}


	}
	private function get_events_by_date($method)
	{
		$token = mysql_escape_mimic($_GET["access_token"]);

		if(!isset($token)){
			echo json_encode(array('success' => false, 'errors'=> ["Token required."]));
			// die();
		}
		
		$user = new User();
        $user = $user->find_by_token($token);
        if (!$user){
        	echo json_encode(array('success' => false, 'errors'=> ["User invalid."]));
        	die();
        }
		$valid = $this->valid($method,$method == 'GET' ? True:False);
		if($valid=='')
		{
			$params = json_decode(file_get_contents('php://input'), true);
			$events = new EventsTopics();
			$response = $events->get_events_by_date(
				$user['id'],
				mysql_escape_mimic($_GET['current_month']),
				mysql_escape_mimic($_GET['current_year']));
			echo json_encode($response);
		}
		else
		{
			echo $valid;
		}
	}

	
	private function valid($method_name,$condition)
	{
		if(!$condition)
		{
			return "Method ".$method_name." not allowed";
		}
		return '';
	}
}


