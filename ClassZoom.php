<?php


Class Zoom {

  private $_id        = 0; // Int
  private $_subject   = ""; // String
  private $_content   = ""; // String
  private $_url       = ""; // String
  private $_patientid = 0; // Int
  private $_medecinid = 0; // Int
  private $_date      = ""; // String

  function Zoom($id, $subject, $content, $url, $patientid, $medecinid, $date){
    $this->_id        = $id;
    $this->_subject   = $subject;
    $this->_content   = $content;
    $this->_url       = $url;
    $this->_patientid = $patientid;
    $this->_medecinid = $medecinid;
    $this->_date      = $date;
  }

  function createZoom(){

    $error = false;
    try{
      $req = $GLOBALS["db"]->prepare( "INSERT INTO " . DB_ZOOM . " ( idZoom, Sujet, Content, Url, idPatient, idMedecin, date )
      VALUES ( NULL, :sujet, :content, :url, :idpatient, :idmedecin, :date )" );
      $req->execute([
            'sujet'     => (string) $this->_subject,
            'content'   => (string) $this->_content,
            'url'       => (string) $this->_url,
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
