<?php


Class User {

  private $_id = 0; // String - M = Homme / F = Femme
  private $_type = ""; // String - M = Homme / F = Femme
  private $_firstName = ""; // String
  private $_lastName = ""; // string
  private $_email = ""; // string
  private $_password = ""; // string
  private $_age = 0; // Int
  private $_height = 0.0; // Float
  private $_weight; // Float
  private $_role; // string - M = Medecin / P = Patient
  private $_medecinid;

  function User($id, $type, $firstName, $lastName, $email, $password, $age, $height, $weight, $role, $medecinid){
    $this->_id = $id;
    $this->_type = $type;
    $this->_firstName = $firstName;
    $this->_lastName = $lastName;
    $this->_email = $email;
    $this->_password = $password;
    $this->_age = $age;
    $this->_height = $height;
    $this->_weight = $weight;
    $this->_role = $role;
    $this->_medecinid = $medecinid;
  }

  function createUser(){

    $error = false;
    try{
      $req = $GLOBALS["db"]->prepare( "INSERT INTO " . DB_USER . " ( idUser, type, FirstName, LastName, Email, Pass, Age, Height, Weight, Role, IdMedecin )
      VALUES ( NULL, :type, :firstName, :lastName, :email, :password, :age, :height, :weight, :role, :medecinid )" );
      $req->execute([
            'type' => $this->_type,
            'firstName' => $this->_firstName,
            'lastName' => $this->_lastName,
            'email' => $this->_email,
            'password' => $this->_password,
            'age' => $this->_age,
            'height' => $this->_height,
            'weight' => $this->_weight,
            'role' => $this->_role,
            'medecinid' => $this->_medecinid
        ]);

      $this->_id = $GLOBALS["db"]->lastInsertId();
    } catch ( PDOException $e) {
      $error = $GLOBALS["db"]->connect_error;
    }
    return $error;

  }

  function connectUser(){

    $error = false;
    try{
      $req = $GLOBALS["db"]->prepare( "SELECT * FROM " . DB_USER . " WHERE Email = :email AND Pass = :password" );
      $req->execute([
        'email' => (string) $this->_email,
        'password' => (string) $this->_password,
      ]);
      $result = $req->fetch();
      return $result;

      $this->_id = $GLOBALS["db"]->lastInsertId();
    } catch ( PDOException $e) {
      $error = $GLOBALS["db"]->connect_error;
    }
    return $error;
  }

  function editUser(){

    $error = false;
    try{ // Id - Type - Role - IdMedecin = Non modifiable
      $req = $GLOBALS["db"]->prepare( "UPDATE " . DB_USER . " SET FirstName = :firstName, LastName = :lastName, Email = :email, Pass = :password, Age = :age, Height = :height, Weight = :weight WHERE idUser = :iduser" );
      $req->execute([
        'iduser' => $this->_id,
        'firstName' => $this->_firstName,
        'lastName' => $this->_lastName,
        'email' => $this->_email,
        'password' => $this->_password,
        'age' => $this->_age,
        'height' => $this->_height,
        'weight' => $this->_weight,
      ]);

      return true;
    } catch ( PDOException $e) {
      $error = $GLOBALS["db"]->connect_error;
      echo '<pre>'; print_r( $error ); echo '</pre>';exit;
    }
    return $error;
  }

  function getId(){
    return $this->_id;
  }

  function getName(){
    return $this->_firstName;
  }

}


 ?>
