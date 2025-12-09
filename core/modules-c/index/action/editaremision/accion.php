<?php
PlacaData::eliminar2($_POST['id']);
PlacaDetalleData::eliminar2($_POST['id']);
$placaData = new PlacaData();
if (isset($_POST['placas'])) {
    $cant = 0;
    $placas = $_POST['placas'];
    foreach ($placas as $c2) {
        $cant += $c2['cantidad'];
    }


    $placaData->nini = 1;
    $placaData->nfin = 1;

    $placaData->serie_placa = 1;



    $placaData->venta = $_POST['id'];
    $placaData->cantidad =  $cant;
    $placaData->sucursal = $_POST["sucursal_id"];
    $res =  $placaData->registro_placa();
    foreach ($placas as $c2) {
        $placaDetalleData = new PlacaDetalleData();
        $placaDetalleData->producto = 1;
        $placaDetalleData->venta = $_POST['id'];
        $placaDetalleData->cantidad = $c2["cantidad"];
        $placaDetalleData->numero_placa_ini = $c2['ini'];
        $placaDetalleData->numero_placa_fin = $c2['fin'];
        //$placaDetalleData->numero_placa_fin = $c2['cantidad'];
        $placaDetalleData->id_placa = $c2['id'];
        $placaDetalleData->registro_serie = $c2['serie'];
        $placaDetalleData->sucursal = $_POST["sucursal_id"];
        $placaDetalleData->registro_placa();
        $placaDetalleD = new PlacaDetalleData();
        $dap = PlacaDetalleData::obtenerPlaca($c2['id']);
        $placaDetalleD->total = $dap->diferencia + $c2["cantidad"];
        $placaDetalleD->inicio = $dap->placa_inicio + $c2["cantidad"];
        $placaDetalleD->id = $c2['id'];
        $t = $placaDetalleD->resta();
    }
    echo 1;
}
