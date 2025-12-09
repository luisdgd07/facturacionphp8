<?php

$result = [];
$cliente = $_GET['id'];


$products = ProductoData::getByCliente2($cliente, $_GET['sucursal']);
// foreach ($products as $prod) {
//     array_push($result, array("producto" => $prod));
// }

echo json_encode($products);
