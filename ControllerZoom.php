<?php
include("/ClassZoom.php");


Class ControllerZoom{

  static public function linkZoom($data){

    $id          = !empty($data["id"]) ? (int) $data["id"] : 0;
    $subject     = !empty($data["subject"]) ? (string) $data["subject"] : "Empty subject";
    $content     = !empty($data["content"]) ? (string) $data["content"] : "Empty content";
    $url         = !empty($data["url"]) ? (string) $data["url"] : "Empty url";
    $patientid   = !empty($data["patientid"]) ? (int) $data["patientid"] : 0;
    $medecinid   = !empty($data["medecinid"]) ? (int) $data["medecinid"] : 0;
    $date        = !empty($data["date"]) ? (string) $data["date"] : strtotime('now');


    $observation = new Zoom($id, $subject, $content, $url, $patientid, $medecinid, $date);

    return $observation;
  }

  static public function createZoom($data){
    $zoom = self::linkZoom($data);

    $response = array(
      "status" => "",
      "message" => ""
    );

    $error = $zoom->createZoom();

    if( ! $error ){
      $response['status'] = "OK";
      $response['message'] = (array) $zoom;
    }else{
      $response['status'] = "KO";
      $response['status_message'] = "Erreur dans l'insertion";
      $response['message'] = $error;
    }

    return $response;

  }

  static public function getZoom($data){

    $text = "";
    $param = array();

    if( $data['patientid'] &&  $data['medecinid'] ){
      $text = " WHERE idMedecin = :medecinid AND idPatient = :patientid";
      $param['medecinid'] = $data['medecinid'];
      $param['patientid'] = $data['patientid'];

    }else if( $data['medecinid'] ){
      $text = " WHERE idMedecin = :medecinid";
      $param['medecinid'] = $data['medecinid'];

    }else if( $data['patientid'] ){
      $text = " WHERE idPatient = :patientid";
      $param['patientid'] = $data['patientid'];

    }else{
      echo '<pre>'; print_r( 'Nécessite patientid ou medecinid' ); echo '</pre>';exit;
    }

    $patientid = !empty($data["patientid"]) ? $data["patientid"] : 0; // M = homme / F = femme

    try{
      $req = $GLOBALS["db"]->prepare( "SELECT * FROM " . DB_ZOOM . $text );
      $req->execute($param);

      return $req->fetchAll();

    } catch ( PDOException $e) {
      echo '<pre>'; print_r( $GLOBALS["db"]->connect_error ); echo '</pre>';exit;
    }
  }

}

?>
