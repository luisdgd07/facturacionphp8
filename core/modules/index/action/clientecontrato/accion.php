<?php

$result = [];
$cliente = $_GET['id'];
$contrato = $_GET['contrato'];
$ventas = VentaData::getByCLienteId($cliente);
foreach ($ventas as $venta) {
    $ops = OperationData::getAllProductsBySellIddd($venta->id_venta);
    foreach ($ops as $op) {
        $fila = $op->is_sqlserver ? "id_sqlserver" : "id_producto";
        $product = ProductoData::getById($op->producto_id, $fila);
        if ($product->contrato_id != 0 && $product->contrato_id != null) {
            array_push($result, array("venta" => $venta, "producto" => $product));
        }
    }
}

echo json_encode($result);
