<?php

require("../index.php");

$data = json_decode( file_get_contents('php://input'), true );
$data['action'] = "createZoom";
redirectApi($data);


?>
