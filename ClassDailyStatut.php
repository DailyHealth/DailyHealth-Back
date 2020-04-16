<?php


Class DailyStatut {

  private $_id = 0; // String - M = Homme / F = Femme
  private $_temperature = 0; // Int
  private $_poux = 0; // Int
  private $_fatigue = 0; // 0-2
  private $_mood = ""; // String
  private $_date; // string
  private $_patientid; // string

  function DailyStatut($id, $_temperature, $_poux, $_fatigue, $_mood, $_date, $_patientid){
    $this->_id = $id;
    $this->_temperature = $_temperature;
    $this->_poux = $_poux;
    $this->_fatigue = $_fatigue;
    $this->_mood = $_mood;
    $this->_date = $_date;
    $this->_patientid = $_patientid;

  }

  function createDailyStatut(){

    $error = false;
    try{
      $req = $GLOBALS["db"]->prepare( "INSERT INTO " . DB_DAILY . " ( idDaily, Temperature, Poux, Tiredness, Mood, idPatient, date )
      VALUES ( NULL, :temperature, :poux, :fatigue, :mood, :patientid, :date )" );
      $req->execute([
            'temperature' => (float) $this->_temperature,
            'poux'        => (float) $this->_poux,
            'fatigue'     => (int) $this->_fatigue,
            'mood'        => (string) $this->_mood,
            'patientid'   => (int) $this->_patientid,
            'date'        => (string) $this->_date
        ]);

      $this->_id = $GLOBALS["db"]->lastInsertId();
    } catch ( PDOException $e) {
      $error = $GLOBALS["db"]->connect_error;
    }
    return $error;

  }

}


 ?>
