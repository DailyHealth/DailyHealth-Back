<?php
include("../ClassUser.php");


Class ControllerUser{

  static public function linkUser($data){
    $id      = !empty($data["id"]) ? (string) $data["id"] : "0"; // M = homme / F = femme
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

    $user = new User($id, $type, $firstName, $lastName, $email, $password, $age, $height, $weight, $role, $medecinid);

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

    $text = "";
    $medecinid = 0;
    $role = "";
    $param = array();
    if( $data['medecinid'] ){
      $medecinid = $data["medecinid"]; // M = homme / F = femme
      $text = " WHERE IdMedecin = :medecinid";
      $param['medecinid'] = $medecinid;
    }else{
      $role = $data["role"] == "P" || $data["role"] == "M" ? $data["role"] : ""; // M = homme / F = femme
      $text = $role != "" ? " WHERE role = :role" : "";
      $param['role'] = $role;
    }


    try{
      $req = $GLOBALS["db"]->prepare( "SELECT * FROM " . DB_USER . $text );
      $req->execute($param);
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

      $datadb = $req->fetch();

      return array(
        'id' => $datadb['idUser'],
        'type' => $datadb['type'],
        'firstname' => $datadb['FirstName'],
        'lastname' => $datadb['LastName'],
        'email' => $datadb['Email'],
        'password' => $datadb['Pass'],
        'age' => $datadb['Age'],
        'height' => $datadb['Height'],
        'weight' => $datadb['Weight'],
        'role' => $datadb['Role'],
        'medecinid' => $datadb['IdMedecin']
      );
      return $req->fetch();

    } catch ( PDOException $e) {
      echo '<pre>'; print_r( $GLOBALS["db"]->connect_error ); echo '</pre>';exit;
    }
  }

  static public function editUser($data){
    $datauserdb = ControllerUser::getUser($data);

    if( $datauserdb['id'] == "" ){
      echo '<pre>'; print_r( 'Utilisateur introuvable' ); echo '</pre>';exit;
    }else {
      // code...
    }

    $result = array_merge($datauserdb, $data);

    $user = self::linkUser($result);
    $user->editUser();

    $response['status'] = "OK";
    $response['message'] = "Mise à jour des données de l'utilisateur : #" . $user->getId() . ' ' .  $user->getName();

    return $response;
  }

}

?>
