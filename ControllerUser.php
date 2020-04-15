<?php
include("/ClassUser.php");


Class ControllerUser{

  static public function linkUser($data){
    $type      = !empty($data["type"]) ? (string) $data["type"] : "M"; // M = homme / F = femme
    $firstName = !empty($data["firstname"]) ? (string) $data["firstname"] : "No FirstName";
    $lastName  = !empty($data["lastname"]) ? (string) $data["lastname"] : "No LastName";
    $email     = !empty($data["email"]) ? (string) $data["email"] : "No Email";
    $password  = !empty($data["password"]) ? (string) $data["password"] : "No Password";
    $age       = !empty($data["age"]) ? (int) $data["age"] : "50";
    $height    = !empty($data["height"]) ? (double) $data["height"] : "180";
    $weight    = !empty($data["weight"]) ? (double) $data["weight"] : "80";
    $role      = !empty($data["role"]) ? (string) $data["role"] : "P"; // M = Medecin / P = Patient
    $medecinid = !empty($data["medecinid"]) ? (int) $data["medecinid"] : "0"; // M = Medecin / P = Patient

    $user = new User($type, $firstName, $lastName, $email, $password, $age, $height, $weight, $role, $medecinid);

    return $user;
  }

  static public function createUser($data){
    $user = self::linkUser($data);

    $response = array(
      "status" => "",
      "message" => ""
    );

    $error = $user->createUser();

    if( ! $error ){
      $response['status'] = "OK";
      $response['message'] = (array) $user;
    }else{
      $response['status'] = "KO";
      $response['status_message'] = "Erreur dans l'insertion";
      $response['message'] = $error;
    }

    return $response;

  }

  static public function connectUser($data){
    $user = self::linkUser($data);

    $user = $user->connectUser();

    if( $user != "" ){
      $response['status'] = "OK";
      $response['message'] = (array) $user;
    }else{
      $response['status'] = "KO";
      $response['status_message'] = "User introuvable";
      $response['message'] = "User introuvable";
    }

    return $response;
  }

  static public function getListUser($data){
    $role = !empty($data["role"])  ? (string) $data["role"] : "";
    $role = $role == "P" || $role == "M" ? $role : ""; // M = homme / F = femme
    $text = $role != "" ? " WHERE role = :role" : "";
    try{
      $req = $GLOBALS["db"]->prepare( "SELECT * FROM " . DB_USER . $text );
      $req->execute([
        'role' => $role,
      ]);
      return $req->fetchAll();

    } catch ( PDOException $e) {
      echo '<pre>'; print_r( $GLOBALS["db"]->connect_error ); echo '</pre>';exit;
    }
  }

  static public function getUser($data){
    $id = !empty($data["iduser"])  ? (int) $data["iduser"] : 0;

    try{
      $req = $GLOBALS["db"]->prepare( "SELECT * FROM " . DB_USER . " WHERE idUser = :iduser" );
      $req->execute([
        'iduser' => $id,
      ]);
      return $req->fetchAll();

    } catch ( PDOException $e) {
      echo '<pre>'; print_r( $GLOBALS["db"]->connect_error ); echo '</pre>';exit;
    }
  }

}

?>
