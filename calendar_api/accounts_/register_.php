<?php
header('content-type: application/json; charset=utf-8');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Origin: *');

include '../connection.php';
include_once '../config.php';
// include '../DB.class.php'
// This is the API, 2 possibilities: show the app list or show a specific app by id.
// This would normally be pulled from a database but for demo purposes, I will be hardcoding the return values.

function register_user()
{
  
  // $hash = substr($password_hash, 0, 60 );
  // $verified = password_verify("123456", $hash);
  // echo $verified;
  // $_POST = json_decode($_POST);
  if ( !(isset($_POST["email"]) && isset($_POST["password"])) ){
    
    return array('success' => false, 'error' => 'Email y password no pueden ser nulas', 'post'=> $_POST);
  }
  if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    return array('success' => false, 'error' => 'emial no validado' );
  }

  // Validation Genre
  $genre = $_POST['genre'];
  $valid_genre = false;
  foreach ($GLOBALS["GENRE_OPTIONS"] as $key => $value) {
    if ($genre == $value){
      $valid_genre = true;
      break;
    } 
  }
  if (!$valid_genre){
    return array('success' => false, 'error' => 'Genero invalido', 'options' => $GLOBALS);
  }
  
  $first_name = mysql_escape_mimic($_POST['first_name']);
  $last_name = mysql_escape_mimic($_POST['last_name']);
  $email = mysql_escape_mimic($_POST['email']);
  $password = mysql_escape_mimic($_POST['password']);
  $password_hash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
  $auth_token = bin2hex(openssl_random_pseudo_bytes(16));
  $address = mysql_escape_mimic($_POST['address']);

  // verificamos si existe el usuario:
  $sql = "SELECT COUNT(*) FROM user WHERE email='$email' ";
  $result = mysql_query($sql) or die (mysql_error());
  $result = mysql_fetch_array($result);
  if ((int) $result["COUNT(*)"] > 0){
    $error = "El email ya existe";
    $result = false;
  }
  else{
    $insert = sprintf("INSERT INTO user 
      (first_name, last_name, email, password, auth_token, address, genre) 
      VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s')",
      $first_name,
      $last_name,
      $email,
      $password_hash,
      $auth_token,
      $address,
      $genre);
      $result = mysql_query($insert) or die (mysql_error());
  }
  
  mysql_close($db_con);
  return array(
    "success" => $result,
    "error" => $error,
    "auth_token" => $auth_token);
}



$value = "An error has occurred";

$value = register_user();


//return JSON array
exit(json_encode($value));
?>
