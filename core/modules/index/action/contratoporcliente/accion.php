<?php
$result = [];
$cliente = $_GET['id'];
$product = ProductoData::getcontratos($cliente);
foreach ($product as $prod) {
    $contr = ContratoData::buscarId($prod->contrato_id);
    array_push($result, $contr);
}

echo json_encode($result);
