<?php

// ---------------------------- BASE DE DONNEEE ------------------------
define( 'DB_SERVER', "localhost" );
define( 'DB_DATABASE', "dailyhealth" );
define( 'DB_NAME', "root" );
define( 'DB_PASS', "" );

define( 'DB_USER', "user" );
define( 'DB_DAILY', "dailystatut" );
define( 'DB_OBSERVATION', "observation" );

// ---------------------------- HEADER ------------------------
/*header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");*/
header("Content-Type: application/json; charset=UTF-8");


// ---------------------------- REQUIRE FILE ------------------------

require("/ControllerUser.php");
require("/ControllerDailyStatut.php");
require("/ControllerObservation.php");


function redirectApi( $data ){
  $response = array();


  if( ! empty($data["action"]) && $data["action"] != "" ){
    $GLOBALS["db"] = connect_to_db();

    switch ($data["action"]) {
      case 'createUser':
        $response = ControllerUser::createUser($data);
        break;
      case 'connectUser':
        $response = ControllerUser::connectUser($data);
        break;
      case 'getListUser':
        $response = ControllerUser::getListUser($data);
        break;
      case 'editUser':
        $response = ControllerUser::editUser($data);
        break;
      case 'createDailyStatut':
        $response = ControllerDailyStatut::createDailyStatut($data);
        break;
      case 'getDailyStatut':
        $response = ControllerDailyStatut::getDailyStatut($data);
        break;
      case 'createObservation':
        $response = ControllerObservation::createObservation($data);
        break;
      case 'getObservation':
        $response = ControllerObservation::getObservation($data);
        break;
      default:
        // code...
        break;
    }
  }else{
    $response['status'] = "KO";
    $response['message'] = "Manque un attribut action dans la requete";
  }

  echo json_encode($response);

}


function connect_to_db(){
  try{
    $db = new PDO("mysql:host=" . DB_SERVER, DB_NAME, DB_PASS); // Initialise la
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Connection
    // $db->query("CREATE DATABASE IF NOT EXISTS " . DB_DATABASE ); // A la base
    $db->query("use " . DB_DATABASE); // de donnée
    $db = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_DATABASE . ";charset=utf8", DB_NAME, DB_PASS);
  } catch ( PDOException $e) {
    echo 'Error connection DB'; exit;
  }
  return $db;
}




?>
