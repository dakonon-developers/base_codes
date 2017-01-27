<?php
$path = dirname(__FILE__);
include_once $path."/../../../config.php";
require_once $path.'/../../../db/handler.php';
require_once $path.'/../events/EventsTopics.php';

class UserEventsTopicColors {

    private $table_name;
    private $id;
    private $_valid;
    private $errors;

    function __construct($params=[]) {
        $this->table_name = "user_events_topic_colors";
        $this->errors = [];
    }

    public function generate_events_for_user($params){
        $problem = false;
        $db = new Handler();
        $events_topics = new EventsTopics();
        $topics = $events_topics->get_all_topics();
        $user_id = $params['id'];
        
        for ($i=0; $i < count($topics); $i++){
            $events_topic_id = $topics[$i]['id'];
            $color = $GLOBALS["CALENDAR_TOPIC_COLORS"][$topics[$i]['name']];
            $command = 'INSERT INTO '.$this->table_name.' (user_id, events_topic_id, color) VALUES (';
            $command .= '"'.$user_id.'", "'.$events_topic_id.'", "'.$color.'")';

            $r = $db->con->query($command) or die($db->con->error.__LINE__);
            if(!$r == 1) 
                $problem = true;
        }
        return !$problem;
    }
    
    
}
