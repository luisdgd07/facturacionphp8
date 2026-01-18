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
        // if ($contrato != '') {
        if ($product->contrato_id == $contrato) {
            array_push($result, array("venta" => $venta, "producto" => $product));
        }
        // } else {
        // var_dump($product->contrato_id);
        // // var_dump($contrato);

        // if ($product->contrato_id == $contrato) {
        //     array_push($result, array("venta" => $venta, "producto" => $product));
        // }
        // }
    }
}

echo json_encode($result);
