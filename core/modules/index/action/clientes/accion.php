<?php

$clientes = ClienteData::verClientesSucursalPaginadoBuscado($_GET['id_sucursal'],$_GET['busqueda'],20,0);

header("Content-type:application/json");
$jsdata = json_decode(file_get_contents('php://input'), true);  
header("HTTP/1.1 200 OK");
header('Content-Type: text/plain');
echo json_encode($clientes);
