<?php
$sucursal = $_GET['sucursal'];
$sucursales = new SuccursalData();
// echo "11111";\
echo json_encode($sucursales->VerId($sucursal));
// echo json_encode(SuccursalData::VerId($sucursal));
