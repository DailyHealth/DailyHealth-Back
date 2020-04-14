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

    $user = new User($type, $firstName, $lastName, $email, $password, $age, $height, $weight, $role);

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
      $response['status'] = "Erreur dans l'insertion";
      $response['message'] = $error;
    }

    return $response;

  }

  static public function connectUser(){

  }




  static public function render( $module, $view, $data = [] ){
    extract( $data );
    require( ROOT_DIR . '/module/' . $module . '/view/'. str_replace('.', '/', $view) . '.view.php' );
  }

  // static public function display_limitlimit_page(){
  //   self::render( 'limitlimit', 'home-page\main' );
  // }
  //
  // static public function display_content_limitlimit_page(){
  //   self::render( 'limitlimit', 'home-page\content' );
  // }

  static public function get( $args ){
    try{
      $req = $GLOBALS["db"]->prepare( "SELECT * FROM " . DB_GAMECURRENT . " WHERE id = :id" );
      $req->execute([
        'id' => (int) $args['id'],
      ]);
      return $req->fetch();
    } catch ( PDOException $e) {
      echo '<pre>'; print_r( $GLOBALS["db"]->connect_error ); echo '</pre>';exit;
    }
  }


}

?>
