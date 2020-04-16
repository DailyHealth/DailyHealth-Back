<?php


Class Observation {

  private $_id        = 0; // Int
  private $_subject   = ""; // String
  private $_content   = ""; // String
  private $_patientid = 0; // Int
  private $_medecinid = 0; // Int
  private $_date      = ""; // String

  function Observation($id, $_subject, $_content, $_patientid, $_medecinid, $date){
    $this->_id        = $id;
    $this->_subject   = $_subject;
    $this->_content   = $_content;
    $this->_patientid = $_patientid;
    $this->_medecinid = $_medecinid;
    $this->_date      = $date;
  }

  function createObservation(){

    $error = false;
    try{
      $req = $GLOBALS["db"]->prepare( "INSERT INTO " . DB_OBSERVATION . " ( idObservation, Sujet, Content, idPatient, idMedecin, date )
      VALUES ( NULL, :sujet, :content, :idpatient, :idmedecin, :date )" );
      $req->execute([
            'sujet'     => (string) $this->_subject,
            'content'   => (string) $this->_content,
            'idpatient' => (int) $this->_patientid,
            'idmedecin' => (int) $this->_medecinid,
            'date'      => (string) $this->_date,
        ]);

      $this->_id = $GLOBALS["db"]->lastInsertId();
    } catch ( PDOException $e) {
      $error = $GLOBALS["db"]->connect_error;
    }
    return $error;

  }

}


 ?>
