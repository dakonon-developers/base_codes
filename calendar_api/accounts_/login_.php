<?php
header('content-type: application/json; charset=utf-8');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Origin: *');

include '../connection.php';
include_once '../config.php';
// include '../DB.class.php'
// This is the API, 2 possibilities: show the app list or show a specific app by id.
// This would normally be pulled from a database but for demo purposes, I will be hardcoding the return values.

function login_user()
{
  
  if ( !(isset($_POST["email"]) && isset($_POST["password"])) ){
    return array('success' => false, 'error' => 'usuario y password no pueden ser nulas' );
  }
  if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    return array('success' => false, 'error' => 'emial no validado' );
  }
  
  $email = mysql_escape_mimic($_POST['email']);
  $password = mysql_escape_mimic($_POST['password']);
  
  // verificamos si existe el usuario:
  // $sql = "SELECT * FROM user WHERE email='$email' ";
  $sql = "SELECT password, auth_token FROM user WHERE email='$email' ";
  $result = mysql_query($sql) or die (mysql_error());
  $result = mysql_fetch_row($result);

  $hash = substr($result[0], 0, 60 );
  $verified = password_verify($password, $hash);
  if ($verified){
	  return array(
	    "success" => true,
	    "error" => null,
	    "access_token" => $result[1]);
  }
  else{
  	return array(
	    "success" => false,
	    "error" => "Password o email incorrecto",
	    "post" => $_POST['password'],
	    "access_token" => null);
  }
  // echo $verified;
  // return $result;
  // mysql_close($db_con);
}



$value = "An error has occurred";

$value = login_user();


//return JSON array
exit(json_encode($value));
?>
