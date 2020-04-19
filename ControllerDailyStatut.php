<?php
include("../ClassDailyStatut.php");

Class ControllerDailyStatut{

  static public function linkDailyStatut($data){

    $id          = !empty($data["id"]) ? (int) $data["id"] : 0; // M = homme / F = femme
    $temperature = !empty($data["temperature"]) ? (int) $data["temperature"] : 100; // M = homme / F = femme
    $poux        = !empty($data["poux"]) ? (string) $data["poux"] : 120;
    $fatigue     = !empty($data["fatigue"]) ? (string) $data["fatigue"] : 1;
    $mood        = !empty($data["mood"]) ? (string) $data["mood"] : "La ça va";
    $date        = !empty($data["date"]) ? (string) $data["date"] : strtotime('now');
    $patientid   = !empty($data["patientid"]) ? (int) $data["patientid"] : "0";

    $dailystatut = new DailyStatut($id, $temperature, $poux, $fatigue, $mood, $date, $patientid);

    return $dailystatut;
  }

  static public function createDailyStatut($data){
    $dailystatut = self::linkDailyStatut($data);

    $response = array(
      "status" => "",
      "message" => ""
    );

    $error = $dailystatut->createDailyStatut();

    if( ! $error ){
      $response['status'] = "OK";
      $response['message'] = (array) $dailystatut;
    }else{
      $response['status'] = "KO";
      $response['status_message'] = "Erreur dans l'insertion";
      $response['message'] = $error;
    }

    return $response;

  }

  static public function getDailyStatut($data){

    $patientid = !empty($data["patientid"]) ? $data["patientid"] : 0; // M = homme / F = femme

    try{
      $req = $GLOBALS["db"]->prepare( "SELECT * FROM " . DB_DAILY . " WHERE idPatient = :patientid" );
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
