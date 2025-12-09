<?php

$id = $_POST["id"];
$sucursalId = $_POST['sucursal'];

echo json_encode(MonedaData::VerId($id, $sucursalId));
