<?php

$username = "root";
$password = "123";
$hostname = "localhost"; 

//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password) 
 or die("Unable to connect to MySQL");
// echo "Connected to MySQL<br>";

//select a database to work with
$db_con = mysql_select_db("calendar",$dbhandle) 
  or die("Could not select calendar");

//execute the SQL query and return records
// $result = mysql_query("SELECT id, description, date FROM Agenda a WHERE user_id=1");

// //fetch tha data from the database 
// while ($row = mysql_fetch_array($result)) {
//    echo "ID:".$row{'id'}." Descripción:".$row{'description'}."date: ". //display the results
//    $row{'date'}."<br>";
// }
// //close the connection
// mysql_close($dbhandle);
?>
