<?php
$GLOBALS["GENRE_OPTIONS"] = ["M", "W", "O"];
$GLOBALS["CALENDAR_TOPIC_COLORS"] = array('Deportes' => 'blue', 'Kids' => 'yellow', 'Trabajo' => 'orange', 'Otros' => 'green');

function mysql_escape_mimic($inp) { 
    if(is_array($inp)) 
        return array_map(__METHOD__, $inp); 

    if(!empty($inp) && is_string($inp)) { 
        return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $inp); 
    } 

    return $inp; 
} 
?>
