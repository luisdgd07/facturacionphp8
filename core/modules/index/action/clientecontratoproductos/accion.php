<?php

$result = [];
$contrato = $_GET['contrato'];


$products = ProductoData::getByContrato($contrato);
// foreach ($products as $prod) {
//     array_push($result, array("producto" => $prod));
// }

echo json_encode($products);
