<?php

require("../index.php");

$data = json_decode( file_get_contents('php://input'), true );

$data['action'] = "getZoom";
$data['medecinid'] = !empty($_GET['medecinid'])  ? (int) $_GET['medecinid'] : 0;
$data['patientid'] = !empty($_GET['patientid'])  ? (int) $_GET['patientid'] : 0;

redirectApi($data);


?>
