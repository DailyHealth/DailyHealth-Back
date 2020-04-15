<?php

require("../index.php");

$data = json_decode( file_get_contents('php://input'), true );
$data['action'] = "getListUser";

$data['medecinid'] = !empty($_GET['medecinid'])  ? (int) $_GET['medecinid'] : 0;
$data['role'] = !empty($_GET['role'])  ? (string) $_GET['role'] : "";

redirectApi($data);


?>
