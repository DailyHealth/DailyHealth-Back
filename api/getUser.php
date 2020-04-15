<?php

require("../index.php");

$data = json_decode( file_get_contents('php://input'), true );

$data['action'] = "getUser";
$data['iduser'] = !empty($_GET['iduser'])  ? (int) $_GET['iduser'] : 0;

redirectApi($data);


?>
