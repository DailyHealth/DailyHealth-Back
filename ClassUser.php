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

  function User($type, $firstName, $lastName, $email, $password, $age, $height, $weight, $role){
    $this->_type = $type;
    $this->_firstName = $firstName;
    $this->_lastName = $lastName;
    $this->_email = $email;
    $this->_password = $password;
    $this->_age = $age;
    $this->_height = $height;
    $this->_weight = $weight;
    $this->_role = $role;
  }

  function createUser(){

    $error = false;
    try{
      $req = $GLOBALS["db"]->prepare( "INSERT INTO " . DB_USER . " ( idUser, type, FirstName, LastName, Email, Pass, Age, Height, Weight, Role, IdMedecin )
      VALUES ( NULL, :type, :firstName, :lastName, :email, :password, :age, :height, :weight, :role, 0 )" );
      $req->execute([
            'type' => $this->_type,
            'firstName' => $this->_firstName,
            'lastName' => $this->_lastName,
            'email' => $this->_email,
            'password' => $this->_password,
            'age' => $this->_age,
            'height' => $this->_height,
            'weight' => $this->_weight,
            'role' => $this->_role
        ]);

      $this->_id = $GLOBALS["db"]->lastInsertId();
    } catch ( PDOException $e) {
      $error = $GLOBALS["db"]->connect_error;
    }
    return $error;

  }

}


 ?>
