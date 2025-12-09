<?php

$vendedor = VendedorData::getAll_ven($_GET['cliente_id']);
header("Content-type:application/json");
$jsdata = json_decode(file_get_contents('php://input'), true);
header("HTTP/1.1 200 OK");
header('Content-Type: text/plain');
echo json_encode($vendedor);
