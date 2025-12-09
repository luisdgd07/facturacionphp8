<?php

$ciudades = CiudadData::getciudad($_GET['dist']);
header("Content-type:application/json");
$jsdata = json_decode(file_get_contents('php://input'), true);
header("HTTP/1.1 200 OK");
header('Content-Type: text/plain');
echo json_encode($ciudades);
