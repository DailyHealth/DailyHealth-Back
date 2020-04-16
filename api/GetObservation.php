<?php

require("../index.php");

$data = json_decode( file_get_contents('php://input'), true );
$data['action'] = "getObservation";
$data['patientid'] = !empty($_GET['patientid'])  ? (int) $_GET['patientid'] : 0;

redirectApi($data);


?>
