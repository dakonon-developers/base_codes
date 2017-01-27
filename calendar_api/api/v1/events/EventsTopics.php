<?php
$path = dirname(__FILE__);
include_once $path."/../../../config.php";
require_once $path.'/../../../db/handler.php';
require_once $path.'/../accounts/User.php';

class EventsTopics {

    private $table_name;

    private $_valid;
    private $errors;
    private $db;

    function __construct($params=[]) {
        $this->table_name = "events_topics";
        $this->errors = [];
        $this->db = new Handler();
    }
    
    public function get_all_topics(){
        $user = new User();
        $db = new Handler();
        $sql = "SELECT * FROM ".$this->table_name;
        $result = $db->con->query($sql);
        $result=mysqli_query($db->con, $sql) or die ("Error in Selecting " . mysqli_error($connection));;
        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function find_by_name($name){
        $sql = "SELECT * FROM $this->table_name WHERE name = '$name' ";
        $result = $this->db->con->query($sql);
        $row = $result->fetch_array(MYSQLI_ASSOC);
        return $row;
    }

    public function get_events_by_date($user_id, $current_month, $current_year){
        if ($current_month == 1){
            $last_month = ($current_year-1)."-12-01"; // Y-m-d
            $next_month = $current_year."-02-31";
        }
        elseif ($current_month == 12) {
            $last_month = $current_year."-11-01";
            $next_month = ($current_year+1)."-01-31";
        }
        else{
            $last_month = $current_year."-".($current_month-1)."-01";
            $next_month = $current_year."-".($current_month+1)."-31";
        }

        $db = new Handler();
        $sql = "
            SELECT c.date, DAY(c.date) as day, MONTH(c.date) as month, 
              c.description as eventName, e.name as calendar, ue.color as color
                FROM calendar c, user_events_topic_colors ue, events_topics e
                  WHERE 
                    c.user_id = '$user_id'
                    AND e.id = c.events_topic_id
                    AND ue.user_id = c.user_id
                    AND ue.events_topic_id = c.events_topic_id
                    AND c.date BETWEEN '$last_month' AND '$next_month';
        ";
        
        $result = $this->db->con->query($sql);
        $result=mysqli_query($db->con, $sql) or die ("Error in Selecting " . mysqli_error($connection));;
        $rows = array();
        while ($row = $result->fetch_assoc()) { 
            $row['day'] = (int) $row['day'];
            $row['month'] = (int) $row['month'];
            $rows[] = $row; 
        }
        return $rows;
    }
    
}
