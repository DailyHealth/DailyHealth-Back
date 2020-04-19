<?php
include("../ClassObservation.php");


Class ControllerObservation{

  static public function linkObservation($data){

    $id          = !empty($data["id"]) ? (int) $data["id"] : 0;
    $subject     = !empty($data["subject"]) ? (string) $data["subject"] : "Empty subject";
    $content     = !empty($data["content"]) ? (string) $data["content"] : "Empty content";
    $patientid   = !empty($data["patientid"]) ? (int) $data["patientid"] : 0;
    $medecinid   = !empty($data["medecinid"]) ? (int) $data["medecinid"] : 0;
    $date        = !empty($data["date"]) ? (string) $data["date"] : strtotime('now');

    $observation = new Observation($id, $subject, $content, $patientid, $medecinid, $date);

    return $observation;
  }

  static public function createObservation($data){
    $observation = self::linkObservation($data);

    $response = array(
      "status" => "",
      "message" => ""
    );

    $error = $observation->createObservation();

    if( ! $error ){
      $response['status'] = "OK";
      $response['message'] = (array) $observation;
    }else{
      $response['status'] = "KO";
      $response['status_message'] = "Erreur dans l'insertion";
      $response['message'] = $error;
    }

    return $response;

  }

  static public function getObservation($data){

    $patientid = !empty($data["patientid"]) ? $data["patientid"] : 0; // M = homme / F = femme

    try{
      $req = $GLOBALS["db"]->prepare( "SELECT * FROM " . DB_OBSERVATION . " WHERE idPatient = :patientid" );
      $req->execute([
        'patientid' => $patientid
      ]);

      return $req->fetchAll();

    } catch ( PDOException $e) {
      echo '<pre>'; print_r( $GLOBALS["db"]->connect_error ); echo '</pre>';exit;
    }
  }

}

?>
